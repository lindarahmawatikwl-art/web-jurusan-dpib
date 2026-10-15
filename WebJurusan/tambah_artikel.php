<?php
include "koneksi.php";

if (isset($_POST['simpan'])) {
    $judul = $_POST['judul'];
    $isi_berita = $_POST['isi_berita'];
    $tanggal_upload = date('Y-m-d', strtotime($_POST['tanggal_upload']));
    $link_berita = $_POST['link_berita'];

    //ambil foto     
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    if (empty($judul) || empty($isi_berita) || empty($tanggal_upload) || empty($gambar) || empty($link_berita)) {
        echo "<script>
        alert('Semua data wajib diisi!');            
        </script>";
    } else {

        $allowed = ['jpg', 'png', 'jpeg'];
        $ext = strtolower(
            pathinfo($gambar, PATHINFO_EXTENSION)
        );

        if (!in_array($ext, $allowed)) {
            die("Format tidak diperbolehkan!");
        } else {
            move_uploaded_file(
                $tmp,
                "uploads/" . $gambar
                );

            $query = mysqli_query($conn, "INSERT INTO artikel (judul, isi_berita, tanggal_upload, gambar, link_berita) VALUES('$judul', '$isi_berita', '$tanggal_upload', '$gambar', '$link_berita')");

            if ($query) {
                echo "<script>
                    alert('Data berhasil disimpan!');                     
                    window.location='Dashboard_artikel.php';                     
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
        input[type="file"] {
            padding: 3px;
        }
        input[type="date"] {
            padding: 6px;
        }
        textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            box-sizing: border-box;
            resize: vertical;
            height: 100px;
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
        <h2>Tambah Data Artikel</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="judul">Judul :</label>
            <input type="text" name="judul" required>

            <label for="tanggal_upload">Tanggal Upload :</label>
            <input type="date" name="tanggal_upload" required>

            <label for="link_berita">Link Berita :</label>
            <input type="text" name="link_berita" required>
            
            <label for="isi_berita">Isi Berita :</label>
            <textarea name="isi_berita" required></textarea>

            <label for="gambar">Gambar :</label>
            <input type="file" name="gambar" required>

            <button type="submit" name="simpan">Simpan Data</button>
        </form>

    </div>
</body>

</html>