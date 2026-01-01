{{-- @if (session()->has('message'))
    @php
        $msg = session('message');
        $icon = session('type') ?? 'info';
        $title = session('title') ?? '';
    @endphp
@endif

@if (!empty($msg))
    <script>
        showNotify('{{ $icon }}', '{{ $msg }}', '{{ $title }}');
    </script>
@endif --}}

<script>
document.addEventListener('DOMContentLoaded', function () {
    Livewire.on('notify', ({ type, message, title }) => {
        showNotify(type, message, title);
    });

    @if(session('notify'))
        let n = @json(session('notify'));
        showNotify(n.type, n.message, n.title);
    @endif

});
</script>



