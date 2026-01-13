@extends('user.layout.app')

@push('css')
    <style>
        body {
            background-color: #f8f9fa;
        }

        .stat-card {
            border-left: 4px solid;
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card.primary {
            border-left-color: #0d6efd;
        }

        .stat-card.success {
            border-left-color: #198754;
        }

        .stat-card.warning {
            border-left-color: #ffc107;
        }

        .stat-card.info {
            border-left-color: #0dcaf0;
        }

        .action-card {
            transition: all 0.3s;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .action-card:hover {
            border-color: #0d6efd;
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .session-card {
            border-left: 4px solid #0d6efd;
        }

        .badge-status {
            padding: 6px 12px;
            font-size: 12px;
        }
    </style>
@endpush

@section('content')
    <div class="card-header">
        <h2 class="fw-bold">Welcome back, Warren Kirkland! 👋</h2>
        <p class="text-muted">Here's what's happening with your learning journey today.</p>
    </div>
    <div class="card-body">
        <div class="container-fluid p-4">

            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="icon-pie-chart text-warning"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Total Classes</p>
                                        <h4 class="card-title">150</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="fa fa-hourglass-half text-danger"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Hours Learned</p>
                                        <h4 class="card-title">50+</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="icon-wallet text-success"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Upcoming Session</p>
                                        <h4 class="card-title">5</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 d-none">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="icon-social-twitter text-primary"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Followers</p>
                                        <h4 class="card-title">+45K</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row mb-4">
                <div class="col-12">
                    <h5 class="fw-bold mb-3">Quick Actions</h5>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card action-card shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-flex mb-3">
                                <i class="fa fa-plus fa-2x text-primary"></i>
                            </div>
                            <h6 class="fw-semibold">Book New Session</h6>
                            <p class="text-muted small mb-0">Find and book a teacher</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card action-card shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="bg-success bg-opacity-10 p-3 rounded-circle d-inline-flex mb-3">
                                <i class="fa fa-calendar fa-2x text-success"></i>
                            </div>
                            <h6 class="fw-semibold">My Schedule</h6>
                            <p class="text-muted small mb-0">View your calendar</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card action-card shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="bg-warning bg-opacity-10 p-3 rounded-circle d-inline-flex mb-3">
                                <i class="fa fa-users fa-2x text-warning"></i>
                            </div>
                            <h6 class="fw-semibold">My Teachers</h6>
                            <p class="text-muted small mb-0">View your teachers</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card action-card shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="bg-info bg-opacity-10 p-3 rounded-circle d-inline-flex mb-3">
                                <i class="fa fa-credit-card fa-2x text-info"></i>
                            </div>
                            <h6 class="fw-semibold">Payment History</h6>
                            <p class="text-muted small mb-0">View transactions</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Upcoming Sessions -->
                <div class="col-lg-8 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-bold">Upcoming Sessions</h5>
                                <a href="#" class="text-decoration-none small">View All</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Session 1 -->
                            <div class="session-card card mb-3">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-2 text-center mb-3 mb-md-0">
                                            <div class="bg-primary bg-opacity-10 rounded p-2">
                                                <div class="fw-bold text-primary">JAN</div>
                                                <div class="h4 mb-0 fw-bold">15</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3 mb-md-0">
                                            <h6 class="fw-semibold mb-1">Mathematics - Calculus</h6>
                                            <p class="text-muted small mb-1">
                                                <i class="fa fa-user-tie me-1"></i> John Smith
                                            </p>
                                            <p class="text-muted small mb-0">
                                                <i class="fa fa-clock me-1"></i> 10:00 AM - 11:00 AM
                                            </p>
                                        </div>
                                        <div class="col-md-4 text-md-end">
                                            <span class="badge bg-success badge-status mb-2">Confirmed</span>
                                            <div>
                                                <button class="btn btn-sm btn-outline-primary">
                                                    <i class="fa fa-video me-1"></i> Join Class
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Session 2 -->
                            <div class="session-card card mb-3">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-2 text-center mb-3 mb-md-0">
                                            <div class="bg-primary bg-opacity-10 rounded p-2">
                                                <div class="fw-bold text-primary">JAN</div>
                                                <div class="h4 mb-0 fw-bold">17</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3 mb-md-0">
                                            <h6 class="fw-semibold mb-1">Physics - Mechanics</h6>
                                            <p class="text-muted small mb-1">
                                                <i class="fa fa-user-tie me-1"></i> Sarah Johnson
                                            </p>
                                            <p class="text-muted small mb-0">
                                                <i class="fa fa-clock me-1"></i> 2:00 PM - 3:30 PM
                                            </p>
                                        </div>
                                        <div class="col-md-4 text-md-end">
                                            <span class="badge bg-warning text-dark badge-status mb-2">Pending</span>
                                            <div>
                                                <button class="btn btn-sm btn-outline-secondary" disabled>
                                                    Awaiting Confirmation
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Session 3 -->
                            <div class="session-card card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-2 text-center mb-3 mb-md-0">
                                            <div class="bg-primary bg-opacity-10 rounded p-2">
                                                <div class="fw-bold text-primary">JAN</div>
                                                <div class="h4 mb-0 fw-bold">20</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3 mb-md-0">
                                            <h6 class="fw-semibold mb-1">Chemistry - Organic</h6>
                                            <p class="text-muted small mb-1">
                                                <i class="fa fa-user-tie me-1"></i> Michael Brown
                                            </p>
                                            <p class="text-muted small mb-0">
                                                <i class="fa fa-clock me-1"></i> 4:00 PM - 5:00 PM
                                            </p>
                                        </div>
                                        <div class="col-md-4 text-md-end">
                                            <span class="badge bg-success badge-status mb-2">Confirmed</span>
                                            <div>
                                                <button class="btn btn-sm btn-outline-primary">
                                                    View Details
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="col-lg-4">
                    <!-- Notifications -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0 fw-bold">Notifications</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                                <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                                    <i class="fa fa-bell text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1 small fw-semibold">Class Reminder</p>
                                    <p class="mb-0 small text-muted">Your Math class starts in 2 hours</p>
                                    <small class="text-muted">10 mins ago</small>
                                </div>
                            </div>

                            <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                                <div class="bg-success bg-opacity-10 p-2 rounded me-3">
                                    <i class="fa fa-check text-success"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1 small fw-semibold">Booking Confirmed</p>
                                    <p class="mb-0 small text-muted">Your session with Sarah Johnson is confirmed</p>
                                    <small class="text-muted">2 hours ago</small>
                                </div>
                            </div>

                            <div class="d-flex align-items-start">
                                <div class="bg-info bg-opacity-10 p-2 rounded me-3">
                                    <i class="fa fa-star text-info"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1 small fw-semibold">New Teacher Available</p>
                                    <p class="mb-0 small text-muted">A new Physics teacher joined your area</p>
                                    <small class="text-muted">1 day ago</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0 fw-bold">Recent Activity</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <p class="mb-0 small fw-semibold">Completed: Math Class</p>
                                        <small class="text-muted">with John Smith</small>
                                    </div>
                                    <span class="badge bg-success">✓</span>
                                </div>
                                <small class="text-muted">Jan 12, 2026</small>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <p class="mb-0 small fw-semibold">Payment Successful</p>
                                        <small class="text-muted">$50.00 paid</small>
                                    </div>
                                    <span class="badge bg-primary">$</span>
                                </div>
                                <small class="text-muted">Jan 11, 2026</small>
                            </div>

                            <div>
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <p class="mb-0 small fw-semibold">Booked: Physics Session</p>
                                        <small class="text-muted">with Sarah Johnson</small>
                                    </div>
                                    <span class="badge bg-info">📅</span>
                                </div>
                                <small class="text-muted">Jan 10, 2026</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush
