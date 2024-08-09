<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'city' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'budget' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'description' => 'nullable|string',
            'type' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'city.required' => 'يجب تحديد المدينة',
            'city.string' => 'يجب أن تكون المدينة سلسلة نصية',
            'city.max' => 'المدينة يجب ألا تتجاوز 255 حرفًا',
            'region.required' => 'يجب تحديد المنطقة',
            'region.string' => 'يجب أن تكون المنطقة سلسلة نصية',
            'region.max' => 'المنطقة يجب ألا تتجاوز 255 حرفًا',
            'phone.required' => 'يجب تحديد رقم الهاتف',
            'phone.string' => 'يجب أن يكون رقم الهاتف سلسلة نصية',
            'phone.max' => 'رقم الهاتف يجب ألا يتجاوز 20 حرفًا',
            'budget.required' => 'يجب تحديد النطاق السعري',
            'budget.string' => 'يجب أن يكون النطاق السعري سلسلة نصية',
            'budget.max' => 'النطاق السعري يجب ألا يتجاوز 255 حرفًا',
            'description.required' => 'يجب تقديم وصف للطلب',
            'description.string' => 'يجب أن يكون الوصف سلسلة نصية',
            'type.required' => 'يجب تحديد نوع الطلب (بيع أو إيجار)',
            'type.string' => 'يجب أن يكون نوع الطلب سلسلة نصية',
            
        ];
    }
}
