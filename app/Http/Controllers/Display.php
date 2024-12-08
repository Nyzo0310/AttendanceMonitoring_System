<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\user_table;
use App\Models\Position;
Use Illuminate\Support\Facades\Auth;
use App\Models\Deductions;
use App\Models\Schedule;


class Display extends Controller

{
    public function Display11(){

        return view ('login');
    }
    public function Display10(){

        return view ('cashadvance');
    }
    public function Display9(){
        $deduction = Deductions::all();
        return view ('Deduction', compact('deduction'));
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
        $schedule = Schedule::all();
        return view ('schedule', compact('schedule'));
    }
    public function Display4(){
        $position = Position::all();
        return view ('position', compact('position'));
    }
    public function Display3()
{
   
    $attendanceCounts = DB::table('attendances')
        ->selectRaw('
            MONTH(date) as month,
            SUM(TIME_TO_SEC(check_in_time) <= TIME_TO_SEC("06:00:00")) as ontime,
            SUM(TIME_TO_SEC(check_in_time) > TIME_TO_SEC("06:05:00")) as late
        ')
        ->groupByRaw('MONTH(date)')
        ->orderByRaw('MONTH(date)')
        ->get();

    // Pass the data to the view
    return view('admindash', compact('attendanceCounts'));
}
    public function Display2(){
        
        return view ('Employee');
    }
    public function DisplayAddEmployeeList() {
        $employees = Employee::all();  
        return view('EmployeeList', compact('employees')); 
    }
    
    
    public function Display1(){

        $attendances = Attendance::all();
        return view('attendanceDash', compact('attendances'));
    }
    public function Display(){

        return view ('Attendance');
    }
    public function saveposition(Request $position)
{
    $validateposition = $position->validate([
        'position_name' => 'required|string|max:255', 
        'rate_per_hour' => 'required|numeric',       
    ]);


    Position::create($validateposition);

    return response("Employee Added");
}
public function AddDeduction(Request $deduction)
{
    $validatededuction = $deduction->validate([
        'deduction_type' => 'required|string|max:255',
        'amount' => 'required|numeric', 
    ]);

    // Create a new position entry in the database
    Deductions::create($validatededuction);

    return response("Employee Added");
}
public function AddSched(Request $schedule){
    $validatedSched = $schedule->validate([
        'work_date' => 'required|date',
        'start_time' => 'required',
        'end_time' => 'required'
    ]);
    Schedule::create($validatedSched);
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
        session()->flash('login_success', 'You have successfully logged in!');
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
public function updatePosition(Request $request, $id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['success' => false, 'message' => 'Employee not found.']);
        }

        $employee->position = $request->input('position');
        $employee->save();

        return response()->json(['success' => true, 'message' => 'Position updated successfully.']);
    }
    public function assignPosition(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'employee_id' => 'required|exists:employees,employee_id',
            'position' => 'required|exists:positions,position_id', 
        ]);
    
        // Find the employee by employee_id
        $employee = Employee::find($validatedData['employee_id']);
        
        // Check if the selected position is different from the current position
        if ($employee->position_id != $validatedData['position']) {
            // Assign the new position_id to the employee
            $employee->position_id = $validatedData['position'];
            // Save the employee's new position
            $employee->save();
    
            // Return with success message
            return redirect()->back()->with('success', 'Position updated successfully!');
        } else {
            // Return with a message if the position is the same
            return redirect()->back()->with('info', 'No changes were made, as the selected position is the same.');
        }
    }
    
}

