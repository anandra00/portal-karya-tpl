<?php

namespace Modules\Karya\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminStoreKaryaRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'deskripsi' => 'required|string',
            'tim_pembuat' => 'required|string|max:255',
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'link_pengumpulan' => 'nullable|url',
            'preview_karya' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file_karya' => 'nullable|file|mimes:pdf|max:10240',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']);
    }
}
