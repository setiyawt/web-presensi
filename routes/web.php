<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QrcodeController;
use App\Http\Controllers\SchedulesController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Models\Attendance;
use App\Models\Schedules;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('dashboard')->name('dashboard.')->group(function(){

        Route::resource('index', AttendanceController::class)
        ->middleware('role:admin');

        Route::get('index', [AttendanceController::class, 'index'])
        ->middleware('role:admin')
        ->name('index');

        //Form Teacher
        Route::get('index', [TeacherController::class, 'form_teacher'])
        ->middleware('role:teacher')
        ->name('index');

        //Untuk menampilkan seluruh kehadiran teacher
        Route::get('/attendance/show/teachers', [TeacherController::class, 'index'])
        ->middleware('role:admin')
        ->name('tables_attend.table_teacher');

        //Untuk menampilkan seluruh kehadiran student
        Route::get('/attendance/show/students', [StudentController::class, 'index'])
        ->middleware('role:admin')
        ->name('tables_attend.table_student');
        

        //Untuk menambahkan kehadiran secara manual (tanpa qr code) untuk student & teacher
        Route::get('/attendance/create', [AttendanceController::class, 'create'])
        ->middleware('role:admin')
        ->name('attendance.create');

        //Untuk mengedit kehadiran teacher
        Route::get('/attendance/edit', [AttendanceController::class, 'edit'])
        ->middleware('role:admin')
        ->name('attendance.edit');
        
    
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
        Route::get('/qrcode/students/{student}', [QrcodeController::class, 'qrcode_students'])
        ->middleware(['role:teacher', 'role:admin'])
        ->name('qrcode.students.create');

        //Untuk create qr code kehadiran teacher 
        Route::get('/qrcode/teachers/{teacher}', [QrcodeController::class, 'qrcode_students'])
        ->middleware('role:admin')
        ->name('qrcode.teachers.create');

        
        //Untuk menampilkan seluruh jadwal pelajaran
        Route::get('/schedule/show/{course}', [SchedulesController::class, 'index'])
        ->middleware('role:admin', 'role:')
        ->name('schedule.index');


        //Untuk create course
        Route::get('/course/create/{course}', [CourseController::class, 'create'])
        ->middleware('role:admin')
        ->name('course.create');

        //Untuk save course
        Route::post('/course/save/{course}', [CourseController::class, 'store'])
        ->middleware('role:admin')
        ->name('course.store');

        //Untuk create schedule
        Route::get('/schedule/create/{schedule}', [SchedulesController::class, 'create'])
        ->middleware('role:admin')
        ->name('schedule.create');

        //Untuk save schedule
        Route::post('/schedule/save/{schedule}', [SchedulesController::class, 'store'])
        ->middleware('role:admin')
        ->name('schedule.store');

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
