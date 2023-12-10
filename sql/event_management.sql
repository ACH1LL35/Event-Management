-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2023 at 03:07 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `event_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_mod`
--

CREATE TABLE `admin_mod` (
  `id` int(5) NOT NULL,
  `uname` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `type` varchar(10) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_mod`
--

INSERT INTO `admin_mod` (`id`, `uname`, `email`, `password`, `type`, `status`) VALUES
(25000, 'alam', 'admin1@eventx.com', 'admin1', 'admin', 1),
(25001, 'zobayer', '', 'admin2', 'admin', 0),
(25002, 'modtest', 'mod1@eventx.com', 'modtest', 'mod', 1),
(25003, 'mod33', 'mod33@eventx.com', 'mod33', '', 0),
(25004, 'mod46', 'mod46@eventx.com', 'mod46', 'mod', 1);

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `user_id` int(8) NOT NULL,
  `booking_id` varchar(10) NOT NULL,
  `venue_name` varchar(32) NOT NULL,
  `venue_fee` int(6) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `duration` int(2) NOT NULL,
  `total_fee` int(7) NOT NULL,
  `name` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL,
  `cnumber` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`user_id`, `booking_id`, `venue_name`, `venue_fee`, `from_date`, `to_date`, `duration`, `total_fee`, `name`, `email`, `cnumber`) VALUES
(15, 'UK95CQ5L9N', 'HALL - 01', 0, '2023-11-20', '2023-11-20', 0, 0, 'Zobayer Alam', 'alam@gmail.com', '01778651619'),
(15, 'E9OBHBC241', 'HALL - 03', 0, '2023-12-21', '2023-12-29', 8, 0, 'Zobayer Alam', 'alam@gmail.com', '01778651619'),
(15, 'IOAF9YTHK9', 'HALL - 05', 200000, '2023-12-13', '2023-12-21', 8, 0, 'Zobayer Alam', 'alam@gmail.com', '01778651619');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `posted_by_id` varchar(16) NOT NULL,
  `posted_by_username` varchar(32) NOT NULL,
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`posted_by_id`, `posted_by_username`, `id`, `post_id`, `comment`, `created_at`, `status`) VALUES
('15', 'alam56', 14, 23, 'comment id+username', '2023-11-10 14:38:53', 1),
('15', 'alam69', 15, 21, 'tywer5yweywerywe5rywerywer', '2023-11-12 20:26:57', 1),
('15', 'alam69', 16, 23, 'tyutjtyjtyjtyjtryjtj', '2023-11-12 20:32:36', 1);

-- --------------------------------------------------------

--
-- Table structure for table `complaint`
--

CREATE TABLE `complaint` (
  `id` int(6) NOT NULL,
  `name` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL,
  `contact` varchar(11) NOT NULL,
  `description` varchar(512) NOT NULL,
  `feedback` varchar(512) NOT NULL,
  `fd_by` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaint`
--

INSERT INTO `complaint` (`id`, `name`, `email`, `contact`, `description`, `feedback`, `fd_by`) VALUES
(124, 'Zobayer Alam', 'mod1@gmail.com', '01111111111', 'segergergergegegegege', 'us id test 53', '25002'),
(125, 'Zobayer Alam', 'mod1@gmail.com', '01774861519', 'efedefeeedeeewfewewewew', 'sdfsf', ''),
(126, 'Zobayer Alam', 'alam@gmail.com', '01774861519', 'ertertetertgetgeg', 'sfsfsfsfs', '');

-- --------------------------------------------------------

--
-- Table structure for table `credential`
--

CREATE TABLE `credential` (
  `id` int(8) NOT NULL,
  `name` varchar(64) NOT NULL,
  `username` varchar(10) NOT NULL,
  `cnumber` varchar(11) NOT NULL,
  `email` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `address` varchar(256) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `credential`
--

INSERT INTO `credential` (`id`, `name`, `username`, `cnumber`, `email`, `password`, `address`, `status`) VALUES
(15, 'Zobayer Alam', 'alam69', '01778651619', 'alam@gmail.com', 'user1', 'YDT[OKNSRTHOPBJIKSDFGBPBJOSDFGBJOPBN', 1);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(8) NOT NULL,
  `event_name` varchar(64) NOT NULL,
  `event_date` date NOT NULL,
  `event_details` varchar(256) NOT NULL,
  `posted_by` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `event_name`, `event_date`, `event_details`, `posted_by`) VALUES
(1, 'denim expo', '2023-11-14', 'qwtrfwefwef', ''),
(2, 'pharma expo', '2023-11-18', '', ''),
(3, 'defence expo', '2023-11-29', 'joined by bangladesh army', ''),
(4, 'aluuuuuuuuu', '2023-11-22', 'safsadfaefaef', ''),
(5, 'gvfsgusfdgu', '2023-11-30', 'sfsdfsdfsdfsdfsd', ''),
(6, 'rtyryrthrhh', '2023-11-28', 'rthrthrthrthrthrth', '25002'),
(7, 'admin test', '2023-11-15', 'posted by test', '25000'),
(8, 'project', '2023-11-15', 'join now!!', '25000');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_data`
--

CREATE TABLE `gallery_data` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery_data`
--

INSERT INTO `gallery_data` (`id`, `image_path`, `title`, `description`, `created_at`) VALUES
(7, 'giphy.gif', '1', '1', '2023-12-02 20:34:25'),
(8, 'pexels-emir-kaan-okutan-2403568.jpg', '2', '2', '2023-12-02 20:34:34'),
(9, 'pexels-jonathan-borba-3014856.jpg', '3', '3', '2023-12-02 20:34:39'),
(10, 'pexels-jonathan-borba-18853312.jpg', '4', '4', '2023-12-02 20:34:44'),
(11, 'pexels-lisa-fotios-18844140.jpg', '5', '5', '2023-12-02 20:34:49'),
(12, 'pexels-nathan-cowley-1128784.jpg', '6', '6', '2023-12-02 20:34:56');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `posted_by_id` varchar(16) NOT NULL,
  `posted_by_username` varchar(32) NOT NULL,
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`posted_by_id`, `posted_by_username`, `id`, `title`, `content`, `created_at`, `status`) VALUES
('', 'alam56', 21, 'tracking test', 'posted_by column check', '2023-11-10 14:25:34', 0),
('15', 'alam56', 23, 'updated tracker test', 'id+username', '2023-11-10 14:38:34', 0);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_info`
--

CREATE TABLE `purchase_info` (
  `user_id` int(6) NOT NULL,
  `ticket_id` varchar(10) NOT NULL,
  `event_name` varchar(256) NOT NULL,
  `venue` varchar(64) NOT NULL,
  `ticket_quantity` int(3) NOT NULL,
  `contact_number` varchar(11) NOT NULL,
  `email` varchar(32) NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_info`
--

INSERT INTO `purchase_info` (`user_id`, `ticket_id`, `event_name`, `venue`, `ticket_quantity`, `contact_number`, `email`, `name`) VALUES
(15, '2Z2TD5907S', 'dgvc', '', 20, '01778651619', 'alam@gmail.com', 'Zobayer Alam'),
(15, 'ZBW9QRL5HM', 'project', '', 15, '01778651619', 'alam@gmail.com', 'Zobayer Alam'),
(15, 'CTBQMZOQ63', 'rock', '', 2, '01778651619', 'alam@gmail.com', 'Zobayer Alam'),
(15, 'YD4JCYCE2Z', 'rock', '', 23, '01778651619', 'alam@gmail.com', 'Zobayer Alam'),
(15, '71FIY1SCVT', 'aiub', 'aiub', 14, '01778651619', 'alam@gmail.com', 'Zobayer Alam'),
(15, '4ZL5MU8CRB', 'dgvc', 'test', 13, '01778651619', 'alam@gmail.com', 'Zobayer Alam');

-- --------------------------------------------------------

--
-- Table structure for table `query`
--

CREATE TABLE `query` (
  `q_id` int(8) NOT NULL,
  `u_id` int(8) NOT NULL,
  `u_name` varchar(10) NOT NULL,
  `u_email` varchar(32) NOT NULL,
  `q_title` varchar(32) NOT NULL,
  `q_des` varchar(256) NOT NULL,
  `q_fed` varchar(256) NOT NULL,
  `fd_by` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `query`
--

INSERT INTO `query` (`q_id`, `u_id`, `u_name`, `u_email`, `q_title`, `q_des`, `q_fed`, `fd_by`) VALUES
(1, 15, 'alam69', 'alam@gmail.com', 'data insertion test', 'data insertion test 101\r\n', 'QUERY FEEDBACK RETURNED', '25002');

-- --------------------------------------------------------

--
-- Table structure for table `quotation`
--

CREATE TABLE `quotation` (
  `qo_id` int(8) NOT NULL,
  `u_id` int(8) NOT NULL,
  `u_name` varchar(10) NOT NULL,
  `u_email` varchar(32) NOT NULL,
  `qo_about` varchar(32) NOT NULL,
  `qo_des` varchar(256) NOT NULL,
  `qo_fed` varchar(256) NOT NULL,
  `fd_by` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quotation`
--

INSERT INTO `quotation` (`qo_id`, `u_id`, `u_name`, `u_email`, `qo_about`, `qo_des`, `qo_fed`, `fd_by`) VALUES
(1, 15, 'alam69', 'alam@gmail.com', 'hsdgfkjhgvsjdfghjksfgjks', 'sfoiyuhsdgfihgsfioysfsfasfasf', 'QUOTATION FEED BACK RETURNED', '25002');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_cr`
--

CREATE TABLE `ticket_cr` (
  `Showid` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `venue` varchar(255) NOT NULL,
  `ticket_price` int(10) NOT NULL,
  `total_tickets` int(11) NOT NULL,
  `available_tickets` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket_cr`
--

INSERT INTO `ticket_cr` (`Showid`, `event_name`, `venue`, `ticket_price`, `total_tickets`, `available_tickets`) VALUES
(2, 'dgvc', 'test', 3999, 500, 422),
(3, 'aiub', 'aiub', 250, 500, 321),
(4, 'rock', 'aiub', 250, 5000, 4875),
(5, 'project', 'hall 01', 999, 2000, 1785);

-- --------------------------------------------------------

--
-- Table structure for table `venues`
--

CREATE TABLE `venues` (
  `venue_id` int(3) NOT NULL,
  `venue_name` varchar(32) NOT NULL,
  `venue_fee` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `venues`
--

INSERT INTO `venues` (`venue_id`, `venue_name`, `venue_fee`) VALUES
(1, 'HALL - 01', 400000),
(2, 'HALL - 02', 400000),
(3, 'HALL - 03', 400000),
(4, 'HALL - 04', 550000),
(5, 'HALL - 05', 200000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_mod`
--
ALTER TABLE `admin_mod`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `complaint`
--
ALTER TABLE `complaint`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `credential`
--
ALTER TABLE `credential`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_data`
--
ALTER TABLE `gallery_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `query`
--
ALTER TABLE `query`
  ADD PRIMARY KEY (`q_id`);

--
-- Indexes for table `quotation`
--
ALTER TABLE `quotation`
  ADD PRIMARY KEY (`qo_id`);

--
-- Indexes for table `ticket_cr`
--
ALTER TABLE `ticket_cr`
  ADD PRIMARY KEY (`Showid`);

--
-- Indexes for table `venues`
--
ALTER TABLE `venues`
  ADD PRIMARY KEY (`venue_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_mod`
--
ALTER TABLE `admin_mod`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25005;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `complaint`
--
ALTER TABLE `complaint`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `credential`
--
ALTER TABLE `credential`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `gallery_data`
--
ALTER TABLE `gallery_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `query`
--
ALTER TABLE `query`
  MODIFY `q_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quotation`
--
ALTER TABLE `quotation`
  MODIFY `qo_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ticket_cr`
--
ALTER TABLE `ticket_cr`
  MODIFY `Showid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `venues`
--
ALTER TABLE `venues`
  MODIFY `venue_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
