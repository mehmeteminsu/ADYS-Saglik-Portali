<?php 
session_start(); 
include 'baglan.php'; 
$mesaj_sonuc = "";

if(isset($_POST['gonder'])) {
    $vt = new Veritabani(); $db = $vt->baglan();
    $ad = $_POST['ad']; $konu = $_POST['konu']; $mesaj = $_POST['mesaj'];
    
    if($db->query("INSERT INTO mesajlar (ad_soyad, konu, mesaj) VALUES ('$ad', '$konu', '$mesaj')")){
        $mesaj_sonuc = "<div class='alert alert-ok'>✅ Mesajınız başarıyla iletildi!</div>";
    } else {
        $mesaj_sonuc = "<div class='alert alert-risk'>❌ Bir hata oluştu.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head><title>İletişim</title><link rel="stylesheet" href="style.css"></head>
<body>
    <header class="ust-alan"><h1>ADYS İletişim</h1><a href="index.php">Ana Sayfa</a></header>
    <div class="ana-kapsayici">
        <aside class="sol-menu">
            <h3>Menü</h3>
            <ul>
                <li><a href="index.php">🏠 Ana Sayfa</a></li>
                <li><a href="risk.php">⚠️ Risk Analizi</a></li>
                <li><a href="karne.php">📊 Kişisel Karne</a></li>
                <li><a href="egzersizler.php">💪 Egzersizler</a></li>
                <li><a href="liderlik.php">🏆 Liderlik Tablosu</a></li>
                <li><a href="iletisim.php" class="aktif">📝 İstek & Şikayet</a></li>
            </ul>
        </aside>
        <main class="icerik">
            <div class="panel">
                <h2>📝 Bize Yazın</h2>
                <p>Görüşleriniz, istekleriniz ve şikayetleriniz bizim için önemli.</p>
                <?php echo $mesaj_sonuc; ?>
                <form method="POST">
                    <label>Adınız Soyadınız:</label>
                    <input type="text" name="ad" required placeholder="Adınız...">
                    
                    <label>Konu Seçiniz:</label>
                    <select name="konu" style="cursor:pointer; font-size:16px;">
                        <option value="İstek">🙏 Bir İsteğim Var</option>
                        <option value="Şikayet">😡 Şikayetim Var</option>
                        <option value="Öneri">💡 Bir Önerim Var</option>
                        <option value="Teşekkür">❤️ Teşekkür Etmek İstiyorum</option>
                    </select>

                    <label>Mesajınız:</label>
                    <textarea name="mesaj" rows="5" required placeholder="Mesajınızı buraya yazın..."></textarea>
                    
                    <button type="submit" name="gonder" class="btn-mavi">GÖNDER</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>