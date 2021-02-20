<?php

use Illuminate\Support\Facades\Route;
//use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FeedbackController;
//use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Feedback;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('/auth/register');
});

Route::get('/healthTips', function () {
    return view('healthTips');
});

Route::post('dashboard',[App\Http\Controllers\AppointmentController::class, 'MakeAppointment']);

Route::get('admin/edit',[FeedbackController::class, 'create'])->name('admin/edit');

Route::get('dashboard/my_appointments',[FeedbackController::class, 'myAppointments'])->name('my_appointments');
Route::post('admin/create_feeback',[FeedbackController::class, 'AppointmentFeedback'])->name('create_feeback');



Route::group(['prefix'=>'admin', 'middleware'=>['admin:admin']],function(){
    Route::get('/login' , [AdminController::class, 'loginForm']);
    Route::post('/login' , [AdminController::class, 'store'])->name('admin.login');
});

Route::middleware(['auth:sanctum,admin', 'verified'])->get('/admin/admin_template', function () {
    $appointments = Appointment::all();
   // $users =User::all();
 //$users = DB::table('users')->get();


    return view('admin_template' , compact('appointments') );
})->name('admin_template');

Route::middleware(['auth:sanctum,web', 'verified'])->get('/dashboard', function () {

    $users =User::all();
 //$users = DB::table('users')->get();
    return view('dashboard',compact('users'));
})->name('dashboard');
