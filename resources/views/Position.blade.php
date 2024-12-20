<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Position Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        /* Global Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            background: #f8f9fa; /* Soft gray background */
        }

        h2 {
            font-family: Georgia, serif;
            font-size: 30px;
            font-weight: 600;
            color: #495057;
            text-align: left; /* Aligns the title to the left */
            margin-bottom: 20px;
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

        /* User Info */
        .user-info img {
            border-radius: 50%;
            border: 2px solid #007bff;
            padding: 3px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Main Content Styles */
        .main-content {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Table Wrapper */
        .table-wrapper {
            padding: 20px;
        }

        /* Table Styles */
        .table {
            border-collapse: collapse;
            width: 100%;
            text-align: center;
        }

        .table thead th {
            background: linear-gradient(90deg, #007bff, #0056b3);
            color: white;
            text-transform: uppercase;
            font-weight: bold;
            padding: 10px;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background-color: #e2e6ea;
        }

        .table tbody td {
            padding: 15px;
            border: 1px solid #dee2e6;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .empty-state {
            text-align: center;
            font-weight: bold;
            color: #6c757d;
        }

        /* Buttons */
        .btn-primary, .btn-success, .btn-danger {
            border: none;
            border-radius: 5px;
            padding: 8px 12px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(90deg, #007bff, #0056b3);
        }

        .btn-success {
            background: linear-gradient(90deg, #28a745, #218838);
        }

        .btn-danger {
            background: linear-gradient(90deg, #dc3545, #b02a37);
        }

        .btn-primary:hover, .btn-success:hover, .btn-danger:hover {
            opacity: 0.8;
            transform: scale(1.05);
        }

        /* Modals */
        .modal-header {
            background: linear-gradient(90deg, #007bff, #0056b3);
            color: white;
            border-radius: 5px 5px 0 0;
        }

        .modal-content {
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .modal-footer {
            border-top: none;
        }

        /* Add Position Button */
        .add-button {
            display: flex;
            justify-content: flex-start;
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
                <a href="{{ route('admin.attendanceDash') }}"><i class="fas fa-calendar-check"></i> Attendance</a>
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
            </div>
        </div>
    </div>

    <div class="container main-content">
        <h2>Manage Position</h2>
        <div class="table-wrapper">
            <!-- Add Position Button -->
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addPositionModal">
                <i class="fas fa-plus"></i> New
            </button>

            <!-- Position Table -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Position Title</th>
                            <th>Rate Per Hour</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($position) === 0)
                            <tr>
                                <td colspan="3" class="text-center">No data available</td>
                            </tr>
                        @else
                            @foreach($position as $positions)
                            <tr data-id="{{ $positions->position_id }}">
                                <td>{{ $positions->position_name }}</td>
                                <td>{{ $positions->rate_per_hour }}</td>
                                <td>
                                    <!-- Edit Button -->
                                    <button class="btn btn-success btn-edit" 
                                            data-id="{{ $positions->position_id }}" 
                                            data-name="{{ $positions->position_name }}" 
                                            data-rate="{{ $positions->rate_per_hour }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <!-- Delete Button -->
                                    <button class="btn btn-danger btn-delete" 
                                            data-id="{{ $positions->position_id }}">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <!-- Add Position Modal -->
    <div class="modal fade" id="addPositionModal" tabindex="-1" aria-labelledby="addPositionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPositionModalLabel">Add Position</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                <form id="addPositionForm" method="POST" action="{{ route('admin.saveposition') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="position_name" class="form-label">Position Name</label>
                        <input type="text" class="form-control" id="position_name" name="position_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="rate_per_hour" class="form-label">Rate Per Hour</label>
                        <input type="number" class="form-control" id="rate_per_hour" name="rate_per_hour" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Position</button>
                </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Position Modal -->
    <div class="modal fade" id="editPositionModal" tabindex="-1" aria-labelledby="editPositionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPositionModalLabel">Edit Position</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editPositionForm">
                        @csrf
                        <input type="hidden" id="edit_position_id">
                        <div class="mb-3">
                            <label for="edit_position_name" class="form-label">Position Name</label>
                            <input type="text" class="form-control" id="edit_position_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_rate_per_hour" class="form-label">Rate Per Hour</label>
                            <input type="number" class="form-control" id="edit_rate_per_hour" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelector('#addPositionForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent default form submission

    // Collect form data directly from input fields
    const positionName = document.getElementById('position_name').value.trim();
    const ratePerHour = document.getElementById('rate_per_hour').value.trim();

    if (!positionName || !ratePerHour) {
        Swal.fire({
            title: 'Error!',
            text: 'Both Position Name and Rate Per Hour are required.',
            icon: 'error',
            confirmButtonText: 'OK',
        });
        return;
    }

    // Send POST request via fetch API
    fetch('{{ route('admin.saveposition') }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            position_name: positionName,
            rate_per_hour: ratePerHour,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                // Close the modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('addPositionModal'));
                modal.hide();

                // Show SweetAlert success message
                Swal.fire({
                    title: 'Success!',
                    text: 'Position has been added successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK',
                }).then(() => {
                    // Reload the page to show the updated position list
                    location.reload();
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.message || 'An error occurred while adding the position.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                });
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error!',
                text: 'An unexpected error occurred.',
                icon: 'error',
                confirmButtonText: 'OK',
            });
        });
});


        document.addEventListener('DOMContentLoaded', () => {
            // Edit Button Click
            document.body.addEventListener('click', (e) => {
                if (e.target.closest('.btn-edit')) {
                    const button = e.target.closest('.btn-edit');
                    const id = button.getAttribute('data-id');
                    const name = button.getAttribute('data-name');
                    const rate = button.getAttribute('data-rate');

                    document.getElementById('edit_position_id').value = id;
                    document.getElementById('edit_position_name').value = name;
                    document.getElementById('edit_rate_per_hour').value = rate;

                    new bootstrap.Modal(document.getElementById('editPositionModal')).show();
                }
            });

            // Edit Form Submission
            document.getElementById('editPositionForm').addEventListener('submit', (e) => {
                e.preventDefault();
                const id = document.getElementById('edit_position_id').value;
                const name = document.getElementById('edit_position_name').value;
                const rate = document.getElementById('edit_rate_per_hour').value;

                fetch(`/position/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ position_name: name, rate_per_hour: rate }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Success', 'Position updated successfully!', 'success').then(() => location.reload());
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                });
            });

            // Delete Button Click
            document.body.addEventListener('click', (e) => {
                if (e.target.closest('.btn-delete')) {
                    const button = e.target.closest('.btn-delete');
                    const id = button.getAttribute('data-id');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'This action cannot be undone!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/position/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                },
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire('Deleted!', 'Position deleted successfully!', 'success').then(() => location.reload());
                                } else {
                                    Swal.fire('Error', data.message, 'error');
                                }
                            });
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
