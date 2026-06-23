<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKelasRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'nama_kelas' => ['required', 'string', 'max:20'],
            'jurusan_id' => ['required', 'exists:jurusans,id'],
            'tingkat' => ['required', 'in:X,XI,XII'],
            'tahun_ajaran' => ['required', 'string', 'max:9'],
            'wali_kelas_id' => ['nullable', 'exists:gurus,id'],
        ];
    }
}
