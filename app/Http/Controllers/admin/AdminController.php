<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // LIST ADMIN
    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        return view('admin.admin-users.list', compact('admins'));
    }

    // FORM TAMBAH ADMIN
    public function create()
    {
        return view('admin.admin-users.create');
    }

    // SIMPAN ADMIN BARU
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'admin',
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('admin.list')->with('success', 'Admin berhasil ditambahkan!');
    }

    // HAPUS ADMIN
    public function destroy($id)
    {
        User::where('id', $id)->delete();
        return back()->with('success', 'Admin dihapus.');
    }
}
