<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\user_table;
Use Illuminate\Support\Facades\Auth;


class Display extends Controller

{
    public function Display11(){

        return view ('login');
    }
    public function Display10(){

        return view ('cashadvance');
    }
    public function Display9(){

        return view ('Deduction');
    }
    public function Display8(){

        return view ('payroll');
    }
    public function Display7(){

        return view ('overtime');
    }
    public function Display6(){

        return view ('holiday');
    }
    public function Display5(){

        return view ('schedule');
    }
    public function Display4(){

        return view ('position');
    }
    public function Display3(){

        return view ('admindash');
    }
    public function Display2(){
        return view ('Employee');
    }
    public function DisplayAddEmployeeList() {
        return view('EmployeeList');
    }
    
    public function Display1(){

        $attendances = Attendance::all();
        return view('attendanceDash', compact('attendances'));
    }
    public function Display(){

        return view ('Attendance');
    }
    
    public function add(Request $EmployeeData)
    {

        $validatedData = $EmployeeData->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'birthdate' => 'required',
            'contact_no' => 'required',
            'gender' => 'required',
            'position_id' => 'nullable',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'statutory_benefits' => 'required',
        ]);
    
        Employee::create($validatedData);
        return response("Employee Added");
        
    }
    
    public function showlogin() {
        if (auth::check()) {
            $users = user_table::all();
            return view('login-sucess', compact('user_table'));
            
        }
        else {
            return view('homepage');
        }
    }

    public function loginAuth(Request $request) 
        {
            $IncomingFields = $request->validate([
                'username' => 'required',
                'password' => 'required',
            ]);
            
            if (Auth::attempt([
                'username' => $IncomingFields['username'],
                'password' => $IncomingFields['password']
            ])) {
                $request->session()->regenerate();

                // Flash a session message to show the Sweet Alert on the dashboard
                session()->flash('login_success', 'You have successfully logged in!');

                // Redirect to the named dashboard route
                return redirect()->route('admin.dashboard');
            } else {
                return redirect('login')->with('incorrect_msg', 'Incorrect Credentials. Login Unsuccessful.');
            }
        }

   
    public function Submit(Request $data)
    {
    $validated = $data->validate([
        'employee_id' => 'required|integer',
        'attendancestatus' => 'required',
        'date' => 'required|date',
        'check_in_time' => 'required',
    ]);

    $employeeId = $validated['employee_id'];
    $date = $validated['date'];
    $attendanceStatus = $validated['attendancestatus'];

    // Find an existing record for the same employee and date
    $attendance = Attendance::where('employee_id', $employeeId)
        ->where('date', $date)
        ->first();

    if ($attendance) {
        if ($attendanceStatus === 'timeout') {
            // Update the check-out time
            $attendance->update([
                'check_out_time' => now()->toTimeString(),
            ]);
            return back()->with('success', 'Time Out recorded successfully!');
        } else {
            return back()->with('error', 'Time In already exists for this employee on this date!');
        }
    } else {
        if ($attendanceStatus === 'timein') {
            // Create a new record for Time In
            Attendance::create([
                'employee_id' => $employeeId,
                'date' => $date,
                'check_in_time' => $validated['check_in_time'],
                'check_out_time' => null,
            ]);
            return back()->with('success', 'Time In recorded successfully!');
        } else {
            return back()->with('error', 'No Time In record found to Time Out!');
        }
    }
}
}