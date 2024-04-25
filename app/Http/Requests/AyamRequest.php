<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AyamRequest extends FormRequest
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
        $rules = [
            'jenis' => 'required'
        ];

        return $rules;
    }

    public function messages()
    {
        return [ 
            'jenis.required' => 'Jenis Ayam Wajib Diisi'
        ];
    }
}
