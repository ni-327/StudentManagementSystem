-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2025 at 04:41 PM
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
-- Database: `student_management_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `Admin_ID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Admin_ID`, `Username`, `Password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `Department_ID` int(11) NOT NULL,
  `Department_Name` varchar(100) NOT NULL,
  `Program_Type` varchar(50) DEFAULT NULL,
  `Institution_Type` varchar(50) DEFAULT NULL,
  `Status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`Department_ID`, `Department_Name`, `Program_Type`, `Institution_Type`, `Status`) VALUES
(1, 'HND in Accountancy', 'HND', 'Public', 'Active'),
(2, 'HND in Business Administration', 'HND', 'Public', 'Active'),
(3, 'HND in Business Finance', 'HND', 'Public', 'Active'),
(4, 'HND in Business Management', 'HND', 'Public', 'Active'),
(5, 'HND in Information Technology', 'HNDIT', 'Public', 'Active'),
(6, 'HND in Civil Engineering', 'HNDE', 'Public', 'Active'),
(7, 'HND in Electrical Engineering', 'HNDE', 'Public', 'Active'),
(8, 'HND in Mechanical Engineering', 'HNDE', 'Public', 'Active'),
(9, 'HND in Quantity Surveying', 'HND', 'Public', 'Active'),
(10, 'HND in Food Technology', 'HND', 'Public', 'Active'),
(11, 'HND in English', 'HND', 'Public', 'Active'),
(12, 'HND in Tourism & Hospitality Management', 'HND', 'Public', 'Active'),
(13, 'HND in Agriculture', 'HND', 'Public', 'Active'),
(14, 'HND in Software Engineering', 'HNDIT', 'Private', 'Active'),
(15, 'HND in Networking & Cyber Security', 'HNDIT', 'Private', 'Active'),
(16, 'HND in Multimedia & Design', 'HND', 'Private', 'Active'),
(17, 'HND in Biomedical Engineering', 'HNDE', 'Private', 'Active'),
(18, 'HND in Nursing', 'HND', 'Private', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `Exam_ID` int(11) NOT NULL,
  `Exam_Name` varchar(100) DEFAULT NULL,
  `Exam_Type` varchar(50) DEFAULT NULL,
  `Subject_ID` int(11) DEFAULT NULL,
  `Exam_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lecturer`
--

CREATE TABLE `lecturer` (
  `Lecturer_ID` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Department_ID` int(11) DEFAULT NULL,
  `Status` varchar(10) DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lecturer_subject`
--

CREATE TABLE `lecturer_subject` (
  `lect_sub_id` int(11) NOT NULL,
  `lecturer_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `Log_ID` int(11) NOT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `Action` varchar(255) DEFAULT NULL,
  `Role` varchar(50) DEFAULT NULL,
  `Timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `user_role` enum('admin','lecturer','student','all') NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `Payment_ID` int(11) NOT NULL,
  `Student_ID` int(11) NOT NULL,
  `Result_ID` int(11) NOT NULL,
  `Payment_Method` varchar(50) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `Bank_Details` text DEFAULT NULL,
  `Payment_Date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`Payment_ID`, `Student_ID`, `Result_ID`, `Payment_Method`, `Amount`, `Bank_Details`, `Payment_Date`) VALUES
(1, 3, 5, 'Bank Transfer', 100.00, 'cash', '2025-06-08 12:29:50'),
(2, 2, 11, 'Cash', 100.00, 'cash', '2025-06-08 12:32:29'),
(3, 2, 12, 'Cash', 100.00, 'cash', '2025-06-08 13:33:09'),
(4, 3, 13, 'Bank Transfer', 100.00, 'cash', '2025-06-08 13:44:57'),
(5, 2, 15, 'Cash', 100.00, 'cash', '2025-06-08 14:14:22'),
(6, 3, 17, 'Online', 100.00, 'bank', '2025-06-08 14:19:06'),
(7, 3, 17, 'Bank Transfer', 100.00, 'cash', '2025-06-08 14:20:05'),
(8, 4, 18, 'Cash', 100.00, 'cash', '2025-06-10 22:52:48');

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE `result` (
  `Result_ID` int(11) NOT NULL,
  `Student_ID` int(11) DEFAULT NULL,
  `Subject_ID` int(11) DEFAULT NULL,
  `Lecturer_ID` int(11) DEFAULT NULL,
  `Marks` float DEFAULT NULL,
  `Grade` varchar(5) DEFAULT NULL,
  `GPA` float DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL,
  `Reschedule_Date` date DEFAULT NULL,
  `Semester` varchar(50) DEFAULT NULL,
  `Exam_Date` date DEFAULT NULL,
  `payment_status` enum('Done','Not_Paid') DEFAULT 'Not_Paid',
  `Assignment_Marks` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `Semester_ID` int(11) NOT NULL,
  `Semester_Name` varchar(50) NOT NULL,
  `Semester_Code` varchar(10) DEFAULT NULL,
  `Duration_Weeks` int(11) DEFAULT 15,
  `Description` text DEFAULT NULL,
  `Status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`Semester_ID`, `Semester_Name`, `Semester_Code`, `Duration_Weeks`, `Description`, `Status`) VALUES
(1, 'Semester 1', 'SEM1', 15, 'First semester of academic coursework', 'Active'),
(2, 'Semester 2', 'SEM2', 15, 'Second semester covering core modules', 'Active'),
(3, 'Semester 3', 'SEM3', 15, 'Third semester focused on advanced topics', 'Active'),
(4, 'Semester 4', 'SEM4', 15, 'Final semester of academic modules', 'Active'),
(5, 'In-Plant Training / Internship', 'SEM5', 15, 'Industrial training or project-based semester', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `Student_ID` int(11) NOT NULL,
  `Full_Name` varchar(100) NOT NULL,
  `Registration_Number` varchar(20) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Department_ID` int(11) DEFAULT NULL,
  `Subject_ID` int(11) DEFAULT NULL,
  `Lecturer_ID` int(11) DEFAULT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `NIC` varchar(20) DEFAULT NULL,
  `Birthday` date DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `District` varchar(100) DEFAULT NULL,
  `Semester_ID` int(11) DEFAULT NULL,
  `Semester` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_lecturer`
--

CREATE TABLE `student_lecturer` (
  `ID` int(11) NOT NULL,
  `Student_ID` int(11) NOT NULL,
  `Lecturer_ID` int(11) NOT NULL,
  `Assigned_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_subject`
--

CREATE TABLE `student_subject` (
  `ID` int(11) NOT NULL,
  `Student_ID` int(11) DEFAULT NULL,
  `Subject_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `Subject_ID` int(11) NOT NULL,
  `Subject_Code` varchar(20) NOT NULL,
  `Subject_Name` varchar(100) NOT NULL,
  `Department_ID` int(11) NOT NULL,
  `Semester_ID` int(11) NOT NULL,
  `Credits` int(11) DEFAULT 3,
  `Contact_Hours` int(11) DEFAULT 45,
  `Description` text DEFAULT NULL,
  `Status` enum('Active','Inactive') DEFAULT 'Active',
  `Lecturer_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`Subject_ID`, `Subject_Code`, `Subject_Name`, `Department_ID`, `Semester_ID`, `Credits`, `Contact_Hours`, `Description`, `Status`, `Lecturer_ID`) VALUES
(1, 'HND-BUS101', 'Principles of Management', 1, 1, 3, 45, 'Fundamentals of management theory and practice', 'Active', NULL),
(2, 'HND-BUS102', 'Business Communication', 1, 1, 3, 45, 'Effective communication in business contexts', 'Active', NULL),
(3, 'HND-BUS103', 'Financial Accounting', 1, 1, 4, 60, 'Introduction to financial accounting principles', 'Active', NULL),
(4, 'HND-BUS104', 'Business Economics', 1, 2, 3, 45, 'Micro and macroeconomic principles', 'Active', NULL),
(5, 'HND-BUS105', 'Marketing Management', 1, 2, 3, 45, 'Marketing theory and practices', 'Active', NULL),
(6, 'HND-BUS106', 'Human Resource Management', 1, 2, 3, 45, 'Introduction to HRM concepts', 'Active', NULL),
(7, 'HND-IT101', 'Fundamentals of Computing', 2, 1, 3, 45, 'Basics of computer systems and operations', 'Active', NULL),
(8, 'HND-IT102', 'Programming in Java', 2, 1, 4, 60, 'Object-oriented programming using Java', 'Active', NULL),
(9, 'HND-IT103', 'Database Management Systems', 2, 1, 4, 60, 'Introduction to relational databases and SQL', 'Active', NULL),
(10, 'HND-IT104', 'Web Development', 2, 2, 3, 45, 'Frontend and backend web technologies', 'Active', NULL),
(11, 'HND-IT105', 'Data Structures and Algorithms', 2, 2, 4, 60, 'Efficient problem solving techniques in programming', 'Active', NULL),
(12, 'HND-IT106', 'Operating Systems', 2, 2, 3, 45, 'Operating system concepts and design', 'Active', NULL),
(13, 'HND-ENG101', 'Engineering Mathematics I', 3, 1, 4, 60, 'Mathematics fundamentals for engineers', 'Active', NULL),
(14, 'HND-ENG102', 'Applied Physics', 3, 1, 3, 45, 'Physics concepts applied in engineering', 'Active', NULL),
(15, 'HND-ENG103', 'Engineering Drawing', 3, 1, 3, 45, 'Technical drawing techniques and standards', 'Active', NULL),
(16, 'HND-ENG104', 'Thermodynamics', 3, 2, 3, 45, 'Heat and energy transfer', 'Active', NULL),
(17, 'HND-ENG105', 'Mechanics of Materials', 3, 2, 3, 45, 'Material strength and structural analysis', 'Active', NULL),
(18, 'HND-ENG106', 'Fluid Mechanics', 3, 2, 3, 45, 'Fluid behavior in engineering systems', 'Active', NULL),
(19, 'HND-ACC101', 'Cost Accounting', 4, 1, 3, 45, 'Recording and analyzing costs', 'Active', NULL),
(20, 'HND-ACC102', 'Taxation', 4, 1, 3, 45, 'Sri Lankan tax laws and computations', 'Active', NULL),
(21, 'HND-ACC103', 'Management Accounting', 4, 2, 3, 45, 'Managerial decision-making using accounting data', 'Active', NULL),
(22, 'HND-ACC104', 'Financial Reporting', 4, 2, 3, 45, 'Preparation of financial statements', 'Active', NULL),
(23, 'HND-ACC105', 'Auditing', 4, 2, 3, 45, 'Principles and procedures of auditing', 'Active', NULL),
(24, 'HND-ACC106', 'Accounting Information Systems', 4, 2, 3, 45, 'Computerized accounting systems', 'Active', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` enum('admin','student','lecturer') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `Username`, `Password`, `Role`) VALUES
(1, 'STU002', '$2y$10$kYc.8MVV6lNX/cZNMtFMB.Gjry1DBRA8ConOJE10gBUVvBQUAE58q', 'student'),
(2, 'STU001', '$2y$10$nXdFkjt0jSfcL8ywf9dvnOm3iRUlZwRM1IcEY/oTV/kuOapIuBkJ.', 'student'),
(3, 'ADM001', '$2y$10$fZUc5M1odBKJdZ7OJsesN.K6lL5Cz5X8dbelVI/Qbr1WHajGAN8xa', 'admin'),
(4, 'aeshwarage336', '$2y$10$/1M1MVBdriTSdBezu0ZS.OtCgQnQ9hsNNfEtT0fGU/Ymw8nOegv8O', 'student'),
(5, 'LEC002', '$2y$10$UXtkkiwK/T/e2SWNh/cLM.P7BvVgZcGtPswJHshNLkvivmVA9k.o.', 'lecturer'),
(6, 'kbandara256', '$2y$10$4.U99866J3O7xOfGwjCrKOo.mRdRm8moUZ/kwEtROEEfm7aR7p6BS', 'student'),
(7, 'LEC001', '$2y$10$dO331ke4v6sIkbuv0SZgp.RftVZNn0ejq2mIgPkKrRdCwFBDzcJWa', 'lecturer'),
(8, 'aeshwarage830', '$2y$10$gYoCG7a/w8xtw2FNNsjABOAW02Eijf2QPNY3sNAc2JE6XrI.VArxC', 'student'),
(9, 'aeshwarage311', '$2y$10$Xp7d/rp44/v7GYbgTACWAufB04bpzZqgG4NW7Lkib4wmCpPIu3Spi', 'student'),
(10, 'aeshwarage696', '$2y$10$tG9/IM5HrKfjOvyrdUhC1.rWIag90KWcxnLzJZkVwRzieK7gm4Lj.', 'student'),
(11, 'aeshwarage499', '$2y$10$6DX2RUpq5LiUeJJnryL30eh0Yp5oF6YbX6VwJlKxKFpDtD.khwuWC', 'student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Admin_ID`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`Department_ID`);

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`Exam_ID`),
  ADD KEY `Subject_ID` (`Subject_ID`);

--
-- Indexes for table `lecturer`
--
ALTER TABLE `lecturer`
  ADD PRIMARY KEY (`Lecturer_ID`),
  ADD KEY `Department_ID` (`Department_ID`);

--
-- Indexes for table `lecturer_subject`
--
ALTER TABLE `lecturer_subject`
  ADD PRIMARY KEY (`lect_sub_id`),
  ADD KEY `lecturer_id` (`lecturer_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`Log_ID`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`Payment_ID`),
  ADD KEY `Student_ID` (`Student_ID`),
  ADD KEY `Result_ID` (`Result_ID`);

--
-- Indexes for table `result`
--
ALTER TABLE `result`
  ADD PRIMARY KEY (`Result_ID`),
  ADD UNIQUE KEY `unique_result` (`Student_ID`,`Subject_ID`,`Semester`),
  ADD KEY `Student_ID` (`Student_ID`),
  ADD KEY `Subject_ID` (`Subject_ID`),
  ADD KEY `Lecturer_ID` (`Lecturer_ID`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`Semester_ID`),
  ADD UNIQUE KEY `Semester_Code` (`Semester_Code`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`Student_ID`),
  ADD UNIQUE KEY `Registration_Number` (`Registration_Number`),
  ADD KEY `Department_ID` (`Department_ID`),
  ADD KEY `Subject_ID` (`Subject_ID`),
  ADD KEY `Lecturer_ID` (`Lecturer_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `student_lecturer`
--
ALTER TABLE `student_lecturer`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `unique_assignment` (`Student_ID`,`Lecturer_ID`),
  ADD KEY `Lecturer_ID` (`Lecturer_ID`);

--
-- Indexes for table `student_subject`
--
ALTER TABLE `student_subject`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Student_ID` (`Student_ID`),
  ADD KEY `Subject_ID` (`Subject_ID`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`Subject_ID`),
  ADD UNIQUE KEY `Subject_Code` (`Subject_Code`),
  ADD KEY `Department_ID` (`Department_ID`),
  ADD KEY `Semester_ID` (`Semester_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `Admin_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `Department_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `exam`
--
ALTER TABLE `exam`
  MODIFY `Exam_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lecturer`
--
ALTER TABLE `lecturer`
  MODIFY `Lecturer_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lecturer_subject`
--
ALTER TABLE `lecturer_subject`
  MODIFY `lect_sub_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `Log_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `Payment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `result`
--
ALTER TABLE `result`
  MODIFY `Result_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `Semester_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `Student_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `student_lecturer`
--
ALTER TABLE `student_lecturer`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student_subject`
--
ALTER TABLE `student_subject`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `Subject_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exam`
--
ALTER TABLE `exam`
  ADD CONSTRAINT `exam_ibfk_1` FOREIGN KEY (`Subject_ID`) REFERENCES `subject` (`Subject_ID`);

--
-- Constraints for table `lecturer`
--
ALTER TABLE `lecturer`
  ADD CONSTRAINT `lecturer_ibfk_1` FOREIGN KEY (`Department_ID`) REFERENCES `department` (`Department_ID`);

--
-- Constraints for table `lecturer_subject`
--
ALTER TABLE `lecturer_subject`
  ADD CONSTRAINT `lecturer_subject_ibfk_1` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`Lecturer_ID`),
  ADD CONSTRAINT `lecturer_subject_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`Subject_ID`);

--
-- Constraints for table `result`
--
ALTER TABLE `result`
  ADD CONSTRAINT `result_ibfk_1` FOREIGN KEY (`Student_ID`) REFERENCES `student` (`Student_ID`),
  ADD CONSTRAINT `result_ibfk_2` FOREIGN KEY (`Subject_ID`) REFERENCES `subject` (`Subject_ID`),
  ADD CONSTRAINT `result_ibfk_3` FOREIGN KEY (`Lecturer_ID`) REFERENCES `lecturer` (`Lecturer_ID`);

--
-- Constraints for table `student_lecturer`
--
ALTER TABLE `student_lecturer`
  ADD CONSTRAINT `student_lecturer_ibfk_1` FOREIGN KEY (`Student_ID`) REFERENCES `student` (`Student_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_lecturer_ibfk_2` FOREIGN KEY (`Lecturer_ID`) REFERENCES `lecturer` (`Lecturer_ID`) ON DELETE CASCADE;

--
-- Constraints for table `student_subject`
--
ALTER TABLE `student_subject`
  ADD CONSTRAINT `student_subject_ibfk_1` FOREIGN KEY (`Student_ID`) REFERENCES `student` (`Student_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_subject_ibfk_2` FOREIGN KEY (`Subject_ID`) REFERENCES `subject` (`Subject_ID`) ON DELETE CASCADE;

--
-- Constraints for table `subject`
--
ALTER TABLE `subject`
  ADD CONSTRAINT `subject_ibfk_1` FOREIGN KEY (`Department_ID`) REFERENCES `department` (`Department_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `subject_ibfk_2` FOREIGN KEY (`Semester_ID`) REFERENCES `semester` (`Semester_ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
