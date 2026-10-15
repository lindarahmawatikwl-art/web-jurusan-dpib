
<?php include "navbar.php"; include "koneksi.php"; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak - DPIB SMKN 1 Kawali</title>
    <link rel="stylesheet" href="kontak.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background: #f5f5f5;
    color: #292929;
    border-top: 3px solid #444;
}
/* Breadcrumb */
.breadcrumb{
    width:90%;
    max-width:1180px;
    margin:28px auto 25px;
    padding:10px 15px;
    display:flex;
    gap:12px;
    background:#eee;
    border-radius:7px;
    box-shadow:0 2px 3px rgba(0,0,0,.2);
    font-size:13px;
}

.breadcrumb a{
    color:#111;
    text-decoration:none;
}

/* Container Kontak */
.kontak-container {
    width: 40%;
    max-width: 1120px;
    min-height: 280px;
    margin: 0 auto 28px;
    padding: 13px 22px 38px;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 11px;
    box-shadow: 0 2px 3px #0002;
}

.kontak-container h2 {
    font-size: 13px;
    font-weight: bold;
    text-align: center;
    margin-top: 0;
}

.judul-garis {
    width: 100px;
    height: 2px;
    background: #ffc400;
    margin: 4px auto 10px;
}

.kontak-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 35px;
    max-width: 400px;
    margin: 0 auto;
}

.lokasi,
.informasi-kontak {
    min-width: 0;
}

.kontak-content h3 {
    text-align: center;
    font-size: 13px;
    font-weight: normal;
    margin-bottom: 3px;
}

.garis-kuning {
    width: 60px;
    height: 2px;
    background: #ffc400;
    margin: 0 auto 12px;
}

/* Lokasi */
.peta {
    width: 100%;
    height: 340px;
    background: #f3f3f3;
    overflow: hidden;
    border-radius: 12px;
    border: 1px solid #e3e3e3;
    box-shadow: 0 3px 10px #00000012;
}

.peta iframe {
    display: block;
    width: 100%;
    height: 100%;
    border: 0;
}

.peta a {
    color: inherit;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 0.3s;
}

.peta a:hover {
    color: #1683e8;
    transform: scale(1.08);
}

/* Informasi Kontak */
.kontak-item {
    display: flex;
    align-items: flex-start;
    gap: 9px;
    margin-bottom: 12px;
    font-size: 10px;
    line-height: 1.4;
}

.kontak-item i {
    width: 13px;
    margin-top: 2px;
    text-align: center;
    font-size: 13px;
    flex-shrink: 0;
}

.kontak-item p,
.kontak-item a {
    color: #333;
    text-decoration: none;
}

.kontak-item a:hover {
    color: #1683e8;
}

/* Media Sosial Kontak */
.sosial-media {
    display: flex;
    justify-content: center;
    gap: 14px;
    margin-top: 30px;
}

.sosial-media a {
    width: 50px;
    height: 50px;
    background: #f1f1f1;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    color: #222;
    font-size: 25px;
    transition: 0.3s;
}

.sosial-media a:hover,
.footer-sosial a:hover {
    background: #ffc400;
    transform: translateY(-3px);
}

/* Tampilan Desktop */
@media (min-width: 768px) {
    .kontak-container {
        width: 90%;
        max-width: 1180px;
        padding: 30px 36px 36px;
    }

    .kontak-content {
        max-width: 1020px;
        grid-template-columns: minmax(0, 1.15fr) minmax(280px, 0.85fr);
        gap: 42px;
    }

    .lokasi {
        min-width: 0;
    }

    .peta {
        width: 100%;
        height: 340px;
    }

    .kontak-container h2 {
        font-size: 22px;
    }

    .kontak-content h3 {
        font-size: 18px;
    }

    .kontak-item {
        font-size: 14px;
        margin-bottom: 18px;
        gap: 12px;
    }

    .kontak-item i {
        font-size: 16px;
        width: 18px;
    }

    .sosial-media {
        margin-top: 30px;
    }

    .footer-content {
        padding: 18px 0 14px;
    }

    .footer h3 {
        font-size: 13px;
    }

    .tentang p,
    .navigasi a {
        font-size: 9px;
    }

    .footer-logo img {
        width: 125px;
        height: 125px;
    }
}

/* Tampilan Mobile */
@media (max-width: 600px) {
    .navbar {
        height: auto;
        min-height: 50px;
        padding: 8px 12px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .nav-menu {
        width: 100%;
        height: auto;
        justify-content: space-between;
        gap: 8px;
        flex-wrap: wrap;
    }

    .nav-menu a {
        font-size: 10px;
    }

    .breadcrumb {
        margin: 15px auto;
    }

    .kontak-container {
        width: 92%;
        min-height: 0;
        padding: 22px 18px 26px;
    }

    .kontak-container h2 {
        font-size: 20px;
    }

    .kontak-content {
        grid-template-columns: 1fr;
        gap: 30px;
        max-width: 560px;
    }

    .kontak-content h3 {
        font-size: 17px;
    }

    .peta {
        height: 300px;
    }

    .kontak-item {
        font-size: 13px;
    }

    .sosial-media {
        margin-top: 20px;
    }

    .footer-content {
        grid-template-columns: 1fr 1fr;
        gap: 25px;
    }

    .footer-logo {
        grid-column: 1 / -1;
    }
}
</style>
<body>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <a href="index.php"><i class="fa-solid fa-house"></i> Beranda</a>
    <i class="fa-solid fa-chevron-right"></i>
    <span>Kontak</span>
</div>

<!-- Konten Kontak -->
<main class="kontak-container">
    <h2>Hubungi Kami</h2>
    <div class="judul-garis"></div>

    <div class="kontak-content">
        <section class="lokasi">
            <h3>Lokasi</h3>
            <div class="garis-kuning"></div>
            <div class="peta">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d32221.382045701434!2d108.3639785397333!3d-7.185971046405599!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f43087e24f9d3%3A0x34cfd3589f2615d0!2sSMK%20Negeri%201%20Kawali!5e0!3m2!1sid!2sid!4v1791771982779!5m2!1sid!2sid" width="800" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
            </div>
        </section>

        <section class="informasi-kontak">
            <h3>Kontak</h3>
            <div class="garis-kuning"></div>

            <div class="kontak-item">
                <i class="fa-solid fa-location-dot"></i>
                <p>Jl. Talagasari, No. 35, Kawalimukti,
                   Kawali, Kabupaten Ciamis,
                   Jawa Barat 46253</p>
            </div>

            <div class="kontak-item">
                <i class="fa-solid fa-phone"></i>
                <a href="tel:08295174679">082 9517 4679</a>
            </div>

            <div class="kontak-item">
                <i class="fa-regular fa-envelope"></i>
                <a href="mailto:info@smkn1kawali.sch.id">
                    info@smkn1kawali.sch.id
                </a>
            </div>

            <div class="sosial-media">
                <a href="https://www.instagram.com/" target="_blank" aria-label="Instagram">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="https://www.tiktok.com/" target="_blank" aria-label="TikTok">
                    <i class="fa-brands fa-tiktok"></i>
                </a>
                <a href="https://www.whatsapp.com/" target="_blank" aria-label="WhatsApp">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>
            </div>
        </section>
    </div>
</main>

<?php include "footer.php"; ?>

</body>
</html>