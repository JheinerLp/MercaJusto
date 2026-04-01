@if (session('success') || session('error'))
    <div id="toast"
        class="toast-custom 
        {{ session('success') ? 'toast-success' : 'toast-error' }}">

        {{ session('success') ?? session('error') }}
    </div>
@endif
@if ($errors->any())
    <div class="toast error show">
        {{ $errors->first() }}
    </div>
@endif
<script>
document.addEventListener('DOMContentLoaded', function () {
    const toast = document.getElementById('toast');

    if (toast) {
        // Mostrar
        setTimeout(() => {
            toast.classList.add('toast-show');
        }, 100);

        // Ocultar después de 3s
        setTimeout(() => {
            toast.classList.remove('toast-show');
        }, 3000);
    }
});
</script>

