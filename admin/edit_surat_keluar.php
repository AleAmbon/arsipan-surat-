<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php");
    exit();
}
include '../config/koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: surat_keluar.php");
    exit();
}

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM surat_keluar WHERE id = '$id'");
$data = mysqli_fetch_array($query);

if (isset($_POST['update'])) {
    $no_surat = $_POST['no_surat'];
    $tgl_surat = $_POST['tgl_surat'];
    $tujuan_surat = $_POST['tujuan_surat'];
    $perihal = $_POST['perihal'];

    $update = mysqli_query($koneksi, "UPDATE surat_keluar SET 
        no_surat = '$no_surat', 
        tgl_surat = '$tgl_surat', 
        tujuan_surat = '$tujuan_surat', 
        perihal = '$perihal' 
        WHERE id = '$id'");

    if ($update) {
        header("Location: surat_keluar.php?pesan=update_berhasil");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Surat Keluar - Arsip Surat</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #3b82f6;
            --primary-light: #eff6ff;
            --bg: #f0fdf9;
            --sidebar-bg: #ffffff;
            --card-bg: #ffffff;
            --text-main: #064e3b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg);
            color: var(--text-main);
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 280px;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border);
            padding: 2rem 1.5rem;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 3rem;
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--primary);
        }

        .nav-link {
            text-decoration: none;
            color: var(--text-muted);
            padding: 0.875rem 1rem;
            border-radius: 0.75rem;
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            transition: 0.2s;
        }

        .nav-link:hover { background: var(--primary-light); color: var(--primary); }
        .nav-link.active { background: var(--primary); color: white; }

        .main-content {
            margin-left: 280px;
            padding: 2.5rem;
            width: calc(100% - 280px);
        }

        .card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 1.5rem;
            padding: 2.5rem;
            box-shadow: var(--shadow);
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            max-width: 800px;
            margin: 0 auto 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--text-main);
        }

        input, textarea {
            width: 100%;
            padding: 0.875rem 1rem;
            border-radius: 0.75rem;
            border: 1px solid var(--border);
            background: #ffffff;
            color: var(--text-main);
            outline: none;
            transition: 0.2s;
            font-size: 0.95rem;
        }

        input:focus, textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .btn-update {
            background: var(--primary);
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 0.75rem;
            font-weight: 700;
            cursor: pointer;
            width: 100%;
            transition: 0.2s;
            font-size: 1rem;
            margin-top: 1rem;
        }

        .btn-update:hover { background: #2563eb; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); }
        
        .btn-back {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <i class="fas fa-paper-plane"></i>
            <span>Arsip Surat</span>
        </div>
        <a href="dashboard.php" class="nav-link">
            <i class="fas fa-grid-2"></i>
            <span>Dashboard</span>
        </a>
        <a href="surat_masuk.php" class="nav-link">
            <i class="fas fa-inbox"></i>
            <span>Surat Masuk</span>
        </a>
        <a href="surat_keluar.php" class="nav-link active">
            <i class="fas fa-share-flat"></i>
            <span>Surat Keluar</span>
        </a>
        <a href="../auth/logout.php" class="nav-link" style="margin-top: auto; color: #ef4444;">
            <i class="fas fa-sign-out-alt"></i>
            <span>Keluar</span>
        </a>
    </div>

    <div class="main-content">
        <div class="header">
            <a href="surat_keluar.php" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali ke Daftar</a>
            <h1 style="font-size: 1.75rem; font-weight: 800;">Edit Surat Keluar</h1>
        </div>

        <div class="card">
            <form action="" method="POST">
                <div class="form-group">
                    <label>No. Surat</label>
                    <input type="text" name="no_surat" value="<?php echo $data['no_surat']; ?>" required autocomplete="off">
                </div>
                <div class="form-group">
                    <label>Tgl. Surat</label>
                    <input type="date" name="tgl_surat" value="<?php echo $data['tgl_surat']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Tujuan Surat</label>
                    <input type="text" name="tujuan_surat" value="<?php echo $data['tujuan_surat']; ?>" required autocomplete="off">
                </div>
                <div class="form-group">
                    <label>Perihal</label>
                    <textarea name="perihal" rows="4" required><?php echo $data['perihal']; ?></textarea>
                </div>
                <button type="submit" name="update" class="btn-update">Perbarui Surat Keluar</button>
            </form>
        </div>
    </div>
</body>
</html>
