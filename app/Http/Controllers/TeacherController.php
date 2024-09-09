<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
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
        $teachers = User::where('role', 'teacher')->get();
        return view('admin.teacher_list.index', compact('teachers'));
    }

    public function createTeacherList(){

    }
   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(teacher $teacher)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, teacher $teacher)
    {
        //
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
