@extends('admin.layout.app')

@push('css')
@endpush

@section('content')
    <div class="card-header text-end">
        <a href="{{ route('admin.subject.add.view') }}" class="btn btn-primary btn-sm">
            Add New
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered location-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Published At</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($subjects as $subject)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $subject->name }}</td>
                            <td>{{ $subject->description }}</td>
                            <td>{{ $subject->status }}</td>
                            <td>{{ $subject->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{-- @include('admin.layout.inc.paginate', ['item' => $subjects]) --}}
        </div>
    </div>
@endsection

{{-- @push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('.delete').on('click', function() {
                let url = $(this).data('url');
                Swal.fire({
                    title: "Are you sure?",
                    text: "Are you sure you want to delete this location?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes",
                    cancelButtonText: "Cancel",
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
            $(document).on('change', '.status-toggle', function() {
                const $toggle = $(this);
                const id = $toggle.data('id');
                const status = $toggle.is(':checked') ? 'active' : 'inactive';
                const url = $toggle.data('url');
                const tooltip = bootstrap.Tooltip.getOrCreateInstance(this);

                const updateTooltip = (text) => {
                    const title = text || (status === 'active' ? 'Active' : 'Inactive');
                    $toggle.attr('data-bs-original-title', title);
                    tooltip.setContent({
                        '.tooltip-inner': title
                    });
                };
                $.ajax({
                    url,
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        id,
                        status
                    },
                    success: function(response) {
                        if (response.success) {
                            showToast(response.msg || 'Status updated.', '', 'success');
                        } else {
                            showToast(response.msg || 'Something went wrong.', '', 'error');
                        }
                    },
                    error: function() {
                        $toggle.prop('checked', !$toggle.is(':checked'));
                        updateTooltip();
                        showToast('Server error occurred.', '', 'error');
                    },
                    beforeSend: function() {
                        updateTooltip();
                    }
                });
            });
        })
    </script>
@endpush --}}
