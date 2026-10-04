-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2026 at 03:48 AM
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
-- Database: `miniproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `name` varchar(70) NOT NULL,
  `email` varchar(70) NOT NULL,
  `detail` longtext NOT NULL,
  `question_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `name`, `email`, `detail`, `question_id`) VALUES
(1, 'user2', '671463007@crrua.ac.th', 'ขอรายละเอียด', 1),
(2, 'user', '671463077@crrua.ac.th', '1', 2);

-- --------------------------------------------------------

--
-- Table structure for table `fishs`
--

CREATE TABLE `fishs` (
  `fish_id` int(11) NOT NULL,
  `namefish` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `care_detail` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fishs`
--

INSERT INTO `fishs` (`fish_id`, `namefish`, `image`, `description`, `care_detail`, `category`, `status`, `created_at`, `user_id`) VALUES
(3, 'ปลาหางนกยูง', 'fish_img/fish_69682101ad8cd.jpg', 'ตัวเล็ก สีสันสดใส หางยาวสวย ลวดลายหลากหลาย', 'เลี้ยงง่าย ชอบอยู่เป็นกลุ่ม เปลี่ยนน้ำสม่ำเสมอ กินอาหารเม็ดและไรแดง', '1', 'approved', '2026-01-15 06:04:33', 5),
(4, 'ปลากัด', 'fish_img/fish_6968211d82897.jpg', 'สีสดจัด ครีบยาว สวยเด่น', 'เลี้ยงเดี่ยว น้ำสะอาด อาหารโปรตีนสูง', '1', 'approved', '2026-01-15 06:05:01', 5),
(5, 'ปลาทอง', 'fish_img/fish_6968213390621.jpg', 'ตัวกลม สีทอง/แดง มีหลายสายพันธุ์', 'ต้องตู้ใหญ่ กรองแรง เปลี่ยนน้ำบ่อย เพราะขับถ่ายเยอะ', '1', 'approved', '2026-01-15 06:05:23', 5),
(6, 'ปลาเทวดา', 'fish_img/fish_6968214b4e493.jpg', 'ลำตัวแบน ครีบยาว ดูสง่างาม', 'ใช้ตู้สูง น้ำอุ่น ไม่ควรเลี้ยงกับปลาตัวเล็กมาก', '1', 'approved', '2026-01-15 06:05:47', 5),
(7, 'ปลาหมอสี', 'fish_img/fish_69682165662d2.jpg', 'สีสด ลวดลายจัด', 'ต้องตู้ใหญ่ มีหินให้หลบซ่อน ค่อนข้างดุ', '1', 'approved', '2026-01-15 06:06:13', 5),
(8, 'ปลาหมอครอสบรีด', 'fish_img/fish_6968217bdc4b8.jpg', 'หัวโหนก ตัวอ้วน สีเข้ม', 'เลี้ยงเดี่ยวดีที่สุด น้ำสะอาด อาหารโปรตีน', '1', 'approved', '2026-01-15 06:06:35', 5),
(9, 'ปลานีออน', 'fish_img/fish_6968218f92c6c.jpg', 'ตัวเล็ก มีแถบเรืองแสงสีฟ้าแดง', 'เลี้ยงเป็นฝูง น้ำค่อนข้างอ่อน', '1', 'approved', '2026-01-15 06:06:55', 5),
(10, 'ปลาคาร์ดินัล', 'fish_img/fish_696821a57f1ae.jpg', 'สีแดงสดกว่า Neon', 'ต้องน้ำสะอาดและอุณหภูมิคงที่', '1', 'approved', '2026-01-15 06:07:17', 5),
(11, 'ปลาซิวหางกรรไกร', 'fish_img/fish_696821c146cbd.jpg', 'ว่ายเร็ว หางแยกเป็นสองแฉก', 'เลี้ยงเป็นฝูง ต้องพื้นที่ว่ายน้ำ', '1', 'approved', '2026-01-15 06:07:45', 5),
(12, 'ปลาซิวม้าลาย', 'fish_img/fish_696821d784c33.jpg', 'ลายขวางเหมือนม้าลาย', 'เลี้ยงง่าย แข็งแรง เหมาะกับมือใหม่', '1', 'approved', '2026-01-15 06:08:07', 5),
(13, 'ปลาการ์ตูน', 'fish_img/fish_696821fd992cf.jpg', 'สีส้มลายขาว', 'ตู้ทะเล ระบบกรองดี', '2', 'approved', '2026-01-15 06:08:45', 5),
(14, 'ปลาสลิดหิน', 'fish_img/fish_696822168d496.jpg', 'สีฟ้าสด', 'ระวังนิสัยดุ', '2', 'approved', '2026-01-15 06:09:10', 5),
(15, 'ปลานกแก้วทะเล', 'fish_img/fish_6968222dad7c8.jpg', 'สีรุ้งสด', 'ต้องตู้ใหญ่', '2', 'approved', '2026-01-15 06:09:33', 5),
(16, 'ปลาสลิดหางเหลือง', 'fish_img/fish_696822526012f.jpg', 'สีฟ้าสด', 'ว่ายน้ำเก่ง ต้องพื้นที่', '2', 'approved', '2026-01-15 06:10:10', 5),
(17, 'ปลาผีเสื้อทะเล', 'fish_img/fish_6968227ba2658.jpg', 'ลวดลายสวยมาก', 'ค่อนข้างเลี้ยงยาก', '2', 'approved', '2026-01-15 06:10:51', 5),
(18, 'ปลาสิงโต', 'fish_img/fish_6968229679e7c.jpg', 'ครีบยาว มีพิษ', 'เลี้ยงเดี่ยว ระวังอันตราย', '2', 'approved', '2026-01-15 06:11:18', 5),
(19, 'ปลาแมนดาริน', 'fish_img/fish_696822b4a6ce2.jpg', 'สีฟ้าเขียวลายสวย', 'ต้องตู้สมบูรณ์ มีอาหารสด', '2', 'approved', '2026-01-15 06:11:48', 5),
(20, 'ปลาบลูแทง', 'fish_img/fish_696822cbaa6be.jpg', 'สีฟ้าสด', 'ต้องตู้ใหญ่และน้ำเสถียร', '2', 'approved', '2026-01-15 06:12:11', 5),
(21, 'ปลากระเบนทะเล', 'fish_img/fish_696822e08de06.jpg', 'ตัวแบน ใหญ่', 'ต้องตู้ขนาดใหญ่มาก', '2', 'approved', '2026-01-15 06:12:32', 5),
(22, 'ปลาไหลมอเรย์', 'fish_img/fish_696823022aac4.jpg', 'ลายขาวดำ', 'ต้องมีที่ซ่อนและฝาปิดตู้', '2', 'approved', '2026-01-15 06:13:06', 5),
(23, 'ปลา1', 'fish_img/fish_69684d0b63f62.jpg', '1', '1', '2', 'approved', '2026-01-15 09:12:27', 5);

-- --------------------------------------------------------

--
-- Table structure for table `fish_comments`
--

CREATE TABLE `fish_comments` (
  `id` int(11) NOT NULL,
  `fish_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `detail` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `fish_comments`
--

INSERT INTO `fish_comments` (`id`, `fish_id`, `user_id`, `name`, `email`, `detail`, `time`) VALUES
(1, 22, 5, 'user', '671463077@crrua.ac.th', '1', '2026-01-15 02:04:31');

-- --------------------------------------------------------

--
-- Table structure for table `fish_likes`
--

CREATE TABLE `fish_likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fish_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fish_likes`
--

INSERT INTO `fish_likes` (`id`, `user_id`, `fish_id`) VALUES
(12, 5, 22);

-- --------------------------------------------------------

--
-- Table structure for table `fish_type`
--

CREATE TABLE `fish_type` (
  `fish_typeid` int(11) NOT NULL,
  `fish_typename` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fish_type`
--

INSERT INTO `fish_type` (`fish_typeid`, `fish_typename`) VALUES
(1, 'ปลาน้ำจืด'),
(2, 'ปลาน้ำเค็ม');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `topic` varchar(255) NOT NULL,
  `detail` longtext NOT NULL,
  `name` varchar(70) NOT NULL,
  `email` varchar(70) NOT NULL,
  `created` datetime NOT NULL,
  `view` int(4) NOT NULL,
  `reply` int(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `topic`, `detail`, `name`, `email`, `created`, `view`, `reply`) VALUES
(1, 'ทำไมปลาตาย', 'ปลาตาย', 'user', '671463077@crrua.ac.th', '2026-01-15 06:13:25', 2, 1),
(2, 'ทดสอบ1', '1', 'user', '671463077@crrua.ac.th', '2026-01-15 09:14:01', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('admin','user','public','') NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `pass`, `name`, `email`, `role`, `image`) VALUES
(4, 'admin', '$2y$10$vQkADHoCeozFqcn8ckRqxuL8FKODDawkGHQzwa8/Ox3SmuKA/szD2', 'admin', '671463055@crrua.ac.th', 'admin', 'fish_img/profile/avatar-1.jpg'),
(5, 'user', '$2y$10$UcwbsgWwyJuPztezVD0CcOB6s5Y2VOQYHgqdOOze58yq8Di.5GvNi', 'user', '671463077@crrua.ac.th', 'user', 'fish_img/profile/avatar-1.jpg'),
(6, 'user2', '$2y$10$.qPIuswM1bELgC1bNcHKtu6DMInCJ1.MkF9c0gHdWC.mguPUQ.qyu', 'user2', '671463007@crrua.ac.th', 'user', 'fish_img/profile/user_6_1768441489.jpg'),
(7, '1', '$2y$10$Kw0dNFz9ql63fZKhuyfKB.r3knnP0sfkYWcwwdet0NYKUjs012D.S', '1', 'theeradet558822@gmail.com', '', 'fish_img/profile/avatar-1.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fishs`
--
ALTER TABLE `fishs`
  ADD PRIMARY KEY (`fish_id`);

--
-- Indexes for table `fish_comments`
--
ALTER TABLE `fish_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fish_likes`
--
ALTER TABLE `fish_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fish_type`
--
ALTER TABLE `fish_type`
  ADD PRIMARY KEY (`fish_typeid`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fishs`
--
ALTER TABLE `fishs`
  MODIFY `fish_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `fish_comments`
--
ALTER TABLE `fish_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fish_likes`
--
ALTER TABLE `fish_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `fish_type`
--
ALTER TABLE `fish_type`
  MODIFY `fish_typeid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
