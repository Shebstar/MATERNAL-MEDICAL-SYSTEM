<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Auth;


class FeedbackController extends Controller{
public function Edit($AppointNo){
    // $categories = DB::table('categories')->where('id',$id)->first();
    $appointments = Appointment::find($AppointNo);
     return view('admin.edit', compact('appointments'));
 }
    //
    public function AppointmentFeedback(Request $request){

        $feedback = new Feedback;
        // $feedback ->AppointId = $request->AppointId;
        $feedback -> FeedDescription = $request->FeedDescrption;
        $feedback -> staff = $request->staff;
        $feedback -> AppointId = $request->AppointId;
        $feedback ->save();


        DB::table('appointments')->where('AppointNo',$request->get('AppointId'))->update(['replied'=>1]);
        return Redirect()->back()->with('success' , 'feedback created succesfully Successfull'); 

}



public function MyAppointments(Request $request){

    $appointments = DB::table('feedback')->join('appointments','feedback.AppointId','=','appointments.AppointNo')->where('appointments.user_id',Auth::user()->id)->get();
    
    return view('user_appointments')->with('appointments',$appointments); 

}


public function create (){

    $appt = Appointment::all();
    return view('admin.edit')->with('appt',$appt);
}
}