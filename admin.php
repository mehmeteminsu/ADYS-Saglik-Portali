<?php
session_start();
include 'baglan.php';

// GÜVENLİK KONTROLÜ: Giriş yapılmamışsa veya yetki admin değilse giriş sayfasına at
if (!isset($_SESSION['yetki']) || $_SESSION['yetki'] != 'admin') {
    header("Location: giris.php");
    exit;
}

$vt = new Veritabani();
$db = $vt->baglan();

// SİLME İŞLEMİ (Egzersizler İçin)
if (isset($_GET['sil'])) {
    $id = $_GET['sil'];
    $db->query("DELETE FROM icerikler WHERE id=$id");
    header("Location: admin.php");
}

// EKLEME İŞLEMİ (Yeni Egzersiz Ekleme)
if (isset($_POST['ekle'])) {
    $baslik = $_POST['baslik'];
    $aciklama = $_POST['aciklama'];
    
    // Resim Yükleme İşlemi
    $target_dir = "resimler/";
    $target_file = $target_dir . basename($_FILES["resim"]["name"]);
    move_uploaded_file($_FILES["resim"]["tmp_name"], $target_file);
    $resim_adi = basename($_FILES["resim"]["name"]);

    $db->query("INSERT INTO icerikler (baslik, aciklama, resim_yolu) VALUES ('$baslik', '$aciklama', '$resim_adi')");
    header("Location: admin.php");
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yönetici Paneli - ADYS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark p-3 mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php" target="_blank">
                <i class="fa-solid fa-house"></i> Siteyi Görüntüle
            </a>
            <span class="navbar-text text-white">
                Yönetici: <?php echo $_SESSION['uye_ad']; ?>
            </span>
            <a href="cikis.php" class="btn btn-danger btn-sm">Çıkış Yap</a>
        </div>
    </nav>

    <div class="container">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>🛠️ Yönetim Paneli</h1>
            <a href="risk_ekle.php" class="btn btn-warning btn-lg">
                <i class="fa-solid fa-triangle-exclamation"></i> Risk Zinciri Yönetimi
            </a>
        </div>

        <div class="row">
            
            <div class="col-md-8">
                
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Yeni Egzersiz / İçerik Ekle</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-2">
                                <label>Başlık:</label>
                                <input type="text" name="baslik" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Açıklama:</label>
                                <textarea name="aciklama" class="form-control" rows="2" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label>Resim Seç:</label>
                                <input type="file" name="resim" class="form-control" required>
                            </div>
                            <button type="submit" name="ekle" class="btn btn-success w-100">İçeriği Kaydet</button>
                        </form>
                    </div>
                </div>

                <div class="card shadow">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">Mevcut İçerikler</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Resim</th>
                                    <th>Başlık</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sorgu = $db->query("SELECT * FROM icerikler ORDER BY id DESC");
                                while($row = $sorgu->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>".$row['id']."</td>";
                                    echo "<td><img src='resimler/".$row['resim_yolu']."' width='50'></td>";
                                    echo "<td>".$row['baslik']."</td>";
                                    echo "<td>
                                            <a href='guncelle.php?id=".$row['id']."' class='btn btn-primary btn-sm'><i class='fa-solid fa-pen'></i> Düzenle</a>
                                            <a href='admin.php?sil=".$row['id']."' class='btn btn-danger btn-sm' onclick=\"return confirm('Silmek istediğine emin misin?')\"><i class='fa-solid fa-trash'></i> Sil</a>
                                          </td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="col-md-4">
                <div class="card shadow" style="border-left: 5px solid orange;">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="fa-solid fa-envelope"></i> Gelen Mesajlar</h5>
                    </div>
                    <div class="card-body" style="max-height: 600px; overflow-y: auto;">
                        <?php
                        // Mesajlar tablosunu kontrol et, yoksa hata vermesin
                        $msg_kontrol = $db->query("SHOW TABLES LIKE 'mesajlar'");
                        if($msg_kontrol->num_rows > 0) {
                            $mesajlar = $db->query("SELECT * FROM mesajlar ORDER BY id DESC");
                            if($mesajlar->num_rows > 0) {
                                while($msg = $mesajlar->fetch_assoc()) {
                                    $renk = ($msg['konu'] == 'Şikayet') ? 'text-danger' : 'text-success';
                                    echo "<div class='alert alert-light border mb-2'>";
                                    echo "<strong class='$renk'>".$msg['konu']."</strong> - <small>".$msg['ad_soyad']."</small>";
                                    echo "<hr class='my-1'>";
                                    echo "<p class='mb-0 small'>".$msg['mesaj']."</p>";
                                    echo "</div>";
                                }
                            } else {
                                echo "<p class='text-muted'>Henüz mesaj yok.</p>";
                            }
                        } else {
                            echo "<p class='text-danger'>Mesaj tablosu bulunamadı.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>