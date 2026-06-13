<?php

namespace Modules\Akademik\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDosenRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'prodi' => 'required|string|max:100',
            'research_interest' => 'nullable|string|max:200',
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
