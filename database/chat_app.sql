-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 01, 2025 at 08:59 AM
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
-- Database: `chat_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat_room_msgs`
--

CREATE TABLE `chat_room_msgs` (
  `msg_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `messages` text NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_room_msgs`
--

INSERT INTO `chat_room_msgs` (`msg_id`, `user_id`, `messages`, `created_on`) VALUES
(1, 1, 'Hello, this is John!', '2025-03-01 07:25:19'),
(2, 2, 'Hi, Jane here!', '2025-03-01 07:25:19'),
(3, 3, 'Alice checking in.', '2025-03-01 07:25:19'),
(4, 4, 'Bob sending a message.', '2025-03-01 07:25:19'),
(5, 5, 'Charlie says hi!', '2025-03-01 07:25:19'),
(6, 1, 'hello', '2025-03-01 03:05:25'),
(7, 3, 'hello saurabh', '2025-03-01 03:06:32'),
(8, 1, 'hello alice johnson', '2025-03-01 03:06:56');

-- --------------------------------------------------------

--
-- Table structure for table `chat_user_table`
--

CREATE TABLE `chat_user_table` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_status` enum('active','inactive') NOT NULL DEFAULT 'inactive',
  `user_created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_verification_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_user_table`
--

INSERT INTO `chat_user_table` (`id`, `user_name`, `user_email`, `user_password`, `user_status`, `user_created_on`, `user_verification_code`) VALUES
(1, 'John Doe', 'john@example.com', 'password123', '', '2025-03-01 07:25:19', 'abc123'),
(2, 'Jane Smith', 'jane@example.com', 'securepass', 'inactive', '2025-03-01 07:25:19', 'xyz456'),
(3, 'Alice Johnson', 'alice@example.com', 'alicepass', '', '2025-03-01 07:25:19', 'lmn789'),
(4, 'Bob Brown', 'bob@example.com', 'bobsecure', 'active', '2025-03-01 07:25:19', 'opq321'),
(5, 'Charlie White', 'charlie@example.com', 'charliepass', 'inactive', '2025-03-01 07:25:19', 'rst654');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat_room_msgs`
--
ALTER TABLE `chat_room_msgs`
  ADD PRIMARY KEY (`msg_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `chat_user_table`
--
ALTER TABLE `chat_user_table`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat_room_msgs`
--
ALTER TABLE `chat_room_msgs`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `chat_user_table`
--
ALTER TABLE `chat_user_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat_room_msgs`
--
ALTER TABLE `chat_room_msgs`
  ADD CONSTRAINT `chat_room_msgs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `chat_user_table` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
