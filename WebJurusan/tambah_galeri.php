<?php
include "koneksi.php";

if (isset($_POST['simpan'])) {
    $nama_foto = $_POST['nama'];
    $tanggal_upload = $_POST['tanggal'];
    $deskripsi_foto = $_POST['deskripsi'];

    //ambil foto     
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];

    if (empty($nama_foto) || empty($tanggal_upload) || empty($deskripsi_foto) || empty($foto)) {
        echo "<script>
        alert('Semua data wajib diisi!');            
        </script>";
    } else {

        $allowed = ['jpg', 'png', 'jpeg'];
        $ext = strtolower(
            pathinfo($foto, PATHINFO_EXTENSION)
        );

        if (!in_array($ext, $allowed)) {
            die("Format tidak diperbolehkan!");
        } else {
            move_uploaded_file(
                $tmp,
                "uploads/" . $foto
                );

            $query = mysqli_query($conn, "INSERT INTO galeri (nama_foto, tanggal_upload, deskripsi_foto, foto) VALUES('$nama_foto', '$tanggal_upload', '$deskripsi_foto', '$foto')");

            if ($query) {
                echo "<script>
                    alert('Data berhasil disimpan!');                     
                    window.location='Dashboard_galeri.php';                     
                    </script>";
            } else {
                echo "<script>                     
                alert('Data gagal ditambahkan!');                     
                </script>";
            }
        }
    }      // echo "Data berhasil disimpan";     
    // header("Location: index.php");    
     // exit; 
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

        h2 {
            text-align: center;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: royalblue;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        button:hover {
            background-color: darkblue;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Tambah Data Galeri</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="nama">Nama Foto :</label>
            <input type="text" name="nama" required>

            <label for="tanggal">Tanggal Upload :</label>
            <input type="date" name="tanggal" required>

            <label for="deskripsi">Deskripsi :</label>
            <input type="text" name="deskripsi" required>

            <label for="foto">Foto :</label>
            <input type="file" name="foto" required>

            <button type="submit" name="simpan">Simpan Data</button>
        </form>

    </div>
</body>

</html>