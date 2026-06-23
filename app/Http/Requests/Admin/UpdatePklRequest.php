<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePklRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'siswa_id' => ['required', 'exists:siswas,id'],
            'guru_id' => ['required', 'exists:gurus,id'],
            'perusahaan' => ['required', 'string', 'max:100'],
            'alamat_perusahaan' => ['required', 'string'],
            'kontak_perusahaan' => ['nullable', 'string', 'max:50'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'status' => ['required', 'in:draft,active,completed'],
            'catatan' => ['nullable', 'string'],
        ];
    }
}
