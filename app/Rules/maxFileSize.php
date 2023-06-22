<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

class maxFileSize implements ValidationRule
{
    private string $mimeType;
    private int $maxBytes;

    public function __construct(string $mimeType, int $maxKb)
    {
        $this->mimeType = $mimeType;
        $this->maxBytes = $maxKb * 1024;
    }

    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $mimeType = $this->mimeType;

        /**
         * @var UploadedFile $value
         */
        if (!$value){
            return;
        }
        if ($value->getMimeType() === $mimeType) {
            if ($value->getSize() > $this->maxBytes) {
                $message = "$attribute must be smaller than ".$this->maxBytes/1024;
                $fail($message.'kb');
            }
        }
    }
}
