
<?php
include 'koneksi.php';

$id = $_GET['id'];

$data = mysqli_query($conn, "SELECT * FROM artikel WHERE id_artikel='$id'");
$row = mysqli_fetch_array($data);

if (!$row) {
    die("Data artikel tidak ditemukan!");
}

if (isset($_POST['simpan'])) {
    $judul = $_POST['judul'];
    $tanggal_upload = $_POST['tanggal_upload'];
    $isi_berita = $_POST['isi_berita'];
    $link_berita = $_POST['link_berita'];

    // Validasi input
    if (
        empty($judul) ||
        empty($tanggal_upload) ||
        empty($isi_berita) ||
        empty($link_berita)
    ) {
        echo "<script>
            alert('Semua data wajib diisi!');
        </script>";
    } else {
        // Cek apakah ada gambar baru
        if ($_FILES['gambar']['name'] != "") {
            $gambar = $_FILES['gambar']['name'];
            $tmp = $_FILES['gambar']['tmp_name'];

            // Validasi format gambar
            $allowed = ['jpg', 'png', 'jpeg'];
            $ext = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed)) {
                echo "<script>
                    alert('Format gambar tidak diperbolehkan!');
                </script>";
                exit;
            }

            // Simpan gambar baru
            if (!move_uploaded_file($tmp, "uploads/" . $gambar)) {
                die("Gambar gagal diunggah!");
            }
        } else {
            // Jika tidak ada gambar baru, gunakan gambar lama
            $gambar = $row['gambar'];
        }

        // Update data artikel
        $query = mysqli_query($conn, "UPDATE artikel SET
            judul='$judul',
            tanggal_upload='$tanggal_upload',
            isi_berita='$isi_berita',
            link_berita='$link_berita',
            gambar='$gambar'
            WHERE id_artikel='$id'");

        if ($query) {
            echo "<script>
                alert('Data artikel berhasil diubah!');
                window.location='Dashboard_artikel.php';
            </script>";
            exit;
        } else {
            echo "<script>
                alert('Data artikel gagal diubah!');
            </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Artikel</title>

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

        textarea {
            width: 100%;
            height: 100px;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            box-sizing: border-box;
            resize: vertical;
            font-family: Arial, sans-serif;
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
        <h2>Edit Data Artikel</h2>

        <form action="" method="POST" enctype="multipart/form-data">

            <label for="judul">Judul:</label>
            <input
                type="text"
                name="judul"
                required
                value="<?= htmlspecialchars($row['judul'], ENT_QUOTES, 'UTF-8'); ?>"
            >

            <label for="tanggal_upload">Tanggal Upload:</label>
            <input
                type="date"
                name="tanggal_upload"
                required
                value="<?= htmlspecialchars($row['tanggal_upload'], ENT_QUOTES, 'UTF-8'); ?>"
            >

            <label for="link_berita">Link Berita:</label>
            <input
                type="text"
                name="link_berita"
                required
                value="<?= htmlspecialchars($row['link_berita'], ENT_QUOTES, 'UTF-8'); ?>"
            >

            <label for="isi_berita">Isi Berita:</label>
            <textarea name="isi_berita" required><?= htmlspecialchars($row['isi_berita'], ENT_QUOTES, 'UTF-8'); ?></textarea>

            <label for="gambar">Gambar Saat Ini:</label>
            <br>
            <img
                src="uploads/<?= rawurlencode(basename($row['gambar'])); ?>"
                alt="Gambar Artikel"
                width="100"
            >

            <br><br>

            <label for="gambar">Ganti Gambar:</label>
            <input type="file" name="gambar" accept=".jpg,.jpeg,.png">

            <button type="submit" name="simpan">Simpan Data</button>
        </form>
    </div>
</body>
</html>
