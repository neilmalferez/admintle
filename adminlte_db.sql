-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2026 at 08:41 AM
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
-- Database: `adminlte_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `archive_users`
--

CREATE TABLE `archive_users` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `time_deleted` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `archive_users`
--

INSERT INTO `archive_users` (`id`, `fname`, `lname`, `email`, `password`, `role`, `date_created`, `time_deleted`) VALUES
(14, '', '', 'marivic@gmail.com', '$2y$10$jCRLc.b8O669QB05aj8RJ.tGiNs.fgu6xgLBkBkTNF5WXZoDm0O0O', 'admin', '2025-03-17 23:30:01', '2025-03-17 23:31:25'),
(15, 'Marivic', 'Emnace', 'marivic@gmail.com', '$2y$10$QcssKW/izplLi62UQOWZpOXMJMhilu2YoV346k0ZSN/EMxC8l0nje', 'admin', '2025-03-17 23:33:19', '2025-03-17 23:34:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `time_deleted` datetime DEFAULT NULL,
  `otp_code` varchar(6) DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `email`, `password`, `role`, `date_created`, `time_deleted`, `otp_code`, `otp_expiry`) VALUES
(1, 'Neil', 'Alferez', 'neil@gmail.com', '$2y$10$3dP4O10o7VaXr.BdceKAAOJGjBqOr0TVoJ1ih3uaULsgSYTRZADv.', 'user', '2025-03-17 12:04:58', NULL, NULL, NULL),
(2, 'Admin', 'Administrator', 'admin@gmail.com', '$2y$10$HDgaKE81.3knle79Wz2D7u.jfr3Bu690dxgH9Ldd9BAOcni6WPSQC', 'admin', '2025-03-17 12:05:56', NULL, NULL, NULL),
(3, 'Marc Nino', 'Epe', 'marc@gmail.com', '$2y$10$fDPGhLHuKxK.hSAoAnjLB.Ainh3Lbn3ISgnaX/g0glbqGUNMLLF5u', 'user', '2025-03-17 13:02:33', NULL, NULL, NULL),
(4, 'Gayle David', 'Faller', 'gayle@gmail.com', '$2y$10$Pz2i342.Ii9o/wLScDEE9O5Vr09mXX.MUhs6r2fwRv4vEMOV3gNyi', 'user', '2025-03-17 14:21:15', NULL, NULL, NULL),
(5, 'Don Dave', 'Igot', 'don@gmail.com', '$2y$10$JFfSsr5mXPUGwQOE2tklDeFD6nQJqtCTBTLJR3O81UXTzrkHQqxwm', 'user', '2025-03-17 14:21:40', NULL, NULL, NULL),
(6, 'Jun-Rey', 'Amistoso', 'jun@gmail.com', '$2y$10$zs8VRu5/vcKTgPwE3dz6jONlSG1b21MSh7KNBbDLSNUMadlsbvZnO', 'user', '2025-03-17 14:22:01', NULL, NULL, NULL),
(7, 'Sherly', 'Indong', 'sherlyn@gmail.com', '$2y$10$KqVixFEo44R5vkBkQpjftOzVEvQGrwB8ocQAyMZ2lRFWPTgBDufNa', 'user', '2025-03-17 14:22:47', NULL, NULL, NULL),
(8, 'Johnna', 'Quevedo', 'johnna@gmail.com', '$2y$10$6.PtSpiioi/Y1Od0AitSg.YSiGqkZEOkVA4Q.e4jp0VAspoNmA8ZC', 'user', '2025-03-17 14:23:06', NULL, NULL, NULL),
(9, 'Roel Jr.', 'Layasan', 'roel@gmail.com', '$2y$10$eCVOKZUZO3gWoXWmSEFVM.yWzFK8lor1ycTpTeW.KUa0PE4vGGXIG', 'user', '2025-02-17 14:23:21', NULL, NULL, NULL),
(10, 'Meah Jean', 'Camiguing', 'meah@gmail.com', '$2y$10$X.HyeJgmruua8RWm1C8Y3.gnMttfpXmIHmX6Ggo/AWiiCv7JiMPZC', 'user', '2025-01-17 14:23:41', NULL, NULL, NULL),
(11, 'Crisel Ann', 'Pitogo', 'crisel@gmail.com', '$2y$10$2IaxF1T6AHhXN0VWBttFK.fhghCDGjIV8QfSmMSX66NTuaFYPH4bK', 'user', '2025-01-17 14:24:04', NULL, NULL, NULL),
(12, 'Renzo', 'Naagas', 'renzo@gmail.com', '$2y$10$NKqAIjH0ox04AdbiKHHYNuzeUmMq7yyXxHkXxAQAn4qDjwLWXwDNu', 'user', '2025-01-17 14:24:27', NULL, NULL, NULL),
(18, 'Jay', 'Vacante', 'jay@gmail.com', '$2y$10$W23BZt0YF7CbO4M4f6c.t.5c9SCcj3.8zB/x/NViERN9zKkNPI6YW', 'user', '2025-03-18 02:34:28', NULL, NULL, NULL),
(19, 'Adminn', 'Administratorr', 'adminn@gmail.com', '$2y$10$Id9SG5Ql1BJZVmPji2vKtepY8BpAZdYmE3O2XDO1CiRQ9xslXbArG', 'admin', '2025-03-18 08:46:40', NULL, NULL, NULL),
(20, 'mc', 'knight', 'miraculous.knight109@gmail.com', '$2y$10$da/lTAJeyqtW56I0AftwV.LI6mlVT1RaNy.lC5w1QUdz4qhIzrVoi', 'user', '2025-03-25 01:48:15', NULL, '666339', '2025-04-04 16:49:58'),
(21, 'mcky', 'knight', 'mcknightz109@gmail.com', '$2y$10$E9LZ.V/KQeV4x0ATATHIQOaKFB.nahsfjRXzXRzqGPV//ptzuLqHO', 'user', '2025-03-25 05:00:17', NULL, '442170', '2025-03-25 16:22:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `archive_users`
--
ALTER TABLE `archive_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `archive_users`
--
ALTER TABLE `archive_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
