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
        $user = Auth::user();
        return view('admin.dashboard.index', compact('user'));
        
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
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $user = Auth::user();

            // Cek apakah pengguna terotentikasi
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            // Cek apakah pengguna memiliki role "student"
            if ($user->role !== 'student') {
                return response()->json(['error' => 'Unauthorized, only students can record attendance'], 403);
            }

            Log::info('Received request data: ' . json_encode($request->all()));

            // Validasi input
            $validatedData = $request->validate([
                'qr_code_id' => 'required|integer|exists:qrcodes,id',
            ]);

            // Cek apakah sudah ada record kehadiran hari ini
            $existingAttendance = Attendance::where('user_id', $user->id)
                ->where('qr_code_id', $validatedData['qr_code_id'])
                ->whereDate('scan_at', Carbon::today())
                ->first();

            if ($existingAttendance) {
                return response()->json(['error' => 'Attendance already recorded for today'], 422);
            }

            // Simpan record kehadiran baru
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
    
    public function teacher_create_scan() {
        return view('teacher.teacher_scan.scan');
    }

    public function teacher_scan(Request $request) {
    try {
        $user = Auth::user();

        // Cek apakah pengguna terotentikasi
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // Cek apakah pengguna memiliki role "teacher"
        if ($user->role !== 'teacher') {
            return response()->json(['error' => 'Unauthorized, only teachers can record attendance'], 403);
        }

        Log::info('Received request data: ' . json_encode($request->all()));

        // Validasi input
        $validatedData = $request->validate([
            'qr_code_id' => 'required|integer|exists:qrcodes,id',
        ]);

        // Cek apakah sudah ada record kehadiran hari ini
        $existingAttendance = Attendance::where('user_id', $user->id)
            ->where('qr_code_id', $validatedData['qr_code_id'])
            ->whereDate('scan_at', Carbon::today())
            ->first();

        if ($existingAttendance) {
            return response()->json(['error' => 'Attendance already recorded for today'], 422);
        }

        // Simpan record kehadiran baru
        $attendance = new Attendance();
        $attendance->qr_code_id = $validatedData['qr_code_id'];
        $attendance->user_id = $user->id;
        $attendance->scan_at = Carbon::now();
        $attendance->save();

        Log::info('Attendance record created: ' . json_encode($attendance));

        return response()->json(['success' => 'Attendance recorded successfully'], 200);
    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('Validation error in AttendanceController@teacher_scan: ' . json_encode($e->errors()));
        return response()->json(['error' => $e->errors()], 422);
    } catch (\Exception $e) {
        Log::error('Error in AttendanceController@teacher_scan: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to record attendance: ' . $e->getMessage()], 500);
    }
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
