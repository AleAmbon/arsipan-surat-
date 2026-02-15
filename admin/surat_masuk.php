<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php");
    exit();
}
include '../config/koneksi.php';

$query = mysqli_query($koneksi, "SELECT * FROM surat_masuk ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Masuk - Arsip Surat</title>
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

        .btn-add:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3); }

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
            letter-spacing: 0.05em;
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

        .btn-edit { background: #f0fdf4; color: #166534; }
        .btn-delete { background: #fef2f2; color: #991b1b; }
        .btn-wa { background: #dcfce7; color: #15803d; }
        .btn-email { background: #eff6ff; color: #1d4ed8; }
        .btn-icon:hover { transform: scale(1.1); }
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
        <a href="surat_masuk.php" class="nav-link active">
            <i class="fas fa-inbox"></i>
            <span>Surat Masuk</span>
        </a>
        <a href="surat_keluar.php" class="nav-link">
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
            <h1 style="font-size: 1.75rem; font-weight: 800;">Daftar Surat Masuk</h1>
            <a href="tambah_surat_masuk.php" class="btn-add">
                <i class="fas fa-plus"></i> Tambah Surat
            </a>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>No. Surat</th>
                        <th>Asal Surat</th>
                        <th>Tgl. Surat</th>
                        <th>Perihal</th>
                        <th>Berkas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($query) > 0): ?>
                        <?php while($row = mysqli_fetch_array($query)): ?>
                            <tr>
                                <td><span class="badge"><?php echo $row['no_surat']; ?></span></td>
                                <td style="font-weight: 600;"><?php echo $row['asal_surat']; ?></td>
                                <td style="color: var(--text-muted);"><?php echo date('d M Y', strtotime($row['tgl_surat'])); ?></td>
                                <td><?php echo $row['perihal']; ?></td>
                                <td>
                                    <?php if($row['file_path'] != ""): ?>
                                        <a href="../uploads/<?php echo $row['file_path']; ?>" target="_blank" class="btn-icon btn-wa" style="width: auto; padding: 0 10px; font-size: 0.75rem; gap: 5px;" title="Lihat Berkas">
                                            <i class="fas fa-file-pdf"></i> Lihat
                                        </a>
                                    <?php else: ?>
                                        <span style="color: var(--text-muted); font-size: 0.75rem;">Tidak ada</span>
                                    <?php endif; ?>
                                </td>
                                <td class="action-btns">
                                    <?php 
                                        $wa_text = "Halo, berikut rincian Surat Masuk:%0A" . 
                                                   "No. Surat: " . $row['no_surat'] . "%0A" .
                                                   "Asal: " . $row['asal_surat'] . "%0A" .
                                                   "Tanggal: " . date('d M Y', strtotime($row['tgl_surat'])) . "%0A" .
                                                   "Perihal: " . $row['perihal'];
                                        
                                        $email_subject = "Data Surat Masuk - " . $row['no_surat'];
                                        $email_body = "No. Surat: " . $row['no_surat'] . "\n" .
                                                      "Asal: " . $row['asal_surat'] . "\n" .
                                                      "Tanggal: " . date('d M Y', strtotime($row['tgl_surat'])) . "\n" .
                                                      "Perihal: " . $row['perihal'];
                                    ?>
                                    <a href="https://api.whatsapp.com/send?text=<?php echo $wa_text; ?>" target="_blank" class="btn-icon btn-wa" title="Kirim ke WhatsApp"><i class="fab fa-whatsapp"></i></a>
                                    <a href="mailto:?subject=<?php echo urlencode($email_subject); ?>&body=<?php echo urlencode($email_body); ?>" class="btn-icon btn-email" title="Kirim ke Email"><i class="fas fa-envelope"></i></a>
                                    
                                    <?php if($_SESSION['role'] == 'admin'): ?>
                                        <a href="edit_surat_masuk.php?id=<?php echo $row['id']; ?>" class="btn-icon btn-edit" title="Edit"><i class="fas fa-pen-to-square"></i></a>
                                        <a href="hapus_surat_masuk.php?id=<?php echo $row['id']; ?>" class="btn-icon btn-delete" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus surat ini?')"><i class="fas fa-trash"></i></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 3rem;">
                                <i class="fas fa-folder-open" style="font-size: 2rem; display: block; margin-bottom: 1rem; opacity: 0.3;"></i>
                                Belum ada data surat masuk.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
