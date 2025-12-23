<?php
session_start();
include 'baglan.php';

// GÜVENLİK: Sadece admin girebilir
if (!isset($_SESSION['yetki']) || $_SESSION['yetki'] != 'admin') {
    header("Location: giris.php");
    exit;
}

$vt = new Veritabani();
$db = $vt->baglan();

// SİLME İŞLEMİ
if (isset($_GET['sil'])) {
    $id = $_GET['sil'];
    $db->query("DELETE FROM risk_zinciri WHERE id=$id");
    header("Location: risk_ekle.php");
}

// EKLEME İŞLEMİ
if (isset($_POST['ekle'])) {
    $sebep = $_POST['sebep'];       // Örn: Sigara İçmek
    $sonuc1 = $_POST['sonuc1'];     // Örn: Akciğer kapasitesi düşer
    $sonuc2 = $_POST['sonuc2'];     // Örn: KOAH ve Kanser Riski
    $olasilik = $_POST['olasilik']; // Örn: 85

    $db->query("INSERT INTO risk_zinciri (sebep, sonuc1, sonuc2, olasilik) VALUES ('$sebep', '$sonuc1', '$sonuc2', '$olasilik')");
    header("Location: risk_ekle.php");
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Risk Zinciri Yönetimi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark p-3 mb-4">
        <div class="container">
            <a class="navbar-brand" href="admin.php">
                <i class="fa-solid fa-arrow-left"></i> Yönetim Paneline Dön
            </a>
            <span class="navbar-text text-white">Risk Zinciri Editörü</span>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="fa-solid fa-plus"></i> Yeni Risk Ekle</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-2">
                                <label>Sebep (Kötü Alışkanlık):</label>
                                <input type="text" name="sebep" class="form-control" placeholder="Örn: Hareketsizlik" required>
                            </div>
                            <div class="mb-2">
                                <label>Zincirleme Etki (Ara Sonuç):</label>
                                <input type="text" name="sonuc1" class="form-control" placeholder="Örn: Kaslar zayıflar..." required>
                            </div>
                            <div class="mb-2">
                                <label>Final Sonuç (Hastalık):</label>
                                <input type="text" name="sonuc2" class="form-control" placeholder="Örn: Obezite ve Kalp Krizi" required>
                            </div>
                            <div class="mb-3">
                                <label>Risk Oranı (%):</label>
                                <input type="number" name="olasilik" class="form-control" placeholder="Örn: 70" required>
                            </div>
                            <button type="submit" name="ekle" class="btn btn-dark w-100">Veritabanına Kaydet</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">📋 Mevcut Risk Zincirleri</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Sebep</th>
                                    <th>Ara Etki</th>
                                    <th>Sonuç</th>
                                    <th>İşlem</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sorgu = $db->query("SELECT * FROM risk_zinciri ORDER BY id DESC");
                                if($sorgu->num_rows > 0) {
                                    while($row = $sorgu->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td><b>".$row['sebep']."</b></td>";
                                        echo "<td>".$row['sonuc1']."</td>";
                                        echo "<td><span class='badge bg-danger'>".$row['sonuc2']."</span></td>";
                                        echo "<td>
                                                <a href='risk_ekle.php?sil=".$row['id']."' class='btn btn-danger btn-sm' onclick=\"return confirm('Silinsin mi?')\"><i class='fa-solid fa-trash'></i></a>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-center'>Hiç veri yok. Soldan ekleyin.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>