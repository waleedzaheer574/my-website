<?php

namespace App\Models\Concerns;

trait HasLocalizedContent
{
    public function localized(string $attribute): mixed
    {
        if (app()->getLocale() === 'ar') {
            $translated = $this->getAttribute($attribute.'_ar');

            if (filled($translated)) {
                return $translated;
            }
        }

        return $this->getAttribute($attribute);
    }
}
