<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Qrcode;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeGenerator;

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
        return view('teacher.qrcode.create');   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'course_id' => 'required|exists:courses,id', // Validasi ID course
            'lesson_time' => 'required|date',
        ]);
    
        $courseId = $request->course_id; // Ambil ID course dari request
        $lessonTime = $request->lesson_time;
    
        // Ambil nama course berdasarkan ID
        $course = Course::find($courseId);
        $courseName = $course ? $course->name : 'Unknown Course';
    
        $qrData = $courseName . ' ' . $lessonTime;
        $qrCodePath = 'qrcodes/' . uniqid() . '.png';
    
        // Generate QR code
        QrCodeGenerator::format('png')->size(300)->generate($qrData, public_path($qrCodePath));
    
        // Simpan data QR Code ke tabel
        $qrCode = QRCode::create([
            'course_id' => $courseId, // Simpan ID course
            'lesson_time' => $lessonTime,
            'qr_code_path' => $qrCodePath,
        ]);
    
        return redirect()->back()->with('success', 'QR Code generated successfully!');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Qrcode $qrcode)
    {
        //
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
