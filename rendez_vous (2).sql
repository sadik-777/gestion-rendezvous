-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 27, 2025 at 01:28 AM
-- Server version: 8.0.40
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rendez_vous`
--

-- --------------------------------------------------------

--
-- Table structure for table `docteurs`
--

CREATE TABLE `docteurs` (
  `id` int NOT NULL,
  `nom` varchar(200) DEFAULT NULL,
  `tel` varchar(200) DEFAULT NULL,
  `specialites_id` int DEFAULT NULL,
  `ville_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `docteurs`
--

INSERT INTO `docteurs` (`id`, `nom`, `tel`, `specialites_id`, `ville_id`, `user_id`) VALUES
(27, 'rahim', '0677331213', 2, 2, 32),
(28, 'fatihi', '06009809', 1, 1, 33),
(29, 'Dr.riyad', '0677584618', 20, 1, 36),
(30, 'sadik Ayyach', '06997697894', 15, 1, 38),
(31, 'khalid', '0600190022', 3, 5, 40),
(32, 'jamal', '0699700767', 4, 4, 41),
(33, 'aziz', '0633142122', 5, 6, 42),
(34, 'hafid', '075432977', 5, 7, 43),
(35, 'Youssef', '0755432143', 6, 8, 44),
(36, 'salah', '0755231299', 7, 10, 45),
(37, 'ayoub', '0706886655', 9, 11, 46),
(38, 'noaman', '0688070809', 20, 12, 47),
(39, 'ayman', '0701020304', 10, 13, 48),
(40, 'mohammed', '070901120', 11, 14, 49),
(41, 'Hassana', '0705030201', 12, 15, 50),
(42, 'Nabil', '0716226188', 13, 16, 51),
(43, 'ennah', '0677331201', 14, 1, 52),
(44, 'ali zarbaoui', '070999752', 15, 3, 53);

-- --------------------------------------------------------

--
-- Table structure for table `patientes`
--

CREATE TABLE `patientes` (
  `id` int NOT NULL,
  `nom` varchar(200) DEFAULT NULL,
  `prenom` varchar(200) DEFAULT NULL,
  `tel` varchar(200) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `patientes`
--

INSERT INTO `patientes` (`id`, `nom`, `prenom`, `tel`, `date_naissance`, `user_id`) VALUES
(10, 'Ayyach', 'sadikk', '0699769789', '2025-06-22', 24),
(14, 'lfairass', 'sadik', '069976978933', '2004-07-19', 28),
(15, 'hala9', 'ra7ma', '1234321', '2004-07-20', 29),
(16, 'ayyach', 'sadik', '5', '2004-07-03', 30),
(18, 'saber', 'alami', '0699769988', '2004-02-22', 35),
(19, 'marid', 'marid', '06997697890', '2004-11-11', 37),
(20, 'samet', 'riyad', '0655443322', '2000-11-02', 39),
(21, 'essadik', 'ayyach', '06997697899', '2000-07-19', 54);

-- --------------------------------------------------------

--
-- Table structure for table `rendezvous`
--

CREATE TABLE `rendezvous` (
  `id` int NOT NULL,
  `date` datetime DEFAULT NULL,
  `patientes_id` int DEFAULT NULL,
  `docteurs_id` int DEFAULT NULL,
  `state` enum('Confirmée','En attente','Annulée') DEFAULT 'En attente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rendezvous`
--

INSERT INTO `rendezvous` (`id`, `date`, `patientes_id`, `docteurs_id`, `state`) VALUES
(95, '2025-06-24 23:53:00', 16, 27, 'En attente'),
(96, '2025-06-24 23:53:00', 16, 27, 'En attente'),
(97, '2025-06-24 23:53:00', 16, 27, 'En attente'),
(98, '2025-06-24 23:53:00', 16, 27, 'En attente'),
(99, '2025-06-24 23:53:00', 16, 27, 'En attente'),
(100, '2025-06-24 23:53:00', 16, 27, 'En attente'),
(101, '2025-06-24 23:53:00', 16, 27, 'En attente'),
(102, '2025-06-24 23:53:00', 16, 27, 'En attente'),
(103, '2025-06-24 23:53:00', 16, 27, 'En attente'),
(104, '2025-06-24 23:53:00', 16, 27, 'En attente'),
(105, '2025-06-24 23:53:00', 16, 27, 'En attente'),
(106, '2025-06-24 23:53:00', 16, 27, 'En attente'),
(113, '2025-06-24 20:58:00', 10, 28, 'En attente'),
(114, '2025-06-24 20:58:00', 10, 28, 'En attente'),
(115, '2025-06-24 20:58:00', 10, 28, 'En attente'),
(116, '2025-06-24 20:58:00', 10, 28, 'En attente'),
(117, '2025-06-24 20:58:00', 10, 28, 'En attente'),
(118, '2025-06-24 20:58:00', 10, 28, 'En attente'),
(119, '2025-06-24 20:58:00', 10, 28, 'En attente'),
(120, '2025-06-24 20:58:00', 10, 28, 'En attente'),
(121, '2025-06-24 20:58:00', 10, 28, 'En attente'),
(122, '2025-06-24 20:58:00', 10, 28, 'En attente'),
(123, '2025-06-24 20:58:00', 10, 28, 'En attente'),
(124, '2025-06-24 20:58:00', 10, 28, 'En attente'),
(125, '2025-06-24 20:58:00', 10, 28, 'En attente'),
(126, '2025-06-24 20:58:00', 10, 28, 'En attente'),
(127, '2025-06-24 20:58:00', 10, 28, 'En attente'),
(128, '2025-06-24 20:58:00', 10, 28, 'En attente'),
(129, '2025-06-24 20:58:00', 10, 28, 'En attente'),
(130, '2025-06-24 20:58:00', 10, 28, 'En attente'),
(131, '2025-06-24 20:58:00', 10, 28, 'En attente'),
(132, '2025-06-24 20:58:00', 10, 28, 'En attente'),
(133, '2025-06-24 12:07:00', 10, 27, 'En attente'),
(134, '2025-06-24 12:07:00', 10, 27, 'En attente'),
(135, '2025-06-24 12:07:00', 10, 27, 'En attente'),
(136, '2025-06-25 12:48:00', 18, 29, 'En attente'),
(137, '2025-06-25 12:48:00', 18, 29, 'En attente'),
(138, '2025-06-25 12:58:00', 18, 27, 'En attente'),
(139, '2025-06-25 12:59:00', 18, 28, 'En attente'),
(140, '2025-06-26 13:22:00', 19, 30, 'En attente'),
(141, '2025-06-26 14:27:00', 14, 30, 'En attente'),
(142, '2025-06-26 14:27:00', 14, 30, 'En attente'),
(143, '2025-06-26 14:36:00', 14, 27, 'En attente'),
(144, '2025-06-26 17:45:00', 20, 30, 'En attente'),
(145, '2025-06-26 17:45:00', 20, 30, 'En attente'),
(146, '2025-06-26 17:45:00', 20, 30, 'En attente'),
(147, '2025-06-26 17:45:00', 20, 30, 'En attente'),
(148, '2025-06-26 17:45:00', 20, 30, 'En attente'),
(149, '2025-06-26 17:45:00', 20, 30, 'En attente'),
(150, '2025-06-26 17:45:00', 20, 30, 'En attente'),
(151, '2025-06-26 17:45:00', 20, 30, 'En attente'),
(152, '2025-06-26 17:45:00', 20, 30, 'En attente'),
(153, '2025-06-26 17:45:00', 20, 30, 'En attente'),
(154, '2025-06-26 17:45:00', 20, 30, 'En attente'),
(155, '2025-06-26 17:45:00', 20, 30, 'En attente'),
(156, '2025-06-26 17:45:00', 20, 30, 'En attente'),
(157, '2025-06-26 17:45:00', 20, 30, 'En attente'),
(158, '2025-06-26 17:45:00', 20, 30, 'En attente'),
(159, '2025-06-26 17:45:00', 20, 30, 'En attente'),
(160, '2025-06-26 17:45:00', 20, 30, 'En attente'),
(161, '2025-06-26 17:45:00', 20, 30, 'En attente'),
(162, '2025-06-26 17:45:00', 20, 27, 'En attente'),
(163, '2025-06-26 17:45:00', 20, 27, 'En attente'),
(164, '2025-06-26 17:45:00', 20, 27, 'En attente'),
(165, '2025-06-26 17:45:00', 20, 27, 'En attente'),
(166, '2025-06-26 17:45:00', 20, 27, 'En attente'),
(167, '2025-06-26 17:45:00', 20, 27, 'En attente'),
(168, '2025-06-26 17:45:00', 20, 27, 'En attente'),
(169, '2025-06-26 17:45:00', 20, 27, 'En attente'),
(170, '2025-06-26 17:45:00', 20, 27, 'En attente'),
(171, '2025-06-26 17:45:00', 20, 27, 'En attente'),
(172, '2025-06-26 17:45:00', 20, 27, 'En attente'),
(173, '2025-06-26 17:45:00', 20, 27, 'En attente'),
(174, '2025-06-26 17:45:00', 20, 27, 'En attente'),
(175, '2025-06-26 17:45:00', 20, 27, 'En attente'),
(176, '2025-06-26 17:45:00', 20, 27, 'En attente'),
(177, '2025-06-26 17:45:00', 20, 27, 'En attente'),
(178, '2025-06-26 17:45:00', 20, 27, 'En attente'),
(179, '2025-06-26 17:45:00', 20, 27, 'En attente'),
(180, '2025-06-26 17:45:00', 20, 27, 'En attente'),
(181, '2025-06-26 17:46:00', 20, 29, 'En attente'),
(182, '2025-06-26 17:46:00', 20, 29, 'En attente'),
(183, '2025-06-26 17:46:00', 20, 29, 'En attente'),
(184, '2025-06-26 17:46:00', 20, 29, 'En attente'),
(185, '2025-06-26 17:46:00', 20, 29, 'En attente'),
(186, '2025-06-26 17:46:00', 20, 29, 'En attente'),
(187, '2025-06-26 17:46:00', 20, 29, 'En attente'),
(188, '2025-06-26 17:46:00', 20, 29, 'En attente'),
(189, '2025-06-26 17:46:00', 20, 29, 'En attente'),
(190, '2025-06-26 17:46:00', 20, 29, 'En attente'),
(191, '2025-06-26 17:46:00', 20, 29, 'En attente'),
(192, '2025-06-26 17:46:00', 20, 29, 'En attente'),
(193, '2025-06-26 17:46:00', 20, 29, 'En attente'),
(194, '2025-06-26 17:46:00', 20, 29, 'En attente'),
(195, '2025-06-26 17:46:00', 20, 29, 'En attente'),
(196, '2025-06-26 17:46:00', 20, 29, 'En attente'),
(197, '2025-06-26 17:46:00', 20, 29, 'En attente'),
(198, '2025-06-26 17:46:00', 20, 29, 'En attente'),
(199, '2025-06-26 17:46:00', 20, 29, 'En attente'),
(200, '2025-06-26 17:46:00', 20, 29, 'En attente'),
(201, '2025-06-26 17:46:00', 20, 29, 'En attente'),
(202, '2025-06-26 17:46:00', 20, 29, 'En attente'),
(203, '2025-06-26 17:46:00', 20, 29, 'En attente'),
(204, '2025-06-26 17:46:00', 20, 29, 'En attente'),
(205, '2025-06-26 17:49:00', 20, 28, 'En attente'),
(206, '2025-06-26 17:49:00', 20, 28, 'En attente'),
(207, '2025-06-26 17:49:00', 20, 28, 'En attente'),
(208, '2025-06-26 17:49:00', 20, 28, 'En attente'),
(209, '2025-06-26 17:49:00', 20, 28, 'En attente'),
(210, '2025-06-26 17:49:00', 20, 28, 'En attente'),
(211, '2025-06-26 17:49:00', 20, 28, 'En attente'),
(212, '2025-06-26 17:49:00', 20, 28, 'En attente'),
(213, '2025-06-26 17:49:00', 20, 28, 'En attente'),
(214, '2025-06-26 17:49:00', 20, 28, 'En attente'),
(215, '2025-06-26 17:49:00', 20, 28, 'En attente'),
(216, '2025-06-26 17:49:00', 20, 28, 'En attente'),
(217, '2025-06-26 17:49:00', 20, 28, 'En attente'),
(218, '2025-06-26 17:49:00', 20, 28, 'En attente'),
(219, '2025-06-26 17:49:00', 20, 28, 'En attente'),
(220, '2025-06-26 17:49:00', 20, 28, 'En attente'),
(221, '2025-06-26 17:49:00', 20, 28, 'En attente'),
(222, '2025-06-26 17:49:00', 20, 28, 'En attente'),
(223, '2025-06-26 17:49:00', 20, 28, 'En attente'),
(224, '2025-06-26 18:23:00', 21, 44, 'En attente'),
(225, '2025-06-26 18:23:00', 21, 44, 'En attente'),
(226, '2025-06-26 18:23:00', 21, 28, 'En attente'),
(227, '2025-06-26 18:24:00', 21, 39, 'En attente');

-- --------------------------------------------------------

--
-- Table structure for table `specialites`
--

CREATE TABLE `specialites` (
  `id` int NOT NULL,
  `nom` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `specialites`
--

INSERT INTO `specialites` (`id`, `nom`) VALUES
(1, 'Anesthesiologists'),
(2, 'test'),
(3, 'mest'),
(4, 'Cardiologue'),
(5, 'Dermatologue'),
(6, 'Pédiatre'),
(7, 'Gynécologue'),
(8, 'Ophtalmologue'),
(9, 'Dentiste'),
(10, 'Chirurgien'),
(11, 'Neurologue'),
(12, 'Psychiatre'),
(13, 'Endocrinologue'),
(14, 'ORL'),
(15, 'Urologue'),
(16, 'Rhumatologue'),
(17, 'Oncologue'),
(18, 'Anesthésiste'),
(20, 'Aide soignonte');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `passcode` text,
  `email` varchar(200) NOT NULL,
  `role` enum('patient','docteur') DEFAULT NULL,
  `date_creation` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `passcode`, `email`, `role`, `date_creation`) VALUES
(15, '$2y$10$GGxXok4pJE.D8K5KWTSxSOe.y27TBpuHa/jt/T4zjAyfGiss.qijO', 'sadikhunter231@gmail.com', 'docteur', '2025-06-21'),
(16, '$2y$10$t885nu7ZU7lsCxwN64tI4edXS8ngJMLXdNxiZNdfiWSzHtpWwFJ5O', 'sadikhunter231@patient.com', 'patient', '2025-06-21'),
(17, '$2y$10$LyuNZF5sRf5twiW22IyHU.RzXnK7x1qpSvoA4eF.2ac2UopRD5DMG', 'sadikhunter231@gmail.comdghd', 'patient', '2025-06-22'),
(18, '$2y$10$7xbDL2MdON/hn64fDUSGZeQWHxtK0LIkQaeirqFVxdK8TPf15YFpy', 'sadikhunter231@gmail.comsd', 'docteur', '2025-06-22'),
(19, '$2y$10$YWWsro3.QKBtbhLXRcBB8.gKJaowG4STsYkmOuRlVELpPqvSiY68O', 'sadikhunter231@gmail.comad', 'patient', '2025-06-22'),
(20, '$2y$10$EKVC169giuloLzoktJFAM.9VZBHFa49nFu8tH/.XPxQJDfayDYiVi', 'sadikhunter231@gmail.comwe', 'patient', '2025-06-22'),
(21, '$2y$10$r.EfVyyOcGcIrKLCNNg3KefohxKdM48BGblDbEdh05y9hX8FYXcrm', 'sadikhunter231@gmail.comnn', 'patient', '2025-06-22'),
(22, '$2y$10$uUxz1vTJKekbSFvGH2VPveaBk4PqF1fJmh0qxtvEEKxuO.p.ekzmy', 'sadikk@gmail.comww', 'patient', '2025-06-22'),
(23, '$2y$10$ZKutaU/S1FOmkhSH1l3Lv.9AZl2GB2yvyADBaEAlEectlJj46hemO', 'sadikk@gmail.comwe', 'patient', '2025-06-22'),
(24, '$2y$10$/bTfbEyCCuorpC9n7HdvxuvE7ueEMLnbNmMfte4Xeh9A8z.tnDxlq', 'sadikk@gmail.comwz', 'patient', '2025-06-22'),
(25, '$2y$10$OpI1jTngsPofOUH.cnxkR.mIqfDzDe7oI1ZRGaVMcjvJnetJ1wZAS', 'sadikhunter@gmail.comqq', 'patient', '2025-06-22'),
(26, '$2y$10$yUyZz7G83hu7mPmdoVOrp.CG8qLsmFBi.1g0jfLil33F0ih9O6uoi', 'sadikhunter231@gmail.comee', 'patient', '2025-06-23'),
(27, '$2y$10$4zK4bGkMpWwBW/wT3ohBVOw7RRtXBbGpgcn1wTP2afzRQ0bBFX8z2', 'sadikhunter231@gmail.comhz', 'patient', '2025-06-25'),
(28, '$2y$10$FtCQXl7Loa9RZpnXD1ROcOVH6hXrFhLmT5OH76fLDtdp2Gaq6TEOq', 'sadikk@gmail.com', 'patient', '2025-06-25'),
(29, '$2y$10$GlhWmfbCDx0GUtxYSYLnK.rOEeIeLkgDqYYmhyz8/vp3ScwMQyEX6', 'nigger@nigga.man', 'patient', '2025-06-25'),
(30, '$2y$10$jCaVKmDPCq3VvRWCQzsSZ.kpHi4IckIRghwpmS2c4WXqAPGUc5asS', 'sad@dick.cum', 'patient', '2025-06-25'),
(31, '$2y$10$LSpF0nyqyo/XTGaskHtTf.mkUb7gm5mKDP22NLROkfxUEaXPTcmPC', 'sadikhunter231@gmail.comft', 'docteur', '2025-06-25'),
(32, '$2y$10$v3jP51SyUZCQZ09CSbbbn.DXm5RxS055VsQf2orWzolSOVMPNpw92', 'tabib@rahma.cum', 'docteur', '2025-06-25'),
(33, '$2y$10$AgkG00A7nWco6GJVQHdoaumJDVeOtezUoM3ZkaY1JojabDdvYus7i', 'tabib1@rahma.cum', 'docteur', '2025-06-25'),
(35, '$2y$10$4sTe1JkdmxNWxa8ifySEu.d8Dj0MyLsx3BEX2M.JJbE8WYWjvr5iu', 'marid@gmail.com', 'patient', '2025-06-25'),
(36, '$2y$10$85LOk/ydQse8LNA531y5/ulv3qNCNaUTV1pn9jkrl0Bw23cG00V9y', 'riyad@gmail.com', 'docteur', '2025-06-25'),
(37, '$2y$10$gMoIIgXGmFXyOAmaqn2OiewPksO8tujfqme3ioDGjhlsJp7lpQY1O', 'marid1@gmail.com', 'patient', '2025-06-26'),
(38, '$2y$10$vrsQD3lqfkD1z/eMiAiWQukOkhgzzBq6.7DvBxXBUtx3FfzMS77p6', 'tabib1@rahma.cumu', 'docteur', '2025-06-26'),
(39, '$2y$10$SRqO5INWiCpgyfVdk4TbUemFFjMEwhOt9mbf0ollULhFbtNsxBOOO', 'riyad1@gmail.com', 'patient', '2025-06-27'),
(40, '$2y$10$pmgJZ6gzBHg7Xjx2Btbn3.nPysH80vwQiCY7V4N5RQdTgQpginp2S', 'doctor@gmail.com', 'docteur', '2025-06-27'),
(41, '$2y$10$/BKY1yjpuaBPFNSLjCLlZeVm5wgnyC.3Q.YsgUhkIq.a.Sic37UeS', 'doctor1@gmail.com', 'docteur', '2025-06-27'),
(42, '$2y$10$J4OcttttljjU90oVW32xYuNCLfwX1pySmeotMETkUVjccMurphBLe', 'doctor2@gmail.com', 'docteur', '2025-06-27'),
(43, '$2y$10$CMsNDOzt7.iS.NfKzKx3uOeX7n3TCpeIygTtoZzeRIuSmas0X5wi6', 'doctor3@gmail.com', 'docteur', '2025-06-27'),
(44, '$2y$10$6iqw1Wdc1TqbJNUJhyxNruIxxYr3GIMqgY5SLVve3m3b7tfxAsMCW', 'doctor4@gmail.com', 'docteur', '2025-06-27'),
(45, '$2y$10$FlcG7HC9SkB80ttMIlYqPe8O8y5VxNf4O/7/lKWJ8GjL1WCW5QHfK', 'doctor5@gmail.com', 'docteur', '2025-06-27'),
(46, '$2y$10$Y4Q8Upvag9SO/egcpr.q5..giOh2wUZddtAZiv4Uqv5AMNrtAyJAW', 'doctor6@gmail.com', 'docteur', '2025-06-27'),
(47, '$2y$10$8iS2AVVrHRyvXl2Ws6fwTOygauurOvtVbesJliO7zZApDhW.vMQ6S', 'doctor7@gmail.com', 'docteur', '2025-06-27'),
(48, '$2y$10$Btfg.ytRiCiLHWTnuNzYFewQOeh4tn8.eVDud3SBwAlWgHCQufeH6', 'doctor8@gmail.com', 'docteur', '2025-06-27'),
(49, '$2y$10$LsOzR4FagrfDapaO46EILO9SZ32.iSglZ9MYZNxkCREe7fT94eZqu', 'doctor9@gmail.com', 'docteur', '2025-06-27'),
(50, '$2y$10$iUxxJRgIiHzlkD8qXTYeA.KFVC9Uyn6zfhL6i0Gk/Brh/AoJMAQBe', 'doctor10@gmail.com', 'docteur', '2025-06-27'),
(51, '$2y$10$YBKqNhu4jpjyatkmnfv8.u30E547VK2U0v.q/W.ErHZ8Qu6yLB7py', 'doctor11@gmail.com', 'docteur', '2025-06-27'),
(52, '$2y$10$OgVkPoizAehuNB0F9pYyMu.rCsa53SUBxq3IpqiiFVFYbEwhbolEy', 'doctor12@gmail.com', 'docteur', '2025-06-27'),
(53, '$2y$10$6F67dXnM6z1O9K1dv/Ct4uybNHr2ZEyv04Oknk8NsMrYUZSFrFadO', 'doctor13@gmail.com', 'docteur', '2025-06-27'),
(54, '$2y$10$fqLvHJs94JSF3DNaH0AYmuCsJdUCgeK385yTeqW3Gw1jwIXIIV9Xe', 'marid2@gmail.com', 'patient', '2025-06-27');

-- --------------------------------------------------------

--
-- Table structure for table `ville`
--

CREATE TABLE `ville` (
  `id` int NOT NULL,
  `nom` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ville`
--

INSERT INTO `ville` (`id`, `nom`) VALUES
(1, 'laayoune'),
(2, 'Casablanca'),
(3, 'Rabat'),
(4, 'Fès'),
(5, 'Marrakech'),
(6, 'Agadir'),
(7, 'Tanger'),
(8, 'Oujda'),
(10, 'Mohammedia'),
(11, 'Khouribga'),
(12, 'Tétouan'),
(13, 'Safi'),
(14, 'Errachidia'),
(15, 'Beni Mellal'),
(16, 'Meknès');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `docteurs`
--
ALTER TABLE `docteurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `specialites_id` (`specialites_id`),
  ADD KEY `ville_id` (`ville_id`);

--
-- Indexes for table `patientes`
--
ALTER TABLE `patientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tel` (`tel`),
  ADD UNIQUE KEY `tel_2` (`tel`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rendezvous`
--
ALTER TABLE `rendezvous`
  ADD PRIMARY KEY (`id`),
  ADD KEY `docteurs_id` (`docteurs_id`),
  ADD KEY `rendezvous_ibfk_1` (`patientes_id`);

--
-- Indexes for table `specialites`
--
ALTER TABLE `specialites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `ville`
--
ALTER TABLE `ville`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `docteurs`
--
ALTER TABLE `docteurs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `patientes`
--
ALTER TABLE `patientes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `rendezvous`
--
ALTER TABLE `rendezvous`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=228;

--
-- AUTO_INCREMENT for table `specialites`
--
ALTER TABLE `specialites`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `ville`
--
ALTER TABLE `ville`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `docteurs`
--
ALTER TABLE `docteurs`
  ADD CONSTRAINT `docteurs_ibfk_1` FOREIGN KEY (`specialites_id`) REFERENCES `specialites` (`id`),
  ADD CONSTRAINT `docteurs_ibfk_2` FOREIGN KEY (`ville_id`) REFERENCES `ville` (`id`),
  ADD CONSTRAINT `docteurs_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patientes`
--
ALTER TABLE `patientes`
  ADD CONSTRAINT `patientes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `rendezvous`
--
ALTER TABLE `rendezvous`
  ADD CONSTRAINT `rendezvous_ibfk_1` FOREIGN KEY (`patientes_id`) REFERENCES `patientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rendezvous_ibfk_2` FOREIGN KEY (`docteurs_id`) REFERENCES `docteurs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
