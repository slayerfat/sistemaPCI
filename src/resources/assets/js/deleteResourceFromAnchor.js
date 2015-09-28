function deleteResourceFromAnchor(id) {
    if (!id) {
        console.log('error, no id.');
        return null;
    }
    if (confirm('Esta accion no se puede deshacer.')) {
        document.getElementById(id).submit();
        return true;
    }
}
