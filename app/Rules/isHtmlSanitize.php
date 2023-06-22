<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

class isHtmlSanitize implements ValidationRule
{
    private HtmlSanitizerConfig $sanitizerConfig;

    public function __construct(HtmlSanitizerConfig $sanitizerConfig)
    {
        $this->sanitizerConfig = $sanitizerConfig;
    }

    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $htmlSanitizer = new HtmlSanitizer($this->sanitizerConfig);

        $sanitizedValue = $htmlSanitizer->sanitize($value);

        if ($sanitizedValue != $value) {
            $fail("$attribute must have only correct HTML tags. Use only allowed HTML");
        }
    }
}
