<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php");
    exit();
}
include '../config/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($koneksi, "DELETE FROM surat_keluar WHERE id = '$id'");

    if ($query) {
        header("Location: surat_keluar.php?pesan=hapus_berhasil");
    } else {
        header("Location: surat_keluar.php?pesan=hapus_gagal");
    }
} else {
    header("Location: surat_keluar.php");
}
?>
