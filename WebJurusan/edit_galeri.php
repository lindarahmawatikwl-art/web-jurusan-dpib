<?php
include 'koneksi.php';

$id = $_GET['id'];

$data = mysqli_query($conn, "SELECT * FROM galeri WHERE id_galeri='$id'");

$row = mysqli_fetch_array($data);

if(isset($_POST['simpan'])){
    $nama_foto = $_POST['nama_foto'];
    $tanggal_upload = $_POST['tanggal_upload'];
    $deskripsi_foto = $_POST['deskripsi_foto'];

    // validasi input
    if(empty($nama_foto) || empty($tanggal_upload) || empty($deskripsi_foto)) {
        echo "<script>
            alert('Semua data wajib diisi!');
            </script>";
    } else {
        //cek foto
        if($_FILES['foto']['name'] != "") {
            $foto = $_FILES['foto']['name'];
            $tmp = $_FILES['foto']['tmp_name'];

            // validasi format foto
            $allowed = ['jpg', 'png', 'jpeg'];

            $ext = strtolower(pathinfo($foto, PATHINFO_EXTENSION));

            if(!in_array($ext, $allowed)) {
                
                echo "<script>
                    alert('Format foto tidak diperbolehkan!');
                    </script>";
                    
                    exit;
            }
            // simpan foto baru
            move_uploaded_file($tmp, "uploads/" . $foto);

        } else {
            // jika tidak ada foto baru, gunakan foto lama
            $foto = $row['foto'];
        }

        // simpan ke db
        $query = mysqli_query($conn, "UPDATE galeri SET nama_foto='$nama_foto', tanggal_upload='$tanggal_upload', deskripsi_foto='$deskripsi_foto', foto='$foto' WHERE id_galeri='$id'");

        if($query) {
            echo "<script>
                alert('Data berhasil diubah!');
                window.location='Dashboard_galeri.php';
                </script>";
        } else {
            echo "<script>
                alert('Data gagal diubah!');
                </script>";
        }
    }
    // echo "Data berhasil disimpan";
    // header("location:index.php");
    //exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
        }
        .container {
            width: 350px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2{
            text-align: center;
        }
        input{
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }
        button{
            width: 100%;
            padding: 10px;
            background-color: royalblue;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        button:hover{
            background-color: darkblue;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Data Galeri</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="nama_foto">Nama Foto :</label>
            <input type="text" name="nama_foto" required value="<?=  $row['nama_foto']; ?>">

            <label for="tanggal_upload">Tanggal Upload :</label>
            <input type="date" name="tanggal_upload" required value="<?=  $row['tanggal_upload']; ?>">

            <label for="deskripsi_foto">Deskripsi Foto :</label>
            <input type="text" name="deskripsi_foto" required value="<?=  $row['deskripsi_foto']; ?>">

            <label for="foto">Foto  saat ini:</label>
            <img src="uploads/<?= $row['foto']; ?>" alt="Foto Galeri" width="100">

            <br><br>
            <label for="foto">Ganti Foto :</label>
            <input type="file" name="foto">

            <button type="submit" name="simpan">Simpan Data</button>
        </form>
        </div>
</body>
</html>
