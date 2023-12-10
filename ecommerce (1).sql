-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 10 déc. 2023 à 23:17
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ecommerce`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `date_creation` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `login`, `password`, `date_creation`) VALUES
(1, 'khaled', '12345', '2023-12-08'),
(2, 'imem', '123', '2023-12-08'),
(3, 'amin', '1234', '2023-12-08'),
(4, 'admin', '123456', '2023-12-08'),
(5, 'admintest', '0000', '2023-12-08'),
(6, 'testa', '123', '2023-12-08'),
(7, 'New_admin', '123', '2023-12-10');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `libelle` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT current_timestamp(),
  `icone` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `libelle`, `description`, `date_creation`, `icone`) VALUES
(1, 'LaLiga', 'Spain League', '2022-10-31 20:51:03', 'laliga.png'),
(3, 'Premier League', 'England league', '2022-11-02 19:41:49', 'premierleague.png'),
(6, 'Ligue 1', 'France league', '2022-11-11 20:08:52', 'ligue1.png'),
(9, 'Bundesliga', 'Germany league', '2022-11-18 18:47:26', 'Bundesliga.png'),
(12, 'SERIE A', 'Italian League', '2023-12-08 23:24:32', 'seriea.png');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `total` decimal(10,0) NOT NULL,
  `valide` int(11) NOT NULL DEFAULT 0,
  `date_creation` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id`, `id_client`, `total`, `valide`, `date_creation`) VALUES
(44, 14, 210, 1, '2023-12-10 20:43:01'),
(47, 14, 229, 0, '2023-12-10 22:34:57'),
(48, 14, 1429, 0, '2023-12-10 22:52:00');

-- --------------------------------------------------------

--
-- Structure de la table `commande1`
--

CREATE TABLE `commande1` (
  `idCommande` int(11) NOT NULL,
  `email` varchar(500) NOT NULL,
  `phone` varchar(8) NOT NULL,
  `addresse` varchar(255) NOT NULL,
  `postalCode` varchar(4) NOT NULL,
  `paymentType` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commande1`
--

INSERT INTO `commande1` (`idCommande`, `email`, `phone`, `addresse`, `postalCode`, `paymentType`) VALUES
(44, 'jmal.khaled@enis.tn', '27818307', 'taniour', '2450', 'cheque'),
(45, 'jmal.khaled@enis.tn', '27818307', 'lkgnzjk', '2011', 'cheque'),
(46, 'jmal.khaled@enis.tn', '25256255', 'xxxx', '0000', 'espece');

-- --------------------------------------------------------

--
-- Structure de la table `ligne_commande`
--

CREATE TABLE `ligne_commande` (
  `id` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `id_commande` int(11) NOT NULL,
  `prix` decimal(10,0) NOT NULL,
  `quantite` int(11) NOT NULL,
  `total` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ligne_commande`
--

INSERT INTO `ligne_commande` (`id`, `id_produit`, `id_commande`, `prix`, `quantite`, `total`) VALUES
(44, 19, 44, 105, 2, 210),
(45, 18, 47, 114, 2, 229),
(46, 14, 48, 120, 10, 1200),
(47, 18, 48, 114, 2, 229);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id` int(11) NOT NULL,
  `libelle` varchar(100) NOT NULL,
  `prix` decimal(10,0) NOT NULL,
  `discount` int(11) NOT NULL,
  `id_categorie` int(11) NOT NULL,
  `date_creation` datetime NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` varchar(150) NOT NULL,
  `quantite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `libelle`, `prix`, `discount`, `id_categorie`, `date_creation`, `description`, `image`, `quantite`) VALUES
(14, 'AC Milan 2024 kit', 120, 0, 12, '2023-12-08 00:00:00', 'Ac Milan jersey', '6573980b0b227milan1.png', 13),
(16, 'Barcelona kit 2023/2024', 100, 0, 1, '2023-12-08 00:00:00', 'Barcelona jersey', '65739f392305fbarcelona.png', 15),
(17, 'Arsenal kit 2023/2024 modified', 90, 0, 3, '2023-12-08 00:00:00', 'Arsenal jersey', '65739fd79213bArsenal_2023-24_Youth_Home_Kit_-removebg-preview.png', 12),
(18, 'Manchester City kit 2023/2024', 130, 0, 3, '2023-12-09 00:00:00', 'Man city Jersey', '6573a00c1c06f0rUpfmEcYvroYLw-removebg-preview.png', 19),
(19, 'Napoli kit 2023/2024', 105, 0, 12, '2023-12-09 00:00:00', 'Napoli Jersey', '6573a056debdd7704-large_default-removebg-preview.png', 5),
(20, 'Paris Saint German kit 2023/2024', 85, 0, 6, '2023-12-09 00:00:00', 'PSG Jersey', '6573a0b1d2533psg_23_24_home_kit__16_-removebg-preview.png', 20),
(21, 'Bayern Munich kit 2023/2024', 100, 0, 9, '2023-12-09 00:00:00', 'Bayern Jersey ', '6573a0e09f134New-White-Bayern-Jersey-2023-2024-removebg-preview.png', 3),
(22, 'Borussia Dortmund kit 2023/2024', 120, 0, 9, '2023-12-09 00:00:00', 'BVB Jersey ', '6573a10e56735770604_01_puma_borussia_dortmund_home_jsy_2023_24_01-removebg-preview.png', 12),
(24, 'Marseille kit 2023/2024', 100, 9, 6, '2023-12-10 00:00:00', 'Marseille jersey ', '6575f995e1b09I2oVBdIHHJm3dlg-removebg-preview.png', 15);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `login` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `date_creation` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `login`, `password`, `date_creation`) VALUES
(1, 'mjamaoui', '123456', '2022-10-30'),
(2, 'user', '123456789', '2022-10-30'),
(3, 'mjamaoui', 'mjamaoui', '2022-11-02'),
(4, 'mjamaoui', 'mjamaoui', '2022-11-04'),
(5, 'mjamaoui', '123456', '2022-11-11'),
(6, 'mjamaoui', '123456', '2022-11-14'),
(14, 'test', '123', '2023-12-08'),
(15, 'test1', '123', '2023-12-08'),
(16, 'New_user', '123', '2023-12-10');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id` (`id`);

--
-- Index pour la table `commande1`
--
ALTER TABLE `commande1`
  ADD PRIMARY KEY (`idCommande`),
  ADD KEY `idCommande` (`idCommande`);

--
-- Index pour la table `ligne_commande`
--
ALTER TABLE `ligne_commande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_produit` (`id_produit`),
  ADD KEY `id_commande` (`id_commande`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categorie` (`id_categorie`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT pour la table `commande1`
--
ALTER TABLE `commande1`
  MODIFY `idCommande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT pour la table `ligne_commande`
--
ALTER TABLE `ligne_commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `ligne_commande`
--
ALTER TABLE `ligne_commande`
  ADD CONSTRAINT `ligne_commande_ibfk_1` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ligne_commande_ibfk_2` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
