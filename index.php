<?php
include 'config/db.php';
include 'header.php';
?>

<div class="p-5 mb-4 bg-light rounded-3 text-center" style="background-image: url('assets/img/bs1.jpg'); background-size: cover; background-position: center;">
    <div class="container-fluid py-5" style="background-color: rgba(255,255,255,0.7);">
        <h1 class="display-5 fw-bold">Selamat Datang di Toko Basreng Enndhhull!</h1>
        <p class="fs-4">Basreng paling enak se-Nusantara. Cobain sekarang!</p>
        <a class="btn btn-primary btn-lg" href="pesanan.php" role="button">Pesan Sekarang</a>
    </div>
</div>

<div class="row" id="produk">
    <h2 class="text-center mb-4">Produk Kami</h2>
    <?php
    $sql = "SELECT * FROM produk";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
    ?>
            <div class="col-md-4">
                <div class="card product-card">
                    <img src="assets/img/<?php echo $row['gambar']; ?>" class="card-img-top" alt="<?php echo $row['nama_produk']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['nama_produk']; ?></h5>
                        <p class="card-text"><?php echo $row['deskripsi']; ?></p>
                        <p class="card-text"><strong>Harga:</strong> Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
                        <a href="pesanan.php?id_produk=<?php echo $row['id_produk']; ?>" class="btn btn-success w-100">Pesan Produk Ini</a>
                    </div>
                </div>
            </div>
    <?php
        }
    } else {
        echo "<p class='text-center'>Belum ada produk.</p>";
    }
    ?>
</div>

<?php include 'footer.php'; ?>