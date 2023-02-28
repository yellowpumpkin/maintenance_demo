-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2023 at 02:40 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `repair_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_case`
--

CREATE TABLE `tbl_case` (
  `case_id` int(10) NOT NULL,
  `date_start` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_end` date NOT NULL,
  `machine_no` varchar(255) NOT NULL,
  `machine_name` varchar(255) NOT NULL,
  `problem_case` text NOT NULL,
  `place_name` varchar(255) NOT NULL,
  `urgency` varchar(255) NOT NULL,
  `user_id` int(10) NOT NULL,
  `agency` varchar(255) NOT NULL,
  `status_id` int(10) NOT NULL,
  `tech` varchar(255) DEFAULT 'ยังไม่มีผู้ดำเนินการ',
  `date_operation` date DEFAULT NULL,
  `date_completion` date DEFAULT NULL,
  `problems_found` text NOT NULL,
  `details` text NOT NULL,
  `spare_part` text NOT NULL,
  `note` text NOT NULL,
  `case_status` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_case`
--

INSERT INTO `tbl_case` (`case_id`, `date_start`, `date_end`, `machine_no`, `machine_name`, `problem_case`, `place_name`, `urgency`, `user_id`, `agency`, `status_id`, `tech`, `date_operation`, `date_completion`, `problems_found`, `details`, `spare_part`, `note`, `case_status`) VALUES
(1, '2023-02-22 07:53:12', '0000-00-00', 'CL-FL-GA-08', 'รถโฟล์คลิฟท์', 'ครบรอบถ่ายน้ำมันเครื่อง', 'จุดตัดผ่า', 'ด่วน', 5, 'โรงงาน', 5, 'technician', '2023-02-23', '2023-03-04', '', 'ถ่ายน้ำมันเครื่อง', '', '    ', 0),
(2, '2023-02-22 07:53:51', '0000-00-00', 'CL-FL-GA-08', 'รถโฟล์คลิฟท์', 'ฝาหม้อต้มแก๊สขาด', 'จุดตัดผ่า', 'ปกติ', 5, 'โรงงาน', 1, 'ยังไม่มีผู้ดำเนินการ', NULL, NULL, '', '', '', '', 0),
(3, '2023-02-22 07:58:51', '0000-00-00', 'WI-FL-EE01', 'รถโฟล์คลิฟท์', 'ล้อประคองสึก', 'จุดตัดผ่า', 'ปกติ', 6, 'โรงงาน', 5, 'technician2', '2023-02-27', '2023-02-28', 'ล้อเสื่อมสภาพ', 'เปลี่ยนล้อใหม่', 'ล้อประคอง', ' ', 0),
(4, '2023-02-22 07:59:27', '0000-00-00', 'หมายเลข 7', 'รถยก 3 ตัน', 'เครื่องยนต์สะดุด', 'โรงงาน', 'ปกติ', 6, 'โรงงาน', 5, 'technician2', '2023-02-22', '2023-02-22', 'เครื่องยนต์มีอาการสะดุด', 'เปลี่ยนซีลเลี้ยวคานหลัง และซีลกระบอก', 'ซีลเลี้ยวคานหลังด้านขวา\r\nซีลกระบอกคว่ำ-หงาย', ' ', 0),
(5, '2023-02-27 03:25:59', '2023-02-28', 'M-7', 'รถยก 3 ตัน', 'เครื่องยนต์สะดุด', 'จุดตัดผ่า', 'ด่วนที่สุด', 6, 'โรงงาน', 2, 'technician', NULL, NULL, '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_department`
--

CREATE TABLE `tbl_department` (
  `department_id` int(10) NOT NULL,
  `department_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_department`
--

INSERT INTO `tbl_department` (`department_id`, `department_name`) VALUES
(1, 'OD'),
(2, 'หัวหน้าแผนก จุด MACO'),
(3, 'Leader Wearhouse'),
(4, 'Leader Production'),
(5, 'Engineer Production'),
(6, 'Leader Maintenance');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_status`
--

CREATE TABLE `tbl_status` (
  `sid` int(10) NOT NULL,
  `status_name` varchar(255) NOT NULL,
  `status_name_en` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_status`
--

INSERT INTO `tbl_status` (`sid`, `status_name`, `status_name_en`) VALUES
(0, 'แจ้งซ่อม', ''),
(1, 'รอตรวจสอบ', 'pending'),
(2, 'รอดำเนินการ', 'in process'),
(3, 'กำลังดำเนินการ', ''),
(4, 'เลื่อนการดำเนินงาน', ''),
(5, 'สำเร็จ', 'done'),
(6, 'ยกเลิก', 'cancel');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `phone` int(10) NOT NULL,
  `department` int(10) NOT NULL,
  `urole` varchar(255) NOT NULL,
  `status` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `username`, `password`, `firstname`, `lastname`, `phone`, `department`, `urole`, `status`, `created_at`) VALUES
(0, 'admin', '$2y$10$v.fWMy4UJl.NZSRJ2HZcv.ZTAgsZqYzzMKOE8Op8/pY1njtb/zgba', 'admin', 'admin', 987654321, 1, 'admin', 0, '2023-02-21 09:28:09'),
(1, 'yellowpumpkin', '$2y$10$wDqN3xfOCOWZCebIJb96gOXLS1dgCIj5JL0SXM9BkpkU.o72yBxDC', 'Gewwarin', 'Wangruamklang', 956136449, 1, 'admin', 0, '2023-02-21 09:31:23'),
(2, 'leader', '$2y$10$GoDUflBpIExExjMWbP2QrOpT2o.OojglRwgLqonxVpX3V.BapH/gC', 'suriya', 'c', 847568343, 1, 'leader', 0, '2023-02-22 02:05:32'),
(3, 'technician', '$2y$10$xQuV12ZtsOg.29xlP9CErOkFGBkPLMMBQMVVE2sn5/5j0OMDNZMJW', 'panuwat', 'supap', 987654321, 2, 'technician', 0, '2023-02-22 02:10:51'),
(4, 'technician2', '$2y$10$Za1pTPsWIfYUDx/qqAl5YOmJ12M6IVUyGhKPQ4ltaDBXtpbMtfASS', 'daniel', 'kang', 987654321, 5, 'technician', 0, '2023-02-22 02:11:33'),
(5, 'users01', '$2y$10$9JRUZUTKCwBhk7k2hr9DleVgniVYty7HLXin3TTkaYc41u2rW0le.', 'somchai', 'jaidee', 987654321, 3, 'users', 0, '2023-02-22 02:14:41'),
(6, 'users02', '$2y$10$/JdLuqrVRjg/2rTZXRtfquEsNuVOfu6HEvkpMyfttvTSapr2hpftu', 'johnny', 'lee', 987654321, 4, 'users', 0, '2023-02-22 02:15:16'),
(7, 'test1', '$2y$10$k.Loo/VqWbieXu2Et.c1YORoqk0.LbiHx05TiSFR1F3Duvkjry7PC', 'test1', 'test1', 917786161, 1, 'users', 0, '2023-02-22 02:16:02'),
(8, 'test2', '$2y$10$vo/W1hpbn6xCvVcxFybFleo0.qxhbcZ39nBz/59iHI7hsQY15EOxm', 'test1', 'test1', 917786161, 4, 'users', 0, '2023-02-22 02:16:18'),
(9, 'test3', '$2y$10$ximZ5jJIHRFaFRENi2FVbOrm6yJBWhifkDBhTASJnbQQmpOKPnjpW', 'daniel', 'kang', 987654321, 2, 'users', 0, '2023-02-22 02:16:37'),
(10, 'test4', '$2y$10$I0yWWIRl/cEyiSzA2U8S2u5NJr8ofMufIOOR8BgNx0R0nTsifvRoK', '11111', '11111', 987654321, 6, 'users', 0, '2023-02-22 02:17:07'),
(11, '111312', '$2y$10$XvVVgGxDSUQfb/UGF9cfGOGfDT4gM6IhzJyiGj2WASWxPPAMrs/By', '231', '1231231', 987654321, 4, 'users', 0, '2023-02-22 02:17:21'),
(12, '1231', '$2y$10$ma9MMoPE9ZhMfB5p2RD5sueM.z9FhtN.aLC3auY2yfTUJssXSnunC', '123231', '112313', 987654321, 3, 'users', 0, '2023-02-22 02:17:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_case`
--
ALTER TABLE `tbl_case`
  ADD PRIMARY KEY (`case_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_department`
--
ALTER TABLE `tbl_department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `tbl_status`
--
ALTER TABLE `tbl_status`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department` (`department`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_case`
--
ALTER TABLE `tbl_case`
  MODIFY `case_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_department`
--
ALTER TABLE `tbl_department`
  MODIFY `department_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_status`
--
ALTER TABLE `tbl_status`
  MODIFY `sid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_case`
--
ALTER TABLE `tbl_case`
  ADD CONSTRAINT `status_id` FOREIGN KEY (`status_id`) REFERENCES `tbl_status` (`sid`),
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`);

--
-- Constraints for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD CONSTRAINT `department` FOREIGN KEY (`department`) REFERENCES `tbl_department` (`department_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
