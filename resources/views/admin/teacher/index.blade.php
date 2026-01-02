@extends('admin.layout.app')

@push('css')
    <style>
        .badge {
            padding: 6px 10px;
            font-size: 13px;
            font-weight: 500;
        }

        .badge-success {
            background-color: #0c9f10;
        }
        .card .row{
            margin-right: 0;
            margin-left: 0;
        }
    </style>
@endpush

@section('content')
    <div class="card-header text-end">
        <a href="{{ route('admin.teacher.add') }}" class="btn btn-primary btn-sm">
            Add New
        </a>
    </div>
    <div class="card-body">
        <div class="card shadow-sm mb-3 border border-1">
            <div class="row w-100">
                <div class="col-md-2 d-flex align-items-center justify-content-center bg-light">
                    <img src="https://i.pravatar.cc/150?img=5" class="img-fluid rounded-circle" alt="Teacher">
                </div>
                <div class="col-md-10">
                    <div class="card-body p-3 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h5 class="card-title mb-1">
                                    Dr. Sarah Johnson
                                    <span class="badge bg-success mx-2 p-2 py-1">Active</span>
                                </h5>
                                <span class="badge bg-primary me-1">Mathematics</span>
                                <span class="badge bg-primary me-1">Statistics</span>
                                <span class="badge bg-primary me-1">Statistics</span>
                                <span class="badge bg-primary me-1">Statistics</span>
                            </div>
                            <div class="d-flex gap-1">
                                <button class="btn btn bg-primary-gradient text-light" data-toggle="tooltip" data-placement="top" title="Edit Teacher">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button class="btn bg-danger-gradient text-light" data-toggle="tooltip" data-placement="top" title="Delete Teacher">
                                    <i class="fa fa-trash"></i>
                                </button>
                                <button class="btn bg-secondary-gradient text-light" data-toggle="tooltip" data-placement="top" title="Schedule">
                                    <i class="fa-solid fa-calendar-days"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row flex-grow-1">
                            <div class="col-md-6">
                                <p class="mb-1 small">
                                    <strong>Email:</strong>
                                    <a href="mailto:sarah.johnson@school.edu">sarah.johnson@school.edu</a>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1 small">
                                    <strong>Phone:</strong>
                                    <a href="tel:+15551234567">+1 (555) 123-4567</a>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1 small"><strong>Qualification:</strong> Ph.D. in Mathematics</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-0 small"><strong>Employee ID:</strong> TCH-2024-001</p>
                            </div>
                            <div class="col-md-6 d-none">
                                <div
                                    class="border border-2 border-dashed border-secondary rounded p-2 d-flex align-items-center justify-content-center">
                                    <small class="text-muted text-center">
                                        <i class="bi bi-plus-circle fs-5 d-block mb-1"></i>
                                        Feature Placeholder
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- @include('admin.layout.inc.paginate', ['item' => $subjects]) --}}
    </div>
@endsection

@push('js')
@endpush
