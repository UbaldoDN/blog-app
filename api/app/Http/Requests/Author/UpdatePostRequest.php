<?php

namespace App\Http\Requests\Author;

use App\Services\Auth\AuthorAuthService;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function __construct(protected AuthorAuthService $authorAuthService)
    {
        //
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->authorAuthService->isLoggedIn() && $this->authorAuthService->getRole() === 'author';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'body'  => 'required|string',
        ];
    }
}
