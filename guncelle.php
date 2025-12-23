<?php
session_start();
include 'baglan.php';

// Güvenlik: Admin değilse at
if (!isset($_SESSION['yetki']) || $_SESSION['yetki'] != 'admin') { header("Location: giris.php"); exit; }

$vt = new Veritabani();
$db = $vt->baglan();

// 1. VERİYİ ÇEKME
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $veri = $db->query("SELECT * FROM icerikler WHERE id=$id")->fetch_assoc();
}

// 2. GÜNCELLEME İŞLEMİ
if (isset($_POST['guncelle'])) {
    $id = $_POST['id'];
    $baslik = $_POST['baslik'];
    $aciklama = $_POST['aciklama'];

    // SQL Update Komutu
    $db->query("UPDATE icerikler SET baslik='$baslik', aciklama='$aciklama' WHERE id=$id");
    header("Location: admin.php"); // İşlem bitince admin paneline dön
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>İçerik Güncelle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">

<div class="container bg-white p-4 rounded shadow" style="max-width: 600px;">
    <h2 class="text-primary">İçerik Düzenle</h2>
    <hr>
    
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $veri['id']; ?>">

        <div class="mb-3">
            <label class="form-label">Başlık:</label>
            <input type="text" name="baslik" class="form-control" value="<?php echo $veri['baslik']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Açıklama:</label>
            <textarea name="aciklama" class="form-control" rows="5" required><?php echo $veri['aciklama']; ?></textarea>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" name="guncelle" class="btn btn-warning">Güncelle</button>
            <a href="admin.php" class="btn btn-secondary">İptal</a>
        </div>
    </form>
</div>

</body>
</html>