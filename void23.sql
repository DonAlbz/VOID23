-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2026 at 04:27 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `void23`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `nome_categoria` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`id`, `nome_categoria`) VALUES
(1, 'Shoes'),
(2, 'T-Shirt'),
(3, 'Hoodie'),
(4, 'Cap'),
(5, 'Pants');

-- --------------------------------------------------------

--
-- Table structure for table `dettagli_ordini`
--

CREATE TABLE `dettagli_ordini` (
  `id` int(11) NOT NULL,
  `id_ordine` int(11) DEFAULT NULL,
  `id_prodotto` int(11) DEFAULT NULL,
  `quantita` int(11) NOT NULL,
  `prezzo_unitario` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dettagli_ordini`
--

INSERT INTO `dettagli_ordini` (`id`, `id_ordine`, `id_prodotto`, `quantita`, `prezzo_unitario`) VALUES
(1, 1, 3, 1, 62.99),
(2, 2, 2, 1, 29.99),
(3, 3, 3, 3, 62.99),
(4, 3, 6, 1, 63.00);

-- --------------------------------------------------------

--
-- Table structure for table `ordini`
--

CREATE TABLE `ordini` (
  `id` int(11) NOT NULL,
  `id_utente` int(11) DEFAULT NULL,
  `data_ordine` timestamp NOT NULL DEFAULT current_timestamp(),
  `totale` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ordini`
--

INSERT INTO `ordini` (`id`, `id_utente`, `data_ordine`, `totale`) VALUES
(1, 1, '2026-05-03 17:32:17', 67.99),
(2, 1, '2026-05-03 17:35:45', 34.99),
(3, 1, '2026-05-03 20:21:30', 251.97);

-- --------------------------------------------------------

--
-- Table structure for table `prodotti`
--

CREATE TABLE `prodotti` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `prezzo` decimal(10,2) NOT NULL,
  `descrizione` text DEFAULT NULL,
  `immagine` varchar(255) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `sconto_percentuale` int(11) DEFAULT 0,
  `badge` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prodotti`
--

INSERT INTO `prodotti` (`id`, `nome`, `prezzo`, `descrizione`, `immagine`, `id_categoria`, `sconto_percentuale`, `badge`) VALUES
(1, 'PROPAGANDA - HOODIE', 95.00, '', 'propaganda-ribs-hoodie-black.jpg', 3, 5, 'SALE'),
(2, 'PROPAGANDA - T-SHIRT', 60.00, 'T-shirt bianca minimal in cotone.', 'propaganda-ribs-lord-tee-black.jpg', 2, 0, 'NEW'),
(3, 'BLUESKIN - BAGGY SHORT', 69.99, '', 'blueskin-baggy-short-rbianco-91a.jpg', 5, 10, 'NEW'),
(4, 'VOLCOM - CAP', 24.99, 'Cappellino nero con ricamo.', 'volcom-full-stone-cheese-hat-black.jpg', 4, 0, 'NEW'),
(5, 'Vai alla fine della galleria di immagini\r\nVai all\'inizio della galleria di immagini\r\nOSIRIS - D3 200', 180.00, '', 'osiris-d3-2001-silver-black-holo.jpg', 1, 15, 'SALE'),
(6, 'THE BLUE SKIN - JEANS BAGGY', 70.00, NULL, 'the-blue-skin-jeans-baggy-black-red-red.jpg', 5, 10, 'SALE'),
(7, 'THE BLUE SKIN - JEANS BAGGY - BLUE', 70.00, NULL, 'the-blue-skin-jeans-baggy-turchese-black.jpg', 5, 5, 'NEW');

-- --------------------------------------------------------

--
-- Table structure for table `utenti`
--

CREATE TABLE `utenti` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `data_registrazione` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utenti`
--

INSERT INTO `utenti` (`id`, `nome`, `email`, `password`, `data_registrazione`) VALUES
(1, 'test', 'test@test.com', '$2y$10$btevZ6Ps4d1ukJRII.NrfuYPA31UJK5rwT/1Y5w5.QTx3XwBp81ke', '2026-05-03 17:19:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dettagli_ordini`
--
ALTER TABLE `dettagli_ordini`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ordine` (`id_ordine`),
  ADD KEY `id_prodotto` (`id_prodotto`);

--
-- Indexes for table `ordini`
--
ALTER TABLE `ordini`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utente` (`id_utente`);

--
-- Indexes for table `prodotti`
--
ALTER TABLE `prodotti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indexes for table `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dettagli_ordini`
--
ALTER TABLE `dettagli_ordini`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ordini`
--
ALTER TABLE `ordini`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `prodotti`
--
ALTER TABLE `prodotti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dettagli_ordini`
--
ALTER TABLE `dettagli_ordini`
  ADD CONSTRAINT `dettagli_ordini_ibfk_1` FOREIGN KEY (`id_ordine`) REFERENCES `ordini` (`id`),
  ADD CONSTRAINT `dettagli_ordini_ibfk_2` FOREIGN KEY (`id_prodotto`) REFERENCES `prodotti` (`id`);

--
-- Constraints for table `ordini`
--
ALTER TABLE `ordini`
  ADD CONSTRAINT `ordini_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `utenti` (`id`);

--
-- Constraints for table `prodotti`
--
ALTER TABLE `prodotti`
  ADD CONSTRAINT `prodotti_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorie` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
