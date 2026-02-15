<?php
session_start();
include '../config/koneksi.php';

$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = $_POST['password'];

$query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
$data = mysqli_fetch_array($query);

if ($data) {
    if (password_verify($password, $data['password'])) {
        $_SESSION['username'] = $data['username'];
        $_SESSION['nama'] = $data['nama_lengkap'];
        $_SESSION['role'] = $data['role'];
        header("Location: ../admin/dashboard.php");
    } else {
        header("Location: login.php?pesan=gagal");
    }
} else {
    header("Location: login.php?pesan=gagal");
}
?>
