<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasLocalizedContent;

    protected $fillable = [
        'page_key',
        'question',
        'question_ar',
        'answer',
        'answer_ar',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public const PAGE_OPTIONS = [
        'home' => 'Home',
        'about' => 'About',
        'service' => 'Services',
        'service_details' => 'Service Details',
        'contact' => 'Contact',
        'portfolio' => 'Portfolio',
        'industries' => 'Industries',
        'case_studies' => 'Case Studies',
        'testimonials' => 'Testimonials',
        'blog' => 'Blog',
    ];

    public static function pageLabel(?string $pageKey): string
    {
        $key = 'website.client.faq_pages.'.(string) $pageKey;

        return __($key) !== $key
            ? __($key)
            : (self::PAGE_OPTIONS[$pageKey] ?? str((string) $pageKey)->replace('_', ' ')->title()->value());
    }

    public static function sanitizeAnswer(?string $answer): string
    {
        $answer = strip_tags((string) $answer, '<strong><b><u><ul><ol><li><br><p><em><i>');

        return preg_replace('/<([a-z][a-z0-9]*)\b[^>]*>/i', '<$1>', $answer) ?? '';
    }

    public function getFormattedAnswerAttribute(): string
    {
        $answer = self::sanitizeAnswer($this->localized('answer'));

        if (preg_match('/<(ul|ol|li|p)\b/i', $answer)) {
            return $answer;
        }

        return nl2br($answer, false);
    }
}
