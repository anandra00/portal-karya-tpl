<?php

namespace Modules\Karya\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKaryaRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'tim_pembuat' => 'required|string',
            'preview_karya' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status_validasi' => 'required|in:submission,accepted,rejected',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
