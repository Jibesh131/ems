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
    </div>
    <div class="card-body">
        
        @include('admin.layout.inc.paginate', ['item' => $users])
    </div>
@endsection

{{-- @push('modal')
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
@endpush --}}


@push('js')
@endpush
