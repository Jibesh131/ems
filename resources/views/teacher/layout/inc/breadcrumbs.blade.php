<div class="page-header justify-content-between">
    <h3 class="fw-bold mb-3">{{ $title ?? '' }}</h3>
    <ul class="breadcrumbs mb-3">
        @if (!empty($links))
            <li class="nav-home">
                <a href="{{ route('teacher.dashboard') }}">
                    <i class="icon-home"></i>
                </a>
            </li>
            @foreach ($links as $index => $item)
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ $item['url'] ?? 'javascript:void(0);' }}">{{ $item['name'] ?? '-'}}</a>
                </li>
            @endforeach
        @endif
    </ul>
</div>
