-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 20 juin 2023 à 19:46
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `footclick`
--

-- --------------------------------------------------------

--
-- Structure de la table `arbitres`
--

CREATE TABLE `arbitres` (
  `IdArbitre` int(11) NOT NULL,
  `NomArbitre` varchar(255) NOT NULL,
  `Nationalite` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `arbitres`
--

INSERT INTO `arbitres` (`IdArbitre`, `NomArbitre`, `Nationalite`) VALUES
(1, 'Mariocchi', 'Italien'),
(2, 'Dupont', 'Francais'),
(3, 'Smith', 'Anglais');

-- --------------------------------------------------------

--
-- Structure de la table `clubs`
--

CREATE TABLE `clubs` (
  `IdClub` int(11) NOT NULL,
  `NomClub` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `clubs`
--

INSERT INTO `clubs` (`IdClub`, `NomClub`) VALUES
(1, 'OM'),
(2, 'PSG'),
(3, 'Auxerre'),
(4, 'Pau');

-- --------------------------------------------------------

--
-- Structure de la table `feuilledematch`
--

CREATE TABLE `feuilledematch` (
  `IdFeuille` int(11) NOT NULL,
  `DateRencontre` date NOT NULL,
  `Lieu` varchar(255) NOT NULL,
  `IdEquipe1` int(11) NOT NULL,
  `IdEquipe2` int(11) NOT NULL,
  `IdArbitrePrinc` int(11) NOT NULL,
  `IdArbitreAss1` int(11) NOT NULL,
  `IdArbitreAss2` int(11) NOT NULL,
  `complete` tinyint(1) NOT NULL,
  `IdFeuilleDeroulement` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `feuilledematch`
--

INSERT INTO `feuilledematch` (`IdFeuille`, `DateRencontre`, `Lieu`, `IdEquipe1`, `IdEquipe2`, `IdArbitrePrinc`, `IdArbitreAss1`, `IdArbitreAss2`, `complete`, `IdFeuilleDeroulement`) VALUES
(1, '2023-06-14', 'Paris', 1, 2, 1, 2, 3, 0, NULL),
(2, '2023-07-22', 'Pau', 3, 4, 1, 2, 3, 0, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `arbitres`
--
ALTER TABLE `arbitres`
  ADD PRIMARY KEY (`IdArbitre`);

--
-- Index pour la table `clubs`
--
ALTER TABLE `clubs`
  ADD PRIMARY KEY (`IdClub`);

--
-- Index pour la table `feuilledematch`
--
ALTER TABLE `feuilledematch`
  ADD PRIMARY KEY (`IdFeuille`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `arbitres`
--
ALTER TABLE `arbitres`
  MODIFY `IdArbitre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `clubs`
--
ALTER TABLE `clubs`
  MODIFY `IdClub` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `feuilledematch`
--
ALTER TABLE `feuilledematch`
  MODIFY `IdFeuille` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
