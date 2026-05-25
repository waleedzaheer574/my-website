<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('page_key')
            ->orderBy('sort_order')
            ->latest()
            ->paginate(12);

        return view('dashboard.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('dashboard.faqs.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateFaq($request);
        $validated['answer'] = Faq::sanitizeAnswer($validated['answer']);
        $validated['answer_ar'] = Faq::sanitizeAnswer($validated['answer_ar'] ?? null);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Faq::create($validated);

        return redirect()->route('faqs.index')->with('success', 'FAQ added successfully.');
    }

    public function edit(Faq $faq)
    {
        return view('dashboard.faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $validated = $this->validateFaq($request);
        $validated['answer'] = Faq::sanitizeAnswer($validated['answer']);
        $validated['answer_ar'] = Faq::sanitizeAnswer($validated['answer_ar'] ?? null);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $faq->update($validated);

        return redirect()->route('faqs.index')->with('success', 'FAQ updated successfully.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('faqs.index')->with('success', 'FAQ deleted successfully.');
    }

    protected function validateFaq(Request $request): array
    {
        return $request->validate([
            'page_key' => ['required', 'string', Rule::in(array_keys(Faq::PAGE_OPTIONS))],
            'question' => ['required', 'string', 'max:255'],
            'question_ar' => ['nullable', 'string', 'max:255'],
            'answer' => ['required', 'string'],
            'answer_ar' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
    }
}
