<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}
include '../config/koneksi.php';

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama_lengkap'];
    $user = $_POST['username'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $query = mysqli_query($koneksi, "INSERT INTO users (username, password, nama_lengkap, role) VALUES ('$user', '$pass', '$nama', '$role')");
    if ($query) {
        header("Location: users.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User - Arsip Surat</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #10b981;
            --primary-light: #ecfdf5;
            --bg: #f0fdf9;
            --sidebar-bg: #ffffff;
            --card-bg: #ffffff;
            --text-main: #064e3b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: var(--bg); color: var(--text-main); display: flex; min-height: 100vh; }
        .sidebar { width: 280px; background: var(--sidebar-bg); border-right: 1px solid var(--border); padding: 2rem 1.5rem; position: fixed; height: 100vh; }
        .logo { font-size: 1.5rem; font-weight: 800; margin-bottom: 3rem; display: flex; align-items: center; gap: 12px; color: var(--primary); }
        .nav-link { text-decoration: none; color: var(--text-muted); padding: 0.875rem 1rem; border-radius: 0.75rem; margin-bottom: 0.25rem; display: flex; align-items: center; gap: 12px; font-weight: 500; }
        .nav-link.active { background: var(--primary); color: white; }
        .main-content { margin-left: 280px; padding: 2.5rem; width: calc(100% - 280px); }
        .card { background: var(--card-bg); border: 1px solid var(--border); border-radius: 1.5rem; padding: 2.5rem; box-shadow: var(--shadow); max-width: 600px; margin: 0 auto; }
        .form-group { margin-bottom: 1.5rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem; }
        input, select { width: 100%; padding: 0.875rem 1rem; border-radius: 0.75rem; border: 1px solid var(--border); outline: none; }
        .btn-save { background: var(--primary); color: white; border: none; padding: 1rem; border-radius: 0.75rem; font-weight: 700; cursor: pointer; width: 100%; transition: 0.2s; }
        .btn-save:hover { background: #059669; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <i class="fas fa-paper-plane"></i>
            <span>Arsip Surat</span>
        </div>
        <a href="dashboard.php" class="nav-link"><i class="fas fa-grid-2"></i> Dashboard</a>
        <a href="surat_masuk.php" class="nav-link"><i class="fas fa-inbox"></i> Surat Masuk</a>
        <a href="surat_keluar.php" class="nav-link"><i class="fas fa-share-flat"></i> Surat Keluar</a>
        <a href="users.php" class="nav-link active"><i class="fas fa-users"></i> Manajemen User</a>
    </div>
    <div class="main-content">
        <div class="card">
            <h2 style="margin-bottom: 1.5rem;">Tambah User Baru</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" required>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role">
                        <option value="petugas">Petugas (Hanya Baca/Tambah)</option>
                        <option value="admin">Admin (Izin Penuh)</option>
                    </select>
                </div>
                <button type="submit" name="simpan" class="btn-save">Simpan User</button>
            </form>
        </div>
    </div>
</body>
</html>
