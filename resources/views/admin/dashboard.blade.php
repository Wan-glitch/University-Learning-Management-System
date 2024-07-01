
    <div class="container mt-5">
    <div class="row">
        <!-- Users Card -->
        <div class="col-md-3">
            <div class="card equal-card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Users</span>
                            <div class="d-flex align-items-end mt-2">
                                <h3 class="mb-0 me-2">{{ $usersCount }}</h3>

                            </div>
                            <small>Total Users</small>
                        </div>
                        <span class="badge bg-label-primary rounded p-2">
                            <i class="bx bx-user bx-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Card -->

        <div class="col-md-3">
            <div class="card equal-card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Roles</span>
                            <div class="d-flex align-items-end mt-2">
                                <h3 class="mb-0 me-2">${{ $Roles }}</h3>

                            </div>
                            <small>Total Roles</small>
                        </div>
                        <span class="badge bg-label-primary rounded p-2">
                            <i class="bx bx-shield bx-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Orders Card -->
        <div class="col-md-3">
            <div class="card equal-card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Faculty</span>
                            <div class="d-flex align-items-end mt-2">
                                <h3 class="mb-0 me-2">{{ $FacultyCount }}</h3>

                            </div>
                            <small>Total Faculties</small>
                        </div>
                        <span class="badge bg-label-primary rounded p-2">
                            <i class="bx bx-buildings bx-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card equal-card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Faculty</span>
                            <div class="d-flex align-items-end mt-2">
                                <h3 class="mb-0 me-2">{{ $courseCount }}</h3>

                            </div>
                            <small>Total Courses</small>
                        </div>
                        <span class="badge bg-label-primary rounded p-2">
                            <i class="bx bx-box bx-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Revenue Card -->

    </div>

    <!-- Charts Row -->
    <div class="row mt-4">
        <!-- New Users Chart -->
        <div class="col-md-6">
            <div class="card equal-card">
                <div class="card-header">
                    <h5 class="card-title">New Users</h5>
                </div>
                <div class="card-body">
                    <div id="new-users-chart"></div>
                </div>
            </div>
        </div>

        <!-- Users in the Faculty Chart -->
        <div class="col-md-6">
            <div class="card equal-card">
                <div class="card-header">
                    <h5 class="card-title">Users in the Faculty</h5>
                </div>
                <div class="card-body">
                    <div id="faculty-users-chart"></div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- ApexCharts JS -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var newUsersOptions = {
                chart: {
                    type: 'line',
                    height: '200px'
                },
                series: [{
                    name: 'New Users',
                    data: @json(array_values($months->toArray()))
                }],
                xaxis: {
                    categories: @json(array_keys($months->toArray()))
                }
            };

            var newUsersChart = new ApexCharts(document.querySelector("#new-users-chart"), newUsersOptions);
            newUsersChart.render();

            var facultyUsersOptions = {
                chart: {
                    type: 'donut',
                    height: '210px'
                },
                series: @json($facultyCounts),
                labels: @json(array_values($facultyNames))
            };

            var facultyUsersChart = new ApexCharts(document.querySelector("#faculty-users-chart"),
                facultyUsersOptions);
            facultyUsersChart.render();
        });
    </script>

    <style>
        .equal-card {
            height: min-content;
        }
    </style>
@endsection
