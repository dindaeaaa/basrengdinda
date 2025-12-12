<?php
include 'header.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_produk = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $harga = (int)$_POST['harga'];
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    // Proses upload gambar
    $gambar = $_FILES['gambar'];
    $gambar_nama = time() . '-' . basename($gambar['name']);
    $target_dir = "../assets/img/";
    $target_file = $target_dir . $gambar_nama;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file adalah gambar asli
    $check = getimagesize($gambar["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $message = "<div class='alert alert-danger'>File bukan gambar.</div>";
        $uploadOk = 0;
    }

    // Cek format gambar
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        $message = "<div class='alert alert-danger'>Maaf, hanya format JPG, JPEG, PNG & GIF yang diperbolehkan.</div>";
        $uploadOk = 0;
    }

    // Jika semua pengecekan lolos
    if ($uploadOk == 1) {
        if (move_uploaded_file($gambar["tmp_name"], $target_file)) {
            // Simpan ke database
            $sql = "INSERT INTO produk (nama_produk, harga, deskripsi, gambar) VALUES ('$nama_produk', $harga, '$deskripsi', '$gambar_nama')";
            if (mysqli_query($conn, $sql)) {
                header("Location: kelola_produk.php?status=tambah_sukses");
                exit();
            } else {
                $message = "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
            }
        } else {
            $message = "<div class='alert alert-danger'>Maaf, terjadi error saat mengupload file.</div>";
        }
    }
}
?>

<h1 class="h2">Tambah Produk Baru</h1>

<?php echo $message; ?>

<form action="tambah_produk.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="nama_produk" class="form-label">Nama Produk</label>
        <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
    </div>
    <div class="mb-3">
        <label for="harga" class="form-label">Harga</label>
        <input type="number" class="form-control" id="harga" name="harga" required>
    </div>
    <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required></textarea>
    </div>
    <div class="mb-3">
        <label for="gambar" class="form-label">Gambar Produk</label>
        <input class="form-control" type="file" id="gambar" name="gambar" required>
    </div>
    <button type="submit" class="btn btn-primary">Simpan Produk</button>
    <a href="kelola_produk.php" class="btn btn-secondary">Batal</a>
</form>

<?php include 'footer.php'; ?>