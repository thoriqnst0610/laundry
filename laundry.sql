-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2024 at 11:40 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `idc` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`idc`, `name`, `phone`, `address`) VALUES
(28, 'neymar', '085263380908', 'Mandailing Natal'),
(29, 'siapa aku', '085263380908', 'Mandailing Natal'),
(30, 'Ronaldo', '085263380908', 'Mandailing Natal'),
(31, 'neymar', '085263380908', 'Mandailing Natal'),
(32, 'siapa lagi', 'Thoriqs', 'Mandailing Natal'),
(33, 'usup', 'Thoriqssss', 'Mandailing Natal'),
(34, 'neymar', 'Thoriqssss', 'Mandailing Natal'),
(35, 'neymar', 'Thoriqs', 'Mandailing Natal'),
(36, 'neymar', '085263380908', 'Mandailing Natal'),
(37, 'thoriq', '085263380908', 'Mandailing'),
(39, 'test dong', '087654321', 'siabu');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `ido` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` int(11) DEFAULT NULL,
  `status` enum('pending','completed','cancelled') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`ido`, `customer_id`, `order_date`, `total_amount`, `status`) VALUES
(11, 22, '2024-07-27 17:00:00', 14000, 'pending'),
(12, 24, '2024-07-25 17:00:00', 142000, 'pending'),
(13, 25, '2024-07-24 17:00:00', 14000, 'completed'),
(14, 26, '2024-07-25 17:00:00', 230000, 'pending'),
(15, 28, '2024-08-21 17:00:00', 6000, 'pending'),
(16, 29, '2024-08-22 17:00:00', 46000, 'completed'),
(17, 37, '2024-08-16 17:00:00', 170000, 'completed'),
(18, 32, '2024-08-28 17:00:00', 161000, 'pending'),
(19, 28, '2024-08-25 17:00:00', 10000, 'pending'),
(20, 28, '2024-08-25 17:00:00', 10000, 'pending'),
(21, 28, '2024-08-25 17:00:00', 10000, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `idd` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `item_name` varchar(255) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`idd`, `order_id`, `item_name`, `quantity`, `price`) VALUES
(7, 11, 'Kain', 4, 14000),
(8, 12, 'Sarung', 34, 142000),
(9, 13, 'Kain', 2, 14000),
(10, 14, 'Sarung', 56, 230000),
(11, 15, 'Sarung', 3, 0),
(12, 16, 'Kain', 23, 0),
(13, 17, 'Kain', 34, 0),
(14, 18, 'kain', 23, 0),
(15, 19, ' dsfdfs', 2, 0),
(16, 21, ' dsfdfs', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id` int(11) NOT NULL,
  `kg` int(11) NOT NULL,
  `har` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengaturan`
--

INSERT INTO `pengaturan` (`id`, `kg`, `har`) VALUES
(1, 5000, 500);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`) VALUES
('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvIiwiYXVkIjoiaHR0cDovL2xvY2FsaG9zdDo4MDgwLyIsImlhdCI6MTcyNDU3MTc5MiwiZXhwIjoxNzI0NTc1MzkyfQ.m0WWAUboO7Qcb7IGFv1l1ELFttAt87hitJkAlbu6lCM', '1233'),
('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvIiwiYXVkIjoiaHR0cDovL2xvY2FsaG9zdDo4MDgwLyIsImlhdCI6MTcyNDY0MjA5NiwiZXhwIjoxNzI0NjQ1Njk2fQ.ZQ_Rz11rESklQ7fxgaRBd_LVnTN3eHDNRg0iPY_Yv6E', '1233'),
('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvIiwiYXVkIjoiaHR0cDovL2xvY2FsaG9zdDo4MDgwLyIsImlhdCI6MTcyNDY0NzUwOCwiZXhwIjoxNzI0NjUxMTA4fQ.FxHU1eag1nh73ktYXqCGF2d9p06HOplzqzHd73CaShM', '1234'),
('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvIiwiYXVkIjoiaHR0cDovL2xvY2FsaG9zdDo4MDgwLyIsImlhdCI6MTcyNDY1NTE2NiwiZXhwIjoxNzI0NjU4NzY2fQ.d3f2RPLaQCdyECY8squmHqONSzIr6XcM8e2iiAPyqrA', '1234'),
('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvIiwiYXVkIjoiaHR0cDovL2xvY2FsaG9zdDo4MDgwLyIsImlhdCI6MTcyNDY1OTAxNywiZXhwIjoxNzI0NjYyNjE3fQ.ssw6QHVTXt1b4BAu_pLmrytJR40fD_GngvMQe9lvmrI', '1234'),
('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvIiwiYXVkIjoiaHR0cDovL2xvY2FsaG9zdDo4MDgwLyIsImlhdCI6MTcyNDY2MjY3NywiZXhwIjoxNzI0NjY2Mjc3fQ.rqZDixXk0AoPJzB-90yJQabf4JB5OHOQyG_WnsoDYLY', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verification_code` varchar(50) NOT NULL,
  `is_verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `verification_code`, `is_verified`) VALUES
('1233', 'api', '$2y$10$A1HA6AkHpXyeZetomrHK9e/BrduhwtTgPEFoR.cvufAhkOcMjcn02', '01c9b7b8f802b2ed0286fe8c3c15a068', 1),
('1234', 'siapa lagi', '$2y$10$43wD5y6AZJtuZcwuEG3ueebEJfQsAwfwC5/jOgoLmKG/mlVpTSAyy', '75f4a3007ebf47468d90e3768599c54e', 1),
('jual', 'jual', '$2y$10$oWLO.9qc9tm6Ahilbc0JIuw4fWAVpdtFimwoKh9VkhJ3FXMbYXjfG', '6563aa13a61dc8e015d70de6b87e596b', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`idc`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ido`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`idd`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sessions_user` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `idc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `ido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `idd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pengaturan`
--
ALTER TABLE `pengaturan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
