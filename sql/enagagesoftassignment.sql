-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2024 at 08:08 PM
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
-- Database: `enagagesoftassignment`
--

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` text NOT NULL,
  `description` text DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `status` text DEFAULT NULL CHECK (`status` in ('Pending','In Progress','Completed')),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `title`, `description`, `due_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 12, 'edit a new task', 'Create new task with all details', '2024-05-20', 'In Progress', '2024-05-19 20:49:23', '2024-05-19 20:49:23'),
(2, NULL, 'edit a new task', 'Create new task with all details', '2024-05-20', 'In Progress', '2024-05-20 17:15:12', '2024-05-20 17:15:12'),
(3, NULL, 'Create a new task', 'Create new task with all details', '2024-05-20', 'Pending', '2024-05-20 17:20:50', '2024-05-20 17:20:50'),
(4, NULL, 'Create a new task', 'Create new task with all details', '2024-05-20', 'Pending', '2024-05-20 17:21:13', '2024-05-20 17:21:13'),
(8, NULL, 'Create a new task', 'Create new task with all details', '2024-05-20', 'Pending', '2024-05-20 17:24:24', '2024-05-20 17:24:24'),
(9, 12, 'edit a new task', 'Create new task with all details', '2024-05-20', 'In Progress', '2024-05-20 17:24:36', '2024-05-20 17:24:36'),
(10, NULL, 'Create a new task 34', 'Create new task with all details', '2024-05-20', 'Pending', '2024-05-20 19:17:37', '2024-05-20 19:17:37'),
(11, NULL, 'Create a new task 34', 'Create new task with all details', '2024-05-20', 'Pending', '2024-05-20 21:27:57', '2024-05-20 21:27:57'),
(12, NULL, 'Create a new task 34', 'Create new task with all details', '2024-05-20', 'Pending', '2024-05-21 17:51:19', '2024-05-21 17:51:19'),
(13, NULL, 'Create a new task 34', 'Create new task with all details', '2024-05-21', 'Pending', '2024-05-21 17:51:54', '2024-05-21 17:51:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `email` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_Admin` tinyint(1) NOT NULL DEFAULT 0,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `created_at`, `is_Admin`, `password`) VALUES
(12, 'yahya test', 'yahya.test@gmail.com', '2024-05-20 16:34:50', 0, ''),
(13, 'morad shajrawi', 'moradshajrawi@gmail.com', '2024-05-20 19:03:46', 1, ''),
(14, 'morad shajrawi', 'moradshajrawi2@gmail.com', '2024-05-20 19:10:19', 1, ''),
(15, 'morad shajrawi', 'moradshajrawi21@gmail.com', '2024-05-20 19:14:59', 1, ''),
(16, 'morad shajrawi', 'moradshajra21wi@gmail.com', '2024-05-20 20:17:49', 1, ''),
(17, 'morad shajrawi', 'yahyashajrawi@gmail.com', '2024-05-20 20:27:33', 1, 'dd54a67f2745a223aac82b84715ebd8c'),
(18, 'morad shajrawi', 'yahyashajrawi@gmail.com1', '2024-05-20 21:31:51', 1, 'dd54a67f2745a223aac82b84715ebd8c');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`) USING HASH;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
