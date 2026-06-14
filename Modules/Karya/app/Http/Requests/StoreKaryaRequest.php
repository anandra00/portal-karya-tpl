<?php

namespace Modules\Karya\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKaryaRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $role = auth()->check() ? auth()->user()->role : 'user';

        if ($role === 'user') {
            return [
                'judul' => 'required|string|max:255',
                'kategori' => 'required|string',
                'deskripsi' => 'required|string',
                'tim_pembuat' => 'required|string|max:255',
                'email' => ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@apps\.ipb\.ac\.id$/'],
                'preview_karya' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
                'link' => 'required|url',
            ];
        }

        return [
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'deskripsi' => 'required|string',
            'tim_pembuat' => 'required|string|max:255',
            'preview_karya' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'link' => 'nullable|url',
        ];
    }

    public function messages(): array
    {
        return [
            'email.regex' => 'Email wajib menggunakan domain @apps.ipb.ac.id',
            'preview_karya.required' => 'Gambar wajib diupload',
        ];
    }

    public function authorize(): bool
    {
        if (auth()->check()) {
            $user = auth()->user();
            if ($user->role === 'user' && !str_ends_with($user->email, '@apps.ipb.ac.id')) {
                return false;
            }
        }
        return true;
    }
}
