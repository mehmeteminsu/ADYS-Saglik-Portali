<?php 
session_start(); 
error_reporting(0);

// --- YENİ EKLENEN KISIM (VERİTABANI BAĞLANTISI) ---
// Karne sayfasında puan ekleyebilmek için veritabanını çağırmamız şart.
include 'baglan.php';
$vt = new Veritabani();
$db = $vt->baglan();
// --------------------------------------------------

$sonuc_kutusu = "";

if(isset($_POST['hesapla'])) {
    $saat = (float)$_POST['saat']; 
    $su = (float)$_POST['su'];
    
    // --- YENİ EKLENEN KISIM (PUAN SİSTEMİ) ---
    $puan_bilgisi = "";
    if(isset($_SESSION['uye_id']) && $db) {
        $uid = $_SESSION['uye_id'];
        // Kullanıcıya 100 puan ekle
        $db->query("UPDATE kullanicilar SET puan = puan + 100 WHERE id = $uid");
        $puan_bilgisi = "<div style='background:#d4edda; color:#155724; padding:10px; margin-bottom:15px; border-radius:5px; border:1px solid #c3e6cb;'>
                            🎉 <b>Tebrikler!</b> Sağlık analizi yaptığınız için <b>+100 Puan</b> kazandınız.
                         </div>";
    }
    // -----------------------------------------
    
    // Tavsiyeleri toplayacağımız listeler
    $riskler = [];
    $iyiler = [];
    $oneriler = [];

    // 1. OTURMA SÜRESİ ANALİZİ
    if($saat >= 9) {
        $riskler[] = "Kritik Hareketsizlik Seviyesi! Vücudunuz alarm veriyor, metabolizmanız durma noktasında.";
        $oneriler[] = "🚨 <b>Acil Önlem:</b> Şu an ayağa kalkın ve en az 50 adım atın.";
        $oneriler[] = "👉 <b>Pomodoro Tekniği:</b> 25 dakika çalışıp 5 dakika ayakta durmayı kural haline getirin.";
    } elseif($saat > 6) {
        $riskler[] = "6 saati aşan oturma süreleri metabolizmayı yavaşlatır ve yağ depolamayı artırır.";
        $oneriler[] = "👉 <b>Tavsiye:</b> Telefonla konuşurken mutlaka ayakta gezinin.";
        $oneriler[] = "👉 <b>Egzersiz:</b> Öğle aralarında mutlaka 'Boyun Güçlendirme' hareketini yapın.";
    } else {
        $iyiler[] = "Oturma süreniz gayet dengeli. Hareketli bir yaşamınız var.";
    }

    // 2. SU TÜKETİMİ ANALİZİ
    if($su < 1.0) {
        $riskler[] = "Vücudunuz CİDDİ seviyede susuz. Baş ağrısı ve odak kaybı yaşamanız normal.";
        $oneriler[] = "🚨 <b>Hemen Yap:</b> Bu yazıyı okur okumaz 2 büyük bardak su için.";
        $oneriler[] = "👉 <b>Takip:</b> Masanızda mutlaka 1.5 litrelik bir şişe bulundurun ve bitirmeyi hedefleyin.";
    } elseif($su < 2.0) {
        $riskler[] = "Su tüketiminiz sınırda. Böbrekleriniz tam kapasite çalışamıyor olabilir.";
        $oneriler[] = "👉 <b>Tavsiye:</b> Kahve veya çay su yerine geçmez. Her kahvenin yanına bir bardak su ekleyin.";
    } else {
        $iyiler[] = "Su tüketiminiz harika! Cildiniz ve böbrekleriniz size teşekkür ediyor.";
    }

    // 3. SONUCU EKRANA BASMA (HTML OLUŞTURMA)
    
    // Eğer hiç risk yoksa
    if(count($riskler) == 0) {
        $sonuc_kutusu = "
        <div class='alert alert-ok'>
            $puan_bilgisi
            <h3>🏆 Mükemmel Sonuç!</h3>
            <p>Hem hareketli bir yaşamınız var hem de vücudunuzu susuz bırakmıyorsunuz.</p>
            <hr>
            <ul>";
            foreach($iyiler as $iyi) { $sonuc_kutusu .= "<li>✅ $iyi</li>"; }
        $sonuc_kutusu .= "</ul></div>";
    } 
    // Eğer risk varsa
    else {
        $sonuc_kutusu = "
        <div class='alert alert-risk'>
            $puan_bilgisi
            <h3>⚠️ Sağlık Uyarısı!</h3>
            <p>Vücudunuzda bazı dengesizlikler tespit edildi:</p>
            <ul>";
            foreach($riskler as $risk) { $sonuc_kutusu .= "<li>⛔ $risk</li>"; }
        $sonuc_kutusu .= "</ul>
            <hr>
            <h4>💪 Uzman Tavsiyeleri:</h4>
            <ul style='list-style-type:none; padding:0;'>";
            foreach($oneriler as $oneri) { $sonuc_kutusu .= "<li style='margin-bottom:8px; background:white; padding:8px; border-radius:5px;'>$oneri</li>"; }
        $sonuc_kutusu .= "</ul></div>";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head><title>Kişisel Karne</title><link rel="stylesheet" href="style.css"></head>
<body>
    <header class="ust-alan"><h1>Kişisel Karne</h1><a href="index.php">Ana Sayfa</a></header>
    <div class="ana-kapsayici">
        <aside class="sol-menu">
            <h3>Menü</h3>
            <ul>
                <li><a href="index.php">🏠 Ana Sayfa</a></li>
                <li><a href="risk.php">⚠️ Risk Analizi</a></li>
                <li><a href="karne.php" class="aktif">📊 Kişisel Karne</a></li>
                <li><a href="egzersizler.php">💪 Egzersizler</a></li>
                <li><a href="liderlik.php">🏆 Liderlik Tablosu</a></li>
                <li><a href="iletisim.php">📝 İstek & Şikayet</a></li>
            </ul>
        </aside>
        <main class="icerik">
            <div class="panel" style="border-left: 5px solid #2ecc71;">
                <h2>📊 Kişisel Ergonomi Karnesi</h2>
                <p>Gerçekçi bir analiz için verileri doğru giriniz.</p>
                <form method="POST">
                    <label>Günlük Oturma Süresi (Saat):</label>
                    <input type="number" name="saat" placeholder="Örn: 9" required>
                    
                    <label>Günlük Su Tüketimi (Litre):</label>
                    <input type="number" step="0.1" name="su" placeholder="Örn: 1.2" required>
                    
                    <button type="submit" name="hesapla" class="btn-yesil">DETAYLI ANALİZ ET</button>
                </form>

                <?php echo $sonuc_kutusu; ?>
            </div>
        </main>
    </div>
</body>
</html>