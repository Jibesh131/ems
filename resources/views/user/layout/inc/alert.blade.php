<script>
document.addEventListener('DOMContentLoaded', function () {
    @if(session('message'))
        let msg = @json(session('message'));
        showNotify(msg.status, msg.msg, msg.status);
    @endif

    @if(session('error'))
        let msg = @json(session('error'));
        showNotify('danger', msg.msg, 'oops');
    @endif

    @if(session('success'))
        let msg = @json(session('success'));
        showNotify('success', msg.msg, 'success');
    @endif
});
</script>
