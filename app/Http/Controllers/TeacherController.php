<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\User;


class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil attendance yang user-nya memiliki role teacher
        $attendances = Attendance::whereHas('user', function($query) {
            $query->role('teacher'); // Pastikan 'teacher' adalah role yang sesuai.
        })
        ->orderBy('id', 'DESC')
        ->get();
        

        return view('admin.tables_attend.table_teacher', [
            'attendances' => $attendances,
        ]);
            
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
        $teachers = User::where('role', 'teacher')->get();
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

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'photo' => $path, // Simpan path foto
            'role' => 'teacher',
        ]);

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
    public function edit($userId){
        // $users = User::findOrFail($userId);
        $user = Auth::user();
        return view('admin.teacher_list.edit', compact('user'));
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
            return redirect()->route('dashboard.teacher_list.index')->with('success', 'Data berhasil diubah.');
        } else {
            Log::error('Failed to update user: ' . $user->id); // Log error if save fails
            return redirect()->back()->with('error', 'Failed to update user.');
        }
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
