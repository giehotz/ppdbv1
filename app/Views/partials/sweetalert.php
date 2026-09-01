<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
.swal2-container {
    z-index: 1000000 !important;
}
</style>

<script>
// ========================
// 1. Flashdata → SweetAlert2
// ========================
document.addEventListener('DOMContentLoaded', function() {
    <?php if (session()->getFlashdata('success')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            html: <?= json_encode(session()->getFlashdata('success')) ?>,
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            customClass: { popup: 'swal-toast' }
        });
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            html: <?= json_encode(session()->getFlashdata('error')) ?>,
            timer: 4000,
            timerProgressBar: true,
            showConfirmButton: true,
            confirmButtonColor: '#ef4444'
        });
    <?php endif; ?>

    <?php if (session()->getFlashdata('msg')): ?>
        Swal.fire({
            icon: 'warning',
            title: 'Perhatian',
            html: <?= json_encode(session()->getFlashdata('msg')) ?>,
            timer: 4000,
            timerProgressBar: true,
            showConfirmButton: true,
            confirmButtonColor: '#f59e0b'
        });
    <?php endif; ?>
});

// ========================
// 2. Global Confirm Helper
// ========================
function swalConfirm(formOrLink, message, title = 'Apakah Anda yakin?', icon = 'warning') {
    event.preventDefault();
    Swal.fire({
        title: title,
        html: message,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: '#16a34a',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Lanjutkan',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            if (formOrLink.tagName === 'FORM') {
                formOrLink.submit();
            } else if (formOrLink.tagName === 'A') {
                window.location.href = formOrLink.href;
            }
        }
    });
}

// Auto-bind: forms with data-confirm attribute
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-confirm]').forEach(function (el) {
        const msg = el.getAttribute('data-confirm');
        const title = el.getAttribute('data-confirm-title') || 'Apakah Anda yakin?';
        const icon = el.getAttribute('data-confirm-icon') || 'warning';
        
        if (el.tagName === 'FORM') {
            el.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: title,
                    html: msg,
                    icon: icon,
                    showCancelButton: true,
                    confirmButtonColor: '#16a34a',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Lanjutkan',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) el.submit();
                });
            });
        } else if (el.tagName === 'A') {
            el.addEventListener('click', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: title,
                    html: msg,
                    icon: icon,
                    showCancelButton: true,
                    confirmButtonColor: '#16a34a',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Lanjutkan',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) window.location.href = el.href;
                });
            });
        }
    });
});
</script>
