@extends('teacher.layout.app')

@push('css')
@endpush

@section('content')
    <div class="container-fluid my-3 px-4">
        @php
            $action = isset($availability)
                ? route('teacher.availability.save', $availability->id)
                : route('teacher.availability.save');
        @endphp

        <form action="{{ $action }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <select name="subject" id="subject" class="form-select">
                        <option value="" disabled>Select Subject</option>
                        @foreach ($subjects ?? [] as $subject)
                            <option value="{{ $subject?->id ?? '' }}">{{ $subject?->name ?? '' }}</option>
                        @endforeach
                    </select>
                    @error('subject')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date"
                        value="{{ isset($availability) ? $availability->date->format('Y-m-d') : old('date') }}"
                        min="{{ now()->format('Y-m-d') }}" required>
                    @error('date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="start_time" class="form-label">Start Time</label>
                    <input type="time" class="form-control" id="start_time" name="start_time"
                        value="{{ isset($availability) ? $availability->start_time->format('H:i') : old('start_time') }}"
                        required>
                    @error('start_time')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="end_time" class="form-label">End Time</label>
                    <input type="time" class="form-control" id="end_time" name="end_time"
                        value="{{ isset($availability) ? $availability->end_time->format('H:i') : old('end_time') }}"
                        required>
                    @error('end_time')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary ">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('model')
@endpush

@push('js')
@endpush
