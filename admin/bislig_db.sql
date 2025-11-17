-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2025 at 10:53 AM
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
-- Database: `bislig_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accommodations`
--

CREATE TABLE `accommodations` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT 0.0,
  `badge` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accommodations`
--

INSERT INTO `accommodations` (`id`, `name`, `description`, `location`, `phone`, `rating`, `badge`, `created_at`, `updated_at`) VALUES
(1, 'RCBCHSI', 'COMFY', 'PANIGTA', '63 81 8242', 3.5, 'POLICE', '2025-11-15 16:03:14', '2025-11-15 16:29:58');

-- --------------------------------------------------------

--
-- Table structure for table `attractions`
--

CREATE TABLE `attractions` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(100) NOT NULL,
  `rating` decimal(2,1) DEFAULT 0.0,
  `badge` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attractions`
--

INSERT INTO `attractions` (`id`, `name`, `description`, `location`, `rating`, `badge`, `created_at`, `updated_at`) VALUES
(1, 'OCEAN VIEW PARK', 'Tourist Park Attraction, 1500 ladder steps. ', 'Cumawas', 3.0, 'Popular', '2025-11-15 17:52:42', '2025-11-15 17:52:52');

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

CREATE TABLE `destinations` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(100) NOT NULL,
  `rating` decimal(2,1) DEFAULT 0.0,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`id`, `name`, `description`, `location`, `rating`, `image_url`, `created_at`, `updated_at`) VALUES
(3, 'KAGWAIT', 'kaon libre', 'UNAHANs', 2.7, 'uploads/1763221285_cagwait.jpg', '2025-11-15 15:41:25', '2025-11-15 17:33:41'),
(4, 'Tinuy-an Falls', 'The three-tiered \"Niagara Falls of the Philippines\" with misty rainbows at sunrise.', ' Barangay Borboanan', 5.0, 'uploads/1763231164_tinuyan-falls-hero.jpg', '2025-11-15 18:26:04', '2025-11-15 18:30:27');

-- --------------------------------------------------------

--
-- Table structure for table `destination_ratings`
--

CREATE TABLE `destination_ratings` (
  `id` int(11) NOT NULL,
  `destination_id` int(11) NOT NULL,
  `rating` decimal(2,1) NOT NULL,
  `rated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `destination_ratings`
--

INSERT INTO `destination_ratings` (`id`, `destination_id`, `rating`, `rated_at`) VALUES
(3, 3, 5.0, '2025-11-15 16:01:11'),
(4, 3, 2.0, '2025-11-15 16:01:26'),
(5, 3, 2.0, '2025-11-15 16:01:27'),
(6, 3, 2.0, '2025-11-15 16:01:28'),
(7, 3, 2.0, '2025-11-15 16:01:29'),
(8, 3, 2.0, '2025-11-15 16:01:32'),
(9, 3, 2.0, '2025-11-15 16:01:33'),
(10, 3, 2.0, '2025-11-15 16:01:34'),
(11, 3, 2.0, '2025-11-15 16:01:34'),
(12, 3, 2.0, '2025-11-15 16:01:35'),
(13, 3, 2.0, '2025-11-15 16:01:36'),
(14, 3, 2.0, '2025-11-15 16:01:38'),
(15, 3, 2.0, '2025-11-15 16:01:40'),
(16, 3, 5.0, '2025-11-15 16:02:03'),
(17, 3, 5.0, '2025-11-15 16:02:05'),
(18, 3, 5.0, '2025-11-15 16:02:05'),
(19, 3, 5.0, '2025-11-15 16:02:06'),
(20, 3, 5.0, '2025-11-15 16:02:07'),
(21, 3, 5.0, '2025-11-15 16:02:08');

-- --------------------------------------------------------

--
-- Table structure for table `emergency_contacts`
--

CREATE TABLE `emergency_contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emergency_contacts`
--

INSERT INTO `emergency_contacts` (`id`, `name`, `phone`, `description`, `created_at`, `updated_at`) VALUES
(1, 'NDRRMC', '911', '', '2025-11-15 18:01:30', '2025-11-15 18:01:30');

-- --------------------------------------------------------

--
-- Table structure for table `festivals`
--

CREATE TABLE `festivals` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(100) NOT NULL,
  `date` varchar(50) DEFAULT NULL,
  `patron_saint` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `festivals`
--

INSERT INTO `festivals` (`id`, `name`, `description`, `location`, `date`, `patron_saint`, `created_at`, `updated_at`) VALUES
(1, 'TINUY AN FESTIVAL', 'CUSTOM EVENTS, TRIBES TRADITION', 'BISLIG CITY, SURIGAO DEL SUR', 'November 5', '', '2025-11-15 17:58:09', '2025-11-16 09:51:43');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `category` enum('destination','restaurant','accommodation','transportation','attraction') NOT NULL,
  `rating` decimal(2,1) NOT NULL,
  `rated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `item_id`, `category`, `rating`, `rated_at`) VALUES
(1, 1, 'restaurant', 2.0, '2025-11-15 16:19:21'),
(2, 1, 'restaurant', 2.0, '2025-11-15 16:19:23'),
(3, 1, 'restaurant', 1.0, '2025-11-15 16:19:26'),
(4, 1, 'restaurant', 1.0, '2025-11-15 16:19:27'),
(5, 1, 'restaurant', 1.0, '2025-11-15 16:19:27'),
(6, 1, 'restaurant', 1.0, '2025-11-15 16:19:27'),
(7, 1, 'restaurant', 1.0, '2025-11-15 16:19:27'),
(8, 1, 'restaurant', 1.0, '2025-11-15 16:19:27'),
(9, 1, 'restaurant', 1.0, '2025-11-15 16:19:27'),
(10, 1, 'restaurant', 1.0, '2025-11-15 16:19:28'),
(11, 1, 'restaurant', 1.0, '2025-11-15 16:19:28'),
(12, 1, 'restaurant', 1.0, '2025-11-15 16:19:28'),
(13, 1, 'restaurant', 1.0, '2025-11-15 16:19:31'),
(14, 1, 'restaurant', 1.0, '2025-11-15 16:19:31'),
(15, 1, 'restaurant', 1.0, '2025-11-15 16:19:31'),
(16, 1, 'restaurant', 1.0, '2025-11-15 16:19:31'),
(17, 1, 'restaurant', 1.0, '2025-11-15 16:19:32'),
(18, 1, 'restaurant', 1.0, '2025-11-15 16:19:32'),
(19, 1, 'restaurant', 2.0, '2025-11-15 16:19:43'),
(20, 1, 'restaurant', 1.0, '2025-11-15 16:20:05'),
(21, 1, 'accommodation', 1.0, '2025-11-15 16:20:11'),
(22, 1, 'restaurant', 1.0, '2025-11-15 16:24:48'),
(23, 1, 'restaurant', 1.0, '2025-11-15 16:25:15'),
(24, 1, 'accommodation', 4.0, '2025-11-15 16:27:14'),
(25, 1, 'accommodation', 3.0, '2025-11-15 16:28:09'),
(26, 1, 'accommodation', 5.0, '2025-11-15 16:28:26'),
(27, 1, 'accommodation', 4.0, '2025-11-15 16:29:54'),
(28, 1, 'accommodation', 4.0, '2025-11-15 16:29:58'),
(29, 3, 'destination', 5.0, '2025-11-15 16:30:05'),
(30, 3, 'destination', 2.0, '2025-11-15 16:30:07'),
(31, 3, 'destination', 3.0, '2025-11-15 16:30:08'),
(32, 3, 'destination', 3.0, '2025-11-15 16:30:09'),
(33, 3, 'destination', 3.0, '2025-11-15 16:30:10'),
(34, 3, 'destination', 5.0, '2025-11-15 16:30:12'),
(35, 3, 'destination', 1.0, '2025-11-15 16:30:13'),
(36, 3, 'destination', 1.0, '2025-11-15 16:30:14'),
(37, 3, 'destination', 1.0, '2025-11-15 16:30:14'),
(38, 1, 'transportation', 5.0, '2025-11-15 16:30:19'),
(39, 1, 'transportation', 4.0, '2025-11-15 16:30:22'),
(40, 1, 'attraction', 3.0, '2025-11-15 17:52:52'),
(41, 4, 'destination', 5.0, '2025-11-15 18:30:27');

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `badge` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `rating` decimal(2,1) DEFAULT 0.0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`id`, `name`, `description`, `location`, `phone`, `email`, `badge`, `created_at`, `updated_at`, `rating`) VALUES
(1, 'Seaside Grille', 'Fresh catch cooked to perfection with classic kinilaw and grilled specialties.', ' Mangagoy Boulevard', '+63 917 222 4562', 'hello@seasidegrille.ph', '', '2025-11-15 15:46:14', '2025-11-15 17:37:49', 1.1);

-- --------------------------------------------------------

--
-- Table structure for table `transportation`
--

CREATE TABLE `transportation` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `operating_hours` varchar(100) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT 0.0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transportation`
--

INSERT INTO `transportation` (`id`, `name`, `description`, `operating_hours`, `rating`, `created_at`, `updated_at`) VALUES
(1, 'Ongbak', 'Sakay na karon dayun', 'open arms', 4.5, '2025-11-15 12:36:51', '2025-11-15 16:30:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(1, 'admin', '$2y$10$.QrT015gK6Yc7NVZzTxyEuInD0RK/88xSLWCiof6v/vRFs8ekmPWi', 'admin@gmail.com', '2025-11-15 11:47:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accommodations`
--
ALTER TABLE `accommodations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attractions`
--
ALTER TABLE `attractions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `destination_ratings`
--
ALTER TABLE `destination_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `destination_id` (`destination_id`);

--
-- Indexes for table `emergency_contacts`
--
ALTER TABLE `emergency_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `festivals`
--
ALTER TABLE `festivals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transportation`
--
ALTER TABLE `transportation`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `accommodations`
--
ALTER TABLE `accommodations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attractions`
--
ALTER TABLE `attractions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `destination_ratings`
--
ALTER TABLE `destination_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `emergency_contacts`
--
ALTER TABLE `emergency_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `festivals`
--
ALTER TABLE `festivals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transportation`
--
ALTER TABLE `transportation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `destination_ratings`
--
ALTER TABLE `destination_ratings`
  ADD CONSTRAINT `destination_ratings_ibfk_1` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
