<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Spatie\Permission\Models\Role;


class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil attendance yang user-nya memiliki role teacher
        $user = Auth::user();
        
        $attendances = Attendance::whereHas('user', function($query) {
            $query->role('teacher'); 
        })
        ->orderBy('id', 'DESC')
        ->get();
        

        return view('admin.tables_attend.table_teacher', [
            'attendances' => $attendances,
        ], compact('user'));
            
    }

    public function scopeRole($query, $roleName)
    {
        return $query->whereHas('roles', function($q) use ($roleName) {
            $q->where('name', $roleName);
        });
    }


    public function form_teacher() {
        return view('teacher.dashboard.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.attendance.create');
    }

    

   
    public function indexListTeacher() {
        $user = Auth::user();
        $teacherRole = Role::where('name', 'teacher')->first();
        $teachers = $teacherRole->users;
        
        return view('admin.teacher_list.index', compact('teachers', 'user'));
    }

    public function createTeacherList(){
        $user = Auth::user();
        return view('admin.teacher_list.create', compact('user'));
    }
   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto
        ]);

        $path = $request->file('photo') ? $request->file('photo')->store('photos', 'public') : null;

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'photo' => $path, // Simpan path foto
        ]);
        $teacherRole = Role::where('name', 'teacher')->first();

        // Tetapkan role ke pengguna
        if ($teacherRole) {
            $user->assignRole($teacherRole);
        }

        return redirect()->route('dashboard.teacher_list.index')->with('success', 'Data berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($userId)
    {
        $teacher = User::findOrFail($userId);
        $user = Auth::user();

        return view('admin.teacher_list.edit', compact('teacher', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $userId)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,email,' . $userId,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $teacher = User::findOrFail($userId);

        if ($request->hasFile('photo')) {
            if ($teacher->photo) {
                Storage::disk('public')->delete($teacher->photo);
            }

            $path = $request->file('photo')->store('photos', 'public');
            if ($path) {
                $teacher->photo = $path;
                Log::info('Photo updated: ' . $path); // Add logging
            } else {
                Log::error('Failed to store photo'); // Log error if storage fails
                return redirect()->back()->with('error', 'Failed to upload photo.');
            }
        }

        $teacher->name = $validated['name'];
        $teacher->email = $validated['email'];

        if ($teacher->save()) {
            Log::info('User updated successfully: ' . $teacher->id); // Log successful update
            return redirect()->route('dashboard.teacher_list.index')->with('success', 'Data berhasil diubah.');
        } else {
            Log::error('Failed to update user: ' . $teacher->id); // Log error if save fails
            return redirect()->back()->with('error', 'Failed to update user.');
        }
    }

    public function resetPassword($userId)
    {
        $user = Auth::user();
        $teacher = User::findOrFail($userId);
        return view('admin.teacher_list.reset_password', compact('teacher', 'user'));
    }

    public function storePassword(Request $request, $userId)
    {
        $request->validate([
            'password' => 'required|string|min:8', // Validasi password jika diperlukan
        ]);

        $user = User::findOrFail($userId);
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->route('dashboard.teacher_list.index')->with('success', 'Password berhasil direset');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($userId)
    {
        // Mendapatkan pengguna yang sedang login
        $currentUser = Auth::user();

        // Memeriksa apakah ID pengguna yang ingin dihapus sama dengan ID pengguna yang sedang login
        if ($currentUser->id == $userId) {
            // Redirect atau tampilkan pesan error jika pengguna mencoba menghapus dirinya sendiri
            return redirect()->route('dashboard.teacher_list.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Jika ID pengguna tidak sama, lanjutkan dengan penghapusan
        $user = User::findOrFail($userId);
        $user->delete();

        return redirect()->route('dashboard.teacher_list.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }

    

    
}
