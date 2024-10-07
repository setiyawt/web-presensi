<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Classroom;
use App\Models\Qrcode;
use Illuminate\Http\Request;

use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeGenerator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class QrcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return('this is qrcode.com');
    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $user = Auth::user();
        $courses = Course::all();
        $classrooms = Classroom::all();
        $latestQrcode = Qrcode::latest()->first(); // Mengambil QR code terakhir

        return view('teacher.qrcode.create', compact('user', 'courses', 'classrooms', 'latestQrcode'));
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'course_id' => 'required|integer', 
            'classroom_id' => 'required|integer', 
            'lesson_time' => 'required|date',
        ]);

        $qrData = $validatedData['course_id'] . ' ' . $validatedData['lesson_time'];
        $qrCodePath = 'qrcodes/' . uniqid() . '.png';

        // Pastikan direktori ada
        if (!file_exists(public_path('qrcodes'))) {
            mkdir(public_path('qrcodes'), 0755, true);
        }

        DB::beginTransaction();
        try {
            // Generate QR code
            QrCode::format('png')->size(300)->generate($qrData, public_path($qrCodePath));


            // Simpan data QR Code ke tabel
            Qrcode::create([
                'course_id' => $validatedData['course_id'],
                'classroom_id' => $validatedData['classroom_id'],
                'lesson_time' => $validatedData['lesson_time'],
                'qr_code_path' => $qrCodePath,
            ]);

            // Commit transaksi
            DB::commit();

            return redirect()->route('dashboard.qrcode.create')
                ->with('success', 'QR Code created successfully')
                ->with('qr_code_path', $qrCodePath); 
        } catch (\Exception $e) {
            // Rollback transaksi jika ada kesalahan
            DB::rollBack();
            Log::error('QR Code creation failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to create QR Code. Please try again.']);
        }
    }


    public function indexTeacherQr() {
        $user = Auth::User();
        $courses = Course::all(); // Mengambil semua data dari tabel 'course'
        $classrooms = Classroom::all(); // Mengambil semua data dari tabel 'classroom'
        return view('admin.attendance.create', [
            'courses' => $courses,
            'classrooms' => $classrooms
        ], compact('user'));
    }

    public function createTeacherQr()
    {
        $user = Auth::User();
        $courses = Course::all();
        $classrooms = Classroom::all();
        $latestQrcode = Qrcode::latest()->first(); // Mengambil QR code terakhir

        return view('admin.attendance.qrcode', compact('user', 'courses', 'classrooms', 'latestQrcode'));
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeTeacherQr(Request $request)
{
    // Validasi input
    $validatedData = $request->validate([
        'course_id' => 'required|integer', 
        'classroom_id' => 'required|integer', 
        'lesson_time' => 'required|date',
    ]);

    // Siapkan data untuk QR Code
    $qrData = $validatedData['course_id'] . ' ' . $validatedData['lesson_time'];
    $qrCodePath = 'qrcodes/' . uniqid() . '.png';

    // Mulai transaksi database
    DB::beginTransaction();

    try {
        // Generate QR code dan simpan ke path yang ditentukan
        QrCode::format('png')->size(300)->generate($qrData, public_path($qrCodePath));

        // Simpan data QR Code ke tabel
        Qrcode::create([
            'course_id' => $validatedData['course_id'],
            'classroom_id' => $validatedData['classroom_id'],
            'lesson_time' => $validatedData['lesson_time'],
            'qr_code_path' => $qrCodePath,
        ]);

        // Commit transaksi jika berhasil
        DB::commit();

        // Redirect dengan pesan sukses
        return redirect()->route('dashboard.attendance.qrcode')
            ->with('success', 'QR Code created successfully')
            ->with('qr_code_path', $qrCodePath); 

    } catch (\Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        DB::rollBack();

        // Log error dan tampilkan pesan kesalahan
        Log::error('QR Code creation failed: ' . $e->getMessage());
        return redirect()->back()->withInput()->withErrors(['error' => 'Failed to create QR Code. Please try again.']);
    }
}






    /**
     * Display the specified resource.
     */
    public function show(Qrcode $qrcode)
    {
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Qrcode $qrcode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Qrcode $qrcode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Qrcode $qrcode)
    {
        //
    }
}