-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 23 Ara 2025, 10:33:22
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `adys_proje`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `icerikler`
--

CREATE TABLE `icerikler` (
  `id` int(11) NOT NULL,
  `baslik` varchar(150) NOT NULL,
  `aciklama` text NOT NULL,
  `resim_yolu` varchar(255) NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `icerikler`
--

INSERT INTO `icerikler` (`id`, `baslik`, `aciklama`, `resim_yolu`, `tarih`) VALUES
(6, 'Boyun Esnetme', 'Başınızı yavaşça sağa yatırın ve sağ elinizle hafifçe çekin. 15 saniye bekleyip diğer tarafa uygulayın. Boyun ağrılarını azaltır.', 'boyun.jpg', '2025-12-22 10:18:57'),
(7, 'Omuz Çevirme', 'Omuzlarınızı kulaklarınıza doğru çekin ve geriye doğru dairesel hareketlerle çevirin. Bunu 10 kez tekrarlayın. Sırt gerginliğini alır.', 'omuz.jpg', '2025-12-22 10:18:57'),
(8, 'Kedi-İnek Esnemesi', 'Dört ayak üzerindeyken sırtınızı kamburlaştırıp nefes verin, ardından belinizi çukurlaştırıp nefes alın. Omurgayı esnetir.', 'kedi_inek.jpg', '2025-12-22 10:18:57'),
(9, 'Bilek Esnetme', 'Kolunuzu öne uzatın, avuç içiniz karşıya baksın. Diğer elinizle parmaklarınızı geriye doğru çekin. Karpal tünel sendromunu önler.', 'bilek.jpg', '2025-12-22 10:18:57'),
(10, 'Plank Duruşu', 'Şınav pozisyonunda dirseklerinizin üzerinde durun. Vücudunuzu dümdüz tutarak 30 saniye bekleyin. Tüm vücut kaslarını güçlendirir.', 'plank.jpg', '2025-12-22 10:18:57');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `id` int(11) NOT NULL,
  `ad_soyad` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `sifre` varchar(255) NOT NULL,
  `yetki` enum('admin','user') DEFAULT 'user',
  `kayit_tarihi` timestamp NOT NULL DEFAULT current_timestamp(),
  `puan` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`id`, `ad_soyad`, `email`, `sifre`, `yetki`, `kayit_tarihi`, `puan`) VALUES
(1, 'Yönetici', 'admin@gmail.com', '202cb962ac59075b964b07152d234b70', 'admin', '2025-12-05 13:16:27', 225),
(3, 'Merve Yılmaz', 'merve@test.com', '202cb962ac59075b964b07152d234b70', 'user', '2025-12-22 10:54:38', 450),
(4, 'Caner Erkin', 'caner@test.com', '202cb962ac59075b964b07152d234b70', 'user', '2025-12-22 10:54:38', 320),
(5, 'Zeynep Bastık', 'zeynep@test.com', '202cb962ac59075b964b07152d234b70', 'user', '2025-12-22 10:54:38', 850),
(6, 'Barış Özcan', 'baris@test.com', '202cb962ac59075b964b07152d234b70', 'user', '2025-12-22 10:54:38', 1200),
(7, 'Selin Ciğerci', 'selin@test.com', '202cb962ac59075b964b07152d234b70', 'user', '2025-12-22 10:54:38', 150),
(8, 'Ahmet Yılmaz', 'ahmet@gmail.com', '202cb962ac59075b964b07152d234b70', 'user', '2025-12-22 11:27:43', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `mesajlar`
--

CREATE TABLE `mesajlar` (
  `id` int(11) NOT NULL,
  `ad_soyad` varchar(100) DEFAULT NULL,
  `konu` varchar(50) DEFAULT NULL,
  `mesaj` text DEFAULT NULL,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `mesajlar`
--

INSERT INTO `mesajlar` (`id`, `ad_soyad`, `konu`, `mesaj`, `tarih`) VALUES
(1, 'Mehmet Emin SU', 'Teşekkür', 'Bilgilendirme için teşekkürler.\r\n', '2025-12-22 07:33:32'),
(2, 'Mehmet Emin SU', 'Teşekkür', 'Bilgilendirme için teşekkürler.\r\n', '2025-12-22 07:34:56'),
(3, 'Mehmet Emin SU', 'Teşekkür', 'Bilgilendirme için teşekkürler.\r\n', '2025-12-22 07:36:57'),
(4, 'Mehmet Emin SU', 'Teşekkür', 'Bilgilendirme için teşekkürler.\r\n', '2025-12-22 07:37:11'),
(5, 'Mehmet Emin SU', 'Teşekkür', 'Bilgilendirme için teşekkürler.\r\n', '2025-12-22 07:53:58'),
(6, 'Ceyda Karagülle', 'Teşekkür', 'Mükemmel bir site', '2025-12-22 07:54:42'),
(7, 'aaa', 'Öneri', 'sdasd', '2025-12-22 09:51:41');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `risk_zinciri`
--

CREATE TABLE `risk_zinciri` (
  `id` int(11) NOT NULL,
  `sebep` varchar(255) NOT NULL,
  `sonuc1` varchar(255) NOT NULL,
  `sonuc2` varchar(255) NOT NULL,
  `olasilik` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `risk_zinciri`
--

INSERT INTO `risk_zinciri` (`id`, `sebep`, `sonuc1`, `sonuc2`, `olasilik`) VALUES
(1, 'Hareketsizlik', 'Kaslar zayıflar', 'Obezite ve Kalp Krizi', 70),
(2, 'Kambur Oturmak', 'Omurga disklerine binen yük artar ve sinir sıkışması başlar', 'Boyun Fıtığı ve Kronik Sırt Ağrısı', 90),
(3, 'Mola Vermeden Ekrana Bakmak', 'Göz kırpma sayısı azalır, gözyaşı kurur', 'Dijital Göz Yorgunluğu ve Miyop', 85),
(4, 'Aşırı Şeker Tüketimi', 'İnsülin direnci gelişir, karaciğer yağlanır', 'Obezite ve Tip 2 Diyabet', 95),
(5, 'Yetersiz Su İçmek', 'Böbrekler toksinleri atamaz, kan koyulaşır', 'Böbrek Taşı ve Cilt Bozulması', 70),
(6, 'Düzensiz Uyku', 'Melatonin hormonu bozulur, hücre yenilenmesi durur', 'Depresyon ve Bağışıklık Çöküşü', 80),
(7, 'Hareketsiz Yaşam', 'Kan dolaşımı yavaşlar, metabolizma durur', 'Kalp Krizi Riski ve Varis', 88),
(8, 'Yüksek Sesle Müzik', 'İç kulak sinirleri kalıcı hasar görür', 'Kalıcı İşitme Kaybı (Tinnitus)', 60);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `icerikler`
--
ALTER TABLE `icerikler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Tablo için indeksler `mesajlar`
--
ALTER TABLE `mesajlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `risk_zinciri`
--
ALTER TABLE `risk_zinciri`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `icerikler`
--
ALTER TABLE `icerikler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `mesajlar`
--
ALTER TABLE `mesajlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `risk_zinciri`
--
ALTER TABLE `risk_zinciri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
