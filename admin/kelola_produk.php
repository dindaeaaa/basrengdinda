<?php 
include 'header.php';

// Logika untuk hapus produk
if (isset($_GET['hapus'])) {
    $id_hapus = $_GET['hapus'];

    // Ambil nama file gambar untuk dihapus dari folder
    $img_res = mysqli_query($conn, "SELECT gambar FROM produk WHERE id_produk = $id_hapus");
    if(mysqli_num_rows($img_res) > 0){
        $img_data = mysqli_fetch_assoc($img_res);
        $gambar_lama = $img_data['gambar'];
        if(file_exists('../assets/img/' . $gambar_lama)){
            unlink('../assets/img/' . $gambar_lama);
        }
    }

    $sql_hapus = "DELETE FROM produk WHERE id_produk = $id_hapus";
    if (mysqli_query($conn, $sql_hapus)) {
        echo "<div class='alert alert-success'>Produk berhasil dihapus.</div>";
    } else {
        echo "<div class='alert alert-danger'>Gagal menghapus produk.</div>";
    }
}

?>

<div class="d-flex justify-content-between align-items-center">
    <h1 class="h2">Kelola Produk</h1>
    <a href="tambah_produk.php" class="btn btn-primary">Tambah Produk Baru</a>
</div>

<div class="table-responsive mt-3">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">#ID</th>
                <th scope="col">Gambar</th>
                <th scope="col">Nama Produk</th>
                <th scope="col">Harga</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM produk ORDER BY id_produk DESC";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><?php echo $row['id_produk']; ?></td>
                <td><img src="../assets/img/<?php echo $row['gambar']; ?>" alt="" width="50"></td>
                <td><?php echo $row['nama_produk']; ?></td>
                <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                <td>
                    <a href="edit_produk.php?id=<?php echo $row['id_produk']; ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="kelola_produk.php?hapus=<?php echo $row['id_produk']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</a>
                </td>
            </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>Belum ada produk.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>