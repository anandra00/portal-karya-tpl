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
        // 1. tangkep data
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $password_confirmation = $request->password_confirmation;

        // 2. validasi (email udh ada atau blm)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', // Cek unik otomatis
            'password' => 'required|min:8|confirmed', // Cek confirmation otomatis
        ]);

        // 3. check password
        if ($password !== $password_confirmation) {
            return back();
        }

        // 4. hash password
        $hashPass = Hash::make($password);

        // 5. masukin ke db
        $user = User::create([
            "name" => $name,
            "email" => $email,
            "password" => $hashPass,
            "role" => "user"
        ]);

        // 6. arahin ke login
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
        $email = $request->email;
        $user = User::where('email', $email)->first();
        if (!$user) {
            return back();
        }
        $token = Crypt::encryptString(value: json_encode($user));
        $resetLink = route('reset-password', $token);
        Mail::to($email)->send(new SendEmail($resetLink));
        return back()->with('success', 'Link reset password berhasil dikirim ke email kamu!');
    }

    public function resetPassword(Request $request)
    {
        return view('auth.reset-password', [
            'token' => $request->token
        ]);
    }

    public function submitResetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $decrypt = Crypt::decryptString($request->token);
        $data = json_decode($decrypt, true);
        $userId = $data["id"];

        // update password
        $update = User::where("id", $userId)->update([
            "password" => Hash::make($request->password),
        ]);

        return redirect(route('login'));
    }
}
