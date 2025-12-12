<?php
include 'config/db.php';
include 'header.php';

$message = '';
$error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil dan bersihkan data dari form
    $nama_pemesan = mysqli_real_escape_string($conn, $_POST['nama_pemesan']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $id_produk = (int)$_POST['id_produk'];
    $jumlah = (int)$_POST['jumlah'];
    $total_harga = (int)$_POST['total_harga'];

    // Validasi sederhana
    if (empty($nama_pemesan) || empty($alamat) || empty($no_hp) || empty($id_produk) || $jumlah <= 0) {
        $message = "Semua field harus diisi dengan benar.";
        $error = true;
    } else {
        // Buat query untuk memasukkan data
        $sql = "INSERT INTO pesanan (nama_pemesan, alamat, no_hp, id_produk, jumlah, total_harga, status) 
                VALUES ('$nama_pemesan', '$alamat', '$no_hp', $id_produk, $jumlah, $total_harga, 'Pending')";

        if (mysqli_query($conn, $sql)) {
            $id_pesanan_baru = mysqli_insert_id($conn);
            $message = "Pesanan Anda dengan nomor <strong>#{$id_pesanan_baru}</strong> telah berhasil dibuat. Kami akan segera memprosesnya.";
            $error = false;
        } else {
            $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
            $error = true;
        }
    }
} else {
    // Jika halaman diakses tanpa POST, redirect ke halaman pesanan
    header("Location: pesanan.php");
    exit();
}
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-body text-center">
                    <?php if ($error): ?>
                        <div class="alert alert-danger">
                            <h4 class="alert-heading">Oops! Terjadi Kesalahan</h4>
                            <p><?php echo $message; ?></p>
                        </div>
                        <a href="pesanan.php" class="btn btn-warning">Kembali ke Form Pemesanan</a>
                    <?php else: ?>
                        <div class="alert alert-success">
                            <h4 class="alert-heading">Terima Kasih!</h4>
                            <p><?php echo $message; ?></p>
                            <hr>
                            <p class="mb-0">Silakan tunggu konfirmasi dari kami.</p>
                        </div>
                        <a href="index.php" class="btn btn-primary">Kembali ke Halaman Utama</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
