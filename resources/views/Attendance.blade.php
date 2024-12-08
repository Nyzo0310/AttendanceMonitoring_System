<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance System</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background-color: #edf2f7;
            margin: 0;
            padding: 0;
        }

         /* Navbar Styles */
         .navbar .btn i.fas.fa-bars {
                color: white; /* Ensures the icon color is white */
                font-size: 1.5rem; /* Adjust the size if necessary */
        }
         .navbar {
            background: linear-gradient(45deg, #007bff, #0056b3);
            padding: 10px 20px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: white !important;
            margin-right: 10px;
        }

        .navbar .menu-and-logo {
            display: flex;
            align-items: center;
        }

        .navbar .username {
            display: flex;
            align-items: center;
        }

        .navbar .username i {
            margin-right: 5px;
            font-size: 1.2rem;
        }

        /* Sidebar Styles */
        .offcanvas {
            width: 300px;
            background: linear-gradient(to bottom, #333, #444);
            color: white;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
        }

        .offcanvas-header {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: white;
        }

        .offcanvas-body {
            padding: 20px 10px;
        }

        /* Fancy Scrollbar */
        .offcanvas-body::-webkit-scrollbar {
            width: 8px;
        }
        .offcanvas-body::-webkit-scrollbar-thumb {
            background-color: #007bff;
            border-radius: 5px;
        }

        /* Sidebar Section Heading Styles */
        .sidebar-section {
            background-color: #444;
            color: #ffffff;
            padding: 15px;
            font-weight: bold;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        /* Sidebar Menu Link */
        .sidebar a {
            text-decoration: none;
            color: white;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            border-radius: 4px;
            margin: 5px 0;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #007bff;
            color: #ffffff;
            transform: scale(1.05);
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .sidebar a i {
            margin-right: 10px;
        }

          
        /* Attendance Card */
        .attendance-card {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            text-align: left;
            margin: 80px auto;
        }

        #clock {
            font-family: 'Orbitron', sans-serif;
            font-size: 60px;
            font-weight: 700;
            color: #2d3748;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-label {
            font-family: 'Georgia', serif;
            font-size: 18px;
            font-weight: 500;
            color: #4a5568;
            margin-bottom: 10px;
            display: block;
        }

        input[type="text"], select {
            width: 100%;
            padding: 12px 16px;
            font-size: 16px;
            color: #4a5568;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            background-color: #f7fafc;
            margin-bottom: 25px;
            transition: box-shadow 0.2s ease-in-out, border-color 0.2s ease-in-out;
        }

        input[type="text"]:focus, select:focus {
            border-color: #3182ce;
            box-shadow: 0 0 8px rgba(49, 130, 206, 0.5);
            outline: none;
        }

        input[type="submit"] {
            width: 100%;
            padding: 15px 20px;
            font-size: 18px;
            font-weight: 500;
            color: #ffffff;
            background-color: #3182ce;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #2b6cb0;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            .attendance-card {
                padding: 30px;
            }

            #clock {
                font-size: 48px;
            }

            input[type="text"], select {
                padding: 12px 15px;
            }

            input[type="submit"] {
                padding: 12px 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a class="navbar-brand" href="#">Mclons Manpower Services</a>
        <button class="btn" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu">
            <i class="fas fa-bars"></i>
        </button>
    </nav>

       <!-- Offcanvas Sidebar -->
       <div class="offcanvas offcanvas-start" id="offcanvasMenu">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Menu</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <div class="sidebar">
                <!-- User Info -->
                <div class="user-info text-center mb-4">
                    @auth
                        <img src="{{ asset('path_to_user_icon.png') }}" alt="User Icon" class="rounded-circle" width="70">
                        <h5 class="mt-2">{{ Auth::user()->username }}</h5>
                        <span><i class="fas fa-circle text-success"></i> Online</span>
                    @else
                        <img src="{{ asset('path_to_guest_icon.png') }}" alt="Guest Icon" class="rounded-circle" width="70">
                        <h5 class="mt-2">Guest</h5>
                        <span><i class="fas fa-circle text-secondary"></i> Offline</span>
                    @endauth
                </div>

                <div class="sidebar-section">Reports</div>
                <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>

                <div class="sidebar-section">Manage</div>
                <a href="{{ route('admin.attendanceDash') }}"><i class="fas fa-calendar-check"></i> Attendance Dashboard</a>
                <a href="#employeesSubmenu" data-bs-toggle="collapse" class="d-flex align-items-center">
                    <i class="fas fa-users"></i> Employees
                    <i class="fas fa-chevron-right ms-auto"></i>
                </a>
                <div class="collapse" id="employeesSubmenu">
                    <ul class="list-unstyled ps-4">
                        <li><a href="{{ route('admin.addEmployeeList') }}">Employee List</a></li>
                        <li><a href="{{ route('admin.overtime') }}">Overtime</a></li>
                        <li><a href="{{ route('admin.cashadvance') }}">Cash Advance</a></li>
                        <li><a href="{{ route('admin.schedule') }}">Schedules</a></li>
                    </ul>
                </div>

                <a href="{{ route('admin.deduction') }}"><i class="fas fa-dollar-sign"></i> Deductions</a>
                <a href="{{ route('admin.position') }}"><i class="fas fa-briefcase"></i> Positions</a>

                <div class="sidebar-section">Printables</div>
                <a href="{{ route('admin.payroll') }}"><i class="fas fa-print"></i> Payroll</a>
                <a href="{{ route('admin.schedule') }}"><i class="fas fa-clock"></i> Schedule</a>
            </div>
        </div>
    </div>


        <!-- Attendance Form -->
        <div class="attendance-card">
        <div id="clock"></div>
        <form action="{{ route('admin.submit') }}" method="post">
            @csrf
            <div>
                <label for="employee_id" class="form-label">Employee ID</label>
                <input type="text" id="employee_id" name="employee_id" placeholder="Enter Employee ID" required>
            </div>
            <div>
                <label for="attendancestatus" class="form-label">Attendance</label>
                <select id="attendancestatus" name="attendancestatus" required>
                    <option value="">--Select--</option>
                    <option value="timein">Time In</option>
                    <option value="timeout">Time Out</option>
                </select>
            </div>
            <input type="hidden" name="date" value="{{ date('Y-m-d') }}">
            <input type="hidden" name="check_in_time" value="{{ now()->toTimeString() }}">
            <input type="submit" value="Submit">
        </form>
    </div>

    <script>
        // Function to update clock in real time
        function updateClock() {
            const now = new Date();
            const currentTime = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            document.getElementById('clock').textContent = currentTime;
        }

        // Update clock every second
        setInterval(updateClock, 1000);
        updateClock();
    </script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Display SweetAlert2 on success
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "{{ session('success') }}",
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false,
        });
    @endif

    // Display SweetAlert2 on error
    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: "{{ session('error') }}",
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false,
        });
    @endif
</script>

</body>
</html>
