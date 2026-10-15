<?php
include "koneksi.php";
include "navbar.php";

// Pengaturan pagination
$batas = 6;
$halaman = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$halaman = max(1, $halaman);

// Menghitung total artikel
$totalQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM artikel");
$totalData = mysqli_fetch_assoc($totalQuery)['total'];
$totalHalaman = ceil($totalData / $batas);

// Memastikan halaman tidak melebihi jumlah halaman
if ($totalHalaman > 0 && $halaman > $totalHalaman) {
    $halaman = $totalHalaman;
}

$mulai = ($halaman - 1) * $batas;

// Mengambil artikel sesuai halaman
$query = mysqli_query(
    $conn,
    "SELECT * FROM artikel
     ORDER BY tanggal_upload DESC
     LIMIT $mulai, $batas"
);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artikel - DPIB SMKN 1 Kawali</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #fff;
        }

        /* Breadcrumb */
        .breadcrumb {
            width: 90%;
            max-width: 1180px;
            margin: 28px auto 25px;
            padding: 10px 15px;
            display: flex;
            gap: 12px;
            background: #eee;
            border-radius: 7px;
            box-shadow: 0 2px 3px rgba(0, 0, 0, .2);
            font-size: 13px;
        }

        .breadcrumb a {
            color: #111;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            color: #b38b00;
        }

        /* Container */
        .container {
            width: 90%;
            max-width: 1180px;
            margin: 60px 50px 50px 60px;
        }

        .container h2 {
            margin-bottom: 12px;
            color: #222;
            font-size: 26px;
        }

        .section-title {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        .section-title hr {
            width: 120px;
            height: 3px;
            background: gold;
            border: none;
            margin: 10px auto 0;
        }

        /* Daftar Artikel */
        .artikel-list {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 25px;
            margin-top: 25px;
        }

        /* Kartu Artikel */
        .artikel-item {
            display: flex;
            flex-direction: column;
            min-width: 0;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .1);
            transition: .3s;
        }

        .artikel-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 12px rgba(0, 0, 0, .15);
        }

        /* Gambar Artikel */
        .artikel-item img {
            width: 100%;
            height: 190px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 12px;
        }

        /* Informasi Artikel */
        .artikel-info {
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .artikel-info h3 {
            margin-bottom: 10px;
            color: #222;
            font-size: 18px;
            line-height: 1.4;
            /* Teks panjang turun ke baris berikutnya dan tidak melebar keluar kartu */
            overflow-wrap: anywhere;
            word-break: normal;
        }

        .artikel-info p {
            color: #555;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 10px;
            overflow-wrap: anywhere;
            word-break: normal;
        }

        /* Batasi isi berita menjadi 4 baris, lalu tampilkan titik-titik */
        .artikel-info .ringkasan-berita {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 4;
            line-clamp: 4;
            overflow: hidden;
            text-overflow: ellipsis;
            overflow-wrap: anywhere;
        }

        /* Link panjang juga tetap berada di dalam kartu */
        .artikel-info .btn-baca {
            max-width: 100%;
            overflow-wrap: anywhere;
        }

        .artikel-info .tanggal {
            color: #888;
            font-size: 12px;
            margin-top: auto;
        }

        /* Tombol Baca */
        .btn-baca {
            display: inline-block;
            width: fit-content;
            margin-top: 10px;
            padding: 9px 14px;
            background: #ffc400;
            color: #222;
            text-decoration: none;
            border-radius: 5px;
            font-size: 13px;
            font-weight: bold;
            transition: .3s;
        }

        .btn-baca:hover {
            background: #e0ad00;
        }

        /* Artikel Kosong */
        .artikel-kosong {
            margin-top: 20px;
            color: #666;
            font-size: 15px;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin: 35px 0;
            flex-wrap: wrap;
        }

        .pagination a,
        .pagination span {
            display: inline-block;
            padding: 9px 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            color: #222;
            text-decoration: none;
            font-size: 14px;
            transition: .3s;
        }

        .pagination a:hover {
            background: #ffc400;
            border-color: #ffc400;
        }

        .pagination .active {
            background: #ffc400;
            border-color: #ffc400;
            font-weight: bold;
        }

        .pagination .disabled {
            color: #aaa;
            pointer-events: none;
            background: #f5f5f5;
        }

        /* Tombol Tambah Artikel */
        .tambah-artikel {
            display: inline-block;
            margin: 0 0 30px;
            padding: 10px 16px;
            background: #198754;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: .3s;
        }

        .tambah-artikel:hover {
            background: #146c43;
        }

        /* Tablet */
        @media (max-width: 900px) {
            .container {
                width: 90%;
                margin: 40px auto;
            }
        }

        /* HP */
        @media (max-width: 600px) {
            .container {
                width: 90%;
                margin: 30px auto;
            }
        }

        .container {
            width: 90%;
            margin: 30px auto;
        }

        .container h2 {
            font-size: 22px;
        }

        .artikel-item img {
            height: 200px;
        }

        .artikel-info h3 {
            font-size: 17px;
        }

        .pagination {
            gap: 5px;
        }

        .pagination a,
        .pagination span {
            padding: 8px 11px;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="index.php">Beranda</a>
        <span>›</span>
        <span>Artikel</span>
    </div>

    <!-- Konten Artikel -->
    <div class="container">
        <div class="section-title">
            <h2>Artikel</h2>
            <hr>
        </div>
        <div class="artikel">
            <?php if ($totalData > 0) { ?>

                <div class="artikel-list">

                    <?php while ($data = mysqli_fetch_assoc($query)) { ?>

                        <div class="artikel-item">

                            <!-- Gambar -->
                            <img
                                src="uploads/<?= htmlspecialchars($data['gambar']); ?>"
                                alt="<?= htmlspecialchars($data['judul']); ?>">

                            <!-- Informasi -->
                            <div class="artikel-info">

                                <h3>
                                    <?= htmlspecialchars($data['judul']); ?>
                                </h3>

                                <p class="ringkasan-berita">
                                    <?= htmlspecialchars(
                                        trim(strip_tags($data['isi_berita'])),
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ); ?>
                                </p>

                                <p class="tanggal">
                                    Tanggal Upload:
                                    <?= date(
                                        'd-m-Y',
                                        strtotime($data['tanggal_upload'])
                                    ); ?>
                                </p>

                                <!-- Tombol Baca -->
                                <a
                                    href="<?= htmlspecialchars($data['link_berita']); ?>"
                                    class="btn-baca">
                                    Baca Selengkapnya
                                </a>

                            </div>
                        </div>

                    <?php } ?>

                </div>

                <!-- Pagination -->
                <?php if ($totalHalaman > 1) { ?>

                    <div class="pagination">

                        <!-- Sebelumnya -->
                        <?php if ($halaman > 1) { ?>

                            <a href="?page=<?= $halaman - 1; ?>">
                                Sebelumnya
                            </a>

                        <?php } else { ?>

                            <span class="disabled">
                                Sebelumnya
                            </span>

                        <?php } ?>

                        <!-- Nomor Halaman -->
                        <?php for ($i = 1; $i <= $totalHalaman; $i++) { ?>

                            <?php if ($i == $halaman) { ?>

                                <span class="active">
                                    <?= $i; ?>
                                </span>

                            <?php } else { ?>

                                <a href="?page=<?= $i; ?>">
                                    <?= $i; ?>
                                </a>

                            <?php } ?>

                        <?php } ?>

                        <!-- Selanjutnya -->
                        <?php if ($halaman < $totalHalaman) { ?>

                            <a href="?page=<?= $halaman + 1; ?>">
                                Selanjutnya
                            </a>

                        <?php } else { ?>

                            <span class="disabled">
                                Selanjutnya
                            </span>

                        <?php } ?>

                    </div>

                <?php } ?>

            <?php } else { ?>

                <p class="artikel-kosong">
                    Belum ada artikel yang tersedia.
                </p>

            <?php } ?>

            <!-- Tombol Tambah Artikel -->
            <!-- <a href="tambah_artikel.php" class="tambah-artikel"> -->
                <!-- Tambah Artikel -->
            <!-- </a> -->

        </div>
    </div>
    <!-- Footer -->
    <?php include "footer.php"; ?>

</body>

</html>