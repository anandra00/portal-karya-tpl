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
        $service = new \Modules\Karya\Services\KaryaValidationService();
        $rules = $service->getRules($role);

        if ($role === 'user') {
            $rules['email'] = ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@apps\.ipb\.ac\.id$/'];
        }

        return $rules;
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
            $service = new \Modules\Karya\Services\KaryaValidationService();
            return $service->authorizeUpload(auth()->user());
        }
        return true;
    }
}
