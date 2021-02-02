<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Auth;
//use iluminate\support\Carbon;

class AppointmentController extends Controller
{
    
    public function MakeAppointment(Request $request){
       
   Appointment::insert([
    'AppointDescription' => $request->Appointment_Description,
  
   'FirstNameAP' => $request->First_Name ,
   'LastNameAP' => $request->Last_Name,
   'UsernameAP' => $request->Username ,
   'CityAP' => $request->City ,
       'ZIPCODE' => $request->Zip_Code ,
       'Gender'  => $request->Gender ,

    
   
  ]);
 

    return Redirect()->back()->with('success' , 'Appointment created succesfully Successfull');    
    
}
}
