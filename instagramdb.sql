-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2024 at 03:04 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `instagramdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `post_id` varchar(100) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `comment_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `user_id`, `post_id`, `comment`, `comment_id`) VALUES
(2, 'mic.stills', '664', 'jati ra', '1'),
(20, 'mic.stills', '665', 'nice', 'comment_66502f8f9372e3.66879253'),
(21, 'mic.stills', '664', 'lezgo', 'comment_665033baec1e87.85660791'),
(22, 'mic.stills', '6650401', 'missyou', 'comment_66504988d3c7a8.81065910'),
(23, 'mic.stills', '6650401', 'mwua', 'comment_66505a91073d45.34148605'),
(24, 'mic.stills', '66505', 'okay', 'comment_66505ac845f4f3.06459684'),
(25, 'wilchrs', '66505', 'vncncvn', 'comment_6666673e5cdb10.72824251');

-- --------------------------------------------------------

--
-- Table structure for table `follow`
--

CREATE TABLE `follow` (
  `id` int(11) NOT NULL,
  `follower_id` varchar(100) NOT NULL,
  `followed_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `follow`
--

INSERT INTO `follow` (`id`, `follower_id`, `followed_id`) VALUES
(92, 'okay', 'mic.stills'),
(113, 'mic.stills', 'wilchrs'),
(117, 'wilchrs', 'lenovoph'),
(118, 'wilchrs', 'mic.stills');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`like_id`, `post_id`, `user_id`) VALUES
(10, 663, 'mic.stills'),
(13, 664, 'mic.stills'),
(20, 6650401, 'mic.stills'),
(37, 66505, 'wilchrs');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `caption` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `post_id`, `user_id`, `image`, `caption`) VALUES
(28, 664, 'wilchrs', 'shttlr-67-removebg-preview (1).png', 'I am Michael'),
(29, 665, 'wilchrs', 'wp6039578.png', 'Orayt'),
(30, 665, 'wilchrs', 'Modern Black and Yellow Twitch Overlay.png', 'Orayt'),
(31, 665, 'wilchrs', 'shttlr-55-removebg-preview.png', 'Orayt'),
(34, 6650401, 'lenovoph', 'R (2).jpg', 'This is Lenovo'),
(35, 6650401, 'lenovoph', 'R (1).jpg', 'This is Lenovo'),
(36, 66504, 'mic.stills', 'desktop-wallpaper-encryption-cryptography.jpg', 'coders'),
(37, 66505, 'mic.stills', '343224926_2145712038958795_199003439196504099_n.jpg', 'badminton'),
(38, 66505, 'mic.stills', '342201371_7027582823922887_5541235382667939639_n.jpg', 'badminton'),
(39, 66505, 'mic.stills', '441438371_1222396509170457_2774919914989383849_n.jpg', 'badminton');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `bio` varchar(255) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `profile` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `bio`, `user_id`, `profile`) VALUES
(1, 'wilchrs', '123456', 'Wilchris Enterprises', 'uhaha', 'wilchrs', 'pogi.png'),
(2, 'mic.stills', '123456', 'Michael Encarnacion', 'Encarnacion Photography', 'mic.stills', 'default-user.png'),
(3, 'lenovoPH', '123456', 'LenovoPh', 'qwerty', 'lenovoph', 'R.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `follow`
--
ALTER TABLE `follow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
