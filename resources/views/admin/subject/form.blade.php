@extends('admin.layout.app')

@push('css')
@endpush

@php
    $url = isset($subject) ? route('admin.subject.save', $subject->id) : route('admin.subject.save');
@endphp

@section('content')
    <div class="card-body">
        <form action="{{ $url }}" method="POST">
            @csrf
            <div class="row">
                <div class="form-group col-6">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control"
                        value="{{ old('name', $subject->name ?? '') }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label class="form-label" for="status">Status</label>
                    <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                            <input type="radio" name="status" value="active" class="selectgroup-input"
                                {{ old('status', $subject->status ?? 'active') == 'active' ? 'checked' : '' }}>
                            <span class="selectgroup-button">Active</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="status" value="inactive" class="selectgroup-input"
                                {{ old('status', $subject->status ?? '') == 'inactive' ? 'checked' : '' }}>
                            <span class="selectgroup-button">Inactive</span>
                        </label>
                    </div>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-12">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control">{{ old('description', $subject->description ?? '') }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">{{ isset($subject) ? 'Update' : 'Submit' }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script></script>
@endpush
