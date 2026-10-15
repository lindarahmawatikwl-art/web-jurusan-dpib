<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DPIB - SMKN 1 Kawali</title>
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body {
        font-family: Arial, sans-serif;
    }
    /* Navbar */
    .navbar {
        width: 100%;
        background-color: #111827;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        position: sticky;
        top: 0;
        z-index: 1000;
    }
    .navbar-container {
        max-width: 1200px;
        margin: auto;
        padding: 15px 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    /* Logo + Judul */
    .navbar-brand {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .logo {
        width: 50px;
        height: 50px;
        object-fit: contain;
    }

    .judul-web {
        font-size: 20px;
        font-weight: bold;
        color: #f7f7f7;
    }

    /* Menu */
    .navbar-menu {
        display: flex;
        align-items: center;
        gap: 10px;
        list-style: none;
    }

    .navbar-menu li {
        position: relative;
    }

    .navbar-menu li a {
        display: block;
        padding: 10px 15px;
        text-decoration: none;
        color: #fdfdfd;
        font-size: 15px;
        transition: 0.3s;
    }

    .navbar-menu li a:hover {
        color: gold;
    }

    /* Dropdown */
    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        min-width: 190px;
        background-color: white;
        list-style: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);

        display: none;
    }

    .dropdown-menu li a {
        padding: 12px 15px;
        color: #333;
        white-space: nowrap;
    }

    .dropdown-menu li a:hover {
        background-color: #f2f2f2;
        color: #007bff;
    }

    /* Tampilkan dropdown saat mouse diarahkan */
    .dropdown:hover .dropdown-menu {
        display: block;
    }

    /* Tombol Login */
    .login-btn {
        background-color: #007bff;
        color: white !important;
        border-radius: 6px;
        padding: 10px 20px !important;
    }

    .login-btn:hover {
        background-color: #0056b3;
    }

    /* Responsive sederhana */
    @media (max-width: 768px) {

        .navbar-container {
            flex-direction: column;
            gap: 15px;
        }

        .navbar-menu {
            flex-wrap: wrap;
            justify-content: center;
        }

        .dropdown-menu {
            position: static;
            box-shadow: none;
        }
    }
</style>

<body>
    <nav class="navbar">
        <div class="navbar-container">
            <!-- Logo + Judul Website -->
            <div class="navbar-brand">
                <img src="img/logoDPIB.png" alt="Logo" class="logo">
                <span class="judul-web">DPIB SMKN 1 KAWALI</span>
            </div>
            <!-- Menu -->
            <ul class="navbar-menu">
                <li>
                    <a href="index.php">Beranda</a>
                </li>
                <!-- Dropdown Profil -->
                <li class="dropdown">
                    <a href="#" class="dropbtn">
                        Profil <span>▼</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="Visi_misi.php">Visi & Misi</a>
                        </li>
                        <li>
                            <a href="SO.php">Struktur Organisasi</a>
                        </li>
                        <li>
                            <a href="HISA.php">Himpunan Siswa</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="galeri.php">Galeri</a>
                </li>
                <li>
                    <a href="Artikel.php">Artikel</a>
                </li>
                <li>
                    <a href="kontak.php">Kontak</a>
                </li>
                <li>
                    <a href="login.php" >Login</a>
                </li>

            </ul>
        </div>
    </nav>
</body>

</html>