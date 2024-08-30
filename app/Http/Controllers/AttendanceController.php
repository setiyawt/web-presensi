<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Course;
use App\Models\Classroom;


class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    
    public function index()
    {
        
        return view('admin.dashboard.index');
        
    }

    public function student_index()
    {
        return view('student.dashboard.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        $classrooms = Classroom::all();

        return view('admin.attendance.create', compact('courses', 'classrooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            Log::info('Received request data: ' . json_encode($request->all()));

            // Validate the incoming request
            $validatedData = $request->validate([
                'qr_code_id' => 'required|integer|exists:qrcodes,id',
            ]);

            // Check if an attendance record already exists for this user and QR code today
            $existingAttendance = Attendance::where('user_id', $user->id)
                ->where('qr_code_id', $validatedData['qr_code_id'])
                ->whereDate('scan_at', Carbon::today())
                ->first();

            if ($existingAttendance) {
                return response()->json(['error' => 'Attendance already recorded for today'], 422);
            }

            // Create the attendance record
            $attendance = new Attendance();
            $attendance->qr_code_id = $validatedData['qr_code_id'];
            $attendance->user_id = $user->id;
            $attendance->scan_at = Carbon::now();
            $attendance->save();

            Log::info('Attendance record created: ' . json_encode($attendance));

            return response()->json(['success' => 'Attendance recorded successfully'], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error in AttendanceController@store: ' . json_encode($e->errors()));
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error in AttendanceController@store: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to record attendance: ' . $e->getMessage()], 500);
        }
    }

    public function store_manual(Request $request) {
        // Validasi data input
        $validatedData = $request->validate([
            'nisn' => ['required', 'string', 'max:255'],
            'classroom_id' => ['required', 'integer', 'exists:classrooms,id'],
            'course_id' => ['required', 'integer', 'exists:courses,id'],
            'scan_at' => ['required', 'date_format:Y-m-d H:i:s'], // Format tanggal sesuai yang diinginkan
        ]);
    
        // Cari user berdasarkan NISN
        $user = User::where('nisn', $request->nisn)->firstOrFail();
        
        // Pastikan user ditemukan, tambahkan relasi ke classroom dan course
        $user->classrooms()->attach($request->classroom_id);
        $user->courses()->attach($request->course_id);
    
        // Tambahkan data ke tabel attendances
        $attendance = Attendance::create([
            'user_id' => $user->id,
            'classroom_id' => $request->classroom_id,
            'course_id' => $request->course_id,
            'scan_at' => $validatedData['scan_at'],
            'qr_code_id' => null, 
        ]);
    
        // Redirect ke halaman tampilan dengan data yang ditampilkan
        return view('attendance.show', compact('user', 'attendance'));
    }
    
    


    /**
     * Display the specified resource.
     */
    public function show()
    {
        // Ambil total siswa dan guru
        $totalStudents = User::where('role', 'student')->count();
        $totalTeachers = User::where('role', 'teacher')->count();
    
        // Ambil siswa dan guru yang hadir
        $attendedStudents = User::where('role', 'student')
            ->whereHas('attendances') // Mengambil siswa yang memiliki data absensi
            ->count();
    
        $attendedTeachers = User::where('role', 'teacher')
            ->whereHas('attendances') // Mengambil guru yang memiliki data absensi
            ->count();
    
        // Hitung siswa dan guru yang absen
        $absentStudents = $totalStudents - $attendedStudents;
        $absentTeachers = $totalTeachers - $attendedTeachers;
    
        // Kembalikan view dengan data
        return view('dashboard.admin.index', [
            'totalStudents' => $totalStudents,
            'attendedStudents' => $attendedStudents,
            'absentStudents' => $absentStudents,
            'totalTeachers' => $totalTeachers,
            'attendedTeachers' => $attendedTeachers,
            'absentTeachers' => $absentTeachers,
        ]);
    }
    
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        return view('admin.attendance.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    // Temukan record attendance yang akan dihapus
    $attendance = Attendance::findOrFail($id);
    
    // Ambil user yang terkait dengan attendance
    $user = $attendance->user;

    // Hapus record attendance
    $attendance->delete();

    // Tentukan URL pengalihan berdasarkan jenis pengguna
    if ($user->hasRole('teacher')) {
        // Jika pengguna adalah guru, arahkan ke halaman guru
        return redirect()->route('dashboard.tables_attend.table_teacher')->with('success', 'Attendance record deleted successfully.');
    } else {
        // Jika pengguna adalah murid, arahkan ke halaman murid
        return redirect()->route('dashboard.tables_attend.table_student')->with('success', 'Attendance record deleted successfully.');
    }
}


    
}
