<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto
        ]);

        $path = $request->file('photo') ? $request->file('photo')->store('photos', 'public') : null;

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'photo' => $path, // Simpan path foto
            'role' => 'admin',
        ]);

        return redirect()->route('dashboard.admin_list.index')->with('success', 'Data berhasil disimpan.');
    }

    public function update(Request $request, $userId)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|max:255|unique:users,email,' . $userId,
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user = User::findOrFail($userId);

    if ($request->hasFile('photo')) {
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $path = $request->file('photo')->store('photos', 'public');
        if ($path) {
            $user->photo = $path;
            Log::info('Photo updated: ' . $path); // Add logging
        } else {
            Log::error('Failed to store photo'); // Log error if storage fails
            return redirect()->back()->with('error', 'Failed to upload photo.');
        }
    }

    $user->name = $validated['name'];
    $user->email = $validated['email'];

    if ($user->save()) {
        Log::info('User updated successfully: ' . $user->id); // Log successful update
        return redirect()->route('dashboard.admin_list.index')->with('success', 'Data berhasil diubah.');
    } else {
        Log::error('Failed to update user: ' . $user->id); // Log error if save fails
        return redirect()->back()->with('error', 'Failed to update user.');
    }
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
