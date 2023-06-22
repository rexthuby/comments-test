<?php

namespace App\Http\Requests;

use App\Http\Filters\CommentFilter;
use Illuminate\Foundation\Http\FormRequest;

class CommentFilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return string[] must return all allowed filter
     */
    public function rules(): array
    {
        return [
            CommentFilter::SORT => 'string'
        ];
    }
}
