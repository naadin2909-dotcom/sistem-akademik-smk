<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiswaRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'nis' => ['required', 'string', 'max:20'],
            'nisn' => ['required', 'string', 'max:20'],
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'tempat_lahir' => ['required', 'string', 'max:50'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat' => ['required', 'string'],
            'nama_ortu' => ['required', 'string', 'max:100'],
            'no_telp_ortu' => ['nullable', 'string', 'max:15'],
            'foto' => ['nullable', 'image', 'max:2048'],
            'angkatan' => ['required', 'string', 'max:4'],
        ];
    }
}
