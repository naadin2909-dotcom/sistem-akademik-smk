<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMataPelajaranRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'kode_mapel' => ['required', 'string', 'max:10', Rule::unique('mata_pelajarans', 'kode_mapel')->ignore($this->route('mapel')->id)],
            'nama_mapel' => ['required', 'string', 'max:100'],
            'kelompok' => ['required', 'in:Normatif,Adaptif,Produktif'],
            'jurusan_id' => ['nullable', 'exists:jurusans,id'],
        ];
    }
}
