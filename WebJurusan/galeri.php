<?php include "navbar.php"; include "koneksi.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri</title>
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
.container{
    width:90%;
    max-width:1180px;
    margin:60px 50px 50px 60px;
    box-shadow:0 2px 3px rgba(0,0,0,.2);
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
.section-title{
    font-size:24px;
    margin-bottom:20px;
    text-align:center;

}
.section-title hr{
    width:120px;
    height:3px;
    background: gold;
    border:none;
    margin:10px auto 0 auto;
}
.gallery {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    margin-top: 20px;
}
.gallery-item {
    background: #fff;
    margin: 10px 10px 20px 10px;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    text-align: center;
    width: 200px;
}
.gallery-item img {
    max-width: 100%;
    border-radius: 8px;
}
.gallery-item h3 {
    margin: 10px 0 5px 0;
}
.gallery-item .tanggal {
    font-size: 10px;
    color: #777;
}
.gallery-item .deskripsi {
    font-size: 12px;
    color: #555;
    margin-top: 5px;
}
</style>
<body>
    <div class="breadcrumb">
        <a href="index.php">Beranda</a>
        <span>›</span>
        <span>Galeri</span>
    </div>

    <div class="container">
        <div class="section-title">
        <h2>Galeri</h2>
        <hr>
        </div>
        <div class="gallery">
            <?php
            $query = mysqli_query($conn, "SELECT * FROM galeri");
            while ($row = mysqli_fetch_assoc($query)) {
                echo '<div class="gallery-item">';
                echo '<img src="uploads/' . htmlspecialchars($row['foto']) . '" alt="Foto Galeri" width="200">';
                echo '<h3>' . htmlspecialchars($row['nama_foto']) . '</h3>';
                echo '<p class="tanggal">Tanggal Upload: ' . htmlspecialchars($row['tanggal_upload']) . '</p>';
                echo '<p class="deskripsi">' . htmlspecialchars($row['deskripsi_foto']) . '</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <?php include "footer.php"; ?>
</body>
</html>