-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Giu 08, 2018 alle 12:11
-- Versione del server: 10.1.31-MariaDB
-- Versione PHP: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `progetto`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `brand`
--

CREATE TABLE `brand` (
  `CodiceBrand` int(11) NOT NULL,
  `Nome` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `brand`
--

INSERT INTO `brand` (`CodiceBrand`, `Nome`) VALUES
(1, 'Supreme'),
(2, 'Gucci'),
(6, 'Nike'),
(7, 'Adidas'),
(8, 'Trasher'),
(9, 'Element'),
(10, 'Vans'),
(11, 'Santa Cruz'),
(12, 'Obey'),
(13, 'Lenz Lucia'),
(14, 'Nixon'),
(15, 'Balenciaga'),
(16, 'Kappa');

-- --------------------------------------------------------

--
-- Struttura della tabella `carte`
--

CREATE TABLE `carte` (
  `CodiceCarta` int(11) NOT NULL,
  `Oggetti` text COLLATE utf8_unicode_ci NOT NULL,
  `Data_Scadenza` datetime NOT NULL,
  `Pagato` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `carte`
--

INSERT INTO `carte` (`CodiceCarta`, `Oggetti`, `Data_Scadenza`, `Pagato`) VALUES
(27, '[{\"id\":\"3\",\"size\":\"L\",\"quantity\":2},{\"id\":\"2\",\"size\":\"XXL\",\"quantity\":1}]', '2018-05-16 21:11:32', 0),
(31, '[{\"id\":\"1\",\"size\":\"L\",\"quantity\":2},{\"id\":\"2\",\"size\":\"XL\",\"quantity\":2}]', '2018-05-18 14:39:10', 0),
(32, '[{\"id\":\"3\",\"size\":\"L\",\"quantity\":\"3\"},{\"id\":\"5\",\"size\":\"M\",\"quantity\":\"3\"},{\"id\":\"4\",\"size\":\"L\",\"quantity\":\"1\"}]', '2018-06-18 14:39:53', 2),
(35, '[{\"id\":\"25\",\"size\":\"L\",\"quantity\":\"1\"},{\"id\":\"10\",\"size\":\"38\",\"quantity\":\"1\"},{\"id\":\"3\",\"size\":\"XL\",\"quantity\":\"1\"}]', '2018-06-19 16:42:16', 2),
(36, '[{\"id\":\"3\",\"size\":\"XXL\",\"quantity\":5}]', '2018-06-19 16:52:43', 2),
(37, '[{\"id\":\"3\",\"size\":\"XXL\",\"quantity\":3}]', '2018-06-19 16:57:18', 0),
(38, '[{\"id\":\"3\",\"size\":\"XXL\",\"quantity\":\"3\"}]', '2018-06-19 17:10:27', 0),
(39, '[{\"id\":\"3\",\"size\":\"XXL\",\"quantity\":\"3\"}]', '2018-06-19 17:14:10', 2),
(40, '[{\"id\":\"9\",\"size\":\"S\",\"quantity\":\"3\"}]', '2018-06-19 17:14:39', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `categorie`
--

CREATE TABLE `categorie` (
  `CodiceCategoria` int(11) NOT NULL,
  `Nome` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Parent` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `categorie`
--

INSERT INTO `categorie` (`CodiceCategoria`, `Nome`, `Parent`) VALUES
(5, 'Magliette', 1),
(6, 'Pantaloni', 1),
(7, 'Scarpe', 1),
(8, 'Accessori', 1),
(9, 'Magliette', 2),
(10, 'Pantaloni', 2),
(11, 'Scarpe', 2),
(12, 'Accessori', 2),
(13, 'Abiti', 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `categoriepadri`
--

CREATE TABLE `categoriepadri` (
  `CodiceCategoriaPadre` int(11) NOT NULL,
  `Nome` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `categoriepadri`
--

INSERT INTO `categoriepadri` (`CodiceCategoriaPadre`, `Nome`) VALUES
(1, 'Uomo'),
(2, 'Donna');

-- --------------------------------------------------------

--
-- Struttura della tabella `prenotazioni`
--

CREATE TABLE `prenotazioni` (
  `CodicePrenotazione` int(11) NOT NULL,
  `CodiceProdotto` int(11) NOT NULL,
  `CodiceCarta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotti`
--

CREATE TABLE `prodotti` (
  `CodiceProdotto` int(11) NOT NULL,
  `Titolo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Prezzo` decimal(10,0) NOT NULL,
  `PrezzoOutlet` decimal(10,0) NOT NULL,
  `Brand` int(11) NOT NULL,
  `Categoria` int(11) NOT NULL,
  `Immagine` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Descrizione` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Featured` tinyint(4) NOT NULL DEFAULT '0',
  `Taglie` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `prodotti`
--

INSERT INTO `prodotti` (`CodiceProdotto`, `Titolo`, `Prezzo`, `PrezzoOutlet`, `Brand`, `Categoria`, `Immagine`, `Descrizione`, `Featured`, `Taglie`, `Deleted`) VALUES
(1, 'Felpa Supreme', '200', '175', 1, 5, '/progetto/images/prodotti/felpa_supreme_rossa.jpg', 'Felpa Supreme rossa adatta per ogni tipo di occassione.\r\nFirmata Supreme nella nuova collezione Autunno/Inverno 2018.', 0, 'L:102,XL:155,XXL:100', 0),
(2, 'Felpa Gucci Bianca', '400', '350', 2, 5, '/progetto/images/prodotti/felpa_gucci_bianca_uomo.jpg', 'Bellissima Felpa Gucci. Perfetta per l&#039;inverno, qualita&#039; ottima. Prezzo onesto.', 1, 'L:120,XL:102,XXL:81', 0),
(3, 'T-Shirt Gucci Nera', '250', '215', 2, 5, '/progetto/images/prodotti/8cc6552f47f3711482770709558dfa0e.jpg', 'Bellissima T-Shirt nera del brand italiano Gucci. Perfetta per l&#039;estate. Voto diesci.', 1, 'L:79,XL:98,XXL:94', 0),
(4, 'Pullover Supreme Arancione', '700', '550', 1, 5, '/progetto/images/prodotti/pullover_supreme_arancio.jpg', 'Pullover del noto brand emergente Supreme. Color arancio, molto visibile da tutti. Cosi&#039; non vi perdete.', 0, 'L:99,XL:100', 0),
(5, 'Canotta Supreme NBA', '250', '235', 1, 9, '/progetto/images/prodotti/3a5085f126785b74f224df3a8f44a02b.jpg', 'Bella, bellissima canotta Supreme.\r\nPerfetta per l&#039;estate.', 0, 'M:87,L:100,XL:100', 0),
(7, 'Scarpe Air Jordan', '500', '470', 6, 7, '/progetto/images/prodotti/70f35f872325051f640be54bb298878c.jpg', 'Bellissime Air Jordan 1.\r\nRosse e Bianche.\r\nBellissime', 1, '38:100,39:100,40:100', 0),
(8, 'T-Shirt Trasher Nera', '40', '35', 8, 5, '/progetto/images/prodotti/d9d1e71787a469c495c087ca66aa2b70.jpg', 'Una maglietta pulita incontra una stampa fichissima! La Skate Goat T-Shirt di Thasher fa centro con la sua stampa cool sul davanti. Questa maglietta &egrave; senza dubbio indossata da un vero skater.', 1, 'M:100,L:50,XL:15', 0),
(9, 'T-Shirt Element Nera', '20', '17', 9, 9, '/progetto/images/prodotti/acb643a828cd12008c0a8cdca59b423e.jpg', 'Una maglietta in linea con il tuo stile di vita tra natura e citt&agrave;. Maglietta in jersey in puro cotone da 160 g con logo artistico con foto stampato ed esclusiva etichetta a clip sulla manica sinistra', 1, 'S:50,M:50,L:20,XL:20', 0),
(10, 'Scarpe Vans Old School', '80', '70', 10, 11, '/progetto/images/prodotti/8d7b10ecf7744e3a2f858bbc931ee8e3.jpg', 'Stringate e dal profilo basso, le Vans Old Skool sono il primo modello a sfoggiare l&#039;iconica banda laterale. Le scarpe presentano una fodera interna e un collo imbottito per un supporto e una flessibilit superiori, una punta rinforzata pensata per durare nel tempo e l&#039;originale suola waffle Vans in gomma per una salda aderenza', 1, '35:10,36:15,37:5,38:8', 0),
(11, 'Element T-Shirt Grigia', '20', '18', 9, 5, '/progetto/images/prodotti/1e69e0cebaa57cd1d22c142440f2af44.jpg', 'Una maglietta con foto che rappresenta la tradizione dello skateboard da strada. La maglietta Log Jam ha una foto artistica stampata sul petto con effetto morbido al tatto.', 0, 'M:10,L:15,XL:5,XXL:20', 0),
(12, 'T-Shirt Trasher Classica Nera', '40', '30', 8, 9, '/progetto/images/prodotti/d72a290e97ce19853debf1be4f6499ad.jpg', 'I ragazzi di Thrasher hanno messo il tratto Thrasher sul petto di questa t-shirt e l&#039;hanno messo a fuoco! Con la Thrasher Flame T-Shirt puoi dimostrare il tuo amore ardente per skateboarding.', 0, 'S:20,M:25,L:10,XL:20', 0),
(13, 'T-Shirt Santa Cruz Nera', '20', '18', 11, 5, '/progetto/images/prodotti/550cf7ce1cdbd032af56eb2d3bf29eb2.jpg', 'E- una tavola arrotondata e divertente che rende facile prendere le onde, mantenendo fluidit&agrave; e divertimento. Brett Warner ha ideato questa tavola a Sydney, in Australia, dove il surf &egrave; praticato dalla popolazione femminile quanto da quella maschile.', 0, 'L:25,XL:30,XXL:20', 0),
(14, 'T-Shirt Obey Verde', '30', '25', 12, 9, '/progetto/images/prodotti/4b67ac9d9c37c497225c6968e2eae440.jpg', 'T-shirt di Obey con stampa del logo sul petto e sulla schiena.', 0, 'M:15,L:20,XL:30', 0),
(15, 'Occhiali Lenz Lucia', '200', '170', 13, 12, '/progetto/images/prodotti/677aa64d446f5aa22d5397af98d77e8b.jpg', 'Super &egrave; il marchio italiano che dal 2007 si &egrave; imposto in tutto il mondo per i suoi occhiali da sole in acetato di alta qualit&agrave;, lenti Zeiss per la massima protezione e colorazioni che spaziano dalle pi&ugrave; classiche alle pi&ugrave; estreme. \r\nQuesto nuovo modello da donna Lenz Lucia, combina la tecnologia Tuttolente alle linee femminili del modello Lucia. Una cornice metallica ne delinea la silhouette raffinata ed elegante. \r\nCome tutti gli occhiali Super, anche questo &egrave; Handmade in Italy.', 1, 'N/A:20', 0),
(16, 'Ochhiali Len Lucia V2.0', '180', '170', 13, 12, '/progetto/images/prodotti/246420e1125357cc34207b0f26ec5f2b.jpg', 'Super &egrave; il marchio italiano che dal 2007 si &egrave; imposto in tutto il mondo per i suoi occhiali da sole in acetato di alta qualit&agrave;, lenti Zeiss per la massima protezione e colorazioni che spaziano dalle pi&ugrave; classiche alle pi&ugrave; estreme. \r\nIl modello Lucia, disegnato per le donne, &egrave; caratterizzato da una montatura molto sottile con uno stile molto personale e lenti rotonde. \r\nCome tutti gli occhiali Super, anche questo &egrave; Handmade in Italy.', 0, 'N/A:15', 0),
(17, 'Orologio Nixon', '200', '190', 14, 8, '/progetto/images/prodotti/9252d7042d368488688ac70fa8d3eb9b.jpg', 'Nuova versione del classico Time Teller, leggermente pi&ugrave; grande del modello tradizionale. Orologio analogico di Nixon, cassa in acciaio inox da 31 mm, vetro minerale temprato, resistente fino a 100 m di profondit&agrave;. Bracciale in acciaio inox.', 1, 'N/A:10', 0),
(18, 'Air Max 97 Grigia', '200', '180', 6, 7, '/progetto/images/prodotti/50fc4d058a1b5e50f7da6b44506e44c3.jpg', 'Il modello Nike Air Max 97 ha cambiato per sempre il mondo del running con la sua rivoluzionaria unit&agrave; Nike Air a tutta lunghezza. La scarpa Nike Air Max 97 Ultra &#039;17 rivisita il design originale con una struttura in mesh e maglia per una maggiore leggerezza e un look pi&ugrave; elegante.', 0, '38:20,39:15,40:15,42:10', 0),
(19, 'Adidas Derupt Runner', '100', '90', 7, 11, '/progetto/images/prodotti/5cef25b129ead2f57312122e86a7bea3.jpg', 'Deerupt &egrave; la prova inconfutabile che un design minimal pu&ograve; essere grande. Queste trainer leggere rinnovano lo stile running adidas degli anni &#039;80. L&#039;ammortizzazione interna a zone assicura morbidezza e comfort immediati.', 0, '35:15,36:15,38:10,40:5', 0),
(20, 'Balenciaga Bianca', '300', '250', 15, 7, '/progetto/images/prodotti/f43ff2e4b9c2c0b38912c0638c3d19d2.jpg', 'Tomaia in maglia stretch. Profilo a costine. Logo. Suola in gomma. Mini me: Lo stile per i pi&ugrave; piccoli ispirato alle collezioni dei grandi.', 0, '38:10,40:12,42:14', 0),
(21, 'Scarpa Gucci Bianca', '600', '550', 2, 7, '/progetto/images/prodotti/3ead2f0ef92c325226cfe2b5441efe8c.jpg', 'Alessandro Michele presenta la sneaker bassa &#039;Ace&#039; con applicazione serpente ricamata sul dettaglio Web. In pelle bianca con dettaglio Web verde e rosso. Applicazione serpente', 0, '39:10,40:12,42:15', 0),
(22, 'Scarpa Gucci Bianca V2.0', '800', '770', 2, 11, '/progetto/images/prodotti/8f3a73f512e1aa465dd83e1cf8320c90.jpg', 'Designed with a thick sole and bulky construction, the sneaker has a retro influence in leather with a vintage Gucci logo inspired by prints from the 1980s. Ivory leather with ...', 0, '36:5,38:10,40:15', 0),
(23, 'Scarpa Gucci Ape', '600', '550', 2, 7, '/progetto/images/prodotti/a33166c5030499d7b2097add95519233.jpg', 'Classica sneaker bassa con l&#039;iconico ricamo ape Gucci color oro su dettaglio Web. In pelle bianca con dettaglio Web laterale in gros-grain verde/rosso/verde e ricamo ape', 0, '40:10,42:15', 0),
(24, 'Pantaloni Blu Kappa', '320', '300', 16, 6, '/progetto/images/prodotti/305cc036266097bb5573cc9231872db7.jpg', 'Pantalone Kappa blu / bianco con elastico in vita - bande laterali logate a contrasto - tasche laterali - tasche posteriori - Composizione: 100% poliestere.', 0, 'L:10,XL:10,XXL:15', 0),
(25, 'Pantaloni Neri Adidias', '80', '70', 7, 10, '/progetto/images/prodotti/ac63960fce467773672edd82d8ddadfc.jpg', 'Un salto indietro nella moda degli anni 90, questi pantaloni Adibreak Popper da donna di adidas Originals aggiungono un tocco vintage al tuo guardaroba. Realizzati in tessuto poliestere e con taglio ampio, i pantaloni sono dotati di cintura elasticizzata per il massimo comfort e delle pieghette classiche sul davanti. Rifiniti con le caratteristiche 3 Strisce lungo le gambe e il logo del Trifoglio al lato', 0, 'L:13', 0),
(26, 'Abito Adidas Nero', '70', '60', 7, 13, '/progetto/images/prodotti/4caeb86263a1513a2e075a75bfb96d6b.jpg', 'Le inconfondibili 3 strisce sono da sempre sinonimo di adidas. Il brand rende omaggio alla sua straordinaria storia riproponendo un leggendario design ripensato per le citt&agrave; moderne. Ispirato a una celebre T-shirt degli anni &lsquo;70, questo abito sfoggia un look sportivo impreziosito da esclusivi dettagli 3-Stripes. La struttura leggera e leggermente elasticizzata presenta degli spacchetti laterali e 3 strisce lungo le maniche', 0, 'M:10,L:15,XL:5', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `CodiceUtente` int(11) NOT NULL,
  `Nome_Cognome` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(175) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Data_Iscrizione` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Ultimo_Accesso` datetime NOT NULL,
  `Permessi` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`CodiceUtente`, `Nome_Cognome`, `Email`, `Password`, `Data_Iscrizione`, `Ultimo_Accesso`, `Permessi`) VALUES
(1, 'Domenico Sarcina', 'domenico@sito.it', '$2y$10$tDh2qHzX8p1o2CyPtXOLj.DwtwFjo3BnW3KQy430eHYfPq3eO5iZy', '2018-05-12 21:51:25', '2018-06-08 12:08:57', 'admin,editor'),
(5, 'Marco Rossi', 'marco@sito.it', '$2y$10$VU9xvJ7bDmcAknMyM/5BmOHn/7/xAtfxDJN7UIgwhTIQrX1GEEThG', '2018-05-13 20:34:39', '2018-05-13 20:37:58', 'editor'),
(6, 'Giuseppe Verdi', 'giuseppe@sito.it', '$2y$10$k50xGj8x8Czpnw4igSQsMeQR9LSs5KagtSfz3KlqKENOZmJCed3tG', '2018-05-19 15:20:54', '2018-05-20 16:56:33', 'editor');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`CodiceBrand`);

--
-- Indici per le tabelle `carte`
--
ALTER TABLE `carte`
  ADD PRIMARY KEY (`CodiceCarta`);

--
-- Indici per le tabelle `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`CodiceCategoria`),
  ADD KEY `Parent` (`Parent`);

--
-- Indici per le tabelle `categoriepadri`
--
ALTER TABLE `categoriepadri`
  ADD PRIMARY KEY (`CodiceCategoriaPadre`);

--
-- Indici per le tabelle `prenotazioni`
--
ALTER TABLE `prenotazioni`
  ADD PRIMARY KEY (`CodicePrenotazione`),
  ADD KEY `prenotazioni_ibfk_1` (`CodiceProdotto`),
  ADD KEY `CodiceCarta` (`CodiceCarta`);

--
-- Indici per le tabelle `prodotti`
--
ALTER TABLE `prodotti`
  ADD PRIMARY KEY (`CodiceProdotto`),
  ADD KEY `Brand` (`Brand`),
  ADD KEY `Categoria` (`Categoria`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`CodiceUtente`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `brand`
--
ALTER TABLE `brand`
  MODIFY `CodiceBrand` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT per la tabella `carte`
--
ALTER TABLE `carte`
  MODIFY `CodiceCarta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT per la tabella `categorie`
--
ALTER TABLE `categorie`
  MODIFY `CodiceCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT per la tabella `categoriepadri`
--
ALTER TABLE `categoriepadri`
  MODIFY `CodiceCategoriaPadre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `prenotazioni`
--
ALTER TABLE `prenotazioni`
  MODIFY `CodicePrenotazione` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `prodotti`
--
ALTER TABLE `prodotti`
  MODIFY `CodiceProdotto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `CodiceUtente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `categorie`
--
ALTER TABLE `categorie`
  ADD CONSTRAINT `categorie_ibfk_1` FOREIGN KEY (`Parent`) REFERENCES `categoriepadri` (`CodiceCategoriaPadre`);

--
-- Limiti per la tabella `prenotazioni`
--
ALTER TABLE `prenotazioni`
  ADD CONSTRAINT `prenotazioni_ibfk_1` FOREIGN KEY (`CodiceProdotto`) REFERENCES `prodotti` (`CodiceProdotto`),
  ADD CONSTRAINT `prenotazioni_ibfk_2` FOREIGN KEY (`CodiceCarta`) REFERENCES `carte` (`CodiceCarta`);

--
-- Limiti per la tabella `prodotti`
--
ALTER TABLE `prodotti`
  ADD CONSTRAINT `prodotti_ibfk_1` FOREIGN KEY (`Brand`) REFERENCES `brand` (`CodiceBrand`),
  ADD CONSTRAINT `prodotti_ibfk_2` FOREIGN KEY (`Categoria`) REFERENCES `categorie` (`CodiceCategoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
