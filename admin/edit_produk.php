<?php
include 'header.php';

$message = '';

// Cek ID produk dari URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: kelola_produk.php");
    exit();
}
$id_produk = $_GET['id'];

// Ambil data produk saat ini
$result = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk = $id_produk");
if (mysqli_num_rows($result) == 0) {
    header("Location: kelola_produk.php");
    exit();
}
$produk = mysqli_fetch_assoc($result);

// Proses update data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_produk = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $harga = (int)$_POST['harga'];
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $gambar_lama = $_POST['gambar_lama'];
    $gambar_nama = $gambar_lama;

    // Cek apakah ada gambar baru yang diupload
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0 && !empty($_FILES['gambar']['name'])){
        $gambar = $_FILES['gambar'];
        $gambar_nama_baru = time() . '-' . basename($gambar['name']);
        $target_dir = "../assets/img/";
        $target_file = $target_dir . $gambar_nama_baru;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validasi gambar baru
        $check = getimagesize($gambar["tmp_name"]);
        if($check === false) {
            $message = "<div class='alert alert-danger'>File bukan gambar.</div>";
            $uploadOk = 0;
        }
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            $message = "<div class='alert alert-danger'>Maaf, hanya format JPG, JPEG, PNG & GIF yang diperbolehkan.</div>";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($gambar["tmp_name"], $target_file)) {
                // Hapus gambar lama jika ada
                if(file_exists($target_dir . $gambar_lama)){
                    unlink($target_dir . $gambar_lama);
                }
                $gambar_nama = $gambar_nama_baru;
            } else {
                $message = "<div class='alert alert-danger'>Maaf, terjadi error saat mengupload file baru.</div>";
                $uploadOk = 0; // Gagalkan proses update jika upload gagal
            }
        }
    } else {
        $uploadOk = 1; // Tidak ada gambar baru, lanjutkan proses update
    }

    // Lakukan update jika tidak ada error upload
    if($uploadOk == 1){
        $sql = "UPDATE produk SET 
                    nama_produk = '$nama_produk', 
                    harga = $harga, 
                    deskripsi = '$deskripsi', 
                    gambar = '$gambar_nama' 
                WHERE id_produk = $id_produk";

        if (mysqli_query($conn, $sql)) {
            header("Location: kelola_produk.php?status=edit_sukses");
            exit();
        } else {
            $message = "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
        }
    }
}
?>

<h1 class="h2">Edit Produk</h1>

<?php echo $message; ?>

<form action="edit_produk.php?id=<?php echo $id_produk; ?>" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="nama_produk" class="form-label">Nama Produk</label>
        <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="<?php echo htmlspecialchars($produk['nama_produk']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="harga" class="form-label">Harga</label>
        <input type="number" class="form-control" id="harga" name="harga" value="<?php echo $produk['harga']; ?>" required>
    </div>
    <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required><?php echo htmlspecialchars($produk['deskripsi']); ?></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Gambar Saat Ini</label><br>
        <img src="../assets/img/<?php echo $produk['gambar']; ?>" width="150">
        <input type="hidden" name="gambar_lama" value="<?php echo $produk['gambar']; ?>">
    </div>
    <div class="mb-3">
        <label for="gambar" class="form-label">Ganti Gambar (Opsional)</label>
        <input class="form-control" type="file" id="gambar" name="gambar">
    </div>
    <button type="submit" class="btn btn-primary">Update Produk</button>
    <a href="kelola_produk.php" class="btn btn-secondary">Batal</a>
</form>

<?php include 'footer.php'; ?>