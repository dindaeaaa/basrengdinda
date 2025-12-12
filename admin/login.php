<?php
session_start();
include '../config/db.php';

$error = '';

// Jika admin sudah login, redirect ke dashboard
if (isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "Username dan password tidak boleh kosong.";
    } else {
        $sql = "SELECT id_admin, password FROM admin WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);

if (password_verify($password, $row['password'])) {
                $_SESSION['admin_id'] = $row['id_admin'];
                $_SESSION['admin_username'] = $username;
                session_write_close(); // Menyimpan sesi sebelum redirect
                header("Location: kelola_pesanan.php"); // Redirect ke halaman kelola pesanan admin
                exit();
            } else {
                $error = "Username atau password salah.";
            }
        } else {
            $error = "Username atau password salah.";
        }
    }
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin - Toko Basreng Enndhhull</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f5f5f5;
        }
        .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
        }
    </style>
</head>
<body class="text-center">

<main class="form-signin">
    <form method="POST" action="login.php">
        <h1 class="h3 mb-3 fw-normal">Login Admin</h1>
        <a href="../index.php">← Kembali ke Toko</a>

        <?php if ($error): ?>
            <div class="alert alert-danger mt-3">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <div class="form-floating mt-3">
            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
            <label for="username">Username</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            <label for="password">Password</label>
        </div>

        <button class="w-100 btn btn-lg btn-primary mt-3" type="submit">Login</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2025 Toko Basreng Enndhhull</p>
    </form>
</main>

</body>
</html>
