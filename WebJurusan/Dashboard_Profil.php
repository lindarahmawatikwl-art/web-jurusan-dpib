<?php
// 1. Cek login admin
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
include "koneksi.php";

// 2. Tentukan bagian profil yang dipilih
$bagian = "visi_misi";
if (isset($_GET['bagian'])) {
    $bagian = $_GET['bagian'];
}
if (isset($_POST['bagian'])) {
    $bagian = $_POST['bagian'];
}
if ($bagian != "visi_misi" && $bagian != "struktur" && $bagian != "himpunan") {
    $bagian = "visi_misi";
}
$pesan = "";
$error = "";

// 3. Simpan visi dan misi (CREATE atau UPDATE)
if (isset($_POST['simpan_konten'])) {
    $visi = mysqli_real_escape_string($conn, $_POST['visi']);
    $misi = mysqli_real_escape_string($conn, $_POST['misi']);

    $cek = mysqli_query($conn, "SELECT bagian FROM profil_konten WHERE bagian='$bagian'");
    if (mysqli_num_rows($cek) > 0) {
        $sql = "UPDATE profil_konten SET visi='$visi', misi='$misi' WHERE bagian='$bagian'";
    } else {
        $sql = "INSERT INTO profil_konten (bagian, visi, misi) VALUES ('$bagian', '$visi', '$misi')";
    }

    if (mysqli_query($conn, $sql)) {
        $pesan = "Data profil berhasil disimpan.";
    } else {
        $error = "Data gagal disimpan.";
    }
}

// 4. Tambah anggota (CREATE)
if (isset($_POST['tambah_anggota'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $urutan = (int) $_POST['urutan'];

    if ($nama != "" && $jabatan != "") {
        $sql = "INSERT INTO profil_anggota (bagian, nama, jabatan, urutan)
                VALUES ('$bagian', '$nama', '$jabatan', $urutan)";
        if (mysqli_query($conn, $sql)) {
            $pesan = "Anggota berhasil ditambahkan.";
        } else {
            $error = "Anggota gagal ditambahkan.";
        }
    } else {
        $error = "Nama dan jabatan harus diisi.";
    }
}

// 5. Hapus anggota (DELETE)
if (isset($_POST['hapus_anggota'])) {
    $id = (int) $_POST['id'];
    $sql = "DELETE FROM profil_anggota WHERE id=$id AND bagian='$bagian'";
    if (mysqli_query($conn, $sql)) {
        $pesan = "Anggota berhasil dihapus.";
    } else {
        $error = "Anggota gagal dihapus.";
    }
}

// 6. Ambil data dari database (READ)
$hasil_konten = mysqli_query($conn, "SELECT * FROM profil_konten WHERE bagian='$bagian'");
$konten = mysqli_fetch_assoc($hasil_konten);
if (!$konten) {
    $konten = array("visi" => "", "misi" => "");
}
$hasil_anggota = mysqli_query($conn, "SELECT * FROM profil_anggota WHERE bagian='$bagian' ORDER BY urutan ASC, id ASC");

function aman($teks)
{
    return htmlspecialchars((string)$teks, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Profil - DPIB SMKN 1 Kawali</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            color: #333
        }

        .dashboard {
            display: flex;
            min-height: 100vh
        }

        .sidebar {
            width: 250px;
            background: #202b3c;
            color: white;
            padding: 25px 15px;
            display: flex;
            flex-direction: column;
            flex-shrink: 0
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 10px 30px;
            border-bottom: 1px solid #3b4657
        }

        .logo img {
            width: 45px;
            height: 45px;
            object-fit: contain;
            background: white;
            border-radius: 50%
        }

        .logo h3 {
            font-size: 20px;
            color: #ffc400
        }

        .logo p {
            font-size: 12px;
            color: #b8c0cc;
            margin-top: 4px
        }

        .menu-title {
            font-size: 11px;
            color: #929eae;
            margin: 30px 10px 12px;
            letter-spacing: 1px
        }

        .sidebar nav {
            display: flex;
            flex-direction: column;
            gap: 8px
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
            transition: .2s
        }

        .sidebar nav a i,
        .logout i {
            width: 20px;
            text-align: center
        }

        .sidebar nav a:hover,
        .sidebar nav a.active {
            background: #ffc400;
            color: #202b3c
        }

        .sidebar-bottom {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid #3b4657
        }

        .logout:hover {
            background: #dc3545;
            color: white
        }

        .main-content {
            flex: 1;
            min-width: 0;
            padding: 30px
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 25px
        }

        .topbar h2 {
            font-size: 24px;
            margin-bottom: 7px
        }

        .topbar p,
        .muted {
            color: #858c98;
            font-size: 14px
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 10px
        }

        .admin-icon {
            width: 42px;
            height: 42px;
            background: #fff0b8;
            color: #ad8300;
            display: grid;
            place-items: center;
            border-radius: 50%
        }

        .admin-info strong,
        .admin-info small {
            display: block
        }

        .admin-info strong {
            font-size: 13px
        }

        .admin-info small {
            font-size: 11px;
            color: #858c98;
            margin-top: 4px
        }

        .welcome {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #202b3c;
            color: white;
            padding: 28px 30px;
            border-radius: 12px;
            margin-bottom: 20px
        }

        .welcome h1 {
            font-size: 23px;
            margin-bottom: 10px
        }

        .welcome p {
            color: #c5cbd4;
            font-size: 14px
        }

        .welcome>i {
            font-size: 50px;
            color: #ffc400;
            margin-right: 15px
        }

        .content-card {
            background: white;
            padding: 24px;
            border-radius: 10px;
            box-shadow: 0 2px 8px #0000000d;
            margin-bottom: 22px
        }

        .card-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px
        }

        .card-heading h3 {
            font-size: 18px;
            margin-bottom: 7px
        }

        .card-heading p {
            color: #858c98;
            font-size: 13px
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
            cursor: pointer
        }

        .btn-add {
            background: #ffc400;
            color: #202b3c;
            font-weight: bold
        }

        .btn-edit {
            background: #e4efff;
            color: #245fa8
        }

        .btn-delete {
            background: #ffe4e4;
            color: #b42332
        }

        label {
            display: block;
            font-weight: bold;
            font-size: 13px;
            margin: 16px 0 7px
        }

        input,
        textarea {
            width: 100%;
            border: 1px solid #d9dee7;
            border-radius: 6px;
            padding: 11px;
            font: inherit;
            font-size: 14px
        }

        textarea {
            min-height: 110px;
            resize: vertical
        }

        .form-button {
            margin-top: 16px
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px
        }

        .notice {
            padding: 12px 15px;
            border-radius: 7px;
            margin-bottom: 18px;
            font-size: 13px;
            background: #e4f7e9;
            color: #20743a
        }

        .notice.error {
            background: #ffe6e6;
            color: #a52323
        }

        .tab-menu {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 20px
        }

        .tab-menu a {
            display: inline-flex;
            padding: 11px 14px;
            border-radius: 6px;
            text-decoration: none;
            background: #f0f2f6;
            color: #3c4654;
            font-size: 13px
        }

        .tab-menu a.active {
            background: #202b3c;
            color: #ffc400
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 500px
        }

        th,
        td {
            padding: 13px 12px;
            text-align: left;
            border-bottom: 1px solid #edf0f4;
            vertical-align: middle;
            font-size: 13px
        }

        th {
            background: #f7f8fb;
            color: #626b78;
            font-size: 12px
        }

        tbody tr:hover {
            background: #fcfcfd
        }

        .actions {
            display: flex;
            gap: 7px;
            align-items: center
        }

        .actions form {
            margin: 0
        }

        .empty {
            padding: 25px;
            text-align: center;
            color: #858c98
        }

        .map-preview {
            width: 100%;
            height: 260px;
            border: 0;
            border-radius: 6px;
            background: #f0f1f4
        }

        footer {
            text-align: center;
            color: #9299a4;
            font-size: 12px;
            padding: 15px 0 5px
        }

        @media(max-width:768px) {
            .sidebar {
                width: 75px;
                padding: 20px 10px
            }

            .logo {
                justify-content: center;
                padding: 0 0 25px
            }

            .logo img {
                width: 42px;
                height: 42px
            }

            .logo div,
            .menu-title,
            .sidebar nav a span,
            .logout span {
                display: none
            }

            .sidebar nav a,
            .logout {
                justify-content: center;
                padding: 14px 5px
            }

            .sidebar nav a i,
            .logout i {
                width: auto;
                font-size: 18px
            }

            .main-content {
                padding: 20px
            }

            .welcome {
                padding: 22px
            }

            .form-grid {
                grid-template-columns: 1fr
            }
        }

        @media(max-width:520px) {
            .main-content {
                padding: 14px
            }

            .topbar {
                align-items: flex-start
            }

            .topbar h2 {
                font-size: 20px
            }

            .admin-info strong {
                font-size: 11px
            }

            .admin-info small {
                font-size: 10px
            }

            .admin-icon {
                width: 35px;
                height: 35px
            }

            .welcome>i {
                display: none
            }

            .content-card {
                padding: 15px
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
                <a href="Dashboard_Profil.php" class="active"><i class="fa-solid fa-building"></i><span>Profil</span></a>
                <a href="Dashboard_artikel.php"><i class="fa-solid fa-newspaper"></i><span>Artikel</span></a>
                <a href="Dashboard_galeri.php"><i class="fa-solid fa-images"></i><span>Galeri</span></a>
                <a href="Dashboard_kontak.php"><i class="fa-solid fa-envelope"></i><span>Kontak</span></a>
            </nav>
            <div class="sidebar-bottom"><a href="logout.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i><span>Keluar</span></a></div>
        </aside>
        <main class="main-content">

            <header class="topbar">
                <div>
                    <h2>Pengelolaan Profil</h2>
                    <p>Kelola visi misi dan susunan organisasi jurusan DPIB.</p>
                </div>
                <div class="admin-info">
                    <div class="admin-icon"><i class="fa-solid fa-user"></i></div>
                    <div><strong>Administrator</strong><small>Admin Website</small></div>
                </div>
            </header>
            <section class="welcome">
                <div>
                    <h1>Kelola Profil Website</h1>
                    <p>Perbarui visi misi, struktur organisasi, dan himpunan siswa melalui halaman ini.</p>
                </div><i class="fa-solid fa-building"></i>
            </section>
            <?php if ($pesan != '') {
                echo '<div class="notice">' . aman($pesan) . '</div>';
            } ?>
            <?php if ($error != '') {
                echo '<div class="notice error">' . aman($error) . '</div>';
            } ?>
            <div class="tab-menu">
                <a class="<?php if ($bagian == 'visi_misi') echo 'active'; ?>" href="?bagian=visi_misi"><i class="fa-solid fa-bullseye"></i>&nbsp; Visi &amp; Misi</a>
                <a class="<?php if ($bagian == 'struktur') echo 'active'; ?>" href="?bagian=struktur"><i class="fa-solid fa-sitemap"></i>&nbsp; Struktur Organisasi</a>
                <a class="<?php if ($bagian == 'himpunan') echo 'active'; ?>" href="?bagian=himpunan"><i class="fa-solid fa-people-group"></i>&nbsp; Himpunan Siswa</a>
            </div>
            <?php if ($bagian == 'visi_misi') { ?>
                <section class="content-card">
                    <div class="card-heading">
                        <div>
                            <h3>Visi dan Misi</h3>
                            <p>Ubah teks visi dan misi yang ditampilkan di website.</p>
                        </div>
                    </div>
                    <form method="post">
                        <input type="hidden" name="bagian" value="visi_misi">
                        <label>Visi</label><textarea name="visi" required><?php echo aman($konten['visi']); ?></textarea>
                        <label>Misi</label><textarea name="misi" required><?php echo aman($konten['misi']); ?></textarea>
                        <button class="btn btn-add form-button" type="submit" name="simpan_konten"><i class="fa-solid fa-floppy-disk"></i> Simpan Visi &amp; Misi</button>
                    </form>
                </section>
            <?php } else { ?>
                <div class="form-grid">
                    <section class="content-card">
                        <div class="card-heading">
                            <div>
                                <h3><?php if ($bagian == 'struktur') {
                                        echo 'Struktur Organisasi';
                                    } else {
                                        echo 'Himpunan Siswa';
                                    } ?></h3>
                                <p>Tambahkan nama dan jabatan anggota.</p>
                            </div>
                        </div>
                        <form method="post">
                            <input type="hidden" name="bagian" value="<?php echo aman($bagian); ?>">
                            <label>Nama</label><input type="text" name="nama" required>
                            <label>Jabatan</label><input type="text" name="jabatan" required>
                            <label>Urutan tampilan</label><input type="number" name="urutan" value="1">
                            <button class="btn btn-add form-button" type="submit" name="tambah_anggota"><i class="fa-solid fa-plus"></i> Tambah Anggota</button>
                        </form>
                    </section>
                    <section class="content-card">
                        <div class="card-heading">
                            <div>
                                <h3>Daftar Anggota</h3>
                                <p>Anggota yang sudah tersimpan.</p>
                            </div>
                        </div>
                        <div class="table-wrap">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Jabatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (mysqli_num_rows($hasil_anggota) == 0) {
                                        echo '<tr><td colspan="3" class="empty">Belum ada anggota.</td></tr>';
                                    } ?>
                                    <?php while ($anggota = mysqli_fetch_assoc($hasil_anggota)) { ?>
                                        <tr>
                                            <td><?php echo aman($anggota['nama']); ?></td>
                                            <td><?php echo aman($anggota['jabatan']); ?></td>
                                            <td>
                                                <form method="post" onsubmit="return confirm('Yakin ingin menghapus anggota ini?');">
                                                    <input type="hidden" name="bagian" value="<?php echo aman($bagian); ?>"><input type="hidden" name="id" value="<?php echo (int)$anggota['id']; ?>">
                                                    <button class="btn btn-delete" type="submit" name="hapus_anggota"><i class="fa-solid fa-trash"></i> Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            <?php } ?>
            <section class="content-card">
                <div class="card-heading">
                    <div>
                        <h3>Menu Pengelolaan Website</h3>
                        <p>Pilih menu lain untuk melanjutkan pengelolaan website.</p>
                    </div>
                </div>
                <div class="actions"><a href="Dashboard_galeri.php" class="btn btn-edit"><i class="fa-solid fa-images"></i> Kelola Galeri</a><a href="Dashboard_kontak.php" class="btn btn-edit"><i class="fa-solid fa-envelope"></i> Kelola Kontak</a></div>
            </section>
            <footer>&copy; <?php echo date("Y"); ?> DPIB SMKN 1 Kawali. Admin Dashboard.</footer>
        </main>
    </div>
</body>

</html>