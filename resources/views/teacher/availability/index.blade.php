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
                <input type="date" name="" id="" class="form-control" style="width: 160px;">

                <select class="form-select" style="width: 160px;" name="type">
                    <option value="" {{ blank(request()->type) ? 'selected' : '' }}>Select Subject</option>
                    <option value="movie" {{ request()->type == 'movie' ? 'selected' : '' }}>Movie</option>
                    <option value="video" {{ request()->type == 'video' ? 'selected' : '' }}>Video</option>
                    <option value="music" {{ request()->type == 'music' ? 'selected' : '' }}>Music</option>
                </select>

                <button type="submit" class="btn btn-secondary">Filter <i
                        class="fa fa-filter opacity-75 ms-1"></i></button>
                @if (!empty(request()->keyword) || !empty(request()->type) || !empty(request()->status) || !empty(request()->time))
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
            <div class="row">
                @forelse ($availabilities as $date => $items)
                    <div class="col-12 px-1 mb-3 shadow">
                        <div class="h-100 border border-1 border-primary" style="overflow: hidden;">
                            <div class="card-header bg-primary text-white">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h5 class="mb-0">
                                            <i class="bi bi-calendar-day me-2"></i>{{ format_date($date, 'l') . '  -  ' . $date }}
                                        </h5>
                                    </div>
                                    <div class="col-auto">
                                        <span class="badge bg-white text-primary">{{ count($items) }} slots</span>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-0">
                                @foreach ($items as $item)
                                    <div class="row align-items-center p-3">
                                    <div class="col">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="bg-light rounded-circle p-2"
                                                    style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;">
                                                    <i class="fa-solid fa-clock text-primary"></i>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="fw-semibold">{{ format_date($item->start_time, 'h:i A') }}  -  {{ format_date($item->end_time, 'h:i A') }} </div>
                                                <small class="text-muted">Duration: {{ format_duration($item->start_time, $item->end_time)}}</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="btn-group">
                                            <button class="btn btn-outline-primary btn-sm">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                @empty
                @endforelse
            </div>
        </div>



        {{-- <div id="emptyState" class="text-center text-muted py-5 d-none">
            <i class="bi bi-calendar-x" style="font-size: 3rem;"></i>
            <p class="mt-3 mb-3">No availability slots defined yet.</p>
            <a href="add-availability.html" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>Add Your First Slot
            </a>
        </div> --}}
    </div>
@endsection

@push('model')
@endpush

@push('js')
@endpush
