<?php
include 'baglan.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vt = new Veritabani();
    $db = $vt->baglan();

    $ad = htmlspecialchars($_POST['ad']);
    $email = htmlspecialchars($_POST['email']);
    $sifre = md5($_POST['sifre']); // Şifreyi gizle
    
    // Aynı mail var mı kontrol et
    $kontrol = $db->query("SELECT * FROM kullanicilar WHERE email='$email'");
    
    if($kontrol->num_rows > 0) {
        $mesaj = "<div style='color:red;'>Bu e-posta zaten kayıtlı!</div>";
    } else {
        // Puan varsayılan olarak 0 eklenir
        $ekle = $db->query("INSERT INTO kullanicilar (ad_soyad, email, sifre, puan) VALUES ('$ad', '$email', '$sifre', 0)");
        
        if($ekle) {
            echo "<script>alert('✅ Kayıt Başarılı! Giriş yapabilirsiniz.'); window.location.href='giris.php';</script>";
        } else {
            $mesaj = "Hata oluştu.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kayıt Ol - ADYS</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { display: flex; align-items: center; justify-content: center; height: 100vh; background: #f4f7f6; }
        .giris-kutusu { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 350px; text-align: center; }
        .giris-kutusu h2 { color: #2ecc71; margin-bottom: 20px; }
        .link { margin-top: 15px; font-size: 14px; display: block; color: #666; }
    </style>
</head>
<body>

    <div class="giris-kutusu">
        <h2>🚀 Aramıza Katıl</h2>
        <p style="color:#777; font-size:13px; margin-bottom:20px;">Sağlıklı bir yaşam için ilk adımı at.</p>
        
        <?php if(isset($mesaj)) echo $mesaj; ?>
        
        <form method="POST">
            <input type="text" name="ad" placeholder="Adınız Soyadınız" required>
            <input type="email" name="email" placeholder="E-Posta Adresiniz" required>
            <input type="password" name="sifre" placeholder="Şifre Belirleyin" required>
            <button type="submit" class="btn-yesil" style="width:100%;">KAYIT OL</button>
        </form>
        
        <a href="giris.php" class="link">Zaten üye misin? <b>Giriş Yap</b></a>
    </div>

</body>
</html>