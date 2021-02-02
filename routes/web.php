<?php

use Illuminate\Support\Facades\Route;
//use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;
//use Illuminate\Support\Facades\DB;
use App\Models\User;

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
Route::post('dashboard',[App\Http\Controllers\AppointmentController::class, 'MakeAppointment']);
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {

    $users =User::all();
 //$users = DB::table('users')->get();
    return view('dashboard',compact('users'));
})->name('dashboard');
