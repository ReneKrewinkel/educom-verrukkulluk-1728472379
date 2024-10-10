-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 10 okt 2024 om 10:52
-- Serverversie: 10.4.32-MariaDB
-- PHP-versie: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `verrukkulluk`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `artiekel`
--

CREATE TABLE `artiekel` (
  `id` int(11) NOT NULL,
  `naam` varchar(255) NOT NULL,
  `omschrijving` text NOT NULL,
  `prijs` float NOT NULL,
  `eenheid` set('stuks','ml','g','teen','ons') NOT NULL,
  `verpakking` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Gegevens worden geëxporteerd voor tabel `artiekel`
--

INSERT INTO `artiekel` (`id`, `naam`, `omschrijving`, `prijs`, `eenheid`, `verpakking`) VALUES
(1, 'Aubergine\r\n', 'Een paarse groente met een zachte, sponsachtige textuur die goed smaken absorbeert.\r\n', 1, 'stuks', 1),
(2, 'Extra vergine olijfolie\r\n', 'Hoogwaardige olijfolie met een rijke, fruitige smaak.\r\n', 4, 'ml', 250),
(3, 'Tomatenpuree\r\n', 'Geconcentreerde tomatenpasta voor een diepe tomatensmaak.\r\n', 0.5, 'g', 70),
(4, 'Knoflook\r\n', 'Aromatische bol met een scherpe smaak, gebruikt om gerechten op smaak te brengen.\r\n', 0.2, 'teen', 15),
(5, 'Mozzarella\r\n', 'Zachte, witte kaas die smelt en een romige textuur toevoegt.\r\n', 0.9, 'ons', 4),
(6, 'Parmezaanse kaas\r\n', 'Harde, korrelige kaas met een rijke, umami-smaak.\r\n', 3.8, 'ons', 4),
(7, 'Verse Basilicum\r\n', 'Aromatisch kruid met een zoete, peperige smaak.\r\n', 2, 'stuks', 1),
(8, 'Gedroogde Oregano\r\n', 'Kruid met een sterke, aromatische smaak.\r\n', 0.5, 'ons', 0),
(9, 'Courgettes\r\n', 'Groene groente met een milde smaak en knapperige textuur.\r\n', 0.8, 'stuks', 1),
(10, 'Gele Pompoen\r\n', 'Groente met een zoete, nootachtige smaak.\r\n', 2.5, 'stuks', 1),
(11, 'Rode Paprika\r\n', 'Zoete, knapperige groente.\r\n', 1, 'stuks', 1),
(12, 'Gele Parika\r\n', 'Zoete, knapperige groente.\r\n', 1, 'stuks', 1),
(13, 'Tomaat\r\n', 'Rijke, sappige groente met een zoete en zure smaak.\r\n', 0.3, 'stuks', 1),
(14, 'Ui', 'Aromatische groente met een scherpe smaak.\r\n', 0.2, 'stuks', 6),
(15, 'Gehakt\r\n', 'Fijngemalen vlees, meestal rundvlees, varkensvlees of een mix daarvan.\r\n', 4, 'ons', 9),
(16, 'Rode pepervlokken\r\n', 'Gedroogde en gemalen chilipepers voor een pittige smaak.\r\n', 1, 'ons', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gerecht`
--

CREATE TABLE `gerecht` (
  `id` int(11) NOT NULL,
  `keuken_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `datum_toegevoegd` date NOT NULL,
  `titel` text NOT NULL,
  `korte_omschrijving` text NOT NULL,
  `lange_omschrijving` text NOT NULL,
  `afbeelding` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Gegevens worden geëxporteerd voor tabel `gerecht`
--

INSERT INTO `gerecht` (`id`, `keuken_id`, `type_id`, `user_id`, `datum_toegevoegd`, `titel`, `korte_omschrijving`, `lange_omschrijving`, `afbeelding`) VALUES
(1, 5, 1, 1, '2024-10-01', 'Melanzane alla Parmigiana', 'Melanzane alla Parmigiana is een heerlijk comfort food dat perfect is voor een gezellige avond.', 'Melanzane alla Parmigiana is een klassiek Italiaans gerecht bestaande uit laagjes gebakken aubergine, tomatensaus, parmezaan en mozzarella. Het is een heerlijk comfort food dat perfect is voor een gezellige avond.', 'https://www.laversionedienrica.it/wp-content/uploads/2016/08/Melanzane-alla-parmigiana-11.jpg'),
(2, 6, 2, 3, '2024-10-02', 'Vegan Ratatouille\r\n', 'Ratatouille is een kleurrijk en smaakvol gerecht dat zowel warm als koud heerlijk is.\r\n', 'Ratatouille is een klassieke Franse groenteschotel die bestaat uit laagjes tomaat, courgette, aubergine en ui, gekruid met Provençaalse kruiden. Het is een kleurrijk en smaakvol gerecht dat zowel warm als koud heerlijk is.\r\n', 'https://fthmb.tqn.com/-I9qcZryRDKymcGtC-UIRnMKeDQ=/960x0/filters:no_upscale()/ratatouuille-593180be3df78c08abf2b499.jpg'),
(3, 7, 3, 5, '2024-10-03', 'Char Siu\r\n', 'Char Siu is een gerecht  met een zoete en hartige smaak.\r\n', 'Char Siu is een klassiek Chinees gerecht uit de Kantonese keuken. Het bestaat uit gemarineerd en geroosterd varkensvlees, vaak met een zoete en hartige smaak. Het vlees wordt gemarineerd in een mix van honing, vijfkruidenpoeder, sojasaus, hoisinsaus en rijstwijn, en vervolgens geroosterd tot het een glanzende, roodbruine buitenkant heeft.\r\n', 'https://images.food52.com/3CqzSnP1rh3cgCtcQrXCgT-Xhcw=/1000x1000/61344a83-2c18-4069-9777-947420f6e72b--mlee-char-siu-pork.jpg'),
(4, 8, 4, 4, '2024-10-04', 'Pepesan Ikan\r\n', 'Pepesan Ikan is een populair Indisch gerecht.\r\n', 'Pepesan Ikan is een populair Indisch gerecht waarbij vis (meestal makreel of sardines) wordt gemarineerd in een pittige kruidenpasta en vervolgens in bananenbladeren wordt gestoomd of gegrild. De marinade bevat vaak ingrediënten zoals citroengras, gember, knoflook, en chilipepers.\r\n', 'https://www.dewereldopjebord.nl/wp-content/uploads/2016/08/Ikan-pepesan-1800x1096.jpg'),
(5, 9, 1, 6, '2024-10-05', 'Vegetarische Taco\'s met Avocado\r\n', 'Vegetarische taco’s met avocado zijn een gezonde en smakelijke optie. \r\n', 'Vegetarische taco’s met avocado zijn een gezonde en smakelijke optie. Deze taco’s bevatten veel groenten zoals paprika, ui, en avocado, en worden op smaak gebracht met komijn en koriander.\r\n', 'https://www.foody.nl/P136381/614x412/vegetarische-taco-met-avocado.jpg'),
(6, 10, 2, 2, '2024-10-06', 'Chana Masala\r\n', 'Chana Masala is voedzaam en perfect te combineren met rijst of naanbrood.\r\n', 'Chana Masala is een populair Indisch gerecht gemaakt van kikkererwten in een pittige tomatensaus met kruiden zoals komijn, koriander en garam masala. Het is voedzaam en perfect te combineren met rijst of naanbrood.\r\n', 'https://www.indianhealthyrecipes.com/wp-content/uploads/2021/08/chana-masala-recipe.jpg'),
(7, 11, 3, 3, '2024-10-07', 'Souvlaki\r\n', 'Souvlaki is een traditioneel Grieks gerecht dat bestaat uit kleine stukjes vlees.\r\n', 'Souvlaki is een traditioneel Grieks gerecht dat bestaat uit kleine stukjes vlees (meestal varkensvlees, kip of lamsvlees) die op een spies worden geregen en gegrild. Het vlees wordt gekruid met mediterrane kruiden zoals oregano, tijm, knoflook en paprika, en vaak geserveerd met pitabroodje, sla, tomaat en tzatziki.\r\n', 'https://www.jocooks.com/wp-content/uploads/2013/07/lamb-souvlaki-1-9.jpg'),
(8, 12, 4, 4, '2024-10-08', 'Gambas al Ajillo\r\n', 'Gambas al Ajillo is een eenvoudig maar smaakvol gerecht dat vaak als tapa wordt geserveerd.\r\n', 'Gambas al Ajillo is een klassiek Spaans gerecht van garnalen gebakken in olijfolie met veel knoflook en een beetje chilipeper. Het is een eenvoudig maar smaakvol gerecht dat vaak als tapa wordt geserveerd.\r\n', 'https://www.hagengrote.fr/$WS/hg1ht/websale8_shop-hg1ht/produkte/medien/bilder/gross/r703.jpg'),
(9, 13, 1, 4, '2024-10-09', 'Vegetarische Pad Thai\r\n', 'Vegetarische Pad Thai is een populaire Thaise roerbakschotel.\r\n', 'Vegetarische Pad Thai is een populaire Thaise roerbakschotel met rijstnoedels, tofu, groenten zoals peulen en taugé, en een smaakvolle saus van sojasaus, chilisaus en limoen.\r\n', 'https://www.thespruceeats.com/thmb/_NbhSMvHG4vw08zg3md7NiJ37Vc=/2999x1999/filters:fill(auto,1)/vegetarian-pad-thai-3217746-10-10-5b0da1deeb97de003761334d.jpg'),
(10, 14, 2, 1, '2024-10-10', 'Patatas Bravas\r\n', 'Patatas Bravas is een favoriet in Spaanse tapasbars en is eenvoudig te maken met slechts een paar ingrediënten.\r\n', 'Patatas Bravas zijn krokant gebakken aardappelen geserveerd met een pittige tomatensaus. Dit gerecht is een favoriet in Spaanse tapasbars en is eenvoudig te maken met slechts een paar ingrediënten.\r\n', 'https://thedeliciousplate.com/wp-content/uploads/2018/05/IMG_2474.jpg');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gerecht_info`
--

CREATE TABLE `gerecht_info` (
  `id` int(11) NOT NULL,
  `gerecht_id` int(11) NOT NULL,
  `datum` date NOT NULL,
  `record_type` set('B','F','O','W') NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `numeriek_veld` int(11) DEFAULT NULL,
  `tekst_veld` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Gegevens worden geëxporteerd voor tabel `gerecht_info`
--

INSERT INTO `gerecht_info` (`id`, `gerecht_id`, `datum`, `record_type`, `user_id`, `numeriek_veld`, `tekst_veld`) VALUES
(1, 1, '2024-10-09', 'B', NULL, 1, 'Snijd de aubergines in plakken van ongeveer 1 cm dik en bestrooi ze met zout. Laat ze ongeveer 30 minuten rusten om overtollig vocht te verwijderen\r\n'),
(2, 2, '2024-10-11', 'W', NULL, 2, ''),
(3, 2, '2024-10-15', 'F', 5, NULL, ''),
(4, 2, '2024-10-10', 'F', 2, NULL, ''),
(5, 2, '2024-10-01', 'W', NULL, 4, ''),
(6, 2, '2024-10-08', 'F', 6, NULL, ''),
(7, 2, '2024-10-15', 'B', NULL, 3, 'Voeg de gesneden aubergine, courgette, paprika, tomaten, gedroogde oregano en rode pepervlokken toe aan de pan en roer alles goed door elkaar.\r\n'),
(8, 3, '2024-10-10', 'O', 2, NULL, 'Was heerlijk!\r\n'),
(9, 3, '2024-10-12', 'W', NULL, 3, ''),
(10, 3, '2024-10-08', 'O', 4, NULL, 'Niet te eten.\r\n');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ingredieent`
--

CREATE TABLE `ingredieent` (
  `id` int(11) NOT NULL,
  `gerecht_id` int(11) NOT NULL,
  `artikel_id` int(11) NOT NULL,
  `aantal` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Gegevens worden geëxporteerd voor tabel `ingredieent`
--

INSERT INTO `ingredieent` (`id`, `gerecht_id`, `artikel_id`, `aantal`) VALUES
(1, 1, 1, 6),
(2, 1, 2, 300),
(3, 1, 3, 225),
(4, 1, 4, 2),
(5, 1, 5, 18),
(6, 1, 6, 4),
(7, 1, 7, NULL),
(8, 1, 8, 0.017),
(9, 2, 1, 2),
(10, 2, 2, 75),
(11, 2, 4, 4),
(12, 2, 7, NULL),
(13, 2, 8, 0.009),
(14, 2, 9, 2),
(15, 2, 10, 2),
(16, 2, 11, 1),
(17, 2, 12, 1),
(18, 2, 13, 6),
(19, 2, 14, 1),
(20, 2, 16, 0.009);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `keuken_type`
--

CREATE TABLE `keuken_type` (
  `id` int(11) NOT NULL,
  `record_type` set('T','K') NOT NULL,
  `omschrijving` set('Vegetarisch','Veganistisch','Vlees','Vis','Italiaans','Frans','Chinees','Japans','Mexicaans','Indisch','Grieks','Thais','Amerikaans','Spaans') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Gegevens worden geëxporteerd voor tabel `keuken_type`
--

INSERT INTO `keuken_type` (`id`, `record_type`, `omschrijving`) VALUES
(1, 'T', 'Vegetarisch'),
(2, 'T', 'Veganistisch'),
(3, 'T', 'Vlees'),
(4, 'T', 'Vis'),
(5, 'K', 'Italiaans'),
(6, 'K', 'Frans'),
(7, 'K', 'Chinees'),
(8, 'K', 'Japans'),
(9, 'K', 'Mexicaans'),
(10, 'K', 'Indisch'),
(11, 'K', 'Grieks'),
(12, 'K', 'Thais'),
(13, 'K', 'Amerikaans'),
(14, 'K', 'Spaans');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `e-mail` varchar(255) NOT NULL,
  `afbeelding` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Gegevens worden geëxporteerd voor tabel `user`
--

INSERT INTO `user` (`id`, `user_name`, `password`, `e-mail`, `afbeelding`) VALUES
(1, 'Persoon 1\r\n', '1111\r\n', 'persoon1@gmail.nl\r\n', 'https://4.bp.blogspot.com/-7Nkvle7C8RY/UBFgm7iWMkI/AAAAAAAADiU/N9spOjwczRU/s1600/hd-katten-wallpapers-een-kat-onder-een-deken-hd-achtergronden.jpg'),
(2, 'Persoon 2\r\n', '2222\r\n', 'persoon2@gmail.nl\r\n', 'https://www.onzenatuur.be/media/cache/fb_og_image/uploads/media/603410285ebd6/kat-vangt-muis.jpg'),
(3, 'Persoon 3\r\n', '3333\r\n', 'persoon3@gmail.nl\r\n', 'https://3.bp.blogspot.com/-1zYdCMyPpMo/UGyTJ1FnAyI/AAAAAAAAFT8/HHUb2x8Y_hM/s1600/hd-katten-achtergrond-met-een-jonge-kat-op-een-kast.jpg'),
(4, 'Persoon 4\r\n', '4444\r\n', 'persoon4@gmail.nl\r\n', 'https://www.nieuwekat.nl/wp-content/uploads/2020/03/15-feiten-over-katten-waardoor-je-er-meer-van-zal-houden-2-1200x675.jpg'),
(5, 'Persoon 5\r\n', '5555\r\n', 'persoon5@gmail.nl\r\n', 'https://www.myhappypet.nl/sites/nlmhp2/files/adobestock_114712922.jpeg'),
(6, 'Persoon 6\r\n', '6666\r\n', 'persoon6@gmail.nl\r\n', 'https://vandijklaren.nl/templates/yootheme/cache/article-katten-60d17948.jpeg');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `artiekel`
--
ALTER TABLE `artiekel`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `gerecht`
--
ALTER TABLE `gerecht`
  ADD PRIMARY KEY (`id`),
  ADD KEY `keuken_id` (`keuken_id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexen voor tabel `gerecht_info`
--
ALTER TABLE `gerecht_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gerecht_id` (`gerecht_id`);

--
-- Indexen voor tabel `ingredieent`
--
ALTER TABLE `ingredieent`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gerecht_id` (`gerecht_id`),
  ADD KEY `artikel_id` (`artikel_id`);

--
-- Indexen voor tabel `keuken_type`
--
ALTER TABLE `keuken_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `artiekel`
--
ALTER TABLE `artiekel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT voor een tabel `gerecht`
--
ALTER TABLE `gerecht`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT voor een tabel `gerecht_info`
--
ALTER TABLE `gerecht_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT voor een tabel `ingredieent`
--
ALTER TABLE `ingredieent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT voor een tabel `keuken_type`
--
ALTER TABLE `keuken_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT voor een tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `gerecht`
--
ALTER TABLE `gerecht`
  ADD CONSTRAINT `keuken_id` FOREIGN KEY (`keuken_id`) REFERENCES `keuken_type` (`id`),
  ADD CONSTRAINT `type_id` FOREIGN KEY (`type_id`) REFERENCES `keuken_type` (`id`),
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Beperkingen voor tabel `ingredieent`
--
ALTER TABLE `ingredieent`
  ADD CONSTRAINT `artikel_id` FOREIGN KEY (`artikel_id`) REFERENCES `artiekel` (`id`),
  ADD CONSTRAINT `gerecht_id` FOREIGN KEY (`gerecht_id`) REFERENCES `gerecht` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
