@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<main class="py-24 bg-gray-50 dark:bg-gray-900 transition-colors duration-300 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="fade-in-up">
            {{-- Header --}}
            <div class="text-center mb-12">
                <span class="inline-block text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest bg-indigo-50 dark:bg-indigo-950/40 px-3 py-1 rounded-full border border-indigo-100 dark:border-indigo-900/30">
                    Pengaturan Akun
                </span>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight mt-3">Profil Saya</h1>
                <div class="w-12 h-1 bg-gradient-to-r from-indigo-600 to-indigo-400 rounded-full mx-auto mt-3"></div>
            </div>

            {{-- Cards --}}
            <div class="space-y-8">
                <!-- Profile Information Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sm:p-8 hover:shadow-md transition-shadow">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Update Password Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sm:p-8 hover:shadow-md transition-shadow">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Delete User Account Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sm:p-8 hover:shadow-md transition-shadow">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
