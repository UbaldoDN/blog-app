<?php

namespace App\Http\Requests\Admin;

use App\Services\Auth\AdminAuthService;
use Illuminate\Foundation\Http\FormRequest;

class StoreAuthorRequest extends FormRequest
{
    public function __construct(protected AdminAuthService $adminAuthService)
    {
        //
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->adminAuthService->isLoggedIn() && $this->adminAuthService->getRole() === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'  => 'required|string',
            'email' => 'required|email',
        ];
    }
}
