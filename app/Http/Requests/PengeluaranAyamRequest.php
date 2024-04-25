<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengeluaranAyamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'kandang_id' => 'required',
            'tanggal_keluar' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'kandang_id.required' => 'Kandang Wajib Diisi',
            'tanggal_keluar.required' => 'Tanggal Keluar Wajib Diisi',
        ];
    }
}
