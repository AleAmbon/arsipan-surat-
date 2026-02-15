<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}
include '../config/koneksi.php';

$query = mysqli_query($koneksi, "SELECT * FROM users ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User - Arsip Surat</title>
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

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .btn-add {
            background: var(--primary);
            color: white;
            text-decoration: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.2s;
        }

        .btn-add:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); }

        .card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: var(--shadow);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 1rem;
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
            text-transform: uppercase;
        }

        td {
            padding: 1.25rem 1rem;
            font-size: 0.95rem;
            border-bottom: 1px solid var(--border);
        }

        .badge {
            background: var(--primary-light);
            color: var(--primary);
            padding: 0.375rem 0.75rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .badge-role {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-admin {
            background: #dcfce7;
            color: #166534;
        }

        .action-btns { display: flex; gap: 8px; }
        .btn-icon {
            width: 32px;
            height: 32px;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: 0.2s;
        }
        .btn-delete { background: #fef2f2; color: #991b1b; }
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
        <a href="surat_keluar.php" class="nav-link">
            <i class="fas fa-share-flat"></i>
            <span>Surat Keluar</span>
        </a>
        <a href="users.php" class="nav-link active">
            <i class="fas fa-users"></i>
            <span>Manajemen User</span>
        </a>
        <a href="../auth/logout.php" class="nav-link" style="margin-top: auto; color: #ef4444;">
            <i class="fas fa-sign-out-alt"></i>
            <span>Keluar</span>
        </a>
    </div>

    <div class="main-content">
        <div class="header">
            <h1 style="font-size: 1.75rem; font-weight: 800;">Manajemen User</h1>
            <a href="tambah_user.php" class="btn-add">
                <i class="fas fa-user-plus"></i> Tambah User
            </a>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_array($query)): ?>
                        <tr>
                            <td style="font-weight: 600;"><?php echo $row['nama_lengkap']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td>
                                <span class="badge <?php echo ($row['role'] == 'admin') ? 'badge-admin' : 'badge-role'; ?>">
                                    <?php echo strtoupper($row['role']); ?>
                                </span>
                            </td>
                            <td class="action-btns">
                                <?php if($row['username'] !== 'admin'): ?>
                                    <a href="hapus_user.php?id=<?php echo $row['id']; ?>" class="btn-icon btn-delete" onclick="return confirm('Hapus user ini?')"><i class="fas fa-trash"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
