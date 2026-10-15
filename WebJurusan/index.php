
<?php
include "navbar.php";
include "koneksi.php";
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>DPIB SMKN 1 Kawali</title>

    <link rel="stylesheet" href="style.css">
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    html {
        scroll-behavior: smooth;
    }
    body {
        font-family: Arial, Helvetica, sans-serif;
        color: #222;
        background-color: #ffffff;
    }
/* Hero */
.hero-full {
    min-height: 100vh;
    width: 100%;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    background-image: url("img/Hero.jpeg");
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    overflow: hidden;
}
/* Overlay */
.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.25);
}
/* Konten */
.hero-content-full {
    position: relative;
    z-index: 2;
    max-width: 850px;
    padding: 30px;
    color: white;
}
/* Label */
.hero-label {
    font-size: 14px;
    font-weight: bold;
    letter-spacing: 3px;
    margin-bottom: 20px;
    color: #ffffff;
    text-shadow: 0 2px 5px rgba(0, 0, 0, 0.9);
}
/* Judul */
.hero-content-full h1 {
    font-size: 56px;
    line-height: 1.2;
    margin-bottom: 25px;
    text-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
}
.hero-content-full h1 span {
    display: block;
    color: #4da3ff;
}
/* Deskripsi */
.hero-text {
    max-width: 700px;
    margin: 0 auto 35px;
    font-size: 18px;
    line-height: 1.8;
    color: #eeeeee;
    text-shadow: 0 2px 5px rgba(0, 0, 0, 0.9);

}
/* Tombol */
.hero-buttons {
    display: flex;
    justify-content: center;
    gap: 15px;
}
/* Tombol utama */
.hero-btn-primary,
.hero-btn-secondary {
    display: inline-block;
    padding: 14px 30px;
    border-radius: 7px;
    text-decoration: none;
    font-size: 15px;
    font-weight: bold;
    transition: 0.3s;
}
/* Tombol biru */
.hero-btn-primary {
    background-color: #0066cc;
    color: white;
}
.hero-btn-primary:hover {
    background-color: #004c99;
    transform: translateY(-3px);
}
/* Tombol transparan */
.hero-btn-secondary {
    border: 2px solid white;
    color: white;
    background: transparent;
}
.hero-btn-secondary:hover {
    background-color: white;
    color: #0066cc;
    transform: translateY(-3px);
}
/* Pengenalan */
    .pengenalan {
        padding: 100px 8%;
        background-color: white;
    }
    .pengenalan-container {
        max-width: 1200px;
        margin: auto;
        display: flex;
        align-items: center;
        gap: 70px;
    }
    /* Gambar */
    .pengenalan-image {
        width: 50%;
    }
    .pengenalan-image img {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: 15px;
    }
    /* Konten */
    .pengenalan-content {
        width: 50%;
    }
    .section-label {
        color: #0066cc;
        font-size: 14px;
        font-weight: bold;
        letter-spacing: 2px;
        margin-bottom: 12px;
    }
    .pengenalan-content h2,
    .berita h2 {
        font-size: 38px;
        color: #1e293b;
        margin-bottom: 20px;
    }
    .pengenalan-content p {
        color: #666;
        line-height: 1.8;
        margin-bottom: 15px;
    }
    .pengenalan-content .btn-primary {
        margin-top: 15px;
    }
    /* Berita */
    .berita {
        padding: 100px 8%;

        background-color: #f7f9fc;
    }
    .berita-container {
        max-width: 1200px;
        margin: auto;
    }
    /* Heading */
    .section-heading {
        text-align: center;
        max-width: 700px;
        margin: auto;
        margin-bottom: 50px;
    }
    .section-heading h2 {
        margin-bottom: 15px;
    }
    .section-heading>p:last-child {
        color: #666;
        line-height: 1.7;
    }
    /* Grid berita */
    .berita-grid {
        display: grid;
        grid-template-columns:
            repeat(3, 1fr);
        gap: 25px;
    }
    /* Card */
    .berita-card {
        background-color: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow:
            0 5px 20px rgba(0, 0, 0, 0.08);
        transition: 0.3s;
    }
    .berita-card:hover {
        transform: translateY(-7px);
        box-shadow:
            0 10px 25px rgba(0, 0, 0, 0.12);
    }
    /* Gambar */
    .berita-card img {
        width: 100%;
        height: 210px;
        object-fit: cover;
    }
    /* Isi */
    .berita-content {
        padding: 25px;
    }
    .berita-tanggal {
        font-size: 13px;
        color: #0066cc;
        font-weight: bold;
    }
    .berita-content h3 {
        font-size: 21px;
        color: #222;
        margin: 12px 0;
    }
    .berita-content p {
        font-size: 14px;
        color: #666;
        line-height: 1.7;
        margin-bottom: 18px;
    }
    .berita-content a {
        text-decoration: none;
        color: #0066cc;
        font-weight: bold;
        font-size: 14px;
    }
    .berita-content a:hover {
        color: #004c99;
    }

    .data-siswa {
    padding: 60px 8%;
    background: #f7f9fc;
}

.data-siswa h2 {
    text-align: center;
    font-size: 32px;
    margin-bottom: 30px;
    color: #1e293b;
}

.data-siswa table {
    width: 100%;
    border-collapse: collapse;
    background: white;
}

.data-siswa th,
.data-siswa td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: center;
}

.data-siswa th {
    background: #1e3a5f;
    color: white;
}

.data-siswa img {
    display: block;
    margin: auto;
}
/* RESPONSIVE */
    @media (max-width: 900px) {
        .hero {
            flex-direction: column;
            text-align: center;
            padding: 70px 30px;
        }
        .hero-content {
            width: 100%;
        }
        .hero-content h1 {
            font-size: 40px;
        }
        .hero-description {
            margin-left: auto;
            margin-right: auto;
        }
        .hero-button {
            justify-content: center;
        }
        .hero-image {
            width: 80%;
        }
        .pengenalan-container {
            flex-direction: column;
        }
        .pengenalan-image,
        .pengenalan-content {
            width: 100%;
        }
        .berita-grid {
            grid-template-columns: 1fr 1fr;
        }
    }
    @media (max-width: 600px) {
        .hero-content h1 {
            font-size: 32px;
        }
        .hero-button {
            flex-direction: column;
        }
        .hero-image {
            width: 100%;
        }
        .pengenalan-content h2,
        .berita h2 {
            font-size: 30px;
        }
        .berita-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
<body>
<section class="hero-full">
    <div class="hero-overlay"></div>
    <div class="hero-content-full">
        <p class="hero-label">
            DESAIN PEMODELAN DAN INFORMASI BANGUNAN
        </p>
        <h1>
            Selamat Datang di
            <span>DPIB SMKN 1 KAWALI</span>
        </h1>
        <p class="hero-text">
            "Bersama Membangun Negri"
        </p>
        <div class="hero-buttons">
            <a href="#pengenalan" class="hero-btn-primary">Kenali DPIB</a>
            <a href="kontak.php" class="hero-btn-secondary">Hubungi Kami</a>    
        </div>
    </div>
</section>
<!-- PENGENALAN -->
    <section class="pengenalan" id="pengenalan">
        <div class="pengenalan-container">
            <div class="pengenalan-image">
                <img
                    src="img/pengenalan-dpib.jpg"
                    alt="Jurusan DPIB">
            </div>
            <div class="pengenalan-content">
                <p class="section-label">
                    TENTANG KAMI
                </p>
                <h2>
                    Mengenal Jurusan DPIB
                </h2>
                <p>
                    Desain Pemodelan dan Informasi Bangunan atau
                    DPIB merupakan salah satu kompetensi keahlian
                    yang mempelajari perencanaan, perancangan,
                    dan pemodelan bangunan.
                </p>
                <p>
                    Siswa DPIB dibekali dengan keterampilan menggambar
                    teknik, perencanaan bangunan, penggunaan perangkat
                    lunak desain, serta berbagai pengetahuan mengenai
                    konstruksi bangunan.
                </p>
                <a href="visi-misi.php" class="btn-primary">Selengkapnya</a>
            </div>
        </div>
    </section>
<!-- BERITA -->
    <section class="berita" id="berita">
        <div class="berita-container">
            <div class="section-heading">
                <p class="section-label">
                    INFORMASI TERBARU
                </p>
                <h2>
                    Berita & Kegiatan
                </h2>
                <p>
                    Informasi terbaru mengenai kegiatan dan
                    aktivitas siswa DPIB SMKN 1 Kawali.
                </p>
            </div>
            <div class="berita-grid">
                <!-- Berita 1 -->
                <div class="berita-card">
                    <img
                        src="img/berita1.jpg" alt="Kegiatan DPIB">
                    <div class="berita-content">
                        <span class="berita-tanggal">
                            20 September 2026
                        </span>
                        <h3>
                            Kegiatan Praktik Siswa DPIB
                        </h3>
                        <p>
                            Siswa DPIB melaksanakan kegiatan praktik
                            sebagai bagian dari pembelajaran keterampilan
                            dan pemodelan bangunan.
                        </p>
                        <a href="#">
                            Baca Selengkapnya →
                        </a>
                    </div>
                </div>
                <!-- Berita 2 -->
                <div class="berita-card">
                    <img
                        src="img/berita2.jpg"
                        alt="Karya Siswa DPIB">
                    <div class="berita-content">
                        <span class="berita-tanggal">
                            15 September 2026
                        </span>
                        <h3>
                            Pameran Karya Siswa
                        </h3>
                        <p>
                            Berbagai hasil karya siswa DPIB ditampilkan
                            dalam kegiatan pameran sebagai bentuk
                            apresiasi terhadap kreativitas siswa.
                        </p>
                        <a href="#">
                            Baca Selengkapnya →
                        </a>
                    </div>
                </div>
                <!-- Berita 3 -->
                <div class="berita-card">
                    <img
                        src="img/berita3.jpg"
                        alt="Kegiatan Sekolah">
                    <div class="berita-content">
                        <span class="berita-tanggal">
                            10 September 2026
                        </span>
                        <h3>
                            Kegiatan Siswa DPIB
                        </h3>
                        <p>
                            Kegiatan siswa menjadi salah satu bagian
                            penting dalam meningkatkan pengalaman dan
                            keterampilan di bidang bangunan.
                        </p>
                        <a href="#">Baca Selengkapnya →</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
<?php include "footer.php"; ?>
</body>
</html>