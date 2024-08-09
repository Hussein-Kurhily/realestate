<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:12',
            'last_name' => 'required|string|max:12',
            'phone' => 'required|numeric|unique:users,phone',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|max:12', 
        ];
    }


    public function messages(): array
    {
        return [
            'first_name.required' => 'الأسم الأول مطلوب',
            'last_name.required' => 'الأسم الأخير مطلوب',
            'phone.required' => 'رقم الهاتف مطلوب',
            'phone.unique' => 'يوجد شخص آخر يستخدم نفس هذا الرقم',
            'email.required' => 'البريد الالكتروني مطلوب',
            'email.email' => 'يرجى إدخال بريد الكتروني صحيح',
            'email.unique' => 'الحساب موجود بالفعل',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.min' => 'كلمة المرور يجب أن تحوي 8 محارف على الأقل',
            'password.max' => 'لا يمكن أن تكون كلمة المرور أكثر من 12 محرف',
            
        ];
    }



}
