<?php session_start(); ?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <title>Ana Sayfa - ADYS</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* DASHBOARD KARTLARI İÇİN ÖZEL CSS */
        .dashboard-grid {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }
        .bilgi-karti {
            flex: 1;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: transform 0.3s;
            border-left: 5px solid #ccc;
            text-decoration: none;
            color: #333;
            min-width: 250px;
        }
        .bilgi-karti:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
        
        /* Renk Kodları */
        .kart-kirmizi { border-color: #ff6b6b; }
        .kart-yesil { border-color: #2ecc71; }
        .kart-mavi { border-color: #4e54c8; }

        .kart-ikon { font-size: 30px; opacity: 0.8; }
        .kart-metin h3 { margin: 0; font-size: 18px; color: #444; }
        .kart-metin p { margin: 5px 0 0; font-size: 13px; color: #888; }

        /* GÜNÜN İPUCU KUTUSU */
        .ipucu-kutu {
            background: #e3f2fd;
            border-left: 5px solid #2196f3;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .ipucu-ikon { font-size: 24px; color: #2196f3; }

        /* ÜST Header CSS'leri (Eski koddan korundu) */
        .uye-paneli { position: absolute; right: 20px; top: 25px; display: flex; align-items: center; gap: 10px; }
        .btn-giris { background: white; color: #4e54c8; padding: 8px 15px; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 14px; transition: 0.3s; }
        .btn-giris:hover { background: #f0f0f0; }
        .btn-cikis { background: #ff6b6b; color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 14px; }
        .puan-rozeti { background:#27ae60; color:white; padding:5px 12px; border-radius:15px; font-size:13px; font-weight: bold; box-shadow: 0 2px 5px rgba(0,0,0,0.2); }
    </style>
</head>
<body>
    <header class="ust-alan">
        <h1>ADYS Sağlık Portalı</h1>
        
        <div class="uye-paneli">
            <?php if(isset($_SESSION['uye_ad'])): ?>
                <span style="color:white;">👤 <?php echo $_SESSION['uye_ad']; ?></span>
                <span class="puan-rozeti">
                   ⭐ <?php 
                      include 'baglan.php'; 
                      $vt = new Veritabani(); $db = $vt->baglan();
                      if($db && isset($_SESSION['uye_id'])) {
                          $uid = $_SESSION['uye_id'];
                          $sorgu = $db->query("SELECT puan FROM kullanicilar WHERE id=$uid");
                          if($sorgu->num_rows > 0) { $p = $sorgu->fetch_assoc(); echo $p['puan']; } else { echo "0"; }
                      } else { echo "0"; }
                   ?> Puan
                </span>
                <a href="cikis.php" class="btn-cikis">Çıkış</a>
            <?php else: ?>
                <a href="giris.php" class="btn-giris">🚀 Giriş Yap</a>
                <a href="kayit.php" class="btn-giris" style="background:transparent; border:1px solid white; color:white;">Kayıt Ol</a>
            <?php endif; ?>
        </div>
    </header>

    <div class="marquee-alan">
        <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
            📢 ADYS Projesi Final Ödevi &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 💧 Su İçmeyi Unutmayın! &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 🏃‍♂️ Günde en az 30 dakika yürüyüş yapın! &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 🍎 Sağlıklı Beslen, Sağlıklı Yaşa!
        </marquee>
    </div>

    <div class="ana-kapsayici">
        <aside class="sol-menu">
            <h3>Menü</h3>
            <ul>
                <li><a href="index.php" class="aktif">🏠 Ana Sayfa</a></li>
                <li><a href="risk.php">⚠️ Risk Analizi</a></li>
                <li><a href="karne.php">📊 Kişisel Karne</a></li>
                <li><a href="egzersizler.php">💪 Egzersizler</a></li>
                <li><a href="liderlik.php">🏆 Liderlik Tablosu</a></li>
                <li><a href="iletisim.php">📝 İstek & Şikayet</a></li>
            </ul>
            <div class="sponsor-alan">
                <p>Sponsorlar</p>
                <div class="animasyon-kutu">💊</div>
            </div>
        </aside>

        <main class="icerik">
            
            <div class="panel">
                <h2>👋 Hoşgeldiniz!</h2>
                <p>Sağlıklı yaşam yolculuğunuza bugün buradan başlayın.</p>
                <hr>
                
                <?php
                    $ipuclar = [
                        "Günde en az 2 litre su içmek metabolizmanızı %30 hızlandırır.",
                        "Sürekli oturarak çalışıyorsanız her 30 dakikada bir ayağa kalkın.",
                        "Göz sağlığı için 20-20-20 kuralını uygulayın: 20 dakikada bir, 20 metre uzağa, 20 saniye bakın.",
                        "Uyku düzeni, bağışıklık sisteminizin en önemli koruyucusudur.",
                        "Kahvaltı günün en önemli öğünüdür, atlamayın!"
                    ];
                    $secilen_ipucu = $ipuclar[array_rand($ipuclar)];
                ?>
                <div class="ipucu-kutu">
                    <div class="ipucu-ikon">💡</div>
                    <div>
                        <strong>Günün Sağlık Bilgisi:</strong><br>
                        <?php echo $secilen_ipucu; ?>
                    </div>
                </div>
            </div>

            <div class="dashboard-grid">
                <a href="risk.php" class="bilgi-karti kart-kirmizi">
                    <div class="kart-metin">
                        <h3>Risk Analizi</h3>
                        <p>Alışkanlıklarını test et.</p>
                    </div>
                    <div class="kart-ikon" style="color:#ff6b6b;">⚠️</div>
                </a>

                <a href="karne.php" class="bilgi-karti kart-yesil">
                    <div class="kart-metin">
                        <h3>Kişisel Karne</h3>
                        <p>Oturma ve su analizi.</p>
                    </div>
                    <div class="kart-ikon" style="color:#2ecc71;">📊</div>
                </a>

                <a href="egzersizler.php" class="bilgi-karti kart-mavi">
                    <div class="kart-metin">
                        <h3>Egzersizler</h3>
                        <p>Harekete geç ve rahatla.</p>
                    </div>
                    <div class="kart-ikon" style="color:#4e54c8;">💪</div>
                </a>
            </div>

            <div class="reklam-kutu">
                📢 BURAYA REKLAM GELECEK
                <span>(Reklam vermek için iletişim sayfasından yazabilirsiniz)</span>
            </div>

        </main>
    </div>
</body>
</html>