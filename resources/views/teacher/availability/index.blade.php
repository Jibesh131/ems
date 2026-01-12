@extends('teacher.layout.app')

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
                <input type="date" name="date" id="" class="form-control" value="{{ request()->date }}" style="width: 160px;">

                <select class="form-select" style="width: 160px;" name="subject">
                    <option value="" {{ blank(request()->subject) ? 'selected' : '' }}>Select Subject</option>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ request()->subject == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }}</option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-secondary">Filter <i
                        class="fa fa-filter opacity-75 ms-1"></i></button>
                @if (!empty(request()->keyword) || !empty(request()->date) || !empty(request()->subject))
                    <a href="{{ route('teacher.availability.index') }}" class="btn btn-danger">
                        Clear <i class="fa fa-xmark fa-fw ms-1" style="font-size: 1rem;"></i>
                    </a>
                @endif

            </div>
        </form>

        <a href="{{ route('teacher.availability.add') }}" class="btn btn-primary"><i class="fa fa-plus me-1"></i> Add New
            Slot</a>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="row gx-2">
                @forelse ($availabilities as $date => $items)
                    <div class="col-12 col-xl-12">
                        <div class="card border" style="overflow:hidden;">
                            <div class="card-header bg-primary text-white" style="border-radius: 5px 5px 0 0;">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h5 class="mb-0">
                                            <i class="fa-solid fa-calendar-day me-2"></i>
                                            {{ format_date($date, 'd M y') . ' ( ' . format_date($date, 'l') . ' )' }}
                                        </h5>
                                    </div>
                                    <div class="col-auto">
                                        <span class="badge bg-white text-primary"><strong>{{ count($items) }}
                                            </strong>slots</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group">
                                    @foreach ($items as $item)
                                        <li class="list-group-item py-3 px-0">
                                            <div class="row w-100 align-items-center ms-0">
                                                <div class="col">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <div class="bg-white rounded-circle p-2"
                                                                style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;">
                                                                <i class="fa-solid fa-clock text-primary"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="fw-semibold">
                                                                {{ format_date($item->start_time, 'h:i A') }} -
                                                                {{ format_date($item->end_time, 'h:i A') }} </div>
                                                            <small class="text-muted">Duration:
                                                                {{ format_duration($item->start_time, $item->end_time) }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <span class="badge badge-black"> Subject: {{ $item->subject->name }}
                                                    </span>
                                                </div>
                                                <div class="col">
                                                    <span class="badge badge-success"> {{ $item->bookings_count ?? '' }}
                                                        Joined </span>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="btn-group">
                                                        <a href="{{ route('teacher.availability.edit', $item->id ?? 0) }}" class="btn bg-primary-gradient text-white btn-sm"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-title="Edit">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                        <a href="{{ route('teacher.availability.delete', $item->id ?? 0) }}" class="btn bg-danger-gradient text-white btn-sm"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-title="Cancle">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @empty
                    <div id="emptyState" class="text-center text-muted py-5 d-none">
                        <i class="bi bi-calendar-x" style="font-size: 3rem;"></i>
                        <p class="mt-3 mb-3">No availability slots defined yet.</p>
                        <a href="{{ route('teacher.availability.add') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i>Add Your First Slot
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
@endsection

@push('model')
@endpush

@push('js')
@endpush
