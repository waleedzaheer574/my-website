<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SupportChatController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'min:1', 'max:1000'],
            'history' => ['nullable', 'array', 'max:10'],
            'history.*.role' => ['required_with:history', Rule::in(['user', 'assistant'])],
            'history.*.content' => ['required_with:history', 'string', 'max:1000'],
        ]);

        foreach (['HTTP_PROXY', 'HTTPS_PROXY', 'ALL_PROXY', 'http_proxy', 'https_proxy', 'all_proxy'] as $proxyVariable) {
            putenv($proxyVariable);
            unset($_ENV[$proxyVariable], $_SERVER[$proxyVariable]);
        }

        $company = CompanySetting::latest()->first();
        $companyName = 'Multitechwave';
        $contactLine = trim(implode(' ', array_filter([
            $company?->email ? 'Email: '.$company->email.'.' : null,
            $company?->phone ? 'Phone: '.$company->phone.'.' : null,
            $company?->whatsapp_number ? 'WhatsApp: '.$company->whatsapp_number.'.' : null,
        ])));

        $systemPrompt = implode("\n", array_filter([
            "You are the live support assistant for {$companyName}, a digital agency.",
            'Answer in the same language or tone the visitor uses. Hinglish, Urdu, and English are all okay.',
            'Help visitors with web design, website development, SEO, branding, digital marketing, ERP, CRM, accounting systems, business software, portfolio, pricing direction, and contact/quote questions.',
            'Keep replies short, friendly, and practical. Ask one useful follow-up question when project details are missing.',
            'Do not claim to be a human. If the visitor needs a confirmed quote, timeline, legal advice, payment details, or urgent help, guide them to contact the team.',
            $contactLine ? "Company contact details: {$contactLine}" : null,
        ]));

        $geminiApiKey = config('services.gemini.key');

        if ($geminiApiKey) {
            return $this->replyWithGemini($validated, $systemPrompt, $geminiApiKey);
        }

        $openAiApiKey = config('services.openai.key');

        if (! $openAiApiKey) {
            return response()->json([
                'reply' => 'Chat support is almost ready. Please add the Gemini API key in the website settings first.',
            ], 503);
        }

        if (! str_starts_with($openAiApiKey, 'sk-')) {
            return response()->json([
                'reply' => 'OpenAI API key is not valid yet. Please paste the secret key from your OpenAI dashboard, not the dashboard URL.',
            ], 503);
        }

        $input = [
            [
                'role' => 'system',
                'content' => [
                    [
                        'type' => 'input_text',
                        'text' => $systemPrompt,
                    ],
                ],
            ],
        ];

        foreach (array_slice($validated['history'] ?? [], -8) as $message) {
            $input[] = [
                'role' => $message['role'],
                'content' => [
                    [
                        'type' => $message['role'] === 'assistant' ? 'output_text' : 'input_text',
                        'text' => $message['content'],
                    ],
                ],
            ];
        }

        $input[] = [
            'role' => 'user',
            'content' => [
                [
                    'type' => 'input_text',
                    'text' => $validated['message'],
                ],
            ],
        ];

        try {
            $response = Http::withToken($openAiApiKey)
                ->acceptJson()
                ->asJson()
                ->withOptions(['proxy' => []])
                ->timeout(30)
                ->post(rtrim(config('services.openai.base_url'), '/').'/responses', [
                    'model' => config('services.openai.model'),
                    'input' => $input,
                    'max_output_tokens' => 500,
                ]);

            if ($response->failed()) {
                $error = $response->json('error') ?? [];
                $code = $error['code'] ?? $error['type'] ?? null;

                report(new \RuntimeException('OpenAI support chat failed: '.$response->body()));

                if ($code === 'insufficient_quota') {
                    return response()->json([
                        'reply' => 'AI support abhi quota/billing ki wajah se unavailable hai. Please OpenAI billing add ya quota recharge karein, phir chat automatically chal jayegi.',
                    ], 502);
                }

                return response()->json([
                    'reply' => 'Sorry, AI support is not responding right now. Please try again in a moment or contact our team directly.',
                ], 502);
            }

            return response()->json([
                'reply' => $this->extractText($response->json())
                    ?: 'I received your message. Please share a few more details so I can help better.',
            ]);
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json([
                'reply' => 'Sorry, something went wrong with AI support. Please try again shortly.',
            ], 500);
        }
    }

    private function replyWithGemini(array $validated, string $systemPrompt, string $apiKey): JsonResponse
    {
        $contents = [];

        foreach (array_slice($validated['history'] ?? [], -8) as $message) {
            $contents[] = [
                'role' => $message['role'] === 'assistant' ? 'model' : 'user',
                'parts' => [
                    ['text' => $message['content']],
                ],
            ];
        }

        $contents[] = [
            'role' => 'user',
            'parts' => [
                ['text' => $validated['message']],
            ],
        ];

        try {
            $model = config('services.gemini.model');
            $baseUrl = rtrim(config('services.gemini.base_url'), '/');

            $response = Http::acceptJson()
                ->asJson()
                ->withOptions(['proxy' => []])
                ->timeout(30)
                ->post("{$baseUrl}/models/{$model}:generateContent?key=".urlencode($apiKey), [
                    'system_instruction' => [
                        'parts' => [
                            ['text' => $systemPrompt],
                        ],
                    ],
                    'contents' => $contents,
                    'generationConfig' => [
                        'maxOutputTokens' => 500,
                        'temperature' => 0.7,
                    ],
                    'safetySettings' => [
                        [
                            'category' => 'HARM_CATEGORY_HARASSMENT',
                            'threshold' => 'BLOCK_MEDIUM_AND_ABOVE',
                        ],
                        [
                            'category' => 'HARM_CATEGORY_HATE_SPEECH',
                            'threshold' => 'BLOCK_MEDIUM_AND_ABOVE',
                        ],
                        [
                            'category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT',
                            'threshold' => 'BLOCK_MEDIUM_AND_ABOVE',
                        ],
                        [
                            'category' => 'HARM_CATEGORY_DANGEROUS_CONTENT',
                            'threshold' => 'BLOCK_MEDIUM_AND_ABOVE',
                        ],
                    ],
                ]);

            if ($response->failed()) {
                report(new \RuntimeException('Gemini support chat failed: '.$response->body()));

                return response()->json([
                    'reply' => $this->localSupportReply($validated['message']),
                ], 502);
            }

            return response()->json([
                'reply' => $this->extractGeminiText($response->json())
                    ?: $this->localSupportReply($validated['message']),
            ]);
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json([
                'reply' => $this->localSupportReply($validated['message']),
            ], 500);
        }
    }

    private function localSupportReply(string $message): string
    {
        $message = Str::lower($message);

        if (Str::contains($message, ['accounting', 'invoice', 'billing', 'ledger', 'finance', 'erp', 'crm'])) {
            return 'Yes, Multitechwave can help you build a custom accounting system. It can include invoices, expenses, ledgers, reports, customer/vendor records, roles, dashboards, and PDF/export features. Please share whether you need a simple accounting app or a full ERP-style system.';
        }

        if (Str::contains($message, ['price', 'pricing', 'cost', 'budget', 'quote'])) {
            return 'Sure. Pricing depends on features, pages, integrations, and timeline. You can use the Quote Generator for an instant estimate, or share your requirements here and I will guide you.';
        }

        return 'Thanks for your message. Multitechwave can help with website design, development, SEO, branding, digital marketing, automation, and business software. Please share your goal and required features so I can guide you better.';
    }

    private function extractText(array $payload): ?string
    {
        if (! empty($payload['output_text']) && is_string($payload['output_text'])) {
            return trim($payload['output_text']);
        }

        foreach ($payload['output'] ?? [] as $output) {
            foreach ($output['content'] ?? [] as $content) {
                if (! empty($content['text']) && is_string($content['text'])) {
                    return trim($content['text']);
                }
            }
        }

        return null;
    }

    private function extractGeminiText(array $payload): ?string
    {
        $parts = $payload['candidates'][0]['content']['parts'] ?? [];
        $text = collect($parts)
            ->pluck('text')
            ->filter(fn ($part) => is_string($part) && trim($part) !== '')
            ->implode("\n");

        return trim($text) ?: null;
    }
}
