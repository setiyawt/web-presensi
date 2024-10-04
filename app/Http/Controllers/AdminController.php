<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index(){
        $user = Auth::user();
        $adminRole = Role::where('name', 'admin')->first();
        $admins = $adminRole->users;
        return view('admin.admin_list.index', compact('admins', 'user'));

        
    }

    public function resetPassword($userId)
    {
        $user = User::findOrFail($userId);
        return view('admin.admin_list.reset_password', compact('user'));
    }


    public function storePassword(Request $request, $userId)
    {
        // Validasi password baru
        $request->validate([
            'password' => 'required|string|min:8|confirmed', // gunakan 'confirmed' untuk mengecek password_confirmation otomatis
        ]);
    
        $user = User::findOrFail($userId);
        $user->password = Hash::make($request->input('password')); // Sesuaikan input 'password'
        $user->save();
    
        return redirect()->route('dashboard.admin_list.index')->with('success', 'Password berhasil direset');
    }
    
    public function create(){
        $user = Auth::user();
        return view('admin.admin_list.create', compact('user'));
        
    }

    public function edit($userId){
        $admin = User::findOrFail($userId);
        $user = Auth::user();
        return view('admin.admin_list.edit', compact('admin', 'user'));
    }

    public function store(Request $request)
    {
        try {
            // Validate the input
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto
            ]);

            // Handle photo upload
            $path = $request->file('photo') ? $request->file('photo')->store('photos', 'public') : null;

            // Create the user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'photo' => $path, // Simpan path foto
            ]);

            // Assign admin role to user
            $adminRole = Role::where('name', 'admin')->first();
            if ($adminRole) {
                $user->assignRole($adminRole);
            }

            // Redirect with success message
            return redirect()->route('dashboard.admin_list.index')->with('success', 'Data berhasil disimpan.');

        } catch (\Exception $e) {
            Log::error('Error occurred: ' . $e->getMessage());
            return back()->with('error', 'Email sudah digunakan');
        }
    }

    public function update(Request $request, $userId)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,email,' . $userId,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $admin = User::findOrFail($userId);

        if ($request->hasFile('photo')) {
            if ($admin->photo) {
                Storage::disk('public')->delete($admin->photo);
            }

            $path = $request->file('photo')->store('photos', 'public');
            if ($path) {
                $admin->photo = $path;
                Log::info('Photo updated: ' . $path); // Add logging
            } else {
                Log::error('Failed to store photo'); // Log error if storage fails
                return redirect()->back()->with('error', 'Failed to upload photo.');
            }
        }

        $admin->name = $validated['name'];
        $admin->email = $validated['email'];

        if ($admin->save()) {
            Log::info('User updated successfully: ' . $admin->id); // Log successful update
            return redirect()->route('dashboard.admin_list.index')->with('success', 'Data berhasil diubah.');
        } else {
            Log::error('Failed to update user: ' . $admin->id); // Log error if save fails
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
