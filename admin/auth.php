<?php
session_start();

// Cek apakah admin sudah login, jika tidak, redirect ke halaman login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>