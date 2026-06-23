<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateJurusanRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'kode_jurusan' => ['required', 'string', 'max:10', Rule::unique('jurusans', 'kode_jurusan')->ignore($this->route('jurusan')->id)],
            'nama_jurusan' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string'],
        ];
    }
}
