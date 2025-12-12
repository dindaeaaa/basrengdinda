<?php 
include 'header.php';

// Ambil data ringkasan
$total_produk_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM produk");
$total_produk = mysqli_fetch_assoc($total_produk_res)['total'];

$pending_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM pesanan WHERE status = 'Pending'");
$pending = mysqli_fetch_assoc($pending_res)['total'];

$diproses_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM pesanan WHERE status = 'Diproses'");
$diproses = mysqli_fetch_assoc($diproses_res)['total'];

$selesai_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM pesanan WHERE status = 'Selesai'");
$selesai = mysqli_fetch_assoc($selesai_res)['total'];

?>

<h1 class="h2">Dashboard</h1>
<p>Selamat datang, <strong><?php echo $_SESSION['admin_username']; ?></strong>!</p>

<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-box-seam"></i> Total Produk</h5>
                <p class="card-text fs-2"><?php echo $total_produk; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-clock-history"></i> Pesanan Pending</h5>
                <p class="card-text fs-2"><?php echo $pending; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-arrow-repeat"></i> Pesanan Diproses</h5>
                <p class="card-text fs-2"><?php echo $diproses; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-check2-circle"></i> Pesanan Selesai</h5>
                <p class="card-text fs-2"><?php echo $selesai; ?></p>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <h4>Akses Cepat</h4>
    <a href="kelola_produk.php" class="btn btn-lg btn-secondary">Kelola Produk</a>
    <a href="kelola_pesanan.php" class="btn btn-lg btn-secondary">Kelola Pesanan</a>
    <a href="logout.php" class="btn btn-lg btn-danger">Logout</a>
</div>


<?php include 'footer.php'; ?>