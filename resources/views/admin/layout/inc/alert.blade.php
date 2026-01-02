<script>
document.addEventListener('DOMContentLoaded', function () {
    @if(session('message'))
        let n = @json(session('message'));
        showNotify(n.status, n.msg, n.status);
    @endif
});
</script>
