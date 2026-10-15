<?php
// 1. Cek apakah admin sudah login
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
include "koneksi.php";

$pesan = "";
$error = "";

// 2. Simpan data kontak (CREATE atau UPDATE)
if (isset($_POST['simpan_kontak'])) {
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $peta = mysqli_real_escape_string($conn, $_POST['peta_embed']);
    $instagram = mysqli_real_escape_string($conn, $_POST['instagram']);
    $tiktok = mysqli_real_escape_string($conn, $_POST['tiktok']);
    $whatsapp = mysqli_real_escape_string($conn, $_POST['whatsapp']);

    if ($alamat == "" || $telepon == "" || $email == "") {
        $error = "Alamat, telepon, dan email wajib diisi.";
    } else {
        $cek = mysqli_query($conn, "SELECT id FROM kontak WHERE id=1");
        if (mysqli_num_rows($cek) > 0) {
            $sql = "UPDATE kontak SET alamat='$alamat', telepon='$telepon', email='$email', peta='$peta', instagram='$instagram', tiktok='$tiktok', whatsapp='$whatsapp' WHERE id=1";
        } else {
            $sql = "INSERT INTO kontak (id, alamat, telepon, email, peta, instagram, tiktok, whatsapp)
                    VALUES (1, '$alamat', '$telepon', '$email', '$peta', '$instagram', '$tiktok', '$whatsapp')";
        }

        if (mysqli_query($conn, $sql)) {
            $pesan = "Informasi kontak berhasil disimpan.";
        } else {
            $error = "Data gagal disimpan. Periksa nama tabel dan kolom database.";
        }
    }
}

// 3. Ambil data kontak (READ)
$hasil = mysqli_query($conn, "SELECT * FROM kontak WHERE id=1");
$data = mysqli_fetch_assoc($hasil);

if (!$data) {
    $data = array();
}
if (!isset($data['alamat'])) $data['alamat'] = 'Jl. Talagasari, No. 35, Kawalimukti, Kawali, Kabupaten Ciamis, Jawa Barat 46253';
if (!isset($data['telepon'])) $data['telepon'] = '082 9517 4679';
if (!isset($data['email'])) $data['email'] = 'info@smkn1kawali.sch.id';
if (!isset($data['peta_embed'])) $data['peta_embed'] = 'https://www.google.com/maps?q=SM%20Negeri%201%20Kawali&output=embed';
if (!isset($data['instagram'])) $data['instagram'] = '';
if (!isset($data['tiktok'])) $data['tiktok'] = '';
if (!isset($data['whatsapp'])) $data['whatsapp'] = '';

function aman_kontak($teks)
{
    return htmlspecialchars((string)$teks, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kontak - DPIB SMKN 1 Kawali</title>
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
            <div class="logo"><img src="img/logoDPIB.png" alt="Logo DPIB">
                <div>
                    <h3>DPIB</h3>
                    <p>Admin Panel</p>
                </div>
            </div>
            <p class="menu-title">MENU UTAMA</p>
            <nav>
                <a href="Dashboard_admin.php"><i class="fa-solid fa-house"></i><span>Beranda</span></a>
                <a href="Dashboard_Profil.php"><i class="fa-solid fa-building"></i><span>Profil</span></a>
                <a href="Dashboard_artikel.php"><i class="fa-solid fa-newspaper"></i><span>Artikel</span></a>
                <a href="Dashboard_galeri.php"><i class="fa-solid fa-images"></i><span>Galeri</span></a>
                <a href="Dashboard_kontak.php" class="active"><i class="fa-solid fa-envelope"></i><span>Kontak</span></a>
            </nav>
            <div class="sidebar-bottom"><a href="logout.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i><span>Keluar</span></a></div>
        </aside>
        <main class="main-content">
            <header class="topbar">
                <div>
                    <h2>Pengelolaan Kontak</h2>
                    <p>Atur alamat, lokasi peta, informasi kontak, dan media sosial.</p>
                </div>
                <div class="admin-info">
                    <div class="admin-icon"><i class="fa-solid fa-user"></i></div>
                    <div><strong>Administrator</strong><small>Admin Website</small></div>
                </div>
            </header>
            <section class="welcome">
                <div>
                    <h1>Kelola Kontak Website</h1>
                    <p>Perbarui informasi agar pengunjung dapat menghubungi jurusan DPIB.</p>
                </div><i class="fa-solid fa-envelope"></i>
            </section>
            <?php if ($pesan != '') {
                echo '<div class="notice">' . aman_kontak($pesan) . '</div>';
            } ?>
            <?php if ($error != '') {
                echo '<div class="notice error">' . aman_kontak($error) . '</div>';
            } ?>
            <form method="post">
                <section class="content-card">
                    <div class="card-heading">
                        <div>
                            <h3><i class="fa-solid fa-map-location-dot"></i> Lokasi dan Alamat</h3>
                            <p>Atur alamat sekolah dan tautan Google Maps.</p>
                        </div>
                    </div>
                    <div class="form-grid">
                        <div><label>Alamat lengkap</label><textarea name="alamat" required><?php echo aman_kontak($data['alamat']); ?></textarea>
                            <label>URL Google Maps</label><input type="url" name="peta_embed" value="<?php echo aman_kontak($data['peta_embed']); ?>" placeholder="https://www.google.com/maps/...">
                            <p class="muted">Salin URL peta dari Google Maps.</p>
                        </div>
                        <div><label>Pratinjau peta</label><iframe class="map-preview" src="<?php echo aman_kontak($data['peta_embed']); ?>" title="Peta lokasi" loading="lazy"></iframe></div>
                    </div>
                </section>
                <section class="content-card">
                    <div class="card-heading">
                        <div>
                            <h3><i class="fa-solid fa-address-card"></i> Informasi Kontak</h3>
                            <p>Nomor telepon dan alamat email yang dapat dihubungi.</p>
                        </div>
                    </div>
                    <div class="form-grid">
                        <div><label>Telepon / WhatsApp</label><input type="text" name="telepon" value="<?php echo aman_kontak($data['telepon']); ?>" required></div>
                        <div><label>Email</label><input type="email" name="email" value="<?php echo aman_kontak($data['email']); ?>" required></div>
                    </div>
                </section>
                <section class="content-card">
                    <div class="card-heading">
                        <div>
                            <h3><i class="fa-solid fa-share-nodes"></i> Media Sosial</h3>
                            <p>Masukkan tautan akun media sosial resmi.</p>
                        </div>
                    </div>
                    <div class="form-grid">
                        <div><label>Instagram</label><input type="url" name="instagram" value="<?php echo aman_kontak($data['instagram']); ?>" placeholder="https://instagram.com/akun"></div>
                        <div><label>TikTok</label><input type="url" name="tiktok" value="<?php echo aman_kontak($data['tiktok']); ?>" placeholder="https://tiktok.com/@akun"></div>
                        <div><label>WhatsApp</label><input type="url" name="whatsapp" value="<?php echo aman_kontak($data['whatsapp']); ?>" placeholder="https://wa.me/62..."></div>
                    </div>
                    <button class="btn btn-add form-button" type="submit" name="simpan_kontak"><i class="fa-solid fa-floppy-disk"></i> Simpan Kontak</button>
                </section>
            </form>
            <section class="content-card">
                <div class="card-heading">
                    <div>
                        <h3>Menu Pengelolaan Website</h3>
                        <p>Pilih menu lain untuk melanjutkan pengelolaan website.</p>
                    </div>
                </div>
                <div class="actions"><a href="Dashboard_Profil.php" class="btn btn-edit"><i class="fa-solid fa-building"></i> Kelola Profil</a><a href="Dashboard_galeri.php" class="btn btn-edit"><i class="fa-solid fa-images"></i> Kelola Galeri</a></div>
            </section>
            <footer>&copy; <?php echo date("Y"); ?> DPIB SMKN 1 Kawali. Admin Dashboard.</footer>
        </main>
    </div>
</body>

</html>