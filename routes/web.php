<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QrcodeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentScheduleController;
use App\Http\Controllers\UserScheduleController;
use App\Http\Models\User;
use App\Models\Attendance;
use App\Models\UserSchedule;
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

        // Form Admin
        Route::get('admin/index', [AttendanceController::class, 'index'])
        ->middleware('role:admin')
        ->name('admin.index');

        //Untuk menambahkan jadwal pelajaran
        Route::get('/schedule/create', [UserScheduleController::class, 'create'])
        ->middleware('role:admin')
        ->name('schedule.create');

        Route::post('schedule/create', [UserScheduleController::class, 'store'])
            ->middleware('role:admin')
            ->name('schedule.store');

        //Untuk mengedit jadwal pelajaran
        // Route untuk menampilkan form edit
        Route::get('/dashboard/schedule/{id}/edit', [UserScheduleController::class, 'edit'])
        ->middleware('role:admin')
        ->name('schedule.edit');

        // Route untuk memperbarui data
        Route::put('/dashboard/schedule/{id}', [UserScheduleController::class, 'update'])
        ->middleware('role:admin')
        ->name('schedule.update');

         // Route untuk menampilkan form edit
         Route::get('/dashboard/course/edit/{id}', [CourseController::class, 'edit'])
         ->middleware('role:admin')
         ->name('course.edit');
 
         // Route untuk memperbarui data
         Route::put('/dashboard/course/{id}', [CourseController::class, 'update'])
         ->middleware('role:admin')
         ->name('course.update');

         // Route untuk menampilkan form edit
         Route::get('/dashboard/classroom/edit/{id}', [ClassroomController::class, 'edit'])
         ->middleware('role:admin')
         ->name('classroom.edit');
 
         // Route untuk memperbarui data
         Route::put('/dashboard/classroom/{id}', [ClassroomController::class, 'update'])
         ->middleware('role:admin')
         ->name('classroom.update');
        
        //Menghapus Jadwal pelajaran
        Route::delete('/dashboard/schedule/{id}', [UserScheduleController::class, 'destroy'])
        ->middleware('role:admin')
        ->name('schedule.delete');

        //Menghapus course
        Route::delete('/dashboard/course/{id}', [CourseController::class, 'destroy'])
        ->middleware('role:admin')
        ->name('course.delete');

        //Menghapus classroom
        Route::delete('/dashboard/classroom/{id}', [ClassroomController::class, 'destroy'])
        ->middleware('role:admin')
        ->name('classroom.delete');
        
        //Form Teacher
        //Untuk menampilkan seluruh courses oleh teacher
        Route::get('teacher/index', [CourseController::class, 'take_course'])
        ->middleware('role:teacher')
        ->name('index');

        Route::get('teacher/index', [ClassroomController::class, 'take_classroom'])
        ->middleware('role:teacher')
        ->name('index');

        Route::get('qrcode/create/', [QRCodeController::class, 'create'])
            ->middleware('role:teacher|admin')
            ->name('qrcode.create');
            
        Route::post('qrcode/create', [QRCodeController::class, 'store'])
            ->middleware('role:teacher|admin')
            ->name('qrcode.store');


        // Form Student Role
        Route::post('/scan-qr', [AttendanceController::class, 'store'])
        ->middleware('auth')
        ->name('student.store');

        Route::get('/student/index', [AttendanceController::class, 'student_index'])
        ->middleware('role:student')
        ->name('student.index');

        //Untuk menampilkan seluruh jadwal 
        Route::get('/schedule/show', [UserScheduleController::class, 'index'])
        ->middleware('role:admin')
        ->name('schedule.index');


        //Untuk menampilkan seluruh pelajaran
        Route::get('/course/show', [CourseController::class, 'index'])
        ->middleware('role:admin')
        ->name('course.index');

        //Untuk menampilkan seluruh kelas
        Route::get('/classroom/show', [ClassroomController::class, 'index'])
        ->middleware('role:admin')
        ->name('classroom.index');

        //Untuk menampilkan seluruh kehadiran teacher
        Route::get('/attendance/show/teachers', [TeacherController::class, 'index'])
        ->middleware('role:admin')
        ->name('tables_attend.table_teacher');

        //Untuk menampilkan seluruh kehadiran student
        Route::get('/attendance/show/students', [StudentController::class, 'index'])
        ->middleware('role:admin')
        ->name('tables_attend.table_student');

        //Untuk menampilkan seluruh data admin
        Route::get('/admin_list/show/index', [AdminController::class, 'index'])
        ->middleware('role:admin')
        ->name('admin_list.index');

        //untuk menambahkan admin baru
        
        Route::get('/admin/create', [AdminController::class, 'create'])
        ->middleware('role:admin')
        ->name('admin.create');

        //Untuk save admin baru
        // Route::post('/admin/create', [AdminController::class, 'store'])
        // ->middleware('role:admin')
        // ->name('admin.store');

        Route::get('/admin_list/create', [AdminController::class, 'create'])
        ->middleware('role:admin')
        ->name('admin_list.create');

        //Untuk save admin baru
        Route::post('/admin_list/create', [AdminController::class, 'store'])
        ->middleware('role:admin')
        ->name('admin_list.store');

        Route::get('/admin_list/reset-password/{id}', [AdminController::class, 'resetPassword'])
        ->middleware('role:admin')
        ->name('admin_list.reset_password');

        Route::post('/admin_list/store-password/{id}', [AdminController::class, 'storePassword'])
        ->middleware('role:admin')
        ->name('admin_list.storePassword');

        Route::post('/admin_list/create', [AdminController::class, 'store'])
        ->middleware('role:admin')
        ->name('admin_list.store');

        Route::get('/admin/edit/{id}', [AdminController::class, 'edit'])
        ->middleware('role:admin')
        ->name('admin_list.edit');

         // Route untuk memperbarui data
         Route::put('/admin/edit/{id}', [AdminController::class, 'update'])
         ->middleware('role:admin')
         ->name('admin_list.update');

        Route::delete('/admin/delete/{id}', [AdminController::class, 'destroy'])
        ->middleware('role:admin')
        ->name('admin_list.delete');


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


        //Untuk create qr code kehadiran students 
        Route::post('/qrcode/students', [QrcodeController::class, 'qrcode_generate'])
        ->middleware(['role:teacher', 'role:admin'])
        ->name('dashboard.create');



        //Untuk create qr code kehadiran teacher 
        Route::get('/qrcode/teachers/{teacher}', [QrcodeController::class, 'qrcode_students'])
        ->middleware('role:admin')
        ->name('qrcode.teachers.create');

        
        

        //Untuk create course
        Route::get('/course/create', [CourseController::class, 'create'])
        ->middleware('role:admin')
        ->name('course.create');


        //Untuk save course
        Route::post('/course/create', [CourseController::class, 'store'])
        ->middleware('role:admin')
        ->name('course.store');

        

        //Untuk create classroom
        Route::get('/classroom/create', [ClassroomController::class, 'create'])
        ->middleware('role:admin')
        ->name('classroom.create');

        //Untuk save classroom
        Route::post('/classroom/create', [ClassroomController::class, 'store'])
        ->middleware('role:admin')
        ->name('classroom.store');

        
    });


});

require __DIR__.'/auth.php';
