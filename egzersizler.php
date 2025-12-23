<?php 
session_start(); 
include 'baglan.php';
$vt = new Veritabani(); 
$db = $vt->baglan();

$mesaj = "";

// --- 1. NEFES EGZERSİZİ BİTİNCE PUAN VERME İŞLEMİ ---
if(isset($_GET['nefes_bitti'])) {
    if(isset($_SESSION['uye_id'])) {
        $uid = $_SESSION['uye_id'];
        
        // Puan ekle
        $db->query("UPDATE kullanicilar SET puan = puan + 25 WHERE id = $uid");
        
        // İşlem bitince temiz sayfaya yönlendir (Sürekli puan artmasın diye)
        header("Location: egzersizler.php?durum=tebrikler");
        exit;
    } else {
        // Üye değilse uyarı ver
        $mesaj = "<div class='alert alert-risk'>⚠️ Puan kazanmak için önce giriş yapmalısınız.</div>";
    }
}

// --- 2. TEBRİK MESAJI GÖSTERME ---
if(isset($_GET['durum']) && $_GET['durum'] == 'tebrikler') {
    $mesaj = "<div class='alert alert-ok'>
                🧘 <b>Harika!</b> Nefes egzersizini tamamlayıp zihninizi boşalttınız. 
                <br>🎁 Hanenize <b>+25 Puan</b> eklendi.
              </div>";
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <title>Egzersizler</title>
    <link rel="stylesheet" href="style.css">
    
    <style>
        /* NEFES KUTUSU TASARIMI */
        .nefes-kutusu {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            border: 1px solid rgba(255,255,255,0.6);
        }
        .nefes-daire {
            width: 140px; height: 140px;
            background: white;
            border-radius: 50%;
            margin: 20px auto;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; font-weight: bold; color: #4e54c8;
            border: 5px solid #fff;
            box-shadow: 0 0 20px rgba(255,255,255,0.6);
            transition: all 1s ease-in-out;
        }
        .buyume { transform: scale(1.3); background: #e0f7fa; border-color: #4e54c8; }
        .kuculme { transform: scale(1); background: white; }
    </style>
</head>
<body>
    <header class="ust-alan"><h1>Önerilen Egzersizler</h1><a href="index.php">Ana Sayfa</a></header>
    
    <div class="ana-kapsayici">
        <aside class="sol-menu">
            <h3>Menü</h3>
            <ul>
                <li><a href="index.php">🏠 Ana Sayfa</a></li>
                <li><a href="risk.php">⚠️ Risk Analizi</a></li>
                <li><a href="karne.php">📊 Kişisel Karne</a></li>
                <li><a href="egzersizler.php" class="aktif">💪 Egzersizler</a></li>
                <li><a href="liderlik.php">🏆 Liderlik Tablosu</a></li>
                <li><a href="iletisim.php">📝 İstek & Şikayet</a></li>
            </ul>
        </aside>
        
        <main class="icerik">
            
            <?php echo $mesaj; ?>

            <div class="nefes-kutusu">
                <h2 style="color:#4e54c8; margin-top:0;">🧘 Ofis Stresini Atın</h2>
                <p>4 saniye kuralı ile rahatlayın. Tamamlayın ve <b>+25 Puan</b> kazanın!</p>
                
                <div id="daire" class="nefes-daire">HAZIR</div>
                
                <button onclick="nefesBaslat()" id="btnBaslat" class="btn-mavi" style="width:200px;">BAŞLAT</button>
                <div id="durumYazisi" style="margin-top:15px; font-weight:bold; color:#555;"></div>
            </div>

            <div class="panel">
                <h2>💪 Egzersiz Listesi</h2>
                <div style="margin-top:20px;">
                    <?php 
                    $sorgu = $db->query("SELECT * FROM icerikler ORDER BY id DESC");
                    if($sorgu->num_rows > 0) {
                        while($r = $sorgu->fetch_assoc()) {
                            echo "<div class='kart'>";
                            echo "<img src='resimler/{$r['resim_yolu']}'>";
                            echo "<h3 style='color:#4e54c8;'>{$r['baslik']}</h3>";
                            echo "<p>{$r['aciklama']}</p>";
                            echo "</div>";
                        }
                    } else {
                        echo "<div class='alert alert-risk'>📭 Henüz hiç egzersiz eklenmemiş.</div>";
                    }
                    ?>
                </div>
            </div>
        </main>
    </div>

    <script>
        function nefesBaslat() {
            const daire = document.getElementById("daire");
            const yazi = document.getElementById("durumYazisi");
            const buton = document.getElementById("btnBaslat");
            
            // Butona tekrar basılmasını engelle
            buton.disabled = true;
            buton.style.opacity = "0.5";
            buton.innerText = "YAPILIYOR...";
            
            yazi.innerText = "Derin bir nefes alın...";
            
            // Toplam 3 tur (Yaklaşık 36 saniye yerine test için hızlı bitsin diye 2 tur yapabiliriz ama 3 ideal)
            let tur = 0;
            const dongu = setInterval(() => {
                if(tur >= 2) { // 0, 1, 2 (Toplam 3 tur)
                    clearInterval(dongu);
                    daire.innerText = "BİTTİ";
                    daire.className = "nefes-daire"; 
                    yazi.innerText = "Harika! Puanınız yükleniyor...";
                    
                    // 2 saniye bekle ve puanı ver (Sayfayı yenile)
                    setTimeout(() => {
                        window.location.href = "egzersizler.php?nefes_bitti=1";
                    }, 2000);
                    return;
                }

                // 1. NEFES AL
                daire.innerText = "NEFES AL";
                daire.className = "nefes-daire buyume";
                
                setTimeout(() => {
                    // 2. TUT
                    daire.innerText = "TUT";
                }, 4000);

                setTimeout(() => {
                    // 3. VER
                    daire.innerText = "VER";
                    daire.className = "nefes-daire kuculme";
                }, 8000);

                tur++;
            }, 12000); 
            
            // İlk tetikleme
            daire.innerText = "NEFES AL";
            daire.className = "nefes-daire buyume";
            setTimeout(() => { daire.innerText = "TUT"; }, 4000);
            setTimeout(() => { daire.innerText = "VER"; daire.className = "nefes-daire kuculme"; }, 8000);
        }
    </script>
</body>
</html>