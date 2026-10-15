<?php
session_start();
if (!isset($_SESSION['admin'])) { header("Location: login.php"); exit; }
require_once "koneksi.php";

function e($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
$sections = [
  'visi_misi' => 'Visi & Misi',
  'struktur' => 'Struktur Organisasi',
  'himpunan' => 'Himpunan Siswa'
];
$section = $_GET['bagian'] ?? $_POST['bagian'] ?? 'visi_misi';
if (!isset($sections[$section])) $section = 'visi_misi';
$success = ''; $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'save_content';
    if ($action === 'save_content') {
        $visi = trim($_POST['visi'] ?? '');
        $misi = trim($_POST['misi'] ?? '');
        $banner = trim($_POST['banner_lama'] ?? '');
        if (!empty($_FILES['banner']['name'])) {
            $allowed = ['jpg'=>'image/jpeg','jpeg'=>'image/jpeg','png'=>'image/png','webp'=>'image/webp'];
            $ext = strtolower(pathinfo($_FILES['banner']['name'], PATHINFO_EXTENSION));
            if (!isset($allowed[$ext]) || !is_uploaded_file($_FILES['banner']['tmp_name'])) {
                $error = 'Banner harus berupa JPG, PNG, atau WEBP.';
            } else {
                $dir = dirname(__DIR__) . '/img/uploads';
                if (!is_dir($dir)) mkdir($dir, 0755, true);
                $newName = $section . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
                if (move_uploaded_file($_FILES['banner']['tmp_name'], $dir . '/' . $newName)) $banner = 'img/uploads/' . $newName;
                else $error = 'Banner gagal diunggah. Periksa izin folder img/uploads.';
            }
        }
        if (!$error) {
            $stmt = $conn->prepare("INSERT INTO profil_konten (bagian, visi, misi, banner) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE visi=VALUES(visi), misi=VALUES(misi), banner=VALUES(banner)");
            $stmt->bind_param("ssss", $section, $visi, $misi, $banner);
            if ($stmt->execute()) $success = 'Informasi profil berhasil disimpan.';
            else $error = 'Gagal menyimpan data: ' . $conn->error;
        }
    } elseif ($action === 'add_member') {
        $nama = trim($_POST['nama'] ?? '');
        $jabatan = trim($_POST['jabatan'] ?? '');
        $urutan = (int)($_POST['urutan'] ?? 0);
        if ($nama === '' || $jabatan === '') $error = 'Nama dan jabatan wajib diisi.';
        else {
            $stmt = $conn->prepare("INSERT INTO profil_anggota (bagian, nama, jabatan, foto, urutan) VALUES (?, ?, ?, '', ?)");
            $stmt->bind_param("sssi", $section, $nama, $jabatan, $urutan);
            if ($stmt->execute()) $success = 'Anggota berhasil ditambahkan.'; else $error = 'Gagal menambah anggota.';
        }
    } elseif ($action === 'delete_member') {
        $id = (int)($_POST['id'] ?? 0);
        $stmt = $conn->prepare("DELETE FROM profil_anggota WHERE id=? AND bagian=?");
        $stmt->bind_param("is", $id, $section);
        if ($stmt->execute()) $success = 'Anggota berhasil dihapus.'; else $error = 'Gagal menghapus anggota.';

    }
}
$stmt = $conn->prepare("SELECT visi, misi, banner FROM profil_konten WHERE bagian=?");
$stmt->bind_param("s", $section); $stmt->execute();
$content = $stmt->get_result()->fetch_assoc() ?: ['visi'=>'','misi'=>'','banner'=>''];
$stmt = $conn->prepare("SELECT id, nama, jabatan, foto, urutan FROM profil_anggota WHERE bagian=? ORDER BY urutan ASC, id ASC");
$stmt->bind_param("s", $section); $stmt->execute(); $members = $stmt->get_result();
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Kelola Profil</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
*{box-sizing:border-box}body{margin:0;font-family:Arial,sans-serif;background:#f4f6fa;color:#263244}.layout{display:flex;min-height:100vh}.side{width:245px;background:#202b3c;color:#fff;padding:26px 16px;flex-shrink:0}.brand{font-weight:700;color:#ffc400;font-size:20px;padding:0 10px 25px;border-bottom:1px solid #3b4657}.side small{display:block;color:#b8c0cc;font-size:12px;margin-top:5px}.side nav{margin-top:25px;display:grid;gap:8px}.side a{color:#d5dbe4;text-decoration:none;padding:13px;border-radius:8px;font-size:14px}.side a.active,.side a:hover{background:#ffc400;color:#202b3c}.main{padding:30px;min-width:0;flex:1}.top{display:flex;justify-content:space-between;gap:20px;align-items:center;margin-bottom:24px}.top h1{font-size:25px;margin:0 0 8px}.muted{color:#7d8796;font-size:13px}.panel{background:white;border-radius:12px;padding:24px;box-shadow:0 3px 12px #202b3c0a;margin-bottom:20px}.tabs{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:20px}.tab{padding:11px 15px;border-radius:8px;background:#fff;border:1px solid #e1e5ec;color:#3d4654;text-decoration:none;font-size:13px}.tab.active{background:#202b3c;color:#ffc400;border-color:#202b3c}label{display:block;font-weight:700;font-size:13px;margin:16px 0 7px}input,textarea{width:100%;border:1px solid #d9dee7;border-radius:8px;padding:12px;font:inherit;font-size:14px}textarea{min-height:125px;resize:vertical}.btn{border:0;border-radius:8px;padding:11px 15px;background:#ffc400;color:#202b3c;font-weight:700;cursor:pointer;margin-top:15px}.btn.dark{background:#202b3c;color:#fff}.btn.danger{background:#ffe5e5;color:#b4232f;margin:0}.notice{padding:12px 14px;border-radius:8px;margin-bottom:15px;font-size:14px}.ok{background:#e4f8ec;color:#17683b}.err{background:#ffe8e8;color:#9f2424}.grid{display:grid;grid-template-columns:1.2fr .8fr;gap:20px}.table-wrap{overflow-x:auto}table{width:100%;border-collapse:collapse;font-size:13px}th,td{text-align:left;padding:12px;border-bottom:1px solid #edf0f4}th{color:#6c7686;background:#f8f9fb}.inline{display:flex;gap:8px;align-items:center}.inline input{min-width:100px}.inline .btn{white-space:nowrap}.badge{display:inline-block;padding:6px 9px;background:#fff5c9;color:#886600;border-radius:20px;font-size:11px}@media(max-width:800px){.side{width:70px;padding:20px 8px}.brand{font-size:0;text-align:center;padding:0 0 20px}.brand:before{content:'D';font-size:22px}.side small,.side nav span{display:none}.side a{text-align:center}.main{padding:18px}.grid{grid-template-columns:1fr}}@media(max-width:500px){.top{align-items:flex-start}.panel{padding:16px}}
</style></head><body><div class="layout"><aside class="side"><div class="brand">DPIB<small>Admin Panel</small></div><nav>
<a href="admin.php"><i class="fa fa-house"></i> <span>Dashboard</span></a><a class="active" href="profil.php"><i class="fa fa-building"></i> <span>Profil</span></a><a href="kontak_kelola.php"><i class="fa fa-address-book"></i> <span>Kontak</span></a><a href="logout.php"><i class="fa fa-right-from-bracket"></i> <span>Keluar</span></a></nav></aside>
<main class="main"><header class="top"><div><h1>Kelola Profil</h1><div class="muted">Atur visi misi, struktur organisasi, dan himpunan siswa.</div></div><span class="badge"><i class="fa fa-shield-halved"></i> Administrator</span></header>
<?php if($success): ?><div class="notice ok"><?=e($success)?></div><?php endif ?><?php if($error): ?><div class="notice err"><?=e($error)?></div><?php endif ?>
<div class="tabs"><?php foreach($sections as $key=>$label): ?><a class="tab <?=$section===$key?'active':''?>" href="?bagian=<?=e($key)?>"><?=e($label)?></a><?php endforeach ?></div>
<?php if($section==='visi_misi'): ?>
<section class="panel"><h2>Visi & Misi</h2><p class="muted">Perbarui teks yang ditampilkan pada halaman visi dan misi.</p>
<form method="post" enctype="multipart/form-data"><input type="hidden" name="bagian" value="<?=e($section)?>"><input type="hidden" name="action" value="save_content"><input type="hidden" name="banner_lama" value="<?=e($content['banner'])?>">
<label>Visi</label><textarea name="visi" required><?=e($content['visi'] ?: 'Mewujudkan ekosistem pembelajaran berbasis industri untuk menghasilkan lulusan yang kompeten, profesional, berportofolio, dan siap diserap dunia kerja.')?></textarea>
<label>Misi (satu poin per baris)</label><textarea name="misi" required><?=e($content['misi'] ?: "Meningkatkan kompetensi & profesionalisme\nMenghasilkan portofolio berstandar industri\nMenciptakan lulusan siap kerja & berwirausaha\nMemperkuat kemitraan strategis dengan DUDI")?></textarea>
<label>Gambar banner (opsional)</label><input type="file" name="banner" accept=".jpg,.jpeg,.png,.webp"><button class="btn" type="submit"><i class="fa fa-floppy-disk"></i> Simpan Visi & Misi</button></form></section>
<?php else: ?>
<div class="grid"><section class="panel"><h2><?=e($sections[$section])?></h2><p class="muted">Gambar banner dan daftar anggota untuk halaman publik.</p>
<form method="post" enctype="multipart/form-data"><input type="hidden" name="bagian" value="<?=e($section)?>"><input type="hidden" name="action" value="save_content"><input type="hidden" name="visi" value=""><input type="hidden" name="misi" value=""><input type="hidden" name="banner_lama" value="<?=e($content['banner'])?>">
<label>Gambar banner (opsional)</label><input type="file" name="banner" accept=".jpg,.jpeg,.png,.webp"><?php if($content['banner']): ?><p class="muted">Banner saat ini: <?=e($content['banner'])?></p><?php endif ?><button class="btn" type="submit"><i class="fa fa-floppy-disk"></i> Simpan Banner</button></form>
<hr style="border:0;border-top:1px solid #edf0f4;margin:24px 0"><h3>Tambah Anggota</h3><form method="post"><input type="hidden" name="bagian" value="<?=e($section)?>"><input type="hidden" name="action" value="add_member"><label>Nama</label><input name="nama" required maxlength="120"><label>Jabatan</label><input name="jabatan" required maxlength="120"><label>Urutan tampilan</label><input type="number" name="urutan" value="0"><button class="btn" type="submit"><i class="fa fa-plus"></i> Tambah Anggota</button></form></section>
<section class="panel"><h2>Daftar Anggota</h2><div class="table-wrap"><table><thead><tr><th>Nama & Jabatan</th><th>Aksi</th></tr></thead><tbody><?php if($members->num_rows===0): ?><tr><td colspan="2" class="muted">Belum ada anggota.</td></tr><?php endif ?><?php while($m=$members->fetch_assoc()): ?><tr><td><strong><?=e($m['nama'])?></strong><br><span class="muted"><?=e($m['jabatan'])?></span><br><small class="muted">Urutan: <?=e($m['urutan'])?></small></td><td><form method="post" onsubmit="return confirm('Hapus anggota ini?')"><input type="hidden" name="bagian" value="<?=e($section)?>"><input type="hidden" name="action" value="delete_member"><input type="hidden" name="id" value="<?=e($m['id'])?>"><button class="btn danger" type="submit" aria-label="Hapus"><i class="fa fa-trash"></i></button></form></td></tr><?php endwhile ?></tbody></table></div></section></div>
<?php endif ?>
<p class="muted">Catatan: data disimpan ke database. Agar otomatis tampil di website, halaman publik perlu membaca tabel profil_konten dan profil_anggota.</p>
</main></div></body></html>
