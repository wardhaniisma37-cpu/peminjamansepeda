<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Menampilkan daftar user (method default untuk route index)
     */
    public function index()
    {
        $users = User::all();
        return view('user', compact('users'));
    }

    /**
     * Handle all user operations (create, update, delete)
     */
    public function handle(Request $request, $userId = null)
    {
        if ($request->isMethod('get')) {
            // Menampilkan daftar user
            $users = User::all();
            return view('user', compact('users'));
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8|confirmed',
                'role' => 'required|string|max:255',
            ]);
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
            ]);
    
            if ($user) {
                return redirect()->route('users')->with('success', 'User berhasil ditambahkan.');
            } else {
                return back()->with('error', 'Terjadi kesalahan saat menambahkan user.');
            }
        }

        if ($request->isMethod('put') && $userId) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $userId,
                'password' => 'nullable|min:8|confirmed',
                'role' => 'required|string|max:255',
            ]);

            $user = User::findOrFail($userId);

            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->password) {
                $user->password = bcrypt($request->password);
            }
            $user->role = $request->role;

            if ($user->save()) {
                return redirect()->route('users')->with('success', 'User berhasil diperbarui.');
            } else {
                return back()->with('error', 'Terjadi kesalahan saat memperbarui user.');
            }
        }

        if ($request->isMethod('delete') && $userId) {
            try {
                $user = User::findOrFail($userId);
                
                // Cegah menghapus diri sendiri
                if ($user->id === auth()->id()) {
                    return back()->with('error', 'Tidak dapat menghapus akun sendiri!');
                }
                
                $user->delete();
                return redirect()->route('users')->with('success', 'User berhasil dihapus.');
            } catch (\Exception $e) {
                return back()->with('error', 'Terjadi kesalahan saat menghapus user.');
            }
        }

        return back()->with('error', 'Aksi tidak diizinkan.');
    }
}