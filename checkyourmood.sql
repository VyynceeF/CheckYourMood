-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mar 13 Décembre 2022 à 13:17
-- Version du serveur :  5.7.11
-- Version de PHP :  7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `checkyourmood`
--

-- --------------------------------------------------------

--
-- Structure de la table `humeur`
--

CREATE TABLE `humeur` (
  `codeHumeur` int(11) NOT NULL,
  `libelle` int(2) NOT NULL,
  `dateHumeur` date NOT NULL,
  `heure` varchar(30) NOT NULL,
  `idUtil` int(11) NOT NULL,
  `contexte` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `humeur`
--

INSERT INTO `humeur` (`codeHumeur`, `libelle`, `dateHumeur`, `heure`, `idUtil`, `contexte`) VALUES
(1, 4, '2022-11-07', '10:29:00', 1, 0x4a65207375697320656e20636f6cc3a8726520636172206a65206e202761692070617320617373657a20646f726d69);

-- --------------------------------------------------------

--
-- Structure de la table `libelle`
--

CREATE TABLE `libelle` (
  `codeLibelle` int(2) NOT NULL,
  `libelleHumeur` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emoji` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `libelle`
--

INSERT INTO `libelle` (`codeLibelle`, `libelleHumeur`, `emoji`) VALUES
(1, 'Admiration', '🤩'),
(2, 'Adoration', '😍'),
(3, 'Appréciation esthétique', 'TODO : insérer emoji'),
(4, 'Amusement', '😄'),
(5, 'Colère', '😡'),
(6, 'Anxiété', '😰'),
(7, 'Émerveillement', '🥰'),
(8, 'Malaise (embarrassement)', '😅'),
(9, 'Ennui', '🥱'),
(10, 'Calme (sérénité)', '😎'),
(11, 'Confusion', '🤨'),
(12, 'Envie (craving)', '🤤'),
(13, 'Dégoût', '🤮'),
(14, 'Douleur empathique', '💔'),
(15, 'Intérêt étonné, intrigué', '🤔'),
(16, 'Excitation (montée d’adrénaline)', 'TODO : insérer emoji'),
(17, 'Peur', '😨'),
(18, 'Horreur', '😱'),
(19, 'Intérêt', 'TODO : insérer emoji'),
(20, 'Joie', '😀'),
(21, 'Nostalgie', '💭'),
(22, 'Soulagement', '😌'),
(23, 'Romance', '👩‍❤️‍💋‍👨'),
(24, 'Tristesse', '🥺'),
(25, 'Satisfaction', '😊'),
(26, 'Désir sexuel', '😏'),
(27, 'Surprise', '😮');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `codeUtil` int(11) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `identifiant` varchar(30) NOT NULL UNIQUE,
  `mail` varchar(30) NOT NULL,
  `motDePasse` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`codeUtil`, `prenom`, `nom`, `identifiant`, `mail`, `motDePasse`) VALUES
(1, 'Jules', 'Blanchard', 'jules22b', 'jules.blanchard@iut-rodez.fr', 'root2022');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `humeur`
--
ALTER TABLE `humeur`
  ADD PRIMARY KEY (`codeHumeur`),
  ADD KEY `fk_Humeur_Libelle` (`libelle`),
  ADD KEY `fk_Humeur_Utilisateur` (`idUtil`);

--
-- Index pour la table `libelle`
--
ALTER TABLE `libelle`
  ADD PRIMARY KEY (`codeLibelle`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`codeUtil`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `humeur`
--
ALTER TABLE `humeur`
  MODIFY `codeHumeur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `libelle`
--
ALTER TABLE `libelle`
  MODIFY `codeLibelle` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `codeUtil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `humeur`
--
ALTER TABLE `humeur`
  ADD CONSTRAINT `fk_Humeur_Libelle` FOREIGN KEY (`libelle`) REFERENCES `libelle` (`codeLibelle`),
  ADD CONSTRAINT `fk_Humeur_Utilisateur` FOREIGN KEY (`idUtil`) REFERENCES `utilisateur` (`codeUtil`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
