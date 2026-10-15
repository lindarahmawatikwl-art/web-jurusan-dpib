<style>
    /* =================================
   FOOTER
================================= */
    .footer {
        background-color: #111827;
        color: white;
        margin-top: 0;
    }

    .garis_footer {
        width: 100%;
        height: 3px;
        border: 0;
        background: #ffc400;
    }

    /* Container */
    .footer-container {
        max-width: 1200px;
        margin: auto;
        padding: 70px 8% 50px;
        display: grid;
        grid-template-columns: 2fr 1fr 1fr;
        gap: 80px;
        align-items: start;
    }

    /* Judul */
    .footer-column h3 {
        font-size: 20px;
        margin-bottom: 10px;
        color: #ffffff;
    }

    /* Tentang Kami */
    .tentang-kami {
        max-width: 500px;
    }

    .tentang-kami p {
        color: #b8c0cc;
        font-size: 14px;
        line-height: 1.8;
        margin-bottom: 25px;
    }

    .tentang-kami hr {
        border: none;
        height: 3px;
        background-color: gold;
        margin-bottom: 15px;
        width: 32%;
    }

    /* =================================
   SOCIAL MEDIA
================================= */
    .social-media {
        display: flex;
        gap: 12px;
        margin-top: 10px;
    }

    .social-icon {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #1f2937;
        color: white;
        text-decoration: none;
        font-size: 16px;
        transition: 0.3s;
    }

    .social-icon:hover {
        background-color: gold;
        transform: translateY(-4px);
    }

    /* =================================
   NAVIGASI
================================= */
    .navigasi ul {
        list-style: none;
        padding: 0;
    }

    .navigasi ul li {
        margin-bottom: 12px;
    }

    .navigasi ul li a {
        color: #b8c0cc;
        text-decoration: none;
        font-size: 14px;
        transition: 0.3s;
    }

    .navigasi ul li a:hover {
        color: #ffffff;
        padding-left: 5px;
    }

    .navigasi hr {
        border: none;
        height: 3px;
        background-color: #e9bb14;
        margin-bottom: 15px;
        width: 42%;
    }

    /* =================================
   LOGO
================================= */
    .footer-logo {
        text-align: center;
        margin-top: 20px;
    }

    .footer-logo img {
        width: 150px;
        height: 150px;
        object-fit: contain;
        margin-bottom: 15px;
    }

    .footer-logo h3 {
        margin-bottom: 5px;
    }

    .footer-logo p {
        color: #b8c0cc;
        font-size: 14px;
        
    }

    /* =================================
   FOOTER BOTTOM
================================= */
    .footer-bottom {
        border-top: 1px solid #283141;
        padding: 20px 8%;
        text-align: center;
    }

    .footer-bottom p {
        color: #8f99a8;
        font-size: 13px;
    }

    /* =================================
   RESPONSIVE
================================= */

    @media (max-width: 900px) {
        .footer-container {
            grid-template-columns: 1fr 1fr;
            gap: 50px;
        }

        .footer-logo {
            text-align: left;
        }
    }

    @media (max-width: 600px) {
        .footer-container {
            grid-template-columns: 1fr;
            padding: 50px 30px;
        }

        .footer-logo {
            text-align: left;
        }

        .footer-bottom {
            padding: 20px 30px;
        }
    }
</style>
<hr class="garis_footer">
<footer class="footer">
    <div class="footer-container">
        <!-- Tentang Kami -->
        <div class="footer-column tentang-kami">
            <h3>Tentang Kami</h3>
            <hr class="garis_footer">
            <p>
                Website resmi jurusan Desain Pemodelan dan Informasi
                Bangunan (DPIB) SMKN 1 Kawali. Media informasi mengenai
                profil, kegiatan, karya, dan berbagai informasi seputar
                jurusan DPIB.
            </p>
            <!-- Media Sosial -->
            <div class="social-media">
                <a href="#" class="social-icon" title="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="social-icon" title="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="social-icon" title="YouTube">
                    <i class="fab fa-youtube"></i>
                </a>
                <a href="#" class="social-icon" title="TikTok">
                    <i class="fab fa-tiktok"></i>
                </a>
            </div>
        </div>
        <!-- Navigasi -->
        <div class="footer-column navigasi">
            <h3>Navigasi</h3>
            <hr class="garis_footer">
            <ul>
                <li>
                    <a href="index.php">Beranda</a>
                </li>
                <li>
                    <a href="visi-misi.php">Visi & Misi</a>
                </li>
                <li>
                    <a href="struktur-organisasi.php">
                        Struktur Organisasi
                    </a>
                </li>
                <li>
                    <a href="himpunan-siswa.php">
                        Himpunan Siswa
                    </a>
                </li>
                <li>
                    <a href="galeri.php">Galeri</a>
                </li>
                <li>
                    <a href="artikel.php">Artikel</a>
                </li>
                <li>
                    <a href="kontak.php">Kontak</a>
                </li>
            </ul>
        </div>
        <!-- Logo -->
        <div class="footer-column footer-logo">
            <img
                src="img/logosmkn.png"
                alt="Logo DPIB SMKN 1 Kawali">
            <h3>DPIB</h3>
            <p>
                SMKN 1 Kawali
            </p>
        </div>
    </div>
    <!-- Copyright -->
    <div class="footer-bottom">
        <p>
            &copy; <?php echo date('Y'); ?>
            DPIB SMKN 1 Kawali. All Rights Reserved.
        </p>
    </div>
</footer>
<!-- Font Awesome -->
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">