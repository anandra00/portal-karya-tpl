<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\SendEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. tangkep variabel
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. cek di database (email, password)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $role = Auth::user()->role; // (superadmin, admin, user)

            if ($role === 'superadmin' || $role === 'admin') {
                // ngarah dashboard
                return redirect(route('dashboard'))->with('success', 'Login berhasil');
            } else {
                // ngarah homepage
                return redirect(route('home'))->with('success', 'Login berhasil');
            }
        }

        return back()->with('error', 'Email atau password salah');
    }

    public function register(Request $request)
    {
        // 1. validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        // 2. hash password & simpan ke db
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        // 3. arahin ke login
        return redirect(route('login'))->with('success', 'Registrasi berhasil. Silakan login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('home'));
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;
        $user = User::where('email', $email)->first();
        if (!$user) {
            // Jangan bocorkan info apakah email terdaftar atau tidak
            return back()->with('success', 'Jika email terdaftar, link reset password akan dikirim.');
        }

        // Token berisi user ID + timestamp expiry (1 jam)
        $tokenPayload = json_encode([
            'id' => $user->id,
            'expires_at' => now()->addHour()->timestamp,
        ]);
        $token = Crypt::encryptString($tokenPayload);
        $resetLink = route('reset-password', $token);
        Mail::to($email)->send(new SendEmail($resetLink));
        return back()->with('success', 'Jika email terdaftar, link reset password akan dikirim.');
    }

    public function resetPassword(Request $request)
    {
        // Validasi token sebelum menampilkan form
        try {
            $decrypt = Crypt::decryptString($request->token);
            $data = json_decode($decrypt, true);

            if (!isset($data['expires_at']) || now()->timestamp > $data['expires_at']) {
                return redirect(route('forgot-password'))->with('error', 'Link reset password sudah kadaluarsa. Silakan minta ulang.');
            }
        } catch (\Exception $e) {
            return redirect(route('forgot-password'))->with('error', 'Link reset password tidak valid.');
        }

        return view('auth.reset-password', [
            'token' => $request->token
        ]);
    }

    public function submitResetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        try {
            $decrypt = Crypt::decryptString($request->token);
            $data = json_decode($decrypt, true);
        } catch (\Exception $e) {
            return redirect(route('forgot-password'))->with('error', 'Token tidak valid.');
        }

        // Cek expiry token
        if (!isset($data['expires_at']) || now()->timestamp > $data['expires_at']) {
            return redirect(route('forgot-password'))->with('error', 'Link reset password sudah kadaluarsa. Silakan minta ulang.');
        }

        $userId = $data['id'];

        // update password
        User::where('id', $userId)->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect(route('login'))->with('success', 'Password berhasil direset. Silakan login.');
    }
}
