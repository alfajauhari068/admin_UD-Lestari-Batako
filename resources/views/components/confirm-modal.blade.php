{{-- Confirmation Modal Component
     Consistent delete confirmation modal with dark mode support
     Usage:
     1. Include this component in your view
     2. Add data attributes to delete button: data-bs-toggle="modal" data-bs-target="#confirmModal" data-action="{{ route('resource.destroy', $id) }}"
--}}
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="confirmModalLabel">
                    <i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <x-btn variant="secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Batal
                </x-btn>
                <form id="confirmForm" method="POST" action="" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <x-btn variant="danger" type="submit">
                        <i class="bi bi-trash me-1"></i>Hapus
                    </x-btn>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const confirmModal = document.getElementById('confirmModal');
        const confirmForm = document.getElementById('confirmForm');

        if (confirmModal && confirmForm) {
            confirmModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                if (button) {
                    const action = button.getAttribute('data-action');
                    confirmForm.setAttribute('action', action);
                }
            });
        }
    });
</script>
