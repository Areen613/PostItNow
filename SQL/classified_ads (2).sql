-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2025 at 02:41 AM
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
-- Database: `classified_ads`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `password`) VALUES
(1, 'VICKY26BHUSHAN@GMAIL.COM', '$2y$10$j/Rjq0a9s1ro5fToIt7Bq.L2smX2BR5eVt0NbB0sh.yPmtdBtf/hW'),
(2, 'VICKY45BHUSHAN@GMAIL.COM', '$2y$10$Cinl2DqmM7npn4gCFdKfE.KmNXjXbvC6H2DZGCJ0rRUD0YssMbPsu');

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `start_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`id`, `member_id`, `category_id`, `subcategory_id`, `title`, `description`, `price`, `status`, `start_date`, `expiry_date`, `created_at`) VALUES
(2, 1, NULL, NULL, 'BIKE', 'BIKE AT EXCELLENT CODITION.', 1500.00, 'active', '2025-05-02', '2025-06-01', '2025-05-02 04:25:25'),
(3, 1, NULL, NULL, 'IPHONE 16 PRO MAX', 'IPHONE Good Condition\r\nWIth original box and reciept', 1000.00, 'active', '2025-05-02', '2025-06-01', '2025-05-02 10:18:05'),
(4, 1, NULL, NULL, 'BMW 5 SERIES', 'BMW 5 SERIES \r\n2016 MODE\r\nWITH GOOD INTERIOR AND WINTER TYRE', 18000.00, 'active', '2025-05-02', '2025-06-01', '2025-05-02 10:20:19'),
(5, 1, 3, 0, '2015 Honda Civic - Excellent Condition', 'Single-owner car, well-maintained with regular service. 110,000 km driven. No accidents. Comes with new winter tires and premium stereo.\r\n\r\n', 9800.00, 'active', '2025-05-02', '2025-06-01', '2025-05-02 10:47:43'),
(6, 1, 3, 0, 'Mountain Bike - Trek Marlin 6', 'Recently serviced mountain bike with front suspension and disc brakes. Suitable for trails and road riding.\r\n\r\n', 450.00, 'active', '2025-05-02', '2025-06-01', '2025-05-02 11:04:28');

-- --------------------------------------------------------

--
-- Table structure for table `ad_images`
--

CREATE TABLE `ad_images` (
  `id` int(11) NOT NULL,
  `ad_id` int(11) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ad_images`
--

INSERT INTO `ad_images` (`id`, `ad_id`, `image_path`) VALUES
(8, 3, 'uploads/ad_images/1746181085_iphone-16-series-mockups-1.jpg'),
(9, 4, 'uploads/ad_images/1746181219_BX823870_167e09de.jpg'),
(10, 5, 'uploads/6814a2cf8c305_img_133078449392954335.jpg'),
(11, 5, 'uploads/6814a2cf8cea3_th.jpeg'),
(12, 5, 'uploads/6814a2cf8dc18_34-frontview-2016-Honda-Civic-Popular-Mechanix-SF-Volvo-auto-repair-for-sale-1000p-WEB-871x1024.jpg'),
(13, 6, 'uploads/6814a6bc8fe88_2cpt91knaq271.jpg'),
(14, 6, 'uploads/6814a6bc9088e_Trek_Marlin_6-1.jpg'),
(16, 2, 'uploads/6814edfa4d114_iphone-15-pro-max-apple-watch-202305738.avif');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`) VALUES
(1, 'Electronics'),
(2, 'Furniture'),
(3, 'Vehicles'),
(4, 'Books'),
(5, 'Fashion');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `name`, `email`, `password`, `address`, `city`, `state`, `phone`, `status`, `created_at`) VALUES
(1, 'Test User', 'test1@example.com', 'password123', 'TestAddress', 'TestCity', 'TestState', '9999999999', 'active', '2025-05-02 09:23:52'),
(2, 'Test User', 'test@example.com', 'password', 'Address', 'City', 'State', '1234567890', 'active', '2025-05-02 09:18:01');

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` int(11) NOT NULL,
  `ad_id` int(11) DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reply` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `ad_id`, `sender_id`, `message`, `created_at`, `reply`) VALUES
(7, 2, 1, '400', '2025-05-02 09:24:07', NULL),
(8, 2, 1, '400', '2025-05-02 09:26:28', 'can u increase the price to 550'),
(9, 2, 1, '500', '2025-05-02 09:44:08', '550');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `category_id`, `subcategory_name`) VALUES
(1, 1, 'Mobile Phones'),
(2, 1, 'Laptops'),
(3, 1, 'Cameras'),
(4, 2, 'Sofas'),
(5, 2, 'Beds'),
(6, 2, 'Dining Tables'),
(7, 3, 'Cars'),
(8, 3, 'Motorcycles'),
(9, 3, 'Bicycles'),
(10, 4, 'Fiction'),
(11, 4, 'Non-fiction'),
(12, 4, 'Comics'),
(13, 5, 'Men\'s Wear'),
(14, 5, 'Women\'s Wear'),
(15, 5, 'Accessories');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `address`, `city`, `state`, `created_at`) VALUES
(1, 'VIKAS', 'VIKAS26BHUSHAN@GMAIL.COM', 'VIKAS', '4388387555', '3315 AV', 'MONTREAL', 'QUEBEC', '2025-05-02 02:08:59'),
(2, 'VIKASH', 'VIKASHH26BHUSHAN@GMAIL.COM', 'VIKAS', '4388387555', '3315 AV', 'MONTREAL', 'QUEBEC', '2025-05-02 02:53:54'),
(5, 'Vikas Nagabhushan', 'vikasH26bhushan@gmail.com', 'VIKAS', '4388387555', '3315 Av. Maréchal', 'Montréal', 'QC', '2025-05-02 14:35:10'),
(6, 'Vikas Nagabhushan', 'VICKY26bhushan@gmail.com', 'VIKAS', '4388387555', '3315 Av. Maréchal', 'Montréal', 'QC', '2025-05-02 14:41:04'),
(7, 'Vikas Nagabhushan', 'vikas46bhushan@gmail.com', 'VIKAS', '4388387555', '3315 Av. Maréchal', 'Montréal', 'QC', '2025-05-02 14:52:53'),
(8, 'Vikas Nagabhushan', 'vikas86bhushan@gmail.com', 'VIKAS', '4388387555', '3315 Av. Maréchal', 'Montréal', 'QC', '2025-05-02 15:04:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ads_ibfk_1` (`member_id`);

--
-- Indexes for table `ad_images`
--
ALTER TABLE `ad_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ad_id` (`ad_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ad_id` (`ad_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ad_images`
--
ALTER TABLE `ad_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ads`
--
ALTER TABLE `ads`
  ADD CONSTRAINT `ads_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ad_images`
--
ALTER TABLE `ad_images`
  ADD CONSTRAINT `ad_images_ibfk_1` FOREIGN KEY (`ad_id`) REFERENCES `ads` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `offers_ibfk_1` FOREIGN KEY (`ad_id`) REFERENCES `ads` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `offers_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
