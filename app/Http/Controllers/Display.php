<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\user_table;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;
use App\Models\Deductions;
use App\Models\Schedule;

class Display extends Controller
{
    public function Display11()
    {
        return view('login');
    }

    public function Display10()
    {
        return view('cashadvance');
    }

    public function Display9()
    {
        $deduction = Deductions::all();
        return view('Deduction', compact('deduction'));
    }

    public function Display8()
    {
        return view('payroll');
    }

    public function Display7()
    {
        return view('overtime');
    }

    public function Display6()
    {
        return view('holiday');
    }

    public function Display5()
    {
        $schedule = Schedule::all();
        return view('schedule', compact('schedule'));
    }

    public function Display4()
    {
        $position = Position::all();
        return view('position', compact('position'));
    }

    public function Display3()
    {
        // Total Employees
        $totalEmployees = Employee::count();

        // On-time Percentage (Total On-time / Total Records * 100)
        $totalAttendance = Attendance::count();
        $onTimeAttendance = Attendance::whereRaw('TIME_TO_SEC(check_in_time) <= TIME_TO_SEC("06:00:00")')->count();
        $onTimePercentage = $totalAttendance > 0 ? ($onTimeAttendance / $totalAttendance) * 100 : 0;

        // On Time Today
        $today = now()->toDateString();
        $onTimeToday = Attendance::whereDate('date', $today)
            ->whereRaw('TIME_TO_SEC(check_in_time) <= TIME_TO_SEC("06:00:00")')
            ->count();

        // Late Today
        $lateToday = Attendance::whereDate('date', $today)
            ->whereRaw('TIME_TO_SEC(check_in_time) > TIME_TO_SEC("06:05:00")')
            ->count();

        // Monthly Attendance Counts
        $attendanceCounts = DB::table('attendances')
            ->selectRaw('
                MONTH(date) as month,
                SUM(TIME_TO_SEC(check_in_time) <= TIME_TO_SEC("06:00:00")) as ontime,
                SUM(TIME_TO_SEC(check_in_time) > TIME_TO_SEC("06:05:00")) as late
            ')
            ->groupByRaw('MONTH(date)')
            ->orderByRaw('MONTH(date)')
            ->get();

        return view('admindash', compact('totalEmployees', 'onTimePercentage', 'onTimeToday', 'lateToday', 'attendanceCounts'));
    }

    public function Display2()
    {
        return view('Employee');
    }

    public function DisplayAddEmployeeList()
    {
        $employees = Employee::all();
        return view('EmployeeList', compact('employees'));
    }

    public function Display1()
    {
        $attendances = Attendance::all();
        return view('attendanceDash', compact('attendances'));
    }

    public function Display()
    {
        return view('Attendance');
    }

    public function saveposition(Request $request)
    {
        $validated = $request->validate([
            'position_name' => 'required|string|max:255',
            'rate_per_hour' => 'required|numeric',
        ]);

        Position::create($validated);

        return response()->json(['success' => true, 'message' => 'Position added successfully.']);
    }

    public function AddDeduction(Request $deduction)
    {
        $validated = $deduction->validate([
            'deduction_type' => 'required|string|max:255',
            'amount' => 'required|numeric',
        ]);

        Deductions::create($validated);

        return response()->json(['success' => true, 'message' => 'Deduction added successfully.']);
    }

    public function AddSched(Request $schedule)
    {
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

        return redirect()->route('admin.addEmployeeList')->with('success', 'Employee Added Successfully!');
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

        $attendance = Attendance::where('employee_id', $employeeId)
            ->where('date', $date)
            ->first();

        if ($attendance) {
            if ($attendanceStatus === 'timeout') {
                $attendance->update([
                    'check_out_time' => now()->toTimeString(),
                ]);
                return back()->with('success', 'Time Out recorded successfully!');
            } else {
                return back()->with('error', 'Time In already exists for this employee on this date!');
            }
        } else {
            if ($attendanceStatus === 'timein') {
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

    public function deleteEmployee($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('admin.addEmployeeList')->with('success', 'Employee deleted successfully.');
    }

    public function deleteDeduction($id)
    {
        \Log::info("Received request to delete deduction with ID: $id");

        $deduction = Deductions::find($id);

        if ($deduction) {
            \Log::info("Found deduction: " . json_encode($deduction));
            $deduction->delete();
            \Log::info("Deduction with ID $id deleted successfully.");
            return response()->json(['success' => true, 'message' => 'Deduction deleted successfully.']);
        }

        \Log::error("Deduction with ID $id not found.");
        return response()->json(['success' => false, 'message' => 'Deduction not found.']);
    }

    public function deletePosition($id)
    {
        \Log::info("Attempting to delete position with ID: $id");
        try {
            $position = Position::findOrFail($id);
            $position->delete();

            \Log::info("Deleted position with ID: $id successfully.");
            return response()->json(['success' => true, 'message' => 'Position deleted successfully.']);
        } catch (\Exception $e) {
            \Log::error("Error deleting position with ID: $id - " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An unexpected error occurred.']);
        }
    }

    
    public function updatePosition(Request $request, $id)
    {
        $validated = $request->validate([
            'position_name' => 'required|string|max:255',
            'rate_per_hour' => 'required|numeric',
        ]);

        $position = Position::where('position_id', $id)->first();
        if (!$position) {
            return response()->json(['success' => false, 'message' => 'Position not found.']);
        }

        $position->update($validated);
        return response()->json(['success' => true, 'message' => 'Position updated successfully.']);
    }


    public function assignPosition(Request $request)
    {
        $validatedData = $request->validate([
            'employee_id' => 'required|exists:employees,employee_id',
            'position' => 'required|exists:positions,position_id',
        ]);

        $employee = Employee::find($validatedData['employee_id']);

        if ($employee->position_id != $validatedData['position']) {
            $employee->position_id = $validatedData['position'];
            $employee->save();

            return redirect()->back()->with('success', 'Position updated successfully!');
        } else {
            return redirect()->back()->with('info', 'No changes were made, as the selected position is the same.');
        }
    }
}