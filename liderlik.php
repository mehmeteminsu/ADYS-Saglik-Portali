<?php 
session_start(); 
include 'baglan.php';
$vt = new Veritabani(); 
$db = $vt->baglan();
?>
<!DOCTYPE html>
<html lang="tr">
<head><title>Liderlik Tablosu</title><link rel="stylesheet" href="style.css"></head>
<body>
    <header class="ust-alan"><h1>🏆 Şampiyonlar Ligi</h1><a href="index.php">Ana Sayfa</a></header>
    <div class="ana-kapsayici">
        <aside class="sol-menu">
            <h3>Menü</h3>
            <ul>
                <li><a href="index.php">🏠 Ana Sayfa</a></li>
                <li><a href="risk.php">⚠️ Risk Analizi</a></li>
                <li><a href="karne.php">📊 Kişisel Karne</a></li>
                <li><a href="egzersizler.php">💪 Egzersizler</a></li>
                <li><a href="liderlik.php" class="aktif">🏆 Liderlik Tablosu</a></li>
                <li><a href="iletisim.php">📝 İstek & Şikayet</a></li>
            </ul>
        </aside>
        <main class="icerik">
            <div class="panel">
                <h2>🏆 En Sağlıklı Üyelerimiz</h2>
                <p>Risk analizi ve karne hesaplaması yaparak puan toplayın, zirveye çıkın!</p>
                
                <table border="1" width="100%" style="border-collapse:collapse; text-align:center; margin-top:20px;">
                    <tr style="background:#4e54c8; color:white;">
                        <th style="padding:15px;">Sıra</th>
                        <th>Üye Adı</th>
                        <th>Toplam Puan</th>
                    </tr>
                    
                    <?php
                    // En yüksek puana sahip 10 kişiyi çek
                    if($db) {
                        $sorgu = $db->query("SELECT * FROM kullanicilar ORDER BY puan DESC LIMIT 10");
                        $sira = 1;
                        while($uye = $sorgu->fetch_assoc()) {
                            // İlk 3 kişiye madalya ikonu koyalım
                            $madalya = "";
                            if($sira == 1) $madalya = "🥇";
                            elseif($sira == 2) $madalya = "🥈";
                            elseif($sira == 3) $madalya = "🥉";

                            echo "<tr style='height:50px;'>";
                            echo "<td><b>$sira</b> $madalya</td>";
                            echo "<td>{$uye['ad_soyad']}</td>";
                            echo "<td><b style='color:#27ae60;'>{$uye['puan']} Puan</b></td>";
                            echo "</tr>";
                            $sira++;
                        }
                    }
                    ?>
                </table>

                <div style="margin-top:20px; font-size:12px; color:gray;">
                    * Risk Analizi: 50 Puan | Karne Analizi: 100 Puan
                </div>
            </div>
        </main>
    </div>
</body>
</html>