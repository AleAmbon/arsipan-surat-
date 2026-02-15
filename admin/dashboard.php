<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php");
    exit();
}
include '../config/koneksi.php';

// Ambil data untuk statistik
$total_masuk = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) FROM surat_masuk"))[0];
$total_keluar = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) FROM surat_keluar"))[0];

// Data untuk chart (Surat per bulan - simulasi atau ambil dari DB)
$labels = ["Januari", "Februari", "Maret", "April", "Mei", "Juni"];
$data_masuk = [5, 10, 8, 15, 12, $total_masuk]; // Contoh data
$data_keluar = [3, 8, 10, 12, 10, $total_keluar]; // Contoh data
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Arsip Surat</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #10b981;
            --primary-light: #ecfdf5;
            --secondary: #3b82f6;
            --bg: #f0fdf9;
            --sidebar-bg: #ffffff;
            --card-bg: #ffffff;
            --text-main: #064e3b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
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

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border);
            padding: 2rem 1.5rem;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            z-index: 100;
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

        .nav-group {
            margin-bottom: 2rem;
        }

        .nav-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 1rem;
            padding-left: 1rem;
            letter-spacing: 0.05em;
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
            transition: all 0.2s;
        }

        .nav-link:hover {
            background: var(--primary-light);
            color: var(--primary);
        }

        .nav-link.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .logout-btn {
            margin-top: auto;
            color: #ef4444;
        }

        .logout-btn:hover {
            background: #fef2f2;
            color: #dc2626;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: 280px;
            padding: 2.5rem;
            width: calc(100% - 280px);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.5rem 1rem;
            background: var(--card-bg);
            border-radius: 1rem;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
        }

        .avatar {
            width: 36px;
            height: 36px;
            background: var(--primary-light);
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            padding: 1.5rem;
            border-radius: 1.25rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: var(--shadow);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .icon-masuk { background: #dcfce7; color: #166534; }
        .icon-keluar { background: #fef2f2; color: #991b1b; }

        .stat-info h3 {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-bottom: 0.25rem;
        }

        .stat-info .value {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-main);
        }

        /* Chart Section */
        .chart-container {
            background: var(--card-bg);
            border: 1px solid var(--border);
            padding: 2rem;
            border-radius: 1.5rem;
            box-shadow: var(--shadow);
            margin-bottom: 2.5rem;
        }

        .chart-header {
            margin-bottom: 2rem;
        }

        .chart-header h2 {
            font-size: 1.25rem;
            font-weight: 700;
        }

        .chart-header p {
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        canvas {
            max-height: 400px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <i class="fas fa-paper-plane"></i>
            <span>Arsip Surat</span>
        </div>
        
        <div class="nav-group">
            <p class="nav-label">Menu Utama</p>
            <a href="dashboard.php" class="nav-link active">
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
            <?php if($_SESSION['role'] == 'admin'): ?>
            <a href="users.php" class="nav-link">
                <i class="fas fa-users"></i>
                <span>Manajemen User</span>
            </a>
            <?php endif; ?>
        </div>

        <div class="nav-group">
            <p class="nav-label">Lainnya</p>
            <a href="../auth/logout.php" class="nav-link logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Keluar Aplikasi</span>
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <div>
                <h1 style="font-size: 1.75rem; font-weight: 800;">Ringkasan Statistik</h1>
                <p style="color: var(--text-muted);">Selamat datang kembali, <?php echo $_SESSION['nama']; ?>!</p>
            </div>
            <div class="user-profile">
                <div class="avatar"><?php echo substr($_SESSION['nama'], 0, 1); ?></div>
                <div style="text-align: left;">
                    <p style="font-size: 0.875rem; font-weight: 700; line-height: 1;"><?php echo $_SESSION['nama']; ?></p>
                    <p style="font-size: 0.75rem; color: var(--text-muted);"><?php echo ucfirst($_SESSION['role']); ?></p>
                </div>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon icon-masuk">
                    <i class="fas fa-download"></i>
                </div>
                <div class="stat-info">
                    <h3>Total Surat Masuk</h3>
                    <div class="value"><?php echo $total_masuk; ?></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon icon-keluar">
                    <i class="fas fa-upload"></i>
                </div>
                <div class="stat-info">
                    <h3>Total Surat Keluar</h3>
                    <div class="value"><?php echo $total_keluar; ?></div>
                </div>
            </div>
        </div>

        <div class="chart-container">
            <div class="chart-header">
                <h2>Diagram Aktivitas Surat</h2>
                <p>Data perbandingan surat masuk dan keluar tahun 2024</p>
            </div>
            <canvas id="suratChart"></canvas>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('suratChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Surat Masuk',
                    data: <?php echo json_encode($data_masuk); ?>,
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointBackgroundColor: '#10b981',
                    pointRadius: 5
                }, {
                    label: 'Surat Keluar',
                    data: <?php echo json_encode($data_keluar); ?>,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointBackgroundColor: '#3b82f6',
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: { family: 'Plus Jakarta Sans', size: 12, weight: '600' }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [5, 5], color: '#e2e8f0' },
                        ticks: { font: { family: 'Plus Jakarta Sans' } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'Plus Jakarta Sans' } }
                    }
                }
            }
        });
    </script>
</body>
</html>
