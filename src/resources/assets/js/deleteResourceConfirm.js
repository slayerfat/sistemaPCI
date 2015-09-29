function deleteResourceConfirm() {
    if (!confirm('Esta accion no se puede deshacer.')) {
        event.preventDefault();
    }
}
