-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 19, 2021 at 02:13 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `preschool`
--

-- --------------------------------------------------------

--
-- Table structure for table `admission`
--

CREATE TABLE `admission` (
  `id` int(11) NOT NULL,
  `pupils_full_name` varchar(255) NOT NULL,
  `birth_certificate_no` varchar(255) NOT NULL,
  `age` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `father_name` varchar(255) NOT NULL,
  `mother_name` varchar(255) NOT NULL,
  `father_contact` varchar(255) NOT NULL,
  `mother_contact` varchar(255) NOT NULL,
  `guardian_name` varchar(255) DEFAULT NULL,
  `guardian_contact` varchar(255) DEFAULT NULL,
  `upi` varchar(255) NOT NULL,
  `special_need` varchar(255) NOT NULL,
  `admission_fee` varchar(255) DEFAULT NULL,
  `school_fee` varchar(255) NOT NULL,
  `graduation_fee` varchar(255) NOT NULL,
  `lunch` varchar(255) NOT NULL,
  `bording` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admission`
--

INSERT INTO `admission` (`id`, `pupils_full_name`, `birth_certificate_no`, `age`, `class`, `father_name`, `mother_name`, `father_contact`, `mother_contact`, `guardian_name`, `guardian_contact`, `upi`, `special_need`, `admission_fee`, `school_fee`, `graduation_fee`, `lunch`, `bording`, `photo`, `gender`) VALUES
(1, 'joshu mbithi kimanzi', 'L0340945494', '6', 'pp2', 'kim', 'glady', '0707333776', '0799807265', 'none', 'none', 'm790877gb', 'no', '500', '600', '120', '200', 'no', 'http://localhost/pre-primaryschoolmanagementsystem/uploads/files/qf8hyjt2o3ea6si.jpg', 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`id`, `title`, `content`, `author`, `date`) VALUES
(1, 'school fee', 'All parent with school fee balances clear before next term.Thank you.', 'headteacher', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `apply_for_admission`
--

CREATE TABLE `apply_for_admission` (
  `id` int(11) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `gender` varchar(80) DEFAULT NULL,
  `class` varchar(80) DEFAULT NULL,
  `special_conditions` varchar(255) NOT NULL,
  `upi` varchar(80) DEFAULT NULL,
  `parent_contact_no` varchar(255) NOT NULL,
  `resdence` varchar(255) NOT NULL,
  `home_county` varchar(255) NOT NULL,
  `year_of_birth` varchar(80) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `with_birth_certificate` varchar(255) NOT NULL,
  `father_full_name` varchar(255) NOT NULL,
  `mother_full_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `apply_for_admission`
--

INSERT INTO `apply_for_admission` (`id`, `surname`, `last_name`, `photo`, `gender`, `class`, `special_conditions`, `upi`, `parent_contact_no`, `resdence`, `home_county`, `year_of_birth`, `first_name`, `with_birth_certificate`, `father_full_name`, `mother_full_name`) VALUES
(1, 'sonko', 'mbuvi', 'http://localhost/pre-primaryschoolmanagementsystem/uploads/files/m6_g7nsw41phtxu.jpg', 'Male', 'grade 2', 'no', 'none', '07073333776', 'voi', 'taita', '2021-01-21', 'michael', 'yes', 'sonko j .m', 'glays m .m');

-- --------------------------------------------------------

--
-- Table structure for table `assignment`
--

CREATE TABLE `assignment` (
  `id` int(11) NOT NULL,
  `assignment_name` varchar(255) NOT NULL,
  `assignment_type` varchar(255) NOT NULL,
  `download` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assignment`
--

INSERT INTO `assignment` (`id`, `assignment_name`, `assignment_type`, `download`, `date`) VALUES
(1, 'kiswahil', 'holyday assigment', 'http://localhost/pre-primaryschoolmanagementsystem/uploads/files/xfulg10vkjsrod_.docx', '0000-00-00'),
(2, 'kiswahil', 'edterm', 'http://localhost/pre-primaryschoolmanagementsystem/uploads/files/640n7h5se3uxfbj.docx', '2021-01-28'),
(3, 'english', 'holyday assigment', 'http://localhost/pre-primaryschoolmanagementsystem/uploads/files/vhkcw8il_uaozg9.docx', '2021-01-28'),
(4, 'math', 'cat', 'http://localhost/pre-primaryschoolmanagementsystem/uploads/files/qf3tbgkcuiwsx51.docx', '2021-01-29');

-- --------------------------------------------------------

--
-- Table structure for table `enrolment`
--

CREATE TABLE `enrolment` (
  `id` int(11) NOT NULL,
  `enrol_year` varchar(255) NOT NULL,
  `number_of_boy` varchar(255) NOT NULL,
  `number_of_girls` varchar(255) NOT NULL,
  `age_below_6` varchar(255) NOT NULL,
  `age_above_10` varchar(255) NOT NULL,
  `number_of_dropout` varchar(255) NOT NULL,
  `transfer` varchar(255) NOT NULL,
  `total_pupils_in_school` varchar(255) NOT NULL,
  `pupils_with_upi` varchar(255) NOT NULL,
  `pupils_birth_certificate` varchar(255) NOT NULL,
  `pupils_without_certificate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `enrolment`
--

INSERT INTO `enrolment` (`id`, `enrol_year`, `number_of_boy`, `number_of_girls`, `age_below_6`, `age_above_10`, `number_of_dropout`, `transfer`, `total_pupils_in_school`, `pupils_with_upi`, `pupils_birth_certificate`, `pupils_without_certificate`) VALUES
(1, '2021', '300', '200', '50', '7', '0', '0', '500', '89', '90', '60');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `title`, `content`, `author`, `date`) VALUES
(1, 'harambee', 'hhhh', 'teacher', 'Enter Date');

-- --------------------------------------------------------

--
-- Table structure for table `feestracture`
--

CREATE TABLE `feestracture` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feestracture`
--

INSERT INTO `feestracture` (`id`, `title`, `content`, `date`) VALUES
(1, 'term 1', 'http://localhost/pre-primaryschoolmanagementsystem/uploads/files/bth3mce45_6f8xp.pdf', 'Enter Date'),
(2, 'PP1 stracture download', 'http://localhost/pre-primaryschoolmanagementsystem/uploads/files/i16ajckmdwnzg39.pdf', 'Enter Date'),
(3, 'pp2', 'http://localhost/pre-primaryschoolmanagementsystem/uploads/files/j1ziqf9r04p73bu.pdf', '2021-01-20 20:15:49');

-- --------------------------------------------------------

--
-- Table structure for table `how_to_make_payment`
--

CREATE TABLE `how_to_make_payment` (
  `id` int(11) NOT NULL,
  `fullname_of_depositor` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `transaction_code` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `transaction_date` varchar(255) NOT NULL,
  `comments` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `how_to_make_payment`
--

INSERT INTO `how_to_make_payment` (`id`, `fullname_of_depositor`, `payment_method`, `transaction_code`, `amount`, `transaction_date`, `comments`) VALUES
(1, 'kimtech sonko', 'm-pesa', 'L0DJKHGBGBP', '500', '2021-01-21 16:12:17', 'Nitamliazia the remaining balance next week');

-- --------------------------------------------------------

--
-- Table structure for table `perfomance`
--

CREATE TABLE `perfomance` (
  `id` int(11) NOT NULL,
  `year` varchar(255) NOT NULL,
  `term` varchar(255) NOT NULL,
  `name_of_pupil` varchar(255) NOT NULL,
  `class_teacher_report` varchar(255) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `class` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `perfomance`
--

INSERT INTO `perfomance` (`id`, `year`, `term`, `name_of_pupil`, `class_teacher_report`, `comment`, `date`, `class`) VALUES
(1, '2021', 'term 1', 'kimtech', '<p>hdhfgffg<br></p>', 'good', '2021-01-21', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `birth_day` varchar(255) NOT NULL,
  `resdence` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `login_session_key` varchar(255) DEFAULT NULL,
  `email_status` varchar(255) DEFAULT NULL,
  `password_expire_date` datetime DEFAULT '2021-04-21 00:00:00',
  `password_reset_key` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `account_status` varchar(255) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `photo`, `birth_day`, `resdence`, `phone`, `username`, `password`, `email`, `login_session_key`, `email_status`, `password_expire_date`, `password_reset_key`, `role`, `class`, `account_status`) VALUES
(1, 'kim', 'sonk', 'http://localhost/pre-primaryschoolmanagementsystem/uploads/files/p_alm365zig74b8.jpg', '12/06/1990', 'nairobi', '0707333776', 'kimtech', '$2y$10$F2br6Zvs35l6rg3YM7oSnuTojUqf4ySxVjLQzoXoJf4ifHn.fJYHq', 'kim@gmail.com', NULL, NULL, '2021-04-21 00:00:00', NULL, 'headteacher', '', 'Active'),
(2, 'sonko', 'kim', 'http://localhost/pre-primaryschoolmanagementsystem/uploads/files/sfacl02xohud_y7.jpg', '12/02/2019', 'voi', '0707333776', 'sonko', '$2y$10$I2EBOkrGZmJul5vmcqTQ4e3o3wKKQm7jrxl18n.fXZasqqmecz96e', 'kim1@gmail.com', NULL, NULL, '2021-04-21 00:00:00', NULL, 'pupils', '2', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admission`
--
ALTER TABLE `admission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `apply_for_admission`
--
ALTER TABLE `apply_for_admission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignment`
--
ALTER TABLE `assignment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enrolment`
--
ALTER TABLE `enrolment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feestracture`
--
ALTER TABLE `feestracture`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `how_to_make_payment`
--
ALTER TABLE `how_to_make_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `perfomance`
--
ALTER TABLE `perfomance`
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
-- AUTO_INCREMENT for table `admission`
--
ALTER TABLE `admission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `apply_for_admission`
--
ALTER TABLE `apply_for_admission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `assignment`
--
ALTER TABLE `assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `enrolment`
--
ALTER TABLE `enrolment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `feestracture`
--
ALTER TABLE `feestracture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `how_to_make_payment`
--
ALTER TABLE `how_to_make_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `perfomance`
--
ALTER TABLE `perfomance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
