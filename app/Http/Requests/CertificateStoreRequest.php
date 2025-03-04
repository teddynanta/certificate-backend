<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class CertificateStoreRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
            ],

            'code' => [
                'required',
                'max:100',
                'unique:App\Models\Certificate,code',
                'regex:/^\d{1,3}\/DISKOMINFOTIKSAN\/[IVXCLDM]+(\.[IVXCLDM]+)?\/\d{4}$/'
            ],

            'issued_date' => [
                'required',
                'date'
            ],
        ];
    }

    // public function messages(): array
    // {
    //     return [
    //         'code.regex' => 'Code format is invalid, example : 99/DISKOMINFOTIKSAN/I.III/2025'
    //     ];
    // }
}
