<?php 
session_start(); 
error_reporting(0);
include 'baglan.php'; 

$sonuc_kutusu = "";
$sebepler = [];

// Veritabanı işlemleri
$vt = new Veritabani();
$db = $vt->baglan();

if($db) {
    // Sebepleri Çek
    $sorgu = $db->query("SELECT sebep FROM risk_zinciri");
    if($sorgu) while($r = $sorgu->fetch_assoc()) $sebepler[] = $r['sebep'];

    // HESAPLAMA İŞLEMİ
    if(isset($_POST['analiz_et'])) {
        $secilen = $_POST['secilen_sebep'];
        $bul = $db->query("SELECT * FROM risk_zinciri WHERE sebep='$secilen'");
        
        if($bul && $bul->num_rows > 0) {
            $v = $bul->fetch_assoc();
            
            // --- PUAN SİSTEMİ ---
            $puan_mesaji = "";
            if(isset($_SESSION['uye_id'])) {
                $uid = $_SESSION['uye_id'];
                $db->query("UPDATE kullanicilar SET puan = puan + 50 WHERE id = $uid");
                $puan_mesaji = "<small style='color:green; font-size:0.6em; vertical-align:middle;'> (+50 Puan Kazandınız! 🎉)</small>";
            }
            // --------------------

            $sonuc_kutusu = "
            <div class='sonuc-kutu sonuc-riskli' style='animation: fadeIn 0.5s;'>
                <h3>⛔ Risk Zinciri Tespit Edildi! $puan_mesaji</h3>
                <p><b>Seçim:</b> {$v['sebep']}</p>
                <p>⬇️ <b>Etki:</b> {$v['sonuc1']}</p>
                <h4 style='background:white; padding:10px; border-radius:5px;'>🏥 SONUÇ: {$v['sonuc2']}</h4>
            </div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>ADYS - Risk Analizi ve Duruş Rehberi</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* İKİ SÜTUNLU YAPI İÇİN CSS */
        .bolum-kapsayici {
            display: flex;
            gap: 20px;
        }
        .sol-panel { flex: 1; }
        .sag-rehber { 
            flex: 1; 
            background: white; 
            padding: 20px; 
            border-radius: 10px; 
            border: 1px solid #eee;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }
        
        /* REHBER MADDELERİ */
        .rehber-liste li { margin-bottom: 10px; color: #555; font-size: 14px; }
        .rehber-liste li b { color: #2ecc71; } /* Yeşil vurgu */
        
        /* MOBİL UYUMU */
        @media (max-width: 768px) {
            .bolum-kapsayici { flex-direction: column; }
        }
    </style>
</head>
<body>

    <header class="ust-alan">
        <h1>Risk Analizi & Doğru Duruş</h1>
        <a href="index.php">Ana Sayfaya Dön</a>
    </header>

    <div class="ana-kapsayici">
        <aside class="sol-menu">
            <h3>Menü</h3>
            <ul>
                <li><a href="index.php">🏠 Ana Sayfa</a></li>
                <li><a href="risk.php" class="aktif">⚠️ Risk Analizi</a></li>
                <li><a href="karne.php">📊 Kişisel Karne</a></li>
                <li><a href="egzersizler.php">💪 Egzersizler</a></li>
                <li><a href="liderlik.php">🏆 Liderlik Tablosu</a></li>
                <li><a href="iletisim.php">📝 İstek & Şikayet</a></li>
            </ul>
        </aside>

        <main class="icerik">
            
            <div class="bolum-kapsayici">
                
                <div class="panel sol-panel" style="border-left: 5px solid #ff6b6b;">
                    <h2>⚠️ 1. Risk Simülatörü</h2>
                    <p>Kötü alışkanlığınızı seçin, olası sonuçları görün.</p>
                    
                    <form method="POST">
                        <label>Riskli Alışkanlık Seçin:</label>
                        <input list="liste" name="secilen_sebep" placeholder="Örn: Bacak bacak üstüne atmak..." required autocomplete="off" style="width:100%; padding:10px; margin:10px 0;">
                        <datalist id="liste">
                            <?php foreach($sebepler as $s) echo "<option value='$s'>"; ?>
                        </datalist>
                        <button type="submit" name="analiz_et" class="btn-kirmizi" style="width:100%;">RİSK HESAPLA</button>
                    </form>

                    <?php echo $sonuc_kutusu; ?>
                </div>

                <div class="sag-rehber">
                    <h2 style="color:#27ae60; margin-top:0;">✅ 2. Akıllı Duruş Rehberi</h2>
                    <p>Masa başında sağlığınızı korumak için altın kurallar:</p>
                    
                    <div style="text-align:center; margin:15px 0;">
                       <img src="resimler/durus.jpg" width="100%" style="max-width: 250px; border-radius:10px;" alt="Doğru Oturuş">
                    </div>

                    <ul class="rehber-liste">
                        <li><b>1. Göz Seviyesi:</b> Monitörün üst kenarı, göz hizasında olmalıdır. (Boyun eğilmemeli).</li>
                        <li><b>2. 90 Derece Kuralı:</b> Dirsekler ve dizler 90 derecelik açıyla bükülmeli.</li>
                        <li><b>3. Ayaklar:</b> Ayak tabanları yere tam basmalı (Gerekirse ayak desteği kullanılmalı).</li>
                        <li><b>4. Bel Desteği:</b> Sandalyeniz bel çukurunuzu tam kavramalıdır.</li>
                        <li><b>5. Mesafe:</b> Ekran ile gözünüz arasında 50-70 cm mesafe olmalıdır.</li>
                    </ul>
                    
                    <div style="background:#e8f8f5; padding:10px; border-radius:5px; font-size:12px; color:#16a085; text-align:center;">
                        💡 <b>İpucu:</b> Bu kurallara uymak, omurga yükünü %40 azaltır.
                    </div>
                </div>

            </div>
        </main>
    </div>
    <script src="script.js"></script>
</body>
</html>