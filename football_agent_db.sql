-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2025 at 02:43 PM
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
-- Database: `football_agent_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `license_number` varchar(50) DEFAULT NULL,
  `years_experience` int(11) DEFAULT NULL,
  `specialization` text DEFAULT NULL,
  `total_players` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`id`, `user_id`, `license_number`, `years_experience`, `specialization`, `total_players`) VALUES
(1, 5, 'AGENT-SL-001', 8, 'Youth Development & International Transfers', 1),
(2, 6, 'AGENT-SL-002', 5, 'Player Management & Contracts', 1);

-- --------------------------------------------------------

--
-- Table structure for table `club_managers`
--

CREATE TABLE `club_managers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `club_name` varchar(100) DEFAULT NULL,
  `club_location` varchar(100) DEFAULT NULL,
  `club_level` enum('Local','National','International') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `club_managers`
--

INSERT INTO `club_managers` (`id`, `user_id`, `club_name`, `club_location`, `club_level`) VALUES
(1, 7, 'Freetown City FC', 'Freetown', 'National'),
(2, 8, 'Bo United SC', 'Bo City', 'Local');

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `position` enum('Goalkeeper','Defender','Midfielder','Forward') DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `preferred_foot` enum('Left','Right','Both') DEFAULT NULL,
  `current_club` varchar(100) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `stats` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`id`, `user_id`, `date_of_birth`, `position`, `height`, `weight`, `preferred_foot`, `current_club`, `agent_id`, `video_url`, `stats`) VALUES
(1, 3, NULL, 'Forward', 180.50, 75.00, 'Right', '0', 5, NULL, NULL),
(2, 4, NULL, 'Midfielder', 175.00, 70.00, 'Both', '0', 6, NULL, NULL),
(3, 9, '0000-00-00', 'Midfielder', 6.10, 45.60, 'Left', 'Eastern Lions', 6, '', '{\"goals\":0,\"assists\":0,\"matches\":0,\"yellow_cards\":0,\"red_cards\":0}');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','player','agent','club_manager') NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `first_name`, `last_name`, `phone`, `address`, `profile_image`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'admin1', 'admin1@footballagent.sl', '$2y$10$/uwXgIeFWll0SikWzVHUXOAlQCWHokDLqJJcF0lU5OpVnFkU5L8tG', 'admin', 'System', 'Administrator', '+232 00 000-001', '15 Goderich Street, Freetown', NULL, 1, '2025-12-01 13:34:16', '2025-12-01 13:34:16'),
(2, 'admin2', 'admin2@footballagent.sl', '$2y$10$/uwXgIeFWll0SikWzVHUXOAlQCWHokDLqJJcF0lU5OpVnFkU5L8tG', 'admin', 'Sarah', 'Johnson', '+232 00 000-002', 'Freetown Office', NULL, 1, '2025-12-01 13:34:16', '2025-12-01 13:34:16'),
(3, 'musa_tombo', 'musa.tombo@example.com', '$2y$10$/uwXgIeFWll0SikWzVHUXOAlQCWHokDLqJJcF0lU5OpVnFkU5L8tG', 'player', 'Musa', 'Tombo', '+232 79 123-456', 'Freetown, Sierra Leone', NULL, 1, '2025-12-01 13:34:16', '2025-12-01 13:34:16'),
(4, 'kai_kamara', 'kai.kamara@example.com', '$2y$10$/uwXgIeFWll0SikWzVHUXOAlQCWHokDLqJJcF0lU5OpVnFkU5L8tG', 'player', 'Kai', 'Kamara', '+232 79 123-457', 'Bo City, Sierra Leone', NULL, 1, '2025-12-01 13:34:16', '2025-12-01 13:34:16'),
(5, 'nelson_agent', 'nelson@footballagent.sl', '$2y$10$/uwXgIeFWll0SikWzVHUXOAlQCWHokDLqJJcF0lU5OpVnFkU5L8tG', 'agent', 'Nelson', 'Football Agent', '+232 79 826-564', '15 Goderich Street, Freetown', NULL, 1, '2025-12-01 13:34:16', '2025-12-01 13:34:16'),
(6, 'sarah_agent', 'sarah.agent@example.com', '$2y$10$/uwXgIeFWll0SikWzVHUXOAlQCWHokDLqJJcF0lU5OpVnFkU5L8tG', 'agent', 'Sarah', 'Conteh', '+232 79 826-565', 'Freetown Office', NULL, 1, '2025-12-01 13:34:16', '2025-12-01 13:34:16'),
(7, 'club_manager1', 'manager@fcsl.com', '$2y$10$/uwXgIeFWll0SikWzVHUXOAlQCWHokDLqJJcF0lU5OpVnFkU5L8tG', 'club_manager', 'John', 'Manager', '+232 88 765-432', 'Freetown Stadium', NULL, 1, '2025-12-01 13:34:16', '2025-12-01 13:34:16'),
(8, 'club_manager2', 'director@asfc.com', '$2y$10$/uwXgIeFWll0SikWzVHUXOAlQCWHokDLqJJcF0lU5OpVnFkU5L8tG', 'club_manager', 'David', 'Koroma', '+232 88 765-433', 'Bo Stadium', NULL, 1, '2025-12-01 13:34:16', '2025-12-01 13:34:16'),
(9, 'gmanga', 'bernardgamanga@icloud.com', '$2y$10$oMEYY8Ic4CNJBg6izm.PSegmml0ecO6lLmPB38gS6rH8kOcQhEszW', 'player', 'Bernard', 'Moore', '079123456', 'Freetown, Sierra Leone', NULL, 1, '2025-12-01 13:37:41', '2025-12-01 13:37:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `club_managers`
--
ALTER TABLE `club_managers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `agent_id` (`agent_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `club_managers`
--
ALTER TABLE `club_managers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agents`
--
ALTER TABLE `agents`
  ADD CONSTRAINT `agents_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `club_managers`
--
ALTER TABLE `club_managers`
  ADD CONSTRAINT `club_managers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `players`
--
ALTER TABLE `players`
  ADD CONSTRAINT `players_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `players_ibfk_2` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
