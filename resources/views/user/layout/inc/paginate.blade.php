@php
    $queryParams = request()->except('page');
    $currentPage = $item->currentPage();
    $lastPage = $item->lastPage();
    $start = max(1, $currentPage - 2);
    $end = min($lastPage, $start + 4);
    if ($end - $start < 4) {
        $start = max(1, $end - 4);
    }
@endphp
@if ($lastPage > 1)
    <div class="pagination-wrap">
        <div class="listing_category_bottom">
            <div class="showing_entries">
                Showing {{ $item->firstItem() }} to {{ $item->lastItem() }} of {{ $item->total() }} entries
            </div>
            <div class="listings_pagination">
                <ul class="pagination">
                    @if ($item->onFirstPage())
                        <li class="disabled"><a href="javascript:void(0);" rel="prev" class="action">&laquo;
                                Previous</a></li>
                    @else
                        <li><a href="{{ $item->appends($queryParams)->previousPageUrl() }}" rel="prev"
                                class="action">&laquo; Previous</a></li>
                    @endif

                    @for ($i = $start; $i <= $end; $i++)
                        @if ($i == $currentPage)
                            <li class="active"><a href="javascript:void(0);">{{ $i }}</a></li>
                        @else
                            <li><a href="{{ $item->appends($queryParams)->url($i) }}">{{ $i }}</a></li>
                        @endif
                    @endfor

                    @if ($item->hasMorePages())
                        <li><a href="{{ $item->appends($queryParams)->nextPageUrl() }}" rel="next"
                                class="action">Next &raquo;</a></li>
                    @else
                        <li class="disabled"><a href="javascript:void(0);" rel="next" class="action">Next
                                &raquo;</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endif
