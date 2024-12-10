<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash Advance Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        /* Global Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
        }

        /* Navbar Styles */
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
            width: 100%;
            margin: 0;
            box-sizing: border-box;
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

        /* User Info */
        .user-info img {
            border-radius: 50%;
            border: 2px solid #007bff;
            padding: 3px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Main Content Styles */
        .main-content {
            font-family: 'Georgia', serif;
            padding: 20px;
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        /* Table Styles */
        .table-wrapper {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="menu-and-logo">
            <a class="navbar-brand" href="#">Mclons Manpower Services</a>
            <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <div class="username">
            <i class="fas fa-user-circle"></i>
            @auth
                <span>{{ Auth::user()->username }}</span>
            @else
                <span>Guest</span>
            @endauth
        </div>
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
                        <h5>{{ Auth::user()->username }}</h5>
                        <span><i class="fas fa-circle text-success"></i> Online</span>
                    @else
                        <img src="{{ asset('path_to_guest_icon.png') }}" alt="Guest Icon" class="rounded-circle" width="70">
                        <h5>Guest</h5>
                        <span><i class="fas fa-circle text-secondary"></i> Offline</span>
                    @endauth
                </div>

                <div class="sidebar-section">Reports</div>
                <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>

                <div class="sidebar-section">Manage</div>
                <a href="{{ route('admin.attendance') }}"><i class="fas fa-calendar-check"></i> Attendance</a>
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
<!-- Main Content -->
<div class="main-content">
    <h2>Cash Advance</h2>
    <div class="table-wrapper">
        <!-- HTML Button Trigger for Modal -->
<button id="newCashAdvanceButton" class="btn btn-primary mb-3">
    <i class="fas fa-plus"></i> New
</button>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Employee ID</th>
                        <th>Employee Name</th> <!-- Add this column for employee name -->
                        <th>Amount</th>
                        <th>Status</th> <!-- Add status column -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cashAdvances as $cashAdvance)
                    <tr>
                        <td>{{ $cashAdvance->request_date }}</td>
                        <td>{{ $cashAdvance->employee_id }}</td>
                        <td>{{ $cashAdvance->employee ? $cashAdvance->employee->first_name . ' ' . $cashAdvance->employee->last_name : 'No Employee Found' }}</td>
                        <td>{{ $cashAdvance->amount }}</td>
                        <td>{{ $cashAdvance->status }}</td>
                        <td>
                            <!-- Action buttons (e.g., Edit, Delete) -->
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal for Adding Cash Advance -->
<div class="modal fade" id="cashAdvanceModal" tabindex="-1" aria-labelledby="cashAdvanceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cashAdvanceModalLabel">New Cash Advance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="/store">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="employee_id">Employee ID</label>
                        <input type="number" class="form-control" id="employee_id" name="employee_id" required>
                    </div>
                    <div class="form-group">
                        <label for="request_date">Request Date</label>
                        <input type="date" class="form-control" id="request_date" name="request_date" required>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript to handle Modal with Bootstrap 5 -->
<script>
    document.getElementById('newCashAdvanceButton').addEventListener('click', function() {
        // Initialize and show the modal
        var myModal = new bootstrap.Modal(document.getElementById('cashAdvanceModal'));
        myModal.show();
    });
</script>

<!-- Bootstrap JS (Bootstrap 5 version) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
