<?php 
include 'header.php';

// Logika untuk update status
if (isset($_GET['update_status']) && isset($_GET['id'])) {
    $id_pesanan = (int)$_GET['id'];
    $status_baru = mysqli_real_escape_string($conn, $_GET['update_status']);

    // Pastikan status yang diinput valid
    $allowed_statuses = ['Pending', 'Diproses', 'Selesai'];
    if (in_array($status_baru, $allowed_statuses)) {
        $sql_update = "UPDATE pesanan SET status = '$status_baru' WHERE id_pesanan = $id_pesanan";
        if (mysqli_query($conn, $sql_update)) {
            echo "<div class='alert alert-success'>Status pesanan #{$id_pesanan} berhasil diubah menjadi <strong>{$status_baru}</strong>.</div>";
        } else {
            echo "<div class='alert alert-danger'>Gagal mengubah status.</div>";
        }
    }
}

// Logika untuk filter
$filter_status = isset($_GET['filter']) ? mysqli_real_escape_string($conn, $_GET['filter']) : 'semua';
$where_clause = '';
if ($filter_status != 'semua') {
    $where_clause = "WHERE ps.status = '$filter_status'";
}

?>

<h1 class="h2">Kelola Pesanan</h1>

<div class="d-flex justify-content-start align-items-center mb-3">
    <span class="me-2">Filter Status:</span>
    <div class="btn-group">
        <a href="kelola_pesanan.php?filter=semua" class="btn btn-sm btn-outline-secondary <?php echo ($filter_status == 'semua') ? 'active' : ''; ?>">Semua</a>
        <a href="kelola_pesanan.php?filter=Pending" class="btn btn-sm btn-outline-secondary <?php echo ($filter_status == 'Pending') ? 'active' : ''; ?>">Pending</a>
        <a href="kelola_pesanan.php?filter=Diproses" class="btn btn-sm btn-outline-secondary <?php echo ($filter_status == 'Diproses') ? 'active' : ''; ?>">Diproses</a>
        <a href="kelola_pesanan.php?filter=Selesai" class="btn btn-sm btn-outline-secondary <?php echo ($filter_status == 'Selesai') ? 'active' : ''; ?>">Selesai</a>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>#ID</th>
                <th>Pemesan</th>
                <th>Produk</th>
                <th>Total</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT ps.*, pr.nama_produk 
                    FROM pesanan ps
                    JOIN produk pr ON ps.id_produk = pr.id_produk
                    $where_clause
                    ORDER BY ps.tanggal_pesan DESC";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><?php echo $row['id_pesanan']; ?></td>
                <td>
                    <strong><?php echo $row['nama_pemesan']; ?></strong><br>
                    <small><?php echo $row['alamat']; ?></small><br>
                    <small>HP: <?php echo $row['no_hp']; ?></small>
                </td>
                <td><?php echo $row['nama_produk']; ?> (x<?php echo $row['jumlah']; ?>)</td>
                <td>Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                <td><?php echo date('d M Y, H:i', strtotime($row['tanggal_pesan'])); ?></td>
                <td>
                    <?php 
                        $status = $row['status'];
                        $badge_class = 'bg-secondary';
                        if($status == 'Pending') $badge_class = 'bg-warning';
                        if($status == 'Diproses') $badge_class = 'bg-info';
                        if($status == 'Selesai') $badge_class = 'bg-success';
                        echo "<span class='badge {$badge_class}'>{$status}</span>";
                    ?>
                </td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Ubah Status
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="kelola_pesanan.php?update_status=Pending&id=<?php echo $row['id_pesanan']; ?>&filter=<?php echo $filter_status; ?>">Pending</a></li>
                            <li><a class="dropdown-item" href="kelola_pesanan.php?update_status=Diproses&id=<?php echo $row['id_pesanan']; ?>&filter=<?php echo $filter_status; ?>">Diproses</a></li>
                            <li><a class="dropdown-item" href="kelola_pesanan.php?update_status=Selesai&id=<?php echo $row['id_pesanan']; ?>&filter=<?php echo $filter_status; ?>">Selesai</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>Tidak ada data pesanan untuk status ini.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>