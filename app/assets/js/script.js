// Contoh: alert ketika klik tombol hapus
document.querySelectorAll('a[href*="hapus"]').forEach(btn => {
    btn.addEventListener('click', function(e) {
        if(!confirm('Yakin ingin menghapus data ini?')) {
            e.preventDefault();
        }
    });
});