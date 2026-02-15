<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Surat - Solusi Digital Arsip Anda</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #10b981;
            --primary-dark: #059669;
            --primary-light: #ecfdf5;
            --bg: #f0fdf9;
            --text-main: #064e3b;
            --text-muted: #64748b;
            --white: #ffffff;
            --shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
            scroll-behavior: smooth;
        }

        body {
            background-color: var(--bg);
            color: var(--text-main);
            overflow-x: hidden;
        }

        /* Navigation */
        nav {
            padding: 1.5rem 10%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(240, 253, 249, 0.8);
            backdrop-filter: blur(10px);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-main);
            font-weight: 600;
            font-size: 0.95rem;
            transition: 0.3s;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .btn-login {
            background: var(--primary);
            color: white !important;
            padding: 0.75rem 1.75rem;
            border-radius: 50px;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
        }

        .btn-login:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero {
            padding: 10rem 10% 5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 5%;
            min-height: 100vh;
        }

        .hero-content {
            flex: 1;
        }

        .hero-badge {
            background: var(--primary-light);
            color: var(--primary);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.85rem;
            display: inline-block;
            margin-bottom: 1.5rem;
        }

        .hero-content h1 {
            font-size: 4rem;
            line-height: 1.1;
            font-weight: 800;
            margin-bottom: 1.5rem;
            color: var(--text-main);
        }

        .hero-content h1 span {
            color: var(--primary);
        }

        .hero-content p {
            font-size: 1.15rem;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 2.5rem;
            max-width: 500px;
        }

        .hero-image {
            flex: 1;
            position: relative;
        }

        .hero-image img {
            width: 100%;
            border-radius: 2rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        /* Features */
        .features {
            padding: 5rem 10%;
            background: var(--white);
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-header h2 {
            font-size: 2.5rem;
            font-weight: 800;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            padding: 2.5rem;
            background: var(--bg);
            border-radius: 1.5rem;
            transition: 0.3s;
            border: 1px solid transparent;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            border-color: var(--primary);
            background: var(--white);
            box-shadow: var(--shadow);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: var(--primary);
            color: white;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .feature-card h3 {
            font-size: 1.25rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .feature-card p {
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* Footer */
        footer {
            padding: 5rem 10% 2rem;
            background: var(--text-main);
            color: var(--white);
            text-align: center;
        }

        .footer-logo {
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 2rem;
            display: inline-flex;
            align-items: center;
            gap: 12px;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .footer-links a {
            color: #94a3b8;
            text-decoration: none;
            transition: 0.3s;
        }

        .footer-links a:hover {
            color: var(--primary);
        }

        .copyright {
            padding-top: 2rem;
            border-top: 1px solid #1e293b;
            color: #64748b;
            font-size: 0.9rem;
        }

        /* CTA Section */
        .cta {
            padding: 5rem 10%;
            text-align: center;
        }

        .cta-box {
            background: var(--primary);
            padding: 4rem 2rem;
            border-radius: 3rem;
            color: white;
            box-shadow: 0 20px 40px rgba(16, 185, 129, 0.3);
        }

        .cta-box h2 {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            font-weight: 800;
        }

        .cta-box p {
            font-size: 1.2rem;
            margin-bottom: 2.5rem;
            opacity: 0.9;
        }

        .btn-white {
            background: white;
            color: var(--primary);
            padding: 1rem 2.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 800;
            transition: 0.3s;
            display: inline-block;
        }

        .btn-white:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        @media (max-width: 991px) {
            .hero {
                flex-direction: column;
                text-align: center;
                padding-top: 8rem;
            }
            .hero-content h1 { font-size: 3rem; }
            .hero-content p { margin: 0 auto 2.5rem; }
            .hero-image { margin-top: 4rem; }
        }
    </style>
</head>
<body>
    <nav>
        <a href="#" class="logo">
            <i class="fas fa-paper-plane"></i>
            <span>Arsip Surat</span>
        </a>
        <div class="nav-links">
            <a href="#fitur">Fitur</a>
            <a href="#tentang">Tentang</a>
            <a href="auth/login.php" class="btn-login">Masuk ke Sistem</a>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-content">
            <div class="hero-badge">Sistem Informasi Manajemen Surat v2.0</div>
            <h1>Kelola <span>Arsip Surat</span> Secara Profesional & Cepat</h1>
            <p>Ubah tumpukan surat menjadi data digital yang terorganisir. Akses kapan saja, kirim rincian lewat WhatsApp, dan pantau tren surat secara real-time.</p>
            <div style="display: flex; gap: 1rem; justify-content: inherit;">
                <a href="auth/login.php" class="btn-login" style="padding: 1.2rem 2.5rem; font-size: 1.1rem;">Coba Sekarang</a>
                <a href="#fitur" style="padding: 1.2rem 2.5rem; font-weight: 700; text-decoration: none; color: var(--text-main);">Lihat Fitur <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
        <style>
            .hero-illustration {
                width: 100%;
                height: 450px;
                background: linear-gradient(135deg, var(--primary) 0%, #3b82f6 100%);
                border-radius: 3rem;
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
                overflow: hidden;
                box-shadow: 0 30px 60px rgba(16, 185, 129, 0.2);
            }
            .hero-illustration::before {
                content: '';
                position: absolute;
                width: 200%;
                height: 200%;
                background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
                top: -50%;
                left: -50%;
                animation: rotate 20s linear infinite;
            }
            @keyframes rotate {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
            .hero-illustration i {
                font-size: 15rem;
                color: rgba(255,255,255,0.2);
                position: absolute;
            }
            .floating-icon {
                position: absolute;
                background: rgba(255,255,255,0.2);
                backdrop-filter: blur(5px);
                padding: 1.5rem;
                border-radius: 1.5rem;
                color: white;
                font-size: 2rem;
                animation: float-icon 4s ease-in-out infinite;
                box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            }
            @keyframes float-icon {
                0%, 100% { transform: translateY(0) rotate(0); }
                50% { transform: translateY(-20px) rotate(10deg); }
            }
        </style>
        <div class="hero-image">
            <div class="hero-illustration">
                <i class="fas fa-folder-open"></i>
                <div class="floating-icon" style="top: 20%; left: 15%; animation-delay: 0s;"><i class="fas fa-envelope"></i></div>
                <div class="floating-icon" style="top: 10%; right: 20%; animation-delay: 1s;"><i class="fas fa-paper-plane"></i></div>
                <div class="floating-icon" style="bottom: 25%; left: 25%; animation-delay: 2s;"><i class="fas fa-file-pdf"></i></div>
                <div class="floating-icon" style="bottom: 15%; right: 15%; animation-delay: 3s;"><i class="fas fa-shield-halved"></i></div>
                <div style="color: white; text-align: center; z-index: 10; padding: 2rem;">
                    <i class="fas fa-paper-plane" style="font-size: 5rem; position: static; color: white; display: block; margin-bottom: 1.5rem;"></i>
                    <h2 style="font-size: 2.5rem; font-weight: 800;">Digital Archiving</h2>
                    <p style="opacity: 0.9; font-weight: 500;">Secure, Fast, & Organized</p>
                </div>
            </div>
        </div>
    </section>

    <section id="fitur" class="features">
        <div class="section-header">
            <h2>Hadir Dengan Fitur Unggulan</h2>
            <p style="color: var(--text-muted); max-width: 600px; margin: 1rem auto;">Segala kemudahan yang Anda butuhkan untuk manajemen persuratan ada di sini.</p>
        </div>
        <div class="feature-grid">
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-file-invoice"></i></div>
                <h3>Pencatatan Surat</h3>
                <p>Catat surat masuk dan keluar dengan detail lengkap, termasuk nomor, asal, tujuan, dan perihal.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fab fa-whatsapp"></i></div>
                <h3>Kirim WA & Email</h3>
                <p>Bagikan rincian arsip surat ke rekan kerja atau atasan langsung melalui integrasi WhatsApp dan Email.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-cloud-upload"></i></div>
                <h3>Upload Berkas</h3>
                <p>Simpan dokumen asli dalam format PDF atau Gambar agar tidak hilang dan mudah dicari kembali.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
                <h3>Visualisasi Data</h3>
                <p>Pantau tren persuratan bulanan melalui grafik interaktif yang mudah dipahami di dashboard.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-user-shield"></i></div>
                <h3>Hak Akses User</h3>
                <p>Sistem multi-user untuk Admin dan Petugas dengan izin akses yang terkelola dengan aman.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-mobile-alt"></i></div>
                <h3>Responsif Desain</h3>
                <p>Akses arsip surat Anda dari mana saja, baik melalui komputer, tablet, maupun smartphone.</p>
            </div>
        </div>
    </section>

    <section class="cta">
        <div class="cta-box">
            <h2>Siap Mengatur Arsip Anda?</h2>
            <p>Bergabunglah dengan ribuan instansi yang telah mendigitalkan sistem persuratan mereka.</p>
            <a href="auth/login.php" class="btn-white">Masuk Sekarang</a>
        </div>
    </section>

    <footer>
        <div class="footer-logo">
            <i class="fas fa-paper-plane"></i>
            <span>Arsip Surat</span>
        </div>
        <div class="footer-links">
            <a href="#">Kebijakan Privasi</a>
            <a href="#">Syarat & Ketentuan</a>
            <a href="#">Kontak Kami</a>
            <a href="#">Bantuan</a>
        </div>
        <div class="copyright">
            &copy; 2026 Arsip Surat Digital. Dibuat dengan <i class="fas fa-heart" style="color: #ef4444;"></i> untuk efisiensi Anda.
        </div>
    </footer>
</body>
</html>
