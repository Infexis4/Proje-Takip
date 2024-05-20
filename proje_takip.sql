-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 20 May 2024, 08:51:37
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
-- Veritabanı: `proje takip`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cinsiyet`
--

CREATE TABLE `cinsiyet` (
  `cinsiyet_ID` int(11) NOT NULL,
  `cinsiyet_Adi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `cinsiyet`
--

INSERT INTO `cinsiyet` (`cinsiyet_ID`, `cinsiyet_Adi`) VALUES
(1, 'Erkek'),
(2, 'Kadın');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `danısman`
--

CREATE TABLE `danısman` (
  `danısman_ID` int(11) NOT NULL,
  `danısman_ad` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `danısman`
--

INSERT INTO `danısman` (`danısman_ID`, `danısman_ad`) VALUES
(68, 'fATİHYAMAN'),
(69, 'yamanfatik'),
(70, 'mehmet'),
(71, 'esen'),
(72, 'yasmin pirinç'),
(73, 'aaaaaaaaaa'),
(74, 'duran göksü'),
(75, 'ıııııııııııııııı'),
(76, 'Fatih Yaman'),
(77, 'asadasd'),
(78, 'sadasdadasd'),
(79, 'xzczcz'),
(80, 'Proje 1 Danışmanı'),
(81, 'Proje 2 Danışman'),
(82, 'Proje 10'),
(83, 'Proje 3 Danışman'),
(84, 'Proje 4 Danışman'),
(85, 'Proje 5 Danışman'),
(86, 'TEST'),
(87, ''),
(88, 'TESSTT'),
(89, 'SDASDASDASDAS'),
(90, 'asdasdasdasda'),
(91, '45243543453'),
(92, 'tessst'),
(93, 'asdsadasdasdas'),
(94, 'Orkun Teke'),
(95, 'lorem ipsum'),
(96, 'deneme 2'),
(97, 'test 2'),
(98, 'uıuıuıuı'),
(99, 'Prof. Dr. Ayşe Yılmaz'),
(100, 'Doç. Dr. Mehmet Özdemir'),
(101, 'Prof. Dr. Fatma Demir'),
(102, 'Yrd. Doç. Dr. Can Yıldız'),
(103, 'Prof. Dr. Ali Koç'),
(104, 'Prof. Dr. Zeynep Yılmaz'),
(105, 'Prof. Dr. Emre Öztürk'),
(106, ' Doç. Dr. Ahmet Şahin'),
(107, 'Prof. Dr. Canan Aktaş'),
(108, 'Yrd. Doç. Dr. Murat Çelik'),
(109, 'Prof. Dr. Mehmet Yılmaz'),
(110, ' Prof. Dr. Mehmet Akgün'),
(111, 'Doç. Dr. Zeynep Bayraktar'),
(112, 'Prof. Dr. Ali Yıldız'),
(113, 'Doç. Dr. Mehmet Kaya'),
(114, ' Prof. Dr. Fatma Demirci'),
(115, 'Prof. Dr. Mehmet Karakaş'),
(116, 'Doç. Dr. Ayşe Demir'),
(117, 'Yrd. Doç. Dr. Canan Aydın'),
(118, 'Doç. Dr. Mehmet Çelik'),
(119, 'Murat kılınç'),
(120, '7777777'),
(121, 'örnek'),
(122, 'örnek örnek'),
(123, 'mehmet ali'),
(124, 'hjhjhjhjhjhjh'),
(125, 'hjhjhjhjhjhjhsadasdasd'),
(126, 'asdasdasdasdasdasd'),
(127, 'fatih yamanaa'),
(128, 'ahmet'),
(129, 'daevede'),
(130, 'murat hoca');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `kullanici_ID` int(11) NOT NULL,
  `kullanici_Adi` varchar(100) NOT NULL,
  `kullanici_Soyadi` varchar(100) NOT NULL,
  `kullanici_nickname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `kullanici_dogumTarihi` date NOT NULL,
  `kullanici_kayitTarihi` datetime NOT NULL DEFAULT current_timestamp(),
  `meslek_ID` int(11) NOT NULL,
  `cinsiyet_ID` int(11) NOT NULL,
  `kullaniciTipi_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`kullanici_ID`, `kullanici_Adi`, `kullanici_Soyadi`, `kullanici_nickname`, `email`, `password`, `kullanici_dogumTarihi`, `kullanici_kayitTarihi`, `meslek_ID`, `cinsiyet_ID`, `kullaniciTipi_ID`) VALUES
(10, 'Fatih', 'Yaman', 'Fatih', 'fatihyamanus@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2001-08-23', '2024-02-28 10:04:12', 2, 1, 2),
(11, 'Hüseyin', 'Gürbüz', 'Hüseyin', 'hsyn@gmail.com', '25f9e794323b453885f5181f1b624d0b', '2024-04-04', '2024-04-03 09:50:52', 3, 1, 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanici_tipi`
--

CREATE TABLE `kullanici_tipi` (
  `kullaniciTipi_ID` int(11) NOT NULL,
  `kullaniciTipi_Adi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `kullanici_tipi`
--

INSERT INTO `kullanici_tipi` (`kullaniciTipi_ID`, `kullaniciTipi_Adi`) VALUES
(1, 'Kullanıcı'),
(2, 'Yönetici');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `meslekler`
--

CREATE TABLE `meslekler` (
  `meslek_ID` int(11) NOT NULL,
  `meslek_Adi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `meslekler`
--

INSERT INTO `meslekler` (`meslek_ID`, `meslek_Adi`) VALUES
(1, 'Öğretmen'),
(2, 'Mühendis'),
(3, 'Doktor'),
(4, 'Hakim');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `projeler`
--

CREATE TABLE `projeler` (
  `projeler_ID` int(11) NOT NULL,
  `proje_Adi` varchar(100) NOT NULL,
  `proje_butce` float NOT NULL,
  `proje_yil` int(11) NOT NULL,
  `proje_sayı` int(11) NOT NULL,
  `proje_aciklama` text NOT NULL,
  `danısman_ID` int(11) NOT NULL,
  `resim_ID` int(11) DEFAULT NULL,
  `sanayı_danısman` varchar(200) NOT NULL,
  `proje_firma` varchar(200) NOT NULL,
  `proje_ID` int(11) DEFAULT NULL,
  `durum_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `projeler`
--

INSERT INTO `projeler` (`projeler_ID`, `proje_Adi`, `proje_butce`, `proje_yil`, `proje_sayı`, `proje_aciklama`, `danısman_ID`, `resim_ID`, `sanayı_danısman`, `proje_firma`, `proje_ID`, `durum_id`) VALUES
(141, 'Siber Güvenlik Eğitim Platformu', 12000, 2023, 7, 'Kullanıcıların siber güvenlik becerilerini geliştirmelerine yardımcı olan interaktif bir eğitim platformu.', 99, NULL, 'Mehmet Yalçın', 'OptiChain Teknolojileri', 2, 1),
(148, 'Görüntü İşleme Tabanlı Tıbbi Teşhis Yardımcısı', 8000, 2024, 8, 'Tıbbi görüntülerin analiz edilmesi ve teşhis süreçlerine destek olmak için görüntü işleme tekniklerini kullanan bir tıbbi teşhis yardımcısı yazılımın geliştirilmesi.\r\n', 116, NULL, 'Burak Kocaman', 'MedImaging Solutions Ltd.', 2, 1),
(150, 'Otomatik Seracılık Sistemleri İyileştirme', 8500, 2024, 7, 'Tarımsal üretimi artırmak ve kaynak kullanımını optimize etmek amacıyla otomatik seracılık sistemlerinin geliştirilmesi.', 118, NULL, 'Zehra Güneş', 'AgroTech Innovations A.Ş', 2, 3);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `proje_durumu`
--

CREATE TABLE `proje_durumu` (
  `durum_id` int(11) NOT NULL,
  `durum` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `proje_durumu`
--

INSERT INTO `proje_durumu` (`durum_id`, `durum`) VALUES
(1, 'Kabul Edildi'),
(2, 'Kabul Edilmedi'),
(3, 'Belirsiz');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `proje_tur`
--

CREATE TABLE `proje_tur` (
  `projetur_ID` int(10) NOT NULL,
  `tur_ID` int(11) NOT NULL,
  `projeler_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `proje_tur`
--

INSERT INTO `proje_tur` (`projetur_ID`, `tur_ID`, `projeler_ID`) VALUES
(193, 52, 150),
(194, 48, 141),
(197, 53, 148),
(205, 48, 159);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `proje_türü`
--

CREATE TABLE `proje_türü` (
  `proje_ID` int(11) NOT NULL,
  `proje_Adi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `proje_türü`
--

INSERT INTO `proje_türü` (`proje_ID`, `proje_Adi`) VALUES
(1, '2209 A'),
(2, '2209 B');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `resimler`
--

CREATE TABLE `resimler` (
  `resim_ID` int(11) NOT NULL,
  `resim` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `resimler`
--

INSERT INTO `resimler` (`resim_ID`, `resim`) VALUES
(30, 'uploads/cbu_dik.jpg'),
(31, 'uploads/cbu_dik.jpg');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tur`
--

CREATE TABLE `tur` (
  `tur_ID` int(11) NOT NULL,
  `tur_Ad` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `tur`
--

INSERT INTO `tur` (`tur_ID`, `tur_Ad`) VALUES
(30, 'Bilimsel '),
(36, 'Ulusal/Uluslararası'),
(48, 'Yazılım'),
(50, 'Savunma Sanayi'),
(52, 'Tarım'),
(53, 'Sağlık'),
(54, 'Enerji'),
(58, 'Mimarlık/Mühendislik');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `cinsiyet`
--
ALTER TABLE `cinsiyet`
  ADD PRIMARY KEY (`cinsiyet_ID`);

--
-- Tablo için indeksler `danısman`
--
ALTER TABLE `danısman`
  ADD PRIMARY KEY (`danısman_ID`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`kullanici_ID`),
  ADD KEY `baglanti1` (`cinsiyet_ID`),
  ADD KEY `baglanti2` (`meslek_ID`),
  ADD KEY `baglanti3` (`kullaniciTipi_ID`);

--
-- Tablo için indeksler `kullanici_tipi`
--
ALTER TABLE `kullanici_tipi`
  ADD PRIMARY KEY (`kullaniciTipi_ID`);

--
-- Tablo için indeksler `meslekler`
--
ALTER TABLE `meslekler`
  ADD PRIMARY KEY (`meslek_ID`);

--
-- Tablo için indeksler `projeler`
--
ALTER TABLE `projeler`
  ADD PRIMARY KEY (`projeler_ID`),
  ADD KEY `filmler_ibfk_1` (`danısman_ID`),
  ADD KEY `filmler_ibfk_2` (`resim_ID`),
  ADD KEY `filmler_ibfk_3` (`proje_ID`),
  ADD KEY `filmler_ibfk_4` (`durum_id`);

--
-- Tablo için indeksler `proje_durumu`
--
ALTER TABLE `proje_durumu`
  ADD PRIMARY KEY (`durum_id`);

--
-- Tablo için indeksler `proje_tur`
--
ALTER TABLE `proje_tur`
  ADD PRIMARY KEY (`projetur_ID`),
  ADD KEY `film_ID` (`projeler_ID`),
  ADD KEY `tur_ID` (`tur_ID`);

--
-- Tablo için indeksler `proje_türü`
--
ALTER TABLE `proje_türü`
  ADD PRIMARY KEY (`proje_ID`);

--
-- Tablo için indeksler `resimler`
--
ALTER TABLE `resimler`
  ADD PRIMARY KEY (`resim_ID`);

--
-- Tablo için indeksler `tur`
--
ALTER TABLE `tur`
  ADD PRIMARY KEY (`tur_ID`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `cinsiyet`
--
ALTER TABLE `cinsiyet`
  MODIFY `cinsiyet_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `danısman`
--
ALTER TABLE `danısman`
  MODIFY `danısman_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `kullanici_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `kullanici_tipi`
--
ALTER TABLE `kullanici_tipi`
  MODIFY `kullaniciTipi_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `meslekler`
--
ALTER TABLE `meslekler`
  MODIFY `meslek_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `projeler`
--
ALTER TABLE `projeler`
  MODIFY `projeler_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- Tablo için AUTO_INCREMENT değeri `proje_tur`
--
ALTER TABLE `proje_tur`
  MODIFY `projetur_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=252;

--
-- Tablo için AUTO_INCREMENT değeri `proje_türü`
--
ALTER TABLE `proje_türü`
  MODIFY `proje_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `resimler`
--
ALTER TABLE `resimler`
  MODIFY `resim_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Tablo için AUTO_INCREMENT değeri `tur`
--
ALTER TABLE `tur`
  MODIFY `tur_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD CONSTRAINT `baglanti1` FOREIGN KEY (`cinsiyet_ID`) REFERENCES `cinsiyet` (`cinsiyet_ID`),
  ADD CONSTRAINT `baglanti2` FOREIGN KEY (`meslek_ID`) REFERENCES `meslekler` (`meslek_ID`),
  ADD CONSTRAINT `baglanti3` FOREIGN KEY (`kullaniciTipi_ID`) REFERENCES `kullanici_tipi` (`kullaniciTipi_ID`);

--
-- Tablo kısıtlamaları `projeler`
--
ALTER TABLE `projeler`
  ADD CONSTRAINT `projeler_ibfk_1` FOREIGN KEY (`danısman_ID`) REFERENCES `danısman` (`danısman_ID`),
  ADD CONSTRAINT `projeler_ibfk_2` FOREIGN KEY (`resim_ID`) REFERENCES `resimler` (`resim_ID`),
  ADD CONSTRAINT `projeler_ibfk_3` FOREIGN KEY (`proje_ID`) REFERENCES `proje_türü` (`proje_ID`),
  ADD CONSTRAINT `projeler_ibfk_4` FOREIGN KEY (`durum_id`) REFERENCES `proje_durumu` (`durum_id`);

--
-- Tablo kısıtlamaları `proje_tur`
--
ALTER TABLE `proje_tur`
  ADD CONSTRAINT `proje_tur_ibfk_1` FOREIGN KEY (`projeler_ID`) REFERENCES `projeler` (`projeler_ID`),
  ADD CONSTRAINT `proje_tur_ibfk_2` FOREIGN KEY (`tur_ID`) REFERENCES `tur` (`tur_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
