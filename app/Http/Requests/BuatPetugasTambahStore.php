<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BuatPetugasTambahStore extends FormRequest
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
            'npp' => 'required|unique:tbl_pegawai,npp_no',
            'nama_petugas' => 'required',
            'jabatan' => 'required',
            'inisial_petugas' => 'required|unique:tbl_pegawai,kode_tugas',
            'gerbang_penempatan' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'npp.unique' => 'NPP sudah digunakan',
            'inisial_petugas.unique' => 'Inisial Petugas sudah digunakan',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    protected function failedValidation(Validator $validator)
    {
        // return response()->json(['code' => 200, 'message' => 'Success Add Data']);
        throw new HttpResponseException(response()->json($validator->errors(), 200));
    }
}
