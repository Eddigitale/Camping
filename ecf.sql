-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 03, 2020 at 03:35 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecf`
--

-- --------------------------------------------------------

--
-- Table structure for table `accompagnants`
--

CREATE TABLE `accompagnants` (
  `id` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `date_naissance` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `date_naissance` varchar(20) NOT NULL,
  `adresse` text NOT NULL,
  `code_postal` int(11) NOT NULL,
  `ville` varchar(20) NOT NULL,
  `tel` int(12) NOT NULL,
  `pays` varchar(20) NOT NULL,
  `mail` text NOT NULL,
  `immatriculation` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `detail_sejour`
--

CREATE TABLE `detail_sejour` (
  `id` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `date_arrivee` varchar(20) NOT NULL,
  `date_depart` varchar(20) NOT NULL,
  `animaux` varchar(20) DEFAULT NULL,
  `nombre_jours` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `emplacement`
--

CREATE TABLE `emplacement` (
  `id` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `type_location` varchar(20) NOT NULL,
  `disponibilite` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `emplacement`
--

INSERT INTO `emplacement` (`id`, `id_client`, `type_location`, `disponibilite`) VALUES
(1, 0, 'tente', 'disponible'),
(2, 0, 'tente', 'disponible'),
(3, 0, 'tente', 'disponible'),
(4, 0, 'tente', 'disponible'),
(5, 0, 'tente', 'disponible'),
(6, 0, 'caravane', 'disponible'),
(7, 0, 'caravane', 'disponible'),
(8, 0, 'caravane', 'disponible'),
(9, 0, 'caravane', 'disponible'),
(10, 0, 'caravane', 'disponible'),
(11, 0, 'mobilhome', 'disponible'),
(12, 0, 'mobilhome', 'disponible'),
(13, 0, 'mobilhome', 'disponible'),
(14, 0, 'mobilhome', 'disponible'),
(15, 0, 'mobilhome', 'disponible'),
(16, 0, 'voiture', 'disponible'),
(17, 0, 'voiture', 'disponible'),
(18, 0, 'voiture', 'disponible'),
(19, 0, 'voiture', 'disponible'),
(20, 0, 'voiture', 'disponible');

-- --------------------------------------------------------

--
-- Table structure for table `location_emplacement`
--

CREATE TABLE `location_emplacement` (
  `id` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `emplacement` varchar(50) NOT NULL,
  `type_location` varchar(50) NOT NULL,
  `electricite` varchar(20) DEFAULT NULL,
  `frigo` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `paiement`
--

CREATE TABLE `paiement` (
  `id` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `prix` int(11) NOT NULL,
  `moyen_paiement` varchar(20) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `date` varchar(20) NOT NULL,
  `signature` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accompagnants`
--
ALTER TABLE `accompagnants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK` (`id_client`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detail_sejour`
--
ALTER TABLE `detail_sejour`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK2` (`id_client`);

--
-- Indexes for table `emplacement`
--
ALTER TABLE `emplacement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location_emplacement`
--
ALTER TABLE `location_emplacement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK3` (`id_client`);

--
-- Indexes for table `paiement`
--
ALTER TABLE `paiement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk` (`id_client`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accompagnants`
--
ALTER TABLE `accompagnants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=395;

--
-- AUTO_INCREMENT for table `detail_sejour`
--
ALTER TABLE `detail_sejour`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emplacement`
--
ALTER TABLE `emplacement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `location_emplacement`
--
ALTER TABLE `location_emplacement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paiement`
--
ALTER TABLE `paiement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accompagnants`
--
ALTER TABLE `accompagnants`
  ADD CONSTRAINT `accompagnants_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id`);

--
-- Constraints for table `detail_sejour`
--
ALTER TABLE `detail_sejour`
  ADD CONSTRAINT `detail_sejour_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id`);

--
-- Constraints for table `location_emplacement`
--
ALTER TABLE `location_emplacement`
  ADD CONSTRAINT `location_emplacement_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id`);

--
-- Constraints for table `paiement`
--
ALTER TABLE `paiement`
  ADD CONSTRAINT `paiement_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
