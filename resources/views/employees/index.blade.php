
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container-fluid py-5">

    <div class="card shadow-sm">

        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Employee Management System</h3>
        </div>

        <div class="card-body">
            <div class="row g-3 mb-4">

    <!-- Total Employees -->
    <div class="col-md-4 col-lg-2">
        <div class="card bg-primary text-white shadow-sm border-0 h-100">
            <div class="card-body">
                <h6>Total Employees</h6>
                <h3 class="fw-bold">{{ $totalEmployees }}</h3>
            </div>
        </div>
    </div>

    <!-- Male Employees -->
    <div class="col-md-4 col-lg-2">
        <div class="card bg-info text-white shadow-sm border-0 h-100">
            <div class="card-body">
                <h6>Male Employees</h6>
                <h3 class="fw-bold">{{ $maleEmployees }}</h3>
            </div>
        </div>
    </div>

    <!-- Female Employees -->
    <div class="col-md-4 col-lg-2">
        <div class="card bg-danger text-white shadow-sm border-0 h-100">
            <div class="card-body">
                <h6>Female Employees</h6>
                <h3 class="fw-bold">{{ $femaleEmployees }}</h3>
            </div>
        </div>
    </div>

    <!-- Average Salary -->
    <div class="col-md-4 col-lg-2">
        <div class="card bg-success text-white shadow-sm border-0 h-100">
            <div class="card-body">
                <h6>Average Salary</h6>
                <h3 class="fw-bold">
                    KSh {{ number_format($averageSalary ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>

    <!-- Total Payroll -->
    <div class="col-md-4 col-lg-2">
        <div class="card bg-warning text-dark shadow-sm border-0 h-100">
            <div class="card-body">
                <h6>Total Payroll</h6>
                <h3 class="fw-bold">
                    KSh {{ number_format($totalPayroll ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>

    <!-- Departments -->
    <div class="col-md-4 col-lg-2">
        <div class="card bg-dark text-white shadow-sm border-0 h-100">
            <div class="card-body">
                <h6>Departments</h6>
                <h3 class="fw-bold">{{ $departments }}</h3>
            </div>
        </div>
    </div>

</div>

            <div class="table-responsive">
    
            <form action="{{ route('employees.index') }}" method="GET" class="mb-4">
    <div class="input-group">
        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Search employees..."
            value="{{ request('search') }}"
        >

        <button type="submit" class="btn btn-primary">
            Search
        </button>

        <a href="{{ route('employees.index') }}" class="btn btn-secondary">
            Clear
        </a>
    </div>
</form>

                <table class="table table-bordered table-striped table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>FIRST NAME</th>
                            <th>LAST NAME</th>
                            <th>EMAIL</th>
                            <th>PHONE NO</th>
                            <th>GENDER</th>
                            <th>HIRE DATE</th>
                            <th>DEPARTMENT</th>
                            <th>SALARY</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($employees as $employee)
                        <tr>
                            <td>{{ $employee->id }}</td>
                            <td>{{ $employee->first_name }}</td>
                            <td>{{ $employee->last_name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->phone_number }}</td>

                            <td>
                                @if($employee->gender == 'Male')
                                    <span class="badge bg-primary">Male</span>
                                @elseif($employee->gender == 'Female')
                                    <span class="badge bg-danger">Female</span>
                                @else
                                    <span class="badge bg-secondary">
                                        {{ $employee->gender }}
                                    </span>
                                @endif
                            </td>

                            <td>{{ $employee->hire_date }}</td>

                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ $employee->department }}
                                </span>
                            </td>

                            <td class="fw-bold">
                                KSh {{ number_format($employee->salary, 2) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
                </table>

<div class="mt-3">
    {{ $employees->links() }}
</div>

            </div>

        </div>
    </div>

</div>

</body>
</html>

