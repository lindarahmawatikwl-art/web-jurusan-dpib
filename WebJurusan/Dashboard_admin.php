<?php
// 1. Cek login admin
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
include "koneksi.php";

// 2. Hitung jumlah artikel
$hasil_artikel = mysqli_query($conn, "SELECT COUNT(*) AS total FROM artikel");
$data_artikel = mysqli_fetch_assoc($hasil_artikel);
$total_artikel = $data_artikel['total'];

// 3. Hitung jumlah foto galeri
$hasil_galeri = mysqli_query($conn, "SELECT COUNT(*) AS total FROM galeri");
$data_galeri = mysqli_fetch_assoc($hasil_galeri);
$total_galeri = $data_galeri['total'];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - DPIB SMKN 1 Kawali</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        background: #f5f6fa;
        color: #333;
    }

    .dashboard {
        display: flex;
        min-height: 100vh;
    }

    /* Sidebar */
    .sidebar {
        width: 250px;
        background: #202b3c;
        color: white;
        padding: 25px 15px;
        display: flex;
        flex-direction: column;
        flex-shrink: 0;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 0 10px 30px;
        border-bottom: 1px solid #3b4657;
    }

    .logo img {
        width: 45px;
        height: 45px;
        object-fit: contain;
        background: white;
        border-radius: 50%;
    }

    .logo h3 {
        font-size: 20px;
        color: #ffc400;
    }

    .logo p {
        font-size: 12px;
        color: #b8c0cc;
        margin-top: 4px;
    }

    .menu-title {
        font-size: 11px;
        color: #929eae;
        margin: 30px 10px 12px;
        letter-spacing: 1px;
    }

    .sidebar nav {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .sidebar nav a,
    .logout {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 13px 15px;
        color: #c5cbd4;
        text-decoration: none;
        border-radius: 8px;
        font-size: 14px;
        transition: 0.2s;
    }

    .sidebar nav a i,
    .logout i {
        width: 20px;
        text-align: center;
    }

    .sidebar nav a:hover,
    .sidebar nav a.active {
        background: #ffc400;
        color: #202b3c;
    }

    .sidebar-bottom {
        margin-top: auto;
        padding-top: 20px;
        border-top: 1px solid #3b4657;
    }

    .logout:hover {
        background: #dc3545;
        color: white;
    }

    /* Konten utama */
    .main-content {
        flex: 1;
        min-width: 0;
        padding: 30px;
    }

    .topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 25px;
    }

    .topbar h2 {
        font-size: 24px;
        margin-bottom: 7px;
    }

    .topbar p,
    .card-heading p {
        color: #858c98;
        font-size: 14px;
    }

    .admin-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .admin-icon {
        width: 42px;
        height: 42px;
        background: #fff0b8;
        color: #ad8300;
        display: grid;
        place-items: center;
        border-radius: 50%;
    }

    .admin-info strong,
    .admin-info small {
        display: block;
    }

    .admin-info strong {
        font-size: 13px;
    }

    .admin-info small {
        font-size: 11px;
        color: #858c98;
        margin-top: 4px;
    }

    /* Sambutan */
    .welcome {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #202b3c;
        color: white;
        padding: 30px;
        border-radius: 12px;
        margin-bottom: 25px;
    }

    .welcome h1 {
        font-size: 23px;
        margin-bottom: 10px;
    }

    .welcome p {
        color: #c5cbd4;
        font-size: 14px;
    }

    .welcome>i {
        font-size: 55px;
        color: #ffc400;
        margin-right: 15px;
    }

    /* Statistik */
    .stats {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
        margin-bottom: 25px;
    }

    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: grid;
        place-items: center;
        font-size: 20px;
    }

    .yellow {
        background: #fff2bf;
        color: #d6a300;
    }

    .blue {
        background: #dcecff;
        color: #3478d4;
    }

    .green {
        background: #d9f6e4;
        color: #269b54;
    }

    .red {
        background: #ffe0e0;
        color: #dc3545;
    }

    .stat-card p {
        color: #858c98;
        font-size: 12px;
        margin-bottom: 7px;
    }

    .stat-card h2 {
        font-size: 22px;
        margin-bottom: 5px;
    }

    .stat-card small {
        color: #9ba1aa;
        font-size: 11px;
    }

    /* Pengelolaan website */
    .content-card {
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .card-heading {
        margin-bottom: 22px;
    }

    .card-heading h3 {
        font-size: 18px;
        margin-bottom: 7px;
    }

    .card-heading p {
        font-size: 13px;
    }

    .management-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .management-item {
        border: 1px solid #e9ebef;
        border-radius: 10px;
        padding: 20px;
        text-decoration: none;
        color: #333;
        transition: 0.2s;
    }

    .management-item:hover {
        border-color: #ffc400;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.07);
    }

    .management-item>i {
        font-size: 23px;
        color: #d5a400;
        margin-bottom: 15px;
    }

    .management-item h4 {
        font-size: 15px;
        margin-bottom: 8px;
    }

    .management-item p {
        color: #858c98;
        font-size: 12px;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .management-item span {
        color: #b18a00;
        font-size: 12px;
        font-weight: bold;
    }

    /* Footer */
    footer {
        text-align: center;
        color: #9299a4;
        font-size: 12px;
        padding: 25px 0 5px;
    }

    /* Responsive */
    @media (max-width: 1100px) {
        .stats {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 75px;
            padding: 20px 10px;
        }

        .logo {
            justify-content: center;
            padding: 0 0 25px;
        }

        .logo img {
            width: 42px;
            height: 42px;
        }

        .logo div,
        .menu-title,
        .sidebar nav a span,
        .logout span {
            display: none;
        }

        .sidebar nav a,
        .logout {
            justify-content: center;
            padding: 14px 5px;
        }

        .sidebar nav a i,
        .logout i {
            width: auto;
            font-size: 18px;
        }

        .main-content {
            padding: 20px;
        }

        .welcome {
            padding: 22px;
        }

        .welcome h1 {
            font-size: 19px;
        }

        .welcome>i {
            font-size: 38px;
        }
    }

    @media (max-width: 520px) {
        .main-content {
            padding: 15px;
        }

        .topbar {
            align-items: flex-start;
        }

        .topbar h2 {
            font-size: 20px;
        }

        .topbar p {
            font-size: 12px;
        }

        .admin-info strong {
            font-size: 11px;
        }

        .admin-info small {
            font-size: 10px;
        }

        .admin-icon {
            width: 35px;
            height: 35px;
        }

        .welcome {
            padding: 20px;
        }

        .welcome p {
            line-height: 1.5;
        }

        .welcome>i {
            display: none;
        }

        .stats,
        .management-grid {
            grid-template-columns: 1fr;
        }

        .stats {
            gap: 12px;
        }

        .content-card {
            padding: 18px;
        }
    }
</style>

<body>
    <div class="dashboard">
        <aside class="sidebar">
            <div class="logo">
                <img src="img/logoDPIB.png" alt="Logo DPIB">
                <div>
                    <h3>DPIB</h3>
                    <p>Admin Panel</p>
                </div>
            </div>
            <p class="menu-title">MENU UTAMA</p>
            <nav>
                <a href="Dashboard_admin.php" class="active"><i class="fa-solid fa-house"></i> Beranda</a>
                <a href="Dashboard_profil.php"><i class="fa-solid fa-building"></i> Profil</a>
                <a href="Dashboard_artikel.php"><i class="fa-solid fa-newspaper"></i> Artikel</a>
                <a href="Dashboard_galeri.php"><i class="fa-solid fa-images"></i> Galeri</a>
                <a href="Dashboard_kontak.php"><i class="fa-solid fa-envelope"></i> Kontak</a>
            </nav>
            <div class="sidebar-bottom">
                <a href="logout.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Keluar</a>
            </div>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <div>
                    <h2>Dashboard</h2>
                    <p>Selamat datang di panel admin DPIB SMKN 1 Kawali</p>
                </div>
                <div class="admin-info">
                    <div class="admin-icon"><i class="fa-solid fa-user"></i></div>
                    <div>
                        <strong>Administrator</strong>
                        <small>Admin Website</small>
                    </div>
                </div>
            </header>

            <section class="welcome">
                <div>
                    <h1>Selamat Datang, Admin!</h1>
                    <p>Kelola informasi dan konten website jurusan DPIB dari halaman ini.</p>
                </div>
                <i class="fa-solid fa-chart-line"></i>
            </section>

            <section class="stats">
                <div class="stat-card">
                    <div class="stat-icon yellow"><i class="fa-solid fa-newspaper"></i></div>
                    <div>
                        <p>Total Artikel</p>
                        <h2><?= number_format($total_artikel, 0, ',', '.'); ?></h2><small>Artikel website</small>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon blue"><i class="fa-solid fa-images"></i></div>
                    <div>
                        <p>Total Galeri</p>
                        <h2><?= number_format($total_galeri, 0, ',', '.'); ?></h2><small>Foto kegiatan</small>
                    </div>
                </div>
            </section>

            <section class="content-card">
                <div class="card-heading">
                    <h3>Pengelolaan Website</h3>
                    <p>Pilih menu untuk mengelola bagian website.</p>
                </div>
                <div class="management-grid">
                    <a href="profil.php" class="management-item">
                        <i class="fa-solid fa-building"></i>
                        <h4>Profil</h4>
                        <p>Kelola informasi jurusan, visi, dan misi.</p>
                        <span>Kelola <i class="fa-solid fa-arrow-right"></i></span>
                    </a>
                    <a href="Dashboard_artikel.php" class="management-item">
                        <i class="fa-solid fa-newspaper"></i>
                        <h4>Artikel</h4>
                        <p>Tambah, ubah, dan hapus artikel.</p>
                        <span>Kelola <i class="fa-solid fa-arrow-right"></i></span>
                    </a>
                    <a href="Dashboard_galeri.php" class="management-item">
                        <i class="fa-solid fa-images"></i>
                        <h4>Galeri</h4>
                        <p>Kelola foto dan dokumentasi kegiatan.</p>
                        <span>Kelola <i class="fa-solid fa-arrow-right"></i></span>
                    </a>
                    <a href="kontak_kelola.php" class="management-item">
                        <i class="fa-solid fa-envelope"></i>
                        <h4>Kontak</h4>
                        <p>Kelola peta, alamat, informasi kontak, dan media sosial.</p>
                        <span>Kelola <i class="fa-solid fa-arrow-right"></i></span>
                    </a>
                </div>
            </section>
            <footer>&copy; <?= date("Y"); ?> DPIB SMKN 1 Kawali. Admin Dashboard.</footer>
        </main>
    </div>
</body>

</html>