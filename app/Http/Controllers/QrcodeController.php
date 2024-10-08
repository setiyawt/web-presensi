<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Models\Qrcode as QrcodeModel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Generator;



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
        $latestQrcode = QrcodeModel::latest()->first(); // Mengambil QR code terakhir

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
            // Generate QR code using QrCode facade
            $qrcode = new Generator;
            $qrcode->format('png')
                ->size(300)
                ->generate($qrData, public_path($qrCodePath));

            // Simpan data QR Code ke tabel
            QrcodeModel::create([
                'course_id' => $validatedData['course_id'],
                'classroom_id' => $validatedData['classroom_id'],
                'lesson_time' => $validatedData['lesson_time'],
                'qr_code_path' => $qrCodePath,
            ]);

            DB::commit();

            return redirect()->route('dashboard.qrcode.create')
                ->with('success', 'QR Code created successfully')
                ->with('qr_code_path', $qrCodePath); 
        } catch (\Exception $e) {
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
        $latestQrcode = QrcodeModel::latest()->first(); // Mengambil QR code terakhir

        return view('admin.attendance.qrcode', compact('user', 'courses', 'classrooms', 'latestQrcode'));
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeTeacherQr(Request $request)
    {
        $validatedData = $request->validate([
            'course_id' => 'required|integer', 
            'classroom_id' => 'required|integer', 
            'lesson_time' => 'required|date',
        ]);

        $qrData = $validatedData['course_id'] . ' ' . $validatedData['lesson_time'];
        $qrCodePath = 'qrcodes/' . uniqid() . '.png';

        DB::beginTransaction();

        try {
            // Generate QR code using QrCode facade
            $qrcode = new Generator;
            $qrcode->format('png')
                ->size(300)
                ->generate($qrData, public_path($qrCodePath));

            QrcodeModel::create([
                'course_id' => $validatedData['course_id'],
                'classroom_id' => $validatedData['classroom_id'],
                'lesson_time' => $validatedData['lesson_time'],
                'qr_code_path' => $qrCodePath,
                'user_id' => Auth::id(),
            ]);

            DB::commit();

            // Redirect dengan pesan sukses
            return redirect()->route('dashboard.attendance.qrcode')
                ->with('success', 'QR Code created successfully')
                ->with('qr_code_path', $qrCodePath); 

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'Failed to create QR Code. Please try again. Error: ' . $e->getMessage()
            ], 500);
        }
    
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
        $qrcode = new Generator;
            $qrcode->format('png')
                ->size(300)
                ->generate($qrData, public_path($qrCodePath));

        // Simpan ke database
        QrcodeModel::create([
            'course_id' => $validatedData['course_id'],
            'classroom_id' => $validatedData['classroom_id'],
            'lesson_time' => $validatedData['lesson_time'],
            'qr_code_path' => $qrCodePath,
            'user_id' => Auth::id(),
        ]);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'QR Code created successfully',
            'qr_code_data' => $qrData,
            'qr_code_path' => asset($qrCodePath)
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'error' => 'Failed to create QR Code. Please try again. Error: ' . $e->getMessage()
        ], 500);
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