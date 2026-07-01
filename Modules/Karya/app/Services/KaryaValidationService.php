<?php

namespace Modules\Karya\Services;

use App\Models\User;

class KaryaValidationService
{
    /**
     * Determine if a user is allowed to upload a student project.
     * Mahasiswa role MUST use an email ending with @apps.ipb.ac.id.
     */
    public function authorizeUpload(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        if ($user->role === 'user' && !str_ends_with($user->email, '@apps.ipb.ac.id')) {
            return false;
        }

        return true;
    }

    /**
     * Get shared validation rules for karya submissions.
     */
    public function getRules(string $role): array
    {
        if ($role === 'user') {
            return [
                'judul' => 'required|string|max:255',
                'kategori' => 'required|string',
                'deskripsi' => 'required|string',
                'tim_pembuat' => 'required|string|max:255',
                'preview_karya' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'file_karya' => 'nullable|file|mimes:pdf|max:10240',
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
            'file_karya' => 'nullable|file|mimes:pdf|max:10240',
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'link' => 'nullable|url',
        ];
    }
}
