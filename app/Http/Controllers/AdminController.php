<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(){
        
        $admins = User::where('role', 'admin')->get();
        return view('admin.admin_list.index', compact('admins'));

        
    }

    public function resetPassword($userId)
    {
        $user = User::findOrFail($userId);
        return view('admin.admin_list.reset_password', compact('user'));
    }


    public function storePassword(Request $request, $userId)
    {
        $request->validate([
            'new_password' => 'required|string|min:8', // Validasi password jika diperlukan
        ]);

        $user = User::findOrFail($userId);
        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return redirect()->route('dashboard.admin_list.index')->with('success', 'Password berhasil direset');
    }

    public function create(){
        return view('admin.admin_list.create');
    }

    public function edit($userId){
        $user = User::findOrFail($userId);
        return view('admin.admin_list.edit', compact('user'));
    }

    public function store(Request $request)
{
    // Validasi data
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // Simpan data ke database dengan role 'admin' sebagai default
    User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role' => 'admin', // Default role as admin
    ]);

    // Redirect atau return response
    return redirect()->route('dashboard.admin_list.index')->with('success', 'Data berhasil disimpan.');
}


    public function update(Request $request, $userId)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users,email,' . $userId],
            
        ]);

        $user = User::findOrFail($userId);
        $user->name = $request->name;
        $user->email = $request->email;

        

        $user->save();

        return redirect()->route('dashboard.admin_list.index')->with('success', 'Data berhasil diubah.');
    }

    public function destroy($userId)
    {
        // Mendapatkan pengguna yang sedang login
        $currentUser = Auth::user();

        // Memeriksa apakah ID pengguna yang ingin dihapus sama dengan ID pengguna yang sedang login
        if ($currentUser->id == $userId) {
            // Redirect atau tampilkan pesan error jika pengguna mencoba menghapus dirinya sendiri
            return redirect()->route('dashboard.admin_list.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Jika ID pengguna tidak sama, lanjutkan dengan penghapusan
        $user = User::findOrFail($userId);
        $user->delete();

        return redirect()->route('dashboard.admin_list.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
