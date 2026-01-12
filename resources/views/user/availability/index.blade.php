@extends('user.layout.app')

@push('css')
    <style>
        .badge {
            padding: 6px 10px;
            font-size: 13px;
            font-weight: 500;
        }

        .day-header {
            border-radius: 5px 5px 0 0;
        }
    </style>
@endpush

@section('content')
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
        <form action="" method="get" autocomplete="off">
            <div class="d-flex gap-2 flex-wrap">
                <input type="date" name="date" id="date" class="form-control" style="width: 160px;"
                    min="{{ now()->toDateString() }}" value="{{ now()->toDateString() }}" required>

                <select class="form-select" style="width: 160px;" name="subject" required>
                    <option value="" {{ blank(request()->subject) ? 'selected' : '' }} disabled>Select Subject</option>
                    @foreach ($subjects ?? [] as $subject)
                        <option value="{{ $subject?->id ?? '' }}" {{ request()->subject === $subject?->id ? 'selected' : '' }}>{{ $subject?->name ?? '' }}</option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-secondary">Filter <i
                        class="fa fa-filter opacity-75 ms-1"></i></button>

            </div>
        </form>
    </div>
    <div class="card-body">
        @if (request()->date && request()->subject)
            @forelse ($availabilities as $teacher => $slots)
                @php
                    $profile_pic = $slots->first()->profile_pic;
                    $teacherName = $slots->first()->teacher_name;
                    $sessionFee = $slots->first()->session_fee;
                    $students = $slots->sum('students_count');

                @endphp
                <div class="card mb-3 border ">
                    <div class="row g-0">
                        <div class="col-md-2">
                            <img src="{{ asset('../storage/' . $profile_pic ?? '') }}" class="img-fluid rounded-start"
                                alt="..." style="height: 100%;">
                        </div>
                        <div class="col-md-5">
                            <div class="card-body py-3 px-0">
                                <h5 class="card-title">
                                    {{ $teacherName ?? '' }}
                                    <span class="my-1 mx-2 badge bg-light text-dark rounded-pill"
                                        style="font-size: 0.8rem;">
                                        <i class="fas fa-star text-warning"></i> 4.9 (127)
                                    </span>

                                </h5>
                                {{-- <p class="text-muted mb-2">
                            <i class="fas fa-graduation-cap"></i> Mathematics & Physics Expert
                        </p> --}}
                                <p>
                                    <span class="badge bg-light text-dark">
                                        <i class="fas fa-university text-secondary me-2" style="width: 20px;"></i>
                                        <span>PhD in Mathematics, MIT</span>
                                    </span>
                                </p>
                                <div class="mt-2">
                                    @foreach ($slots as $slot)
                                        <span class="badge badge-primary rounded-pill me-1">
                                            {{ format_date($slot->start_time, 'h:i A') }}
                                            -
                                            {{ format_date($slot->end_time, 'h:i A') }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-2 align-content-center text-center">
                            @if ($students > 1)
                                <div class="fs-5 fw-bold">{{ $students - 1 }}+</div>
                                <div class="small text-muted">Students</div>
                            @endif
                        </div>
                        <div class="col-md-3 d-flex flex-column align-items-center justify-content-center text-center">
                            <div class="mb-2">
                                <span class="text-muted small">From</span>
                                <span class="fw-bold text-success fs-3 ms-1">${{ $sessionFee ?? 'N?A' }}</span>
                                <span class="text-muted small">/session</span>
                            </div>

                            <button type="button" class="btn btn-success px-4">
                                <i class="fas fa-calendar-check me-2"></i> Book Now
                            </button>
                        </div>
                    </div>
                </div>
            @empty
            @endforelse
        @else
            <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-modal="true" role="dialog" style="display: block;">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="" method="get" autocomplete="off">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Please Choose Date & Subject</h5>
                            </div>
                            <div class="modal-body px-4">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="date">Date</label>
                                        <input type="date" name="date" id="date" class="form-control"
                                            style="width: 100%;" min="{{ now()->toDateString() }}"
                                            value="{{ now()->toDateString() }}" required>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="subject">Subjetc</label>
                                        <select class="form-select" style="width: 100%;" name="subject" id="subject" required>
                                            <option value="" selected="" disabled>Select Subject</option>
                                            @foreach ($subjects ?? [] as $subject)
                                                <option value="{{ $subject?->id ?? '' }}">{{ $subject?->name ?? '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script>
                var myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {
                    backdrop: 'static',
                    keyboard: false
                });
                myModal.show();
            </script>
        @endif

    </div>
@endsection

@push('model')
@endpush

@push('js')
@endpush
