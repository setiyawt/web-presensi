<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QrcodeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        // Cek role user
        if ($user->role === 'admin') {
            return redirect()->route('dashboard.admin.index');
        } elseif ($user->role === 'teacher') {
            return redirect()->route('dashboard.teacher.index');
        } else {
            return redirect()->route('dashboard.student.index');
        }
    }
    
    return view('dashboard'); // Default view jika tidak ada role
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('dashboard')->name('dashboard.')->group(function(){

        Route::get('admin/index', [AttendanceController::class, 'index'])
        ->middleware('role:admin')
        ->name('admin.index');

        //Form Teacher
        //Untuk menampilkan seluruh courses oleh teacher
        Route::get('teacher/index', [CourseController::class, 'take_course'])
        ->middleware('role:teacher')
        ->name('index');

        Route::get('teacher/index', [ClassroomController::class, 'take_classroom'])
        ->middleware('role:teacher')
        ->name('index');

        Route::get('qrcode/create/', [QRCodeController::class, 'create'])
        ->middleware('role:teacher')
        ->name('qrcode.create');
        
        
        Route::post('qrcode/create', [QRCodeController::class, 'store'])
        ->middleware('role:teacher')
        ->name('qrcode.store');


        // Form Student Role
        Route::post('/scan-qr', [AttendanceController::class, 'store'])
        ->middleware('auth')
        ->name('student.store');

        Route::get('/student/index', [AttendanceController::class, 'student_index'])
        ->middleware('role:student')
        ->name('student.index');

        //Untuk menampilkan seluruh kehadiran teacher
        Route::get('/attendance/show/teachers', [TeacherController::class, 'index'])
        ->middleware('role:admin')
        ->name('tables_attend.table_teacher');

        //Untuk menampilkan seluruh kehadiran student
        Route::get('/attendance/show/students', [StudentController::class, 'index'])
        ->middleware('role:admin')
        ->name('tables_attend.table_student');

        //Untuk menampilkan seluruh data admin
        Route::get('/attendance/show/admins', [AdminController::class, 'index'])
        ->middleware('role:admin')
        ->name('tables_attend.table_admin');


        //Untuk menambahkan kehadiran secara manual (tanpa qr code) untuk student & teacher
        Route::get('/attendance/create', [AttendanceController::class, 'create'])
        ->middleware('role:admin')
        ->name('attendance.create');

        //Untuk mengedit kehadiran teacher
        Route::get('/dashboard/attendance/edit/{id}', [AttendanceController::class, 'edit'])
        ->middleware('role:admin')
        ->name('attendance.edit');
        
        //Menghapus Attendances
        Route::delete('/dashboard/attendance/{id}', [AttendanceController::class, 'destroy'])
        ->middleware('role:admin')
        ->name('attendance.delete');

        //Untuk menyimpan kehadiran secara manual (tanpa qr code) untuk student
        Route::post('/attendance/students/save/{student}', [AttendanceController::class, 'store_students_attendance'])
        ->middleware('role:admin')
        ->name('attendance.students.store');
    
        //Untuk menyimpan kehadiran secara manual (tanpa qr code) untuk teacher
        Route::post('/attendance/teachers/save/{teacher}', [AttendanceController::class, 'store_students_attendance'])
        ->middleware('role:admin')
        ->name('attendance.teachers.store');

        // Untuk melihat kehadiran siswa oleh siswa itu sendiri
        Route::get('/attendance/students/show/{student}', [AttendanceController::class, 'show_attendance_students_id'])
        ->middleware('role:student')
        ->name('attendance.students.self.show');

        // Untuk melihat semua kehadiran siswa oleh guru
        Route::get('/attendance/students/show/all/{student}', [AttendanceController::class, 'show_attendance_students'])
        ->middleware('role:teacher')
        ->name('attendance.students.show.all');

        //Untuk status selesai melakukan kehadiran student 
        Route::get('/attendance/students/finished/{student}', [AttendanceController::class, 'attendance_students_finished'])
        ->middleware('role:student')
        ->name('attendance.students.finished');
        
        //Untuk status selesai melakukan kehadiran teacher 
        Route::get('/attendance/teachers/finished/{teacher}', [AttendanceController::class, 'attendance_students_finished'])
        ->middleware('role:teacher')
        ->name('attendance.teachers.finished');

        //Untuk create qr code kehadiran students 
        Route::post('/qrcode/students', [QrcodeController::class, 'qrcode_generate'])
        ->middleware(['role:teacher', 'role:admin'])
        ->name('dashboard.create');



        //Untuk create qr code kehadiran teacher 
        Route::get('/qrcode/teachers/{teacher}', [QrcodeController::class, 'qrcode_students'])
        ->middleware('role:admin')
        ->name('qrcode.teachers.create');

        
        

        //Untuk create course
        Route::get('/course/create/{course}', [CourseController::class, 'create'])
        ->middleware('role:admin')
        ->name('course.create');

        //Untuk save course
        Route::post('/course/save/{course}', [CourseController::class, 'store'])
        ->middleware('role:admin')
        ->name('course.store');

        

        //Untuk create classroom
        Route::get('/classroom/create/{classroom}', [ClassroomController::class, 'create'])
        ->middleware('role:admin')
        ->name('classroom.create');

        //Untuk save classroom
        Route::post('/classroom/save/{classroom}', [ClassroomController::class, 'store'])
        ->middleware('role:admin')
        ->name('classroom.store');

        
    });


});

require __DIR__.'/auth.php';
