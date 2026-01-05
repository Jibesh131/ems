@extends('admin.layout.app')

@push('css')
    <style>
        .selectgroup-button {
            padding: 0.65rem 0rem;
            color: #747c8d;
        }
    </style>
@endpush

@php
    $url = isset($teacher) ? route('admin.teacher.save', $teacher->id) : route('admin.teacher.save');
@endphp

@section('content')
    <div class="card-body">
        <form action="{{ $url }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="profile_pic">Profile Picture</label>
                    <input type="file" name="profile_pic" id="profile_pic" class="form-control" accept="image/*">
                    @if (isset($teacher->profile_pic))
                        <small class="text-muted">Current: {{ $teacher->profile_pic }}</small>
                    @endif
                    @error('profile_pic')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control"
                        value="{{ old('name', $teacher->name ?? '') }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control"
                        value="{{ old('email', $teacher->email ?? '') }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" class="form-control"
                        value="{{ old('phone', $teacher->phone ?? '') }}">
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- <div class="form-group col-md-6">
                    <label for="qualification">Qualification</label>
                    <input type="text" name="qualification" id="qualification" class="form-control"
                        value="{{ old('qualification', $teacher->qualification ?? '') }}">
                    @error('qualification')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div> --}}
                <div class="form-group col-md-6">
                    <label for="password">Password {{ isset($teacher) ? '(Leave blank to keep current)' : '' }}</label>
                    <input type="password" name="password" id="password" class="form-control">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label class="form-label" for="status">Status</label>
                    <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                            <input type="radio" name="status" value="active" class="selectgroup-input"
                                {{ old('status', $teacher->status ?? 'active') == 'active' ? 'checked' : '' }}>
                            <span class="selectgroup-button">Active</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="status" value="inactive" class="selectgroup-input"
                                {{ old('status', $teacher->status ?? '') == 'inactive' ? 'checked' : '' }}>
                            <span class="selectgroup-button">Inactive</span>
                        </label>
                    </div>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-12">
                    <h5 class="mt-3 border-bottom border-3 pb-2">Session Fees per Subject</h5>
                    @php
                        $oldSubjects = old('subjects');
                        $oldFees = old('fees');

                        if (empty($oldSubjects) || !is_array($oldSubjects)) {
                            $oldSubjects = [''];
                        }
                        if (empty($oldFees) || !is_array($oldFees)) {
                            $oldFees = [''];
                        }
                    @endphp

                    <div id="fee-rows">
                        @foreach ($oldSubjects as $index => $subjectId)
                            @php
                                $fee = $oldFees[$index] ?? '';
                            @endphp
                            
                            @if ($index === 0 || !empty($subjectId) || !empty($fee))
                                <div class="row fee-row mb-3">
                                    <div class="form-group col-md-6">
                                        <label>Subject</label>
                                        <select name="subjects[]" class="form-select">
                                            <option value="">Select Subject</option>
                                            @foreach ($subjects as $subject)
                                                <option value="{{ $subject->id }}"
                                                    {{ $subjectId == $subject->id ? 'selected' : '' }}>
                                                    {{ $subject->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('subjects.' . $index)
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Session Fees ($)</label>
                                        <input type="number" name="fees[]" class="form-control" min="0"
                                            value="{{ $fee }}">
                                        @error('fees.' . $index)
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="col-md-12 mb-3 text-end">
                        <button type="button" id="add-row" class="btn btn-secondary">
                            + New Row
                        </button>
                    </div>

                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">{{ isset($teacher) ? 'Update' : 'Submit' }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#add-row').click(function() {
                let $firstRow = $('.fee-row:first').clone();
                $firstRow.find('select').val('');
                $firstRow.find('input').val('');
                $('#fee-rows').append($firstRow);
            });
        });
    </script>
@endpush
