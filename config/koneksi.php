<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "arsip_surat_db";

$koneksi = mysqli_connect($host, $user, $pass);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Buat database jika belum ada
$sql_db = "CREATE DATABASE IF NOT EXISTS $db";
mysqli_query($koneksi, $sql_db);

// Pilih database
mysqli_select_db($koneksi, $db);

// Buat tabel users
$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100),
    role ENUM('admin', 'petugas') DEFAULT 'admin'
)";
mysqli_query($koneksi, $sql_users);

// Buat user default jika belum ada (admin/admin123)
$check_user = mysqli_query($koneksi, "SELECT * FROM users WHERE username='admin'");
if (mysqli_num_rows($check_user) == 0) {
    $pass_hash = password_hash('admin123', PASSWORD_DEFAULT);
    mysqli_query($koneksi, "INSERT INTO users (username, password, nama_lengkap, role) VALUES ('admin', '$pass_hash', 'Administrator', 'admin')");
}

// Buat tabel surat_masuk
$sql_masuk = "CREATE TABLE IF NOT EXISTS surat_masuk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    no_surat VARCHAR(50) NOT NULL,
    tgl_surat DATE,
    tgl_terima DATE,
    asal_surat VARCHAR(100),
    perihal TEXT,
    file_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($koneksi, $sql_masuk);

// Buat tabel surat_keluar
$sql_keluar = "CREATE TABLE IF NOT EXISTS surat_keluar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    no_surat VARCHAR(50) NOT NULL,
    tgl_surat DATE,
    tujuan_surat VARCHAR(100),
    perihal TEXT,
    file_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($koneksi, $sql_keluar);
?>
