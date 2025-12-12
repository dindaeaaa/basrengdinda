        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Script to set active class on current page nav link
    document.addEventListener('DOMContentLoaded', function() {
        const currentPage = window.location.pathname.split('/').pop();
        if (currentPage === 'index.php') {
            document.getElementById('nav-dashboard').classList.add('active');
        } else if (currentPage === 'kelola_produk.php' || currentPage === 'tambah_produk.php' || currentPage === 'edit_produk.php') {
            document.getElementById('nav-produk').classList.add('active');
        } else if (currentPage === 'kelola_pesanan.php') {
            document.getElementById('nav-pesanan').classList.add('active');
        }
    });
</script>
</body>
</html>