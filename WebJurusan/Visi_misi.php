<?php include "navbar.php"; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visi dan Misi - DPIB SMKN 1 Kawali</title>
    <link rel="stylesheet" href="visi-misi.css">
</head>
<style>
    *{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial,sans-serif;
    color:#111;
    border-top:6px solid #4a4a4a;
}

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

.banner{
    width:75%;
    max-width:800px;
    height:275px;
    margin:25px auto 32px;
    border-radius:13px;
    overflow:hidden;
    background:#e9e4ed;
}

.banner img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.garis{
    width:88%;
    height:3px;
    margin:auto;
    border:0;
    background:#ffc400;
}

.visi,.misi{
    width:88%;
    max-width:1050px;
    margin:25px auto 35px;
}

.visi h1,.misi h1{
    margin-bottom:15px;
}

.visi p{
    text-align:center;
    font-size:14px;
    line-height:1.5;
}

.misi ol{
    padding-left:20px;
    font-size:14px;
    line-height:1.5;
}
</style>
<body>
    <div class="breadcrumb">
        <a href="index.php">Beranda</a>
        <span>›</span>
        <span>Visi dan Misi</span>
    </div>

    <section class="banner">
        <img src="img/visi-misi.jpg" alt="Visi dan Misi DPIB">
    </section>

    <hr class="garis">

    <section class="visi">
        <h1>VISI</h1>
        <p>"Mewujudkan ekosistem pembelajaran berbasis industri untuk menghasilkan lulusan yang kompeten, profesional, berportofolio, dan siap diserap dunia kerja."</p>
    </section>

    <hr class="garis">

    <section class="misi">
        <h1>MISI</h1>
        <ol>
            <li>Meningkatkan kompetensi & profesionalisme</li>
            <li>Menghasilkan portofolio berstandar industri</li>
            <li>Menciptakan lulusan siap kerja & berwirausaha</li>
            <li>Memperkuat kemitraan strategis dengan DUDI</li>
        </ol>
    </section>

    <?php include "footer.php"; ?>
</body>
</html>