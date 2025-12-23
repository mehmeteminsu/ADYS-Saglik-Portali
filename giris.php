<?php
session_start();
include 'baglan.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vt = new Veritabani();
    $db = $vt->baglan();

    $email = $_POST['email'];
    $sifre = md5($_POST['sifre']); // Şifreleme

    // Kullanıcıyı bul
    $sonuc = $db->query("SELECT * FROM kullanicilar WHERE email='$email' AND sifre='$sifre'");

    if ($sonuc->num_rows > 0) {
        $uye = $sonuc->fetch_assoc();
        
        // OTURUM VERİLERİNİ BAŞLAT (KRİTİK KISIM)
        $_SESSION['uye_id'] = $uye['id'];
        $_SESSION['uye_ad'] = $uye['ad_soyad'];
        $_SESSION['yetki'] = $uye['yetki'];

        // Admin ise panele, değilse ana sayfaya
        if($uye['yetki'] == 'admin') { 
            header("Location: admin.php"); 
        } else { 
            header("Location: index.php"); 
        }
        exit;
    } else {
        $hata = "E-posta veya şifre hatalı!";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Giriş Yap - ADYS</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { display: flex; align-items: center; justify-content: center; height: 100vh; background: #f4f7f6; }
        .giris-kutusu { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 350px; text-align: center; }
        .giris-kutusu h2 { color: #4e54c8; margin-bottom: 20px; }
        .link { margin-top: 15px; font-size: 14px; display: block; color: #666; }
        .hata { color: red; font-size: 14px; margin-bottom: 10px; }
    </style>
</head>
<body>

    <div class="giris-kutusu">
        <h2>👋 Tekrar Hoşgeldin</h2>
        
        <?php if(isset($hata)) echo "<div class='hata'>$hata</div>"; ?>
        
        <form method="POST">
            <input type="email" name="email" placeholder="E-Posta Adresiniz" required>
            <input type="password" name="sifre" placeholder="Şifreniz" required>
            <button type="submit" class="btn-mavi" style="width:100%;">GİRİŞ YAP</button>
        </form>
        
        <a href="kayit.php" class="link">Hesabın yok mu? <b>Kayıt Ol</b></a>
        <a href="index.php" class="link" style="color:#aaa;">← Ana Sayfaya Dön</a>
    </div>

</body>
</html>