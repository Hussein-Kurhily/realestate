<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // السماح بالتحقق من صحة الطلب
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string|min:8|max:12',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'البريد الالكتروني مطلوب',
            'email.email' => 'يرجى إدخال بريد الكتروني صحيح',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.min' => 'كلمة المرور يجب أن تحوي 8 محارف على الأقل',
            'password.max' => 'لا يمكن أن تكون كلمة المرور أكثر من 12 محرف',
        ];
    }
}
