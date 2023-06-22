<?php

namespace App\Http\Requests;

use App\Rules\isHtmlSanitize;
use App\Rules\maxFileSize;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

class CommentStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'username'=>'required|string|max:40|min:3',
            'captcha'=>'nullable|string',
            'email'=>'required|email',
            'url'=>'nullable|url',
            'body'=>['required',
                new isHtmlSanitize((new HtmlSanitizerConfig())
                ->allowElement('a', ['href', 'title'])
                ->allowElement('code')
                ->allowElement('i')
                ->allowElement('strong')),
                ],
            'file'=>[
                'nullable',
                'mimetypes:text/plain,image/jpeg,image/png,image/gif',
                new maxFileSize('text/plain',100),
            ],
            'parent_id'=>'nullable|exists:comments,id'
        ];
    }
}
