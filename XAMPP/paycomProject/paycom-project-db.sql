-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 17, 2020 at 06:37 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `paycom_project_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `sessionId` int(11) NOT NULL,
  `sessionName` longtext NOT NULL,
  `sessionAttendees` int(11) NOT NULL,
  `sessionTime` bigint(11) NOT NULL,
  `sessionDesc` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`sessionId`, `sessionName`, `sessionAttendees`, `sessionTime`, `sessionDesc`) VALUES
(119, 'Clean Code 2 Book Review', 4, 1595865600000, 'Today we are reviewing the sequel to Clean Code, \"Clean Code 2: Now with Double the Cleanliness!\".'),
(120, 'How to Make Example Text', 3, 1595435400000, 'How to make your screenshot example funny, interesting, and grammatically correct. Make sure to spel chek!'),
(121, 'The Social Network Movie Night', 2, 1596063600000, 'The story of a small startup and their journey to becoming the underdog we know today.'),
(122, 'React Reactions', 3, 1595606400000, 'Our engineers react to your React!'),
(123, 'Programming Puns 101', 3, 1595610000000, 'Why\'d the Software Engineer quit his job? He didn\'t get Arrays!'),
(124, 'How to Exit vim', 4, 1595869200000, 'Don\'t worry, we aren\'t sure either.'),
(125, 'Event Wrap Up', 2, 1596214800000, 'The grand finale to the Paycom Summer Engagement Program!'),
(126, 'Working with UI/UX', 3, 1595433600000, 'Everything you need to know to make beautiful applications.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `idUsers` int(11) NOT NULL,
  `uidUsers` tinytext NOT NULL,
  `emailUsers` tinytext NOT NULL,
  `pwdUsers` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`idUsers`, `uidUsers`, `emailUsers`, `pwdUsers`) VALUES
(1, 'test', 'test@test.com', '$2y$10$3y5V7tF3wtygIGdqiML85OBk5Aut9u/p8/87TIyZwc/1TFwq11ucm'),
(15, 'Jack58', 'jackschwarz58@gmail.com', '$2y$10$TtwHUVIHTUlms7SnODPTDemCUDl3tBx07jpDSm4IWkFSIJz7KmC86'),
(16, 'test2', 'test2@test.test', '$2y$10$1zPj22wq1zv6nr4dGtZNtO3wVOsiMQggSI6Ov2wagffN1WaSoz8Uy'),
(17, 'test3', 'test2@test.test', '$2y$10$3BCXpURA4.joL8RpyHcINOsTDQVb7o.SxO/4RALHW5dGuWi/qR4K.');

-- --------------------------------------------------------

--
-- Table structure for table `users_sessions`
--

CREATE TABLE `users_sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_sessions`
--

INSERT INTO `users_sessions` (`id`, `user_id`, `session_id`) VALUES
(44, 1, 119),
(45, 1, 120),
(46, 1, 121),
(47, 1, 122),
(48, 1, 123),
(49, 1, 124),
(50, 1, 125),
(51, 15, 119),
(52, 15, 120),
(53, 15, 122),
(54, 15, 123),
(55, 15, 124),
(56, 15, 126),
(57, 16, 119),
(58, 16, 126),
(59, 16, 123),
(60, 16, 124),
(61, 17, 122),
(62, 17, 119),
(63, 17, 120),
(64, 17, 124),
(65, 17, 121),
(66, 17, 125),
(67, 17, 126);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`sessionId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUsers`);

--
-- Indexes for table `users_sessions`
--
ALTER TABLE `users_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `session_id` (`session_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `sessionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `idUsers` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users_sessions`
--
ALTER TABLE `users_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_sessions`
--
ALTER TABLE `users_sessions`
  ADD CONSTRAINT `users_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`idUsers`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_sessions_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`sessionId`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
