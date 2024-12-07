<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance System</title>
    <style>
    body {
        font-family: 'Poppins', Arial, sans-serif;
        background-color: #f0f4f8;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        height: 100vh;
        margin: 0;
        text-align: center;
    }

    #clock {
        font-size: 80px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #1a202c;
    }

    .container {
        margin-top: 20px;
        text-align: left;
        width: 100%;
        max-width: 400px;
    }

    h1 {
        font-size: 24px;
        color: #2d3748;
        margin-bottom: 10px;
    }

    input[type="text"], select {
        width: 100%;
        padding: 12px;
        margin-bottom: 20px;
        font-size: 16px;
        border: 1px solid #cbd5e0;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        outline: none;
        transition: all 0.3s ease;
    }

    input[type="text"]:focus, select:focus {
        border-color: #3182ce;
        box-shadow: 0 0 6px rgba(49, 130, 206, 0.5);
    }

    input[type="submit"] {
        width: 100%;
        padding: 12px;
        font-size: 18px;
        color: #fff;
        background-color: #3182ce;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    input[type="submit"]:hover {
        background-color: #2b6cb0;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }

    #attendanceMessage {
        font-size: 18px;
        margin-top: 10px;
        color: #38a169;
    }

    @media (max-width: 480px) {
        #clock {
            font-size: 60px;
        }

        h1 {
            font-size: 20px;
        }

        input[type="text"], select, input[type="submit"] {
            font-size: 14px;
        }
    }
</style>
</head>
<body>
<form action="/Submit" method="post">
    @csrf
    <div id="clock"></div>
    <div class="container">
        <h1>Employee ID</h1>
        <input type="text" id="employee_id" name="employee_id" required>
    </div>
    <div class="container">
        <h1>Attendance</h1>
        <select id="attendancestatus" name="attendancestatus" required>
            <option value="">--Select--</option>
            <option value="timein">Time In</option>
            <option value="timeout">Time Out</option>
        </select>
        <div id="attendanceMessage"></div>
    </div>
    <input type="submit">
    <input type="hidden" name="date" value="{{ date('Y-m-d') }}">
<input type="hidden" name="check_in_time" value="{{ now()->toTimeString() }}">
</form>


    

</body>
<script>
    // Function to update clock in real time
    function updateClock() {
        const currentTime = new Date().toLocaleTimeString();
        document.getElementById('clock').textContent = currentTime;
    }

    // Update clock every second
    setInterval(updateClock, 1000);
    updateClock(); // Call it initially to show time immediately

    // Function to handle the attendance selection
    function recordAttendance() {
        const status = document.getElementById('attendancestatus').value;
        const messageDiv = document.getElementById('attendanceMessage');

        
    }
</script>
</html>
