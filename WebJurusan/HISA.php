<?php include "navbar.php"; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struktur Organisasi HISA - DPIB SMKN 1 Kawali</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            color: #111;
            background: #fff;
            border-top: 6px solid #4a4a4a;
        }

        .breadcrumb {
            width: 90%;
            max-width: 1180px;
            margin: 20px auto;
            padding: 10px 15px;
            display: flex;
            gap: 10px;
            align-items: center;
            background: #eee;
            border-radius: 7px;
            box-shadow: 0 2px 3px rgba(0,0,0,.2);
            font-size: 12px;
        }

        .breadcrumb a {
            color: #111;
            text-decoration: none;
        }

        .struktur-banner {
            width: 80%;
            max-width: 800px;
            height: 500px;
            margin: 50px auto;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,.2);
        }

        .struktur-banner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .garis-pemisah {
            width: 90%;
            height: 3px;
            margin: 20px auto 30px;
            border: 0;
            background: #ffc400;
        }

        .struktur {
            width: 86%;
            max-width: 1120px;
            margin: 0 auto 30px;
            padding: 20px 12px 30px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,.2);
        }

        .struktur h1 {
            text-align: center;
            color: #ffc400;
            font-size: 30px;
            margin-bottom: 20px;
        }

        .slider-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
            overflow: visible;
        }

        .anggota {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            overflow-y: hidden;
            scroll-behavior: smooth;
            padding: 30px 35px 25px;
            width: 100%;
            scroll-snap-type: x proximity;
        }

        .anggota::-webkit-scrollbar {
            height: 7px;
        }

        .anggota::-webkit-scrollbar-track {
            background: #eee;
            border-radius: 10px;
        }

        .anggota::-webkit-scrollbar-thumb {
            background: #ffc400;
            border-radius: 10px;
        }

        .card {
            flex: 0 0 250px;
            overflow: hidden;
            text-align: center;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,.2);
            padding-bottom: 15px;
            scroll-snap-align: center;
            --scale: 1;
            transform: scale(var(--scale));
            transition: transform .2s ease, box-shadow .2s ease;
            will-change: transform;
        }

        .card:hover {
            transform: translateY(-8px) scale(var(--scale));
            box-shadow: 0 8px 18px rgba(0,0,0,.2);
        }

        .card img {
            width: 100%;
            height: 150px;
            display: block;
            object-fit: cover;
            background: #e9e4ed;
            transition: .3s ease;
        }

        .card:hover img {
            transform: scale(1.03);
        }

        .card h3 {
            margin: 12px 5px 8px;
            font-size: 13px;
            font-weight: 400;
            transition: .3s ease;
        }

        .card p {
            font-size: 11px;
            transition: .3s ease;
        }

        .card:hover h3 {
            color: #ffc400;
        }

        .card:hover p {
            color: #555;
        }

        .slider-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            width: 38px;
            height: 38px;
            border: 0;
            border-radius: 50%;
            background: #ffc400;
            color: #111;
            font-size: 27px;
            line-height: 38px;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(0,0,0,.25);
            transition: .3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slider-btn:hover {
            background: #111;
            color: #ffc400;
            transform: translateY(-50%) scale(1.1);
        }

        .prev {
            left: 2px;
        }

        .next {
            right: 2px;
        }

        @media (max-width: 768px) {
            .struktur-banner {
                width: 90%;
                height: 350px;
            }

            .struktur {
                width: 90%;
            }

            .anggota {
                gap: 8px;
                padding: 25px 30px 20px;
            }

            .card {
                flex: 0 0 220px;
            }

            .slider-btn {
                width: 34px;
                height: 34px;
                font-size: 24px;
                line-height: 34px;
            }
        }
    </style>
</head>
<body>

    <div class="breadcrumb">
        <a href="index.php">Beranda</a>
        <span>›</span>
        <span>Profil - Struktur Organisasi HISA</span>
    </div>

    <section class="struktur-banner">
        <img src="img/HISA.jpeg" alt="Struktur Organisasi HISA DPIB">
    </section>

    <hr class="garis-pemisah">

    <section class="struktur">
        <h1>STRUKTUR ORGANISASI HISA</h1>

        <div class="slider-wrapper">
            <button class="slider-btn prev" type="button" onclick="geserKiri()">‹</button>

            <div class="anggota" id="anggota">
                <div class="card">
                    <img src="img/default.jpg" alt="Nama 1">
                    <h3>Nama 1</h3>
                    <p>Jabatan</p>
                </div>

                <div class="card">
                    <img src="img/default.jpg" alt="Nama 2">
                    <h3>Nama 2</h3>
                    <p>Jabatan</p>
                </div>

                <div class="card">
                    <img src="img/default.jpg" alt="Nama 3">
                    <h3>Nama 3</h3>
                    <p>Jabatan</p>
                </div>

                <div class="card">
                    <img src="img/default.jpg" alt="Nama 4">
                    <h3>Nama 4</h3>
                    <p>Jabatan</p>
                </div>

                <div class="card">
                    <img src="img/default.jpg" alt="Nama 5">
                    <h3>Nama 5</h3>
                    <p>Jabatan</p>
                </div>

                <div class="card">
                    <img src="img/default.jpg" alt="Nama 6">
                    <h3>Nama 6</h3>
                    <p>Jabatan</p>
                </div>
            </div>

            <button class="slider-btn next" type="button" onclick="geserKanan()">›</button>
        </div>
    </section>

    <?php include "footer.php"; ?>

    <script>
        const anggota = document.getElementById("anggota");
        const kartu = document.querySelectorAll(".card");
        const jarak = 260;

        function animasiKartu() {
            const area = anggota.getBoundingClientRect();
            const tengah = area.left + area.width / 2;

            kartu.forEach(card => {
                const box = card.getBoundingClientRect();
                const tengahKartu = box.left + box.width / 2;
                const distance = Math.abs(tengah - tengahKartu);
                const maxDistance = area.width / 2;

                let scale = 1 - (distance / maxDistance) * 0.18;
                scale = Math.max(0.82, Math.min(1, scale));

                card.style.setProperty("--scale", scale);
            });
        }

        function geserKanan() {
            if (anggota.scrollLeft + anggota.clientWidth >= anggota.scrollWidth - 5) {
                anggota.scrollTo({
                    left: 0,
                    behavior: "smooth"
                });
            } else {
                anggota.scrollBy({
                    left: jarak,
                    behavior: "smooth"
                });
            }
        }

        function geserKiri() {
            if (anggota.scrollLeft <= 5) {
                anggota.scrollTo({
                    left: anggota.scrollWidth - anggota.clientWidth,
                    behavior: "smooth"
                });
            } else {
                anggota.scrollBy({
                    left: -jarak,
                    behavior: "smooth"
                });
            }
        }

        anggota.addEventListener("scroll", animasiKartu);
        window.addEventListener("resize", animasiKartu);
        window.addEventListener("load", animasiKartu);
    </script>

</body>
</html>