<?php
// 1. Cek login admin
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
include "koneksi.php";

// 2. Proses hapus foto (DELETE)
if (isset($_POST['hapus_galeri'])) {
    $id = (int) $_POST['id'];
    // Ambil nama file foto sebelum data dihapus
    $cek_foto = mysqli_query($conn, "SELECT foto FROM galeri WHERE id_galeri=$id");
    $foto = mysqli_fetch_assoc($cek_foto);

    $hapus = mysqli_query($conn, "DELETE FROM galeri WHERE id_galeri=$id");
    if ($hapus) {
        if (!empty($foto['foto']) && file_exists("uploads/" . $foto['foto'])) {
            unlink("uploads/" . $foto['foto']);
        }
        header("Location: Dashboard_galeri.php?status=hapus");
        exit;
    }
}

// 3. Hitung jumlah data untuk statistik dan halaman
$hasil_total = mysqli_query($conn, "SELECT COUNT(*) AS total FROM galeri");
$data_total = mysqli_fetch_assoc($hasil_total);
$total_galeri = $data_total['total'];

$per_halaman = 10;
$total_halaman = ceil($total_galeri / $per_halaman);
if ($total_halaman < 1) {
    $total_halaman = 1;
}
$halaman = 1;
if (isset($_GET['halaman'])) {
    $halaman = (int) $_GET['halaman'];
}
if ($halaman < 1) {
    $halaman = 1;
}
if ($halaman > $total_halaman) {
    $halaman = $total_halaman;
}
$offset = ($halaman - 1) * $per_halaman;

// 4. Ambil data galeri (READ)
$data_galeri = mysqli_query($conn, "SELECT * FROM galeri ORDER BY tanggal_upload DESC LIMIT $offset, $per_halaman");

// Fungsi sederhana untuk menampilkan teks dengan aman
function e($teks)
{
    return htmlspecialchars((string)$teks, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Galeri - DPIB SMKN 1 Kawali</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
            transition: .2s;
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
        .muted {
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

        .welcome {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #202b3c;
            color: white;
            padding: 28px 30px;
            border-radius: 12px;
            margin-bottom: 20px;
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
            font-size: 50px;
            color: #ffc400;
            margin-right: 15px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 2px 8px #0000000d;
            margin-bottom: 22px;
            max-width: 340px;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: grid;
            place-items: center;
            font-size: 20px;
            background: #fff2bf;
            color: #d6a300;
        }

        .stat-card p {
            color: #858c98;
            font-size: 12px;
            margin-bottom: 7px;
        }

        .stat-card h2 {
            font-size: 25px;
            margin-bottom: 5px;
        }

        .stat-card small {
            color: #9ba1aa;
            font-size: 11px;
        }

        .content-card {
            background: white;
            padding: 24px;
            border-radius: 10px;
            box-shadow: 0 2px 8px #0000000d;
            margin-bottom: 22px;
        }

        .card-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
        }

        .card-heading h3 {
            font-size: 18px;
            margin-bottom: 7px;
        }

        .card-heading p {
            color: #858c98;
            font-size: 13px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 0;
            border-radius: 6px;
            padding: 10px 14px;
            text-decoration: none;
            font-size: 13px;
            cursor: pointer;
        }

        .btn-add {
            background: #ffc400;
            color: #202b3c;
            font-weight: bold;
        }

        .btn-edit {
            background: #e4efff;
            color: #245fa8;
        }

        .btn-delete {
            background: #ffe4e4;
            color: #b42332;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 850px;
        }

        th,
        td {
            padding: 13px 12px;
            text-align: left;
            border-bottom: 1px solid #edf0f4;
            vertical-align: middle;
            font-size: 13px;
        }

        th {
            background: #f7f8fb;
            color: #626b78;
            font-size: 12px;
            white-space: nowrap;
        }

        tbody tr:hover {
            background: #fcfcfd;
        }

        .thumb {
            width: 62px;
            height: 48px;
            object-fit: cover;
            border-radius: 5px;
            background: #f0f1f4;
        }

        .title-cell {
            min-width: 180px;
            max-width: 260px;
            font-weight: bold;
            line-height: 1.4;
        }

        .excerpt {
            color: #727b88;
            font-weight: normal;
            margin-top: 5px;
            line-height: 1.4;
            max-width: 320px;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
            line-clamp: 3;
            overflow: hidden;
            overflow-wrap: anywhere;
        }

        .actions {
            display: flex;
            gap: 7px;
            align-items: center;
        }

        .actions form {
            margin: 0;
        }

        .empty {
            padding: 30px;
            text-align: center;
            color: #858c98;
        }

        .notice {
            padding: 12px 15px;
            border-radius: 7px;
            margin-bottom: 18px;
            font-size: 13px;
            background: #e4f7e9;
            color: #20743a;
        }

        .notice.error {
            background: #ffe6e6;
            color: #a52323;
        }

        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 20px;
        }

        .page-links {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .page-links a,
        .page-links span {
            min-width: 35px;
            padding: 9px 11px;
            border-radius: 6px;
            text-align: center;
            text-decoration: none;
            color: #3c4654;
            background: #f0f2f6;
            font-size: 13px;
        }

        .page-links .current {
            background: #202b3c;
            color: white;
        }

        footer {
            text-align: center;
            color: #9299a4;
            font-size: 12px;
            padding: 15px 0 5px;
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
        }

        @media (max-width: 520px) {
            .main-content {
                padding: 14px;
            }

            .topbar {
                align-items: flex-start;
            }

            .topbar h2 {
                font-size: 20px;
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

            .welcome>i {
                display: none;
            }

            .content-card {
                padding: 15px;
            }

            .stat-card {
                max-width: none;
            }
        }
    </style>
</head>

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
                <a href="Dasboard_admin.php"><i class="fa-solid fa-house"></i><span>Beranda</span></a>
                <a href="Dashboard_profil.php"><i class="fa-solid fa-building"></i><span>Profil</span></a>
                <a href="Dashboard_artikel.php"><i class="fa-solid fa-newspaper"></i><span>Artikel</span></a>
                <a href="Dashboard_galeri.php" class="active"><i class="fa-solid fa-images"></i><span>Galeri</span></a>
                <a href="Dashboard_kontak.php"><i class="fa-solid fa-envelope"></i><span>Kontak</span></a>
            </nav>
            <div class="sidebar-bottom">
                <a href="logout.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i><span>Keluar</span></a>
            </div>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <div>
                    <h2>Pengelolaan Galeri</h2>
                    <p>Kelola, edit, dan hapus foto galeri jurusan DPIB.</p>
                </div>
                <div class="admin-info">
                    <div class="admin-icon"><i class="fa-solid fa-user"></i></div>
                    <div><strong>Administrator</strong><small>Admin Website</small></div>
                </div>
            </header>

            <section class="welcome">
                <div>
                    <h1>Kelola Galeri Website</h1>
                    <p>Semua foto kegiatan website jurusan dapat dikelola dari halaman ini.</p>
                </div>
                <i class="fa-solid fa-images"></i>
            </section>

            <section class="stat-card">
                <div class="stat-icon"><i class="fa-solid fa-image"></i></div>
                <div>
                    <p>Total Foto Galeri</p>
                    <h2><?= number_format($total_galeri, 0, ',', '.'); ?></h2>
                    <small>Jumlah foto galeri yang tersimpan di database</small>
                </div>
            </section>

            <?php if (isset($_GET['status']) && $_GET['status'] === 'hapus'): ?>
                <div class="notice">Foto galeri berhasil dihapus.</div>
            <?php elseif (isset($_GET['status']) && $_GET['status'] === 'gagal'): ?>
                <div class="notice error">Foto galeri gagal dihapus. Silakan coba lagi.</div>
            <?php endif; ?>

            <section class="content-card">
                <div class="card-heading">
                    <div>
                        <h3>Daftar Galeri</h3>
                        <p>Menampilkan maksimal 10 foto per halaman.</p>
                    </div>
                    <a href="tambah_galeri.php" class="btn btn-add"><i class="fa-solid fa-plus"></i> Tambah Foto</a>
                </div>

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Gambar</th>
                                <th>Nama & Deskripsi Foto</th>
                                <th>Tanggal Upload</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($data_galeri) > 0): ?>
                                <?php $nomor = $offset + 1; ?>
                                <?php while ($galeri = mysqli_fetch_assoc($data_galeri)): ?>
                                    <tr>
                                        <td><?= $nomor++; ?></td>
                                        <td>
                                            <?php if (!empty($galeri['foto'])): ?>
                                                <img class="thumb" src="uploads/<?= e(rawurlencode(basename($galeri['foto']))); ?>" alt="Foto galeri">
                                            <?php else: ?>
                                                <span class="muted">Tidak ada</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="title-cell">
                                            <?= e($galeri['nama_foto']); ?>
                                            <div class="excerpt">
                                                <?php
                                                $isi = trim(strip_tags($galeri['deskripsi_foto']));
                                                echo e(mb_strimwidth($isi, 0, 100, '...', 'UTF-8'));
                                                ?>
                                            </div>
                                        </td>
                                        <td><?= e($galeri['tanggal_upload']); ?></td>
                                        <td>
                                            <div class="actions">
                                                <a class="btn btn-edit" href="edit_galeri.php?id=<?= (int) $galeri['id_galeri']; ?>" title="Edit">
                                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                                </a>
                                                <form method="POST" onsubmit="return confirm('Yakin ingin menghapus foto galeri ini?');">
                                                    <input type="hidden" name="id" value="<?= (int) $galeri['id_galeri']; ?>">
                                                    <button type="submit" name="hapus_galeri" class="btn btn-delete" title="Hapus foto galeri">
                                                        <i class="fa-solid fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="empty">Belum ada foto galeri. Klik “Tambah Foto” untuk menambahkan foto pertama.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="pagination">
                    <p class="muted">
                        <?php if ($total_galeri > 0): ?>
                            Menampilkan <?= $offset + 1; ?>–<?= min($offset + $per_halaman, $total_galeri); ?>
                            dari <?= number_format($total_galeri, 0, ',', '.'); ?> foto
                        <?php else: ?>
                            Belum ada data foto galeri
                        <?php endif; ?>
                    </p>

                    <?php if ($total_halaman > 1): ?>
                        <div class="page-links">
                            <?php if ($halaman > 1): ?>
                                <a href="?halaman=<?= $halaman - 1; ?>" aria-label="Halaman sebelumnya">&laquo;</a>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $total_halaman; $i++): ?>
                                <?php if ($i === $halaman): ?>
                                    <span class="current"><?= $i; ?></span>
                                <?php else: ?>
                                    <a href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                                <?php endif; ?>
                            <?php endfor; ?>

                            <?php if ($halaman < $total_halaman): ?>
                                <a href="?halaman=<?= $halaman + 1; ?>" aria-label="Halaman berikutnya">&raquo;</a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <section class="content-card">
                <div class="card-heading">
                    <div>
                        <h3>Menu Pengelolaan Website</h3>
                        <p>Galeri menjadi fokus utama. Menu lain tetap tersedia di bawah ini.</p>
                    </div>
                </div>
                <div class="actions">
                    <a href="tambah_galeri.php" class="btn btn-add"><i class="fa-solid fa-plus"></i> Tambah Foto</a>
                    <a href="Dashboard_galeri.php" class="btn btn-edit"><i class="fa-solid fa-images"></i> Kelola Galeri</a>
                    <a href="profil.php" class="btn btn-edit"><i class="fa-solid fa-building"></i> Kelola Profil</a>
                    <a href="kontak.php" class="btn btn-edit"><i class="fa-solid fa-envelope"></i> Kelola Kontak</a>
                </div>
            </section>

            <footer>&copy; <?= date("Y"); ?> DPIB SMKN 1 Kawali. Admin Dashboard.</footer>
        </main>
    </div>
</body>

</html>