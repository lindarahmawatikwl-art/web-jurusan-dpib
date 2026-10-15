<?php
// 1. Cek login admin
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
include "koneksi.php";

// 2. Proses hapus artikel (DELETE)
if (isset($_POST['hapus_artikel'])) {
    $id = (int) $_POST['id_artikel'];
    $cek_gambar = mysqli_query($conn, "SELECT gambar FROM artikel WHERE id_artikel=$id");
    $gambar = mysqli_fetch_assoc($cek_gambar);

    $hapus = mysqli_query($conn, "DELETE FROM artikel WHERE id_artikel=$id");
    if ($hapus) {
        if (!empty($gambar['gambar']) && file_exists("uploads/" . $gambar['gambar'])) {
            unlink("uploads/" . $gambar['gambar']);
        }
        header("Location: Dashboard_artikel.php?status=hapus");
        exit;
    }
}

// 3. Hitung artikel untuk statistik dan pagination
$hasil_total = mysqli_query($conn, "SELECT COUNT(*) AS total FROM artikel");
$data_total = mysqli_fetch_assoc($hasil_total);
$total_artikel = $data_total['total'];

$per_halaman = 10;
$total_halaman = ceil($total_artikel / $per_halaman);
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

// 4. Ambil data artikel (READ)
$data_artikel = mysqli_query($conn, "SELECT * FROM artikel ORDER BY tanggal_upload DESC LIMIT $offset, $per_halaman");

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
    <title>Dashboard Artikel - DPIB SMKN 1 Kawali</title>
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
                <a href="Dashboard_admin.php"><i class="fa-solid fa-house"></i><span>Beranda</span></a>
                <a href="Dashboard_profil.php"><i class="fa-solid fa-building"></i><span>Profil</span></a>
                <a href="Dashboard_artikel.php" class="active"><i class="fa-solid fa-newspaper"></i><span>Artikel</span></a>
                <a href="Dashboard_galeri.php"><i class="fa-solid fa-images"></i><span>Galeri</span></a>
                <a href="Dashboard_kontak.php"><i class="fa-solid fa-envelope"></i><span>Kontak</span></a>
            </nav>
            <div class="sidebar-bottom">
                <a href="logout.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i><span>Keluar</span></a>
            </div>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <div>
                    <h2>Pengelolaan Artikel</h2>
                    <p>Kelola, edit, dan hapus artikel jurusan DPIB.</p>
                </div>
                <div class="admin-info">
                    <div class="admin-icon"><i class="fa-solid fa-user"></i></div>
                    <div><strong>Administrator</strong><small>Admin Website</small></div>
                </div>
            </header>

            <section class="welcome">
                <div>
                    <h1>Kelola Artikel Website</h1>
                    <p>Semua artikel website jurusan dapat dikelola dari halaman ini.</p>
                </div>
                <i class="fa-solid fa-newspaper"></i>
            </section>

            <section class="stat-card">
                <div class="stat-icon"><i class="fa-solid fa-file-lines"></i></div>
                <div>
                    <p>Total Artikel</p>
                    <h2><?= number_format($total_artikel, 0, ',', '.'); ?></h2>
                    <small>Jumlah artikel yang tersimpan di database</small>
                </div>
            </section>

            <?php if (isset($_GET['status']) && $_GET['status'] === 'hapus'): ?>
                <div class="notice">Artikel berhasil dihapus.</div>
            <?php elseif (isset($_GET['status']) && $_GET['status'] === 'gagal'): ?>
                <div class="notice error">Artikel gagal dihapus. Silakan coba lagi.</div>
            <?php endif; ?>

            <section class="content-card">
                <div class="card-heading">
                    <div>
                        <h3>Daftar Artikel</h3>
                        <p>Menampilkan maksimal 10 artikel per halaman.</p>
                    </div>
                    <a href="tambah_artikel.php" class="btn btn-add"><i class="fa-solid fa-plus"></i> Tambah Artikel</a>
                </div>

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Gambar</th>
                                <th>Judul & Isi Artikel</th>
                                <th>Tanggal Upload</th>
                                <th>Link Berita</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($data_artikel) > 0): ?>
                                <?php $nomor = $offset + 1; ?>
                                <?php while ($artikel = mysqli_fetch_assoc($data_artikel)): ?>
                                    <tr>
                                        <td><?= $nomor++; ?></td>
                                        <td>
                                            <?php if (!empty($artikel['gambar'])): ?>
                                                <img class="thumb" src="uploads/<?= e(rawurlencode(basename($artikel['gambar']))); ?>" alt="Gambar artikel">
                                            <?php else: ?>
                                                <span class="muted">Tidak ada</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="title-cell">
                                            <?= e($artikel['judul']); ?>
                                            <div class="excerpt">
                                                <?php
                                                $isi = trim(strip_tags($artikel['isi_berita']));
                                                echo e(mb_strimwidth($isi, 0, 100, '...', 'UTF-8'));
                                                ?>
                                            </div>
                                        </td>
                                        <td><?= e($artikel['tanggal_upload']); ?></td>
                                        <td>
                                            <?php if (!empty($artikel['link_berita'])): ?>
                                                <a href="<?= e($artikel['link_berita']); ?>" target="_blank" rel="noopener noreferrer">Lihat link</a>
                                            <?php else: ?>
                                                <span class="muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="actions">
                                                <a class="btn btn-edit" href="edit_artikel.php?id=<?= (int) $artikel['id_artikel']; ?>" title="Edit artikel">
                                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                                </a>
                                                <form method="POST" onsubmit="return confirm('Yakin ingin menghapus artikel ini?');">
                                                    <input type="hidden" name="id_artikel" value="<?= (int) $artikel['id_artikel']; ?>">
                                                    <button type="submit" name="hapus_artikel" class="btn btn-delete" title="Hapus artikel">
                                                        <i class="fa-solid fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="empty">Belum ada artikel. Klik “Tambah Artikel” untuk membuat artikel pertama.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="pagination">
                    <p class="muted">
                        <?php if ($total_artikel > 0): ?>
                            Menampilkan <?= $offset + 1; ?>–<?= min($offset + $per_halaman, $total_artikel); ?>
                            dari <?= number_format($total_artikel, 0, ',', '.'); ?> artikel
                        <?php else: ?>
                            Belum ada data artikel
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
                        <p>Artikel menjadi fokus utama. Menu lain tetap tersedia di bawah ini.</p>
                    </div>
                </div>
                <div class="actions">
                    <a href="tambah_artikel.php" class="btn btn-add"><i class="fa-solid fa-plus"></i> Tambah Artikel</a>
                    <a href="galeri.php" class="btn btn-edit"><i class="fa-solid fa-images"></i> Kelola Galeri</a>
                    <a href="profil.php" class="btn btn-edit"><i class="fa-solid fa-building"></i> Kelola Profil</a>
                    <a href="kontak.php" class="btn btn-edit"><i class="fa-solid fa-envelope"></i> Kelola Kontak</a>
                </div>
            </section>

            <footer>&copy; <?= date("Y"); ?> DPIB SMKN 1 Kawali. Admin Dashboard.</footer>
        </main>
    </div>
</body>

</html>