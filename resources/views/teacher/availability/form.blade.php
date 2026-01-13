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
                        <option value="" {{ old('subject', $availability->subject_id ?? '') == '' ? 'selected' : '' }}
                            disabled>Select Subject</option>
                        @foreach ($subjects ?? [] as $subject)
                            <option value="{{ $subject->id }}"
                                {{ old('subject', $availability->subject_id ?? '') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
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

                <div class="col-md-6">
                    <label for="fees" class="form-label">Session Fees</label>
                    <input type="text" class="form-control" id="fees" value="{{ format_amount($fees ?? '') }}" readonly>
                </div>

                <div class="col-md-6 text-end" style="margin-top: 30px;"> 
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('model')
@endpush

@push('js')
    <script>
        $(function() {
            $('#subject').on('change', function() {
                let selectedValue = $(this).val();
                let url = '{{ route("teacher.availability.getFees", ":id") }}'.replace(':id', selectedValue);
                $.ajax({
                    url: url,
                    method: 'GET',
                    dataType: 'JSON',
                    success: function(res){
                        $('#fees').val('$' + res.toFixed(2));
                        console.log(res.toFixed(2));
                    },
                    error: function(){

                    },
                    complete: function() {
                        
                    }
                });
            });
        });
    </script>
@endpush
