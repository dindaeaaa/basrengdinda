<?php
include 'config/db.php';
include 'header.php';

// Ambil data produk untuk dropdown
$produk_result = mysqli_query($conn, "SELECT id_produk, nama_produk, harga FROM produk");

// Cek apakah ada id_produk dari URL (ketika user klik 'Pesan Produk Ini')
$selected_prod_id = isset($_GET['id_produk']) ? (int)$_GET['id_produk'] : 0;

?>

<h2 class="mb-4">Form Pemesanan</h2>

<form action="proses_pesanan.php" method="POST" id="form-pesanan">
    <div class="mb-3">
        <label for="nama_pemesan" class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control" id="nama_pemesan" name="nama_pemesan" required>
    </div>
    <div class="mb-3">
        <label for="alamat" class="form-label">Alamat Lengkap</label>
        <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
    </div>
    <div class="mb-3">
        <label for="no_hp" class="form-label">Nomor HP</label>
        <input type="tel" class="form-control" id="no_hp" name="no_hp" required>
    </div>
    <hr class="my-4">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="id_produk" class="form-label">Pilih Produk</label>
            <select class="form-select" id="id_produk" name="id_produk" required>
                <option value="" data-harga="0">-- Pilih Basreng --</option>
                <?php
                if (mysqli_num_rows($produk_result) > 0) {
                    while ($row = mysqli_fetch_assoc($produk_result)) {
                        $selected = ($row['id_produk'] == $selected_prod_id) ? 'selected' : '';
                        echo "<option value='{$row['id_produk']}' data-harga='{$row['harga']}' {$selected}>{$row['nama_produk']}</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" value="1" min="1" required>
        </div>
    </div>
    <div class="mt-3">
        <h3 class="fw-bold">Total Harga: <span id="total_harga">Rp 0</span></h3>
    </div>
    <input type="hidden" id="total_harga_input" name="total_harga">
    <button type="submit" class="btn btn-success w-100 btn-lg mt-4">Kirim Pesanan</button>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const produkSelect = document.getElementById('id_produk');
    const jumlahInput = document.getElementById('jumlah');
    const totalHargaSpan = document.getElementById('total_harga');
    const totalHargaInput = document.getElementById('total_harga_input');

    function calculateTotal() {
        const selectedOption = produkSelect.options[produkSelect.selectedIndex];
        const harga = parseFloat(selectedOption.dataset.harga) || 0;
        const jumlah = parseInt(jumlahInput.value) || 0;
        const total = harga * jumlah;

        totalHargaSpan.textContent = 'Rp ' + total.toLocaleString('id-ID');
        totalHargaInput.value = total;
    }

    produkSelect.addEventListener('change', calculateTotal);
    jumlahInput.addEventListener('input', calculateTotal);

    // Hitung total saat halaman pertama kali dimuat jika produk sudah terpilih
    calculateTotal();
});
</script>

<?php include 'footer.php'; ?>
