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
    </style>
@endpush

@section('content')
    <div class="card-header text-end">
        <a href="{{ route('admin.teacher.add') }}" class="btn btn-primary btn-sm">
            Add New
        </a>
    </div>
    <div class="card-body">
        @forelse ($teachers as $teacher)
            <div class="card shadow-sm mb-3 border border-1" style="overflow: hidden;">
                <div class="row w-100">
                    <div class="col-md-2 d-flex align-items-center justify-content-center ps-5">
                        <img src="{{ asset('../storage/' . $teacher->profile_pic) }}"
                            class="img-fluid img-thumbnail" alt="{{ $teacher->name }}" width="115px">
                    </div>
                    <div class="col-md-10">
                        <div class="card-body p-3 d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h5 class="card-title mb-1">
                                        {{ $teacher->name }}
                                        <span
                                            class="badge {{ status_badge($teacher->status) }} mx-2 p-2 py-1">{{ ucfirst($teacher->status) }}</span>
                                    </h5>
                                    @php
                                        $subjectNames = $teacher->getSubjectNames();
                                    @endphp
                                    @foreach ($subjectNames as $subjectName)
                                        <span class="badge bg-primary me-0">{{ $subjectName }}</span>
                                    @endforeach
                                </div>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.teacher.edit', $teacher->id ?? 0) }}" class="btn btn bg-primary-gradient text-light" data-toggle="tooltip"
                                        data-placement="top" title="Edit Teacher">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a href="{{ route('admin.teacher.delete', $teacher->id ?? 0) }}" class="btn bg-danger-gradient text-light" data-toggle="tooltip"
                                        data-placement="top" title="Delete Teacher">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    <button class="btn bg-secondary-gradient text-light" data-toggle="tooltip"
                                        data-placement="top" title="Schedule">
                                        <i class="fa-solid fa-calendar-days"></i>
                                    </button>
                                    <button id="openModalBtn"
                                        style="padding-right: 15.25px !important; padding-left: 15.25px !important;"
                                        class="btn bg-black-gradient text-light px-3 fees-model" data-bs-toggle="modal"
                                        data-bs-target="#sessionFeesModel" data-toggle="tooltip" data-placement="top"
                                        title="Schedule" data-teacher-id="{{ $teacher->id ?? '0' }}">

                                        <i class="fa-solid fa-hand-holding-dollar fa-lg"></i>
                                        <span class="spinner-border spinner-border-sm text-light d-none"
                                            role="status"></span>
                                    </button>

                                </div>
                            </div>
                            <div class="row flex-grow-1">
                                <div class="col-md-6">
                                    <p class="mb-1 small">
                                        <strong>Email:</strong>
                                        <a href="mailto:{{ $teacher->email ?? '' }}">{{ $teacher->email ?? '(empty)' }}</a>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1 small">
                                        <strong>Phone:</strong>
                                        <a href="tel:{{ $teacher->phone ?? '' }}">{{ $teacher->phone ?? '(empty)' }}</a>
                                    </p>
                                </div>
                                {{-- <div class="col-md-6">
                                    <p class="mb-1 small"><strong>Qualification:</strong> Ph.D. in Mathematics</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-0 small"><strong>Employee ID:</strong> TCH-2024-001</p>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="p-3 text-center">No records found</div>
        @endforelse
        @include('admin.layout.inc.paginate', ['item' => $teachers])
    </div>
@endsection

@push('modal')
    <!-- Session Fees Modal -->
    <div class="modal fade" id="sessionFeesModel" tabindex="-1" aria-labelledby="sessionFeesModelLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sessionFeesModelLabel">Session Fees</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalContent">
                    <p class="text-center text-primary">
                        Loading...
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary d-none">Save</button>
                </div>
            </div>
        </div>
    </div>
@endpush


@push('js')
    <script>
        $(document).ready(function() {
            $('.fees-model').on('click', function(e) {
                e.preventDefault();

                var $btn = $(this);
                var $spinner = $btn.find('.spinner-border');
                var $icon = $btn.find('i');
                var $modalContent = $('#modalContent');
                var teacher_id = $btn.data('teacher-id');

                $btn.prop('disabled', true);
                $spinner.removeClass('d-none');
                $icon.addClass('d-none');

                $modalContent.html('<div class="text-center py-3">Loading...</div>');

                // Ajax call
                $.ajax({
                    url: '{{ route("admin.teacher.fees", ":id") }}'.replace(':id', teacher_id),
                    method: 'GET',
                    dataType: 'html',
                    success: function(response) {
                        $modalContent.html(response);
                    },
                    error: function() {
                        $modalContent.html(
                            '<div class="text-danger text-center">Failed to load data.</div>'
                            );
                    },
                    complete: function() {
                        $spinner.addClass('d-none');
                        $icon.removeClass('d-none');
                        $btn.prop('disabled', false);
                    }
                });
            });
        });
    </script>
@endpush
