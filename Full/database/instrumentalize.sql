-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2023 at 04:02 PM
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
-- Database: `instrumentalize`
--

-- --------------------------------------------------------

--
-- Table structure for table `carousel`
--

CREATE TABLE `carousel` (
  `carousel_id` int(11) NOT NULL,
  `carousel_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carousel`
--

INSERT INTO `carousel` (`carousel_id`, `carousel_img`) VALUES
(5, 'images/carousel/656eddde29a846.42238269.png'),
(8, 'images/carousel/656f23ff96d969.77522192.png');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_img` varchar(255) NOT NULL,
  `product_quantity` int(100) NOT NULL,
  `product_price_total` decimal(15,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `product_id`, `product_img`, `product_quantity`, `product_price_total`) VALUES
(44, 21, 10, 'images/product/656df5af7f7222.18688678.png', 1, 125000000),
(45, 21, 7, 'images/product/656df1dad56e80.58272562.png', 1, 80000000),
(52, 22, 14, 'images/product/65798ccdf306b1.52567995.png', 1, 200000000),
(53, 22, 1, 'images/product/6554dd71d86e53.36237163.png', 2, 90000000),
(56, 20, 11, 'images/product/657836bc588ce0.98015695.png', 1, 50000000),
(73, 5, 14, 'images/product/65798ccdf306b1.52567995.png', 1, 200000000);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(10) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `category_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_img`) VALUES
(1, 'Gitar', 'images/category/656c4f6b832bc3.10970790.png'),
(2, 'Drum', 'images/category/656c4f82000997.37588840.png'),
(3, 'Biola', 'images/category/656d5cd35dcf53.04686317.png'),
(4, 'Saksofon', 'images/category/656d662c05ec85.04372405.png'),
(5, 'Piano', 'images/category/656d5a523164c7.83284293.png'),
(10, 'Harmonika', 'images/category/656efc219bed72.39086446.png');

-- --------------------------------------------------------

--
-- Table structure for table `form`
--

CREATE TABLE `form` (
  `form_id` int(11) NOT NULL,
  `form_name` varchar(255) NOT NULL,
  `form_email` varchar(255) NOT NULL,
  `form_phone` varchar(255) NOT NULL,
  `form_title` varchar(255) NOT NULL,
  `form_desc` text NOT NULL,
  `form_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form`
--

INSERT INTO `form` (`form_id`, `form_name`, `form_email`, `form_phone`, `form_title`, `form_desc`, `form_datetime`) VALUES
(5, 'tes1', 'tes1@gmail.com', '123', 'tes1', 'tes1', '2023-12-14 13:21:18'),
(6, 'tes2', 'tes2@gmail.com', '123', 'tes2', 'tes2', '2023-12-14 13:23:36'),
(7, 'tes3', 'tes3@gmail.com', '123', 'tes3', 'tes3', '2023-12-14 13:24:44');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_user` int(10) NOT NULL,
  `order_address` varchar(50) NOT NULL,
  `order_phone` varchar(20) NOT NULL,
  `order_total` decimal(15,0) NOT NULL,
  `order_payment` enum('Transfer','COD') NOT NULL,
  `order_status` enum('Antrian','Dalam Proses','Dikirim','Selesai') NOT NULL,
  `order_proof` varchar(255) NOT NULL,
  `order_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_user`, `order_address`, `order_phone`, `order_total`, `order_payment`, `order_status`, `order_proof`, `order_datetime`) VALUES
(1, 5, 'Taman Sari', '085836655136', 265500000, 'Transfer', 'Dalam Proses', 'images/order_proof/6577cadfc4fec9.15053714.png', '2023-12-11 11:10:54'),
(2, 5, 'Taman Sari', '085836655136', 311000000, 'COD', 'Dikirim', '', '2023-12-12 10:33:45'),
(3, 5, 'Taman Sari Hijau', '085836655136', 50500000, 'Transfer', 'Antrian', '', '2023-12-12 05:52:05'),
(5, 22, 'rumah3', '000000000003', 370500000, 'Transfer', 'Dalam Proses', '', '2023-12-14 12:00:19'),
(9, 5, 'rmh', '085836655136', 76000000, 'COD', 'Antrian', '', '2023-12-22 08:13:24');

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_item_quantity` int(100) NOT NULL,
  `order_item_total_price` decimal(15,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`order_item_id`, `order_id`, `product_id`, `order_item_quantity`, `order_item_total_price`) VALUES
(1, 1, 10, 1, 125000000),
(2, 1, 1, 1, 45000000),
(3, 1, 2, 1, 55000000),
(4, 1, 3, 1, 40000000),
(5, 2, 10, 1, 125000000),
(6, 2, 2, 1, 55000000),
(7, 2, 9, 1, 130000000),
(12, 3, 11, 1, 50000000),
(13, 5, 10, 2, 250000000),
(14, 5, 3, 3, 120000000),
(20, 9, 6, 1, 75000000);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_img` varchar(255) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_category` int(10) NOT NULL,
  `product_desc` varchar(255) NOT NULL,
  `product_stock` int(100) NOT NULL,
  `product_price` decimal(15,0) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_img`, `product_name`, `product_category`, `product_desc`, `product_stock`, `product_price`, `is_deleted`) VALUES
(1, 'images/product/6554dd71d86e53.36237163.png', 'J-35, Exclusive - Vintage Sunburst', 1, 'Produk gitar baru', 3, 45000000, 0),
(2, 'images/product/6554dece9399a7.63831253.png', 'Hummingbird Faded - Natural', 1, 'gitar lebih baru sudah ada foto tapi barusan saya edit tanpa', 3, 55000000, 0),
(3, 'images/product/6555a0123976f4.54757711.png', 'L-00 Original - Ebony', 1, 'Gitarnya warna hitam baru', 2, 40000000, 0),
(5, 'images/product/6556fdbe83e3d3.39191031.png', 'CF 6 Yamaha', 5, 'Seri CF', 3, 52500000, 0),
(6, 'images/product/656deb6f959725.01933126.png', 'Tenor SX90R 3401 Keilwerth', 4, 'Julius Keilwerth', 1, 75000000, 0),
(7, 'images/product/656df1dad56e80.58272562.png', 'Sopranos ST1100 Keilwerth', 4, 'Julius Keilwerth', 3, 80000000, 0),
(8, 'images/product/656df29cd29137.01188187.png', 'Alto SX90R 2401 Keilwerth', 4, 'Julius Keilwerth', 1, 70000000, 0),
(9, 'images/product/656df53fb6ab31.97014716.png', 'VE5294FTC Mapex', 2, 'Drum kits', 2, 130000000, 0),
(10, 'images/product/656df5af7f7222.18688678.png', 'SR628XU Studioease Mapex', 2, 'Drum kit', 1, 125000000, 0),
(11, 'images/product/657836bc588ce0.98015695.png', 'S5X Yamaha', 5, 'Piano baru', 1, 50000000, 0),
(12, 'images/product/65798b782fe342.68165922.png', 'LC Strad Plus Violin', 3, 'Biola baru', 0, 70000000, 0),
(13, 'images/product/65798bd551f354.59402448.png', 'Dragon 30 Violin', 3, 'Biola baru lagi', 2, 75000000, 0),
(14, 'images/product/65798ccdf306b1.52567995.png', 'Andrea Castagneri 1742 Violin', 3, 'Biola tua', 2, 200000000, 0),
(15, 'images/product/657ab818e10f25.46917794.png', 'PC12MH Ibanez', 1, 'Ibanez guitar', 0, 70000000, 0),
(17, 'images/product/65844a5d195811.13943963.png', 'test', 1, 'tst', 5, 1000, 1),
(18, 'images/product/65844b5e90ba80.67640630.png', 'test', 2, 'tst', 10, 2000, 1),
(19, 'images/product/658459cecee3d2.56216256.png', '1998', 5, 'ok', 5, 50000, 1),
(20, 'images/product/6584de471fbb51.28673073.png', 'asa', 2, 'tst2', 5, 10000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(10) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_birthday` date NOT NULL,
  `user_gender` enum('Pria','Wanita') NOT NULL,
  `user_phone` varchar(20) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_role` enum('Buyer','Seller') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_email`, `user_birthday`, `user_gender`, `user_phone`, `user_password`, `user_role`) VALUES
(1, 'Muhammad Fathu Al Razi', 'fathuplayer@gmail.com', '2004-08-18', 'Pria', '080808080808', '$2y$10$PdvOJ.LOsEXyDqNkw1QgouyiKDLIsQ48E.t5wM.M9P86hsmeaaMXC', 'Seller'),
(2, 'PBL IF D-03', 'pblifd03.2023@gmail.com', '2000-01-01', 'Pria', '080000000000', '$2y$10$ZWCEzjbbY0BqFLw5EEY0D.gcLJt1gGLyh.nAwW39Oigt/yOj8Xpka', 'Buyer'),
(3, 'admin', 'admin@gmail.com', '2024-01-01', 'Pria', '12312312312', '$2y$10$Am1pVYRZ89o3zgHRmAYX4eGl.ZBNZAGmTQMKuBff4MQNMAPp94tPu', 'Seller'),
(5, 'test', 'test@gmail.com', '2023-11-01', 'Wanita', '085836655136', '$2y$10$oHhFe5GH.irAMidy5eHUuOMYAT3PmX8HDegp2LtG/ZpyM/4rDEFwG', 'Buyer'),
(6, 'bebas', 'bebas@gmail.com', '2023-11-01', 'Wanita', '000000000005', '$2y$10$XMQRN5rtppNHyn8YIHTuEu9d5VrwSOZ4FbGCDB.cXb4ik6U1u7uMe', 'Buyer'),
(8, 'abc', 'abc@gmail.com', '2012-12-12', 'Pria', '123', '$2y$10$cHuQ6hjmm5zS39maNlr6R.GgYuJXkkrMoA151f/U5nxMVoAekYlcG', 'Buyer'),
(9, 'Ada', 'ada@gmail.com', '2023-11-30', 'Wanita', '111111111111', '$2y$10$ghTfo.p1L.iZzkxTjukL8OyB9gtr7Sy2SuAVWgck8YsYt5g0dRq72', 'Buyer'),
(10, 'sepuluh', 'sepuluh@gmail.com', '2024-01-01', 'Wanita', '10', '$2y$10$zqRxJWyDZAA9M6UlbotPk.CNz2hf38tKy2D/G0K77gGXVtZhEZpy6', 'Buyer'),
(11, 'Pagination', 'pagination@gmail.com', '2023-11-16', 'Pria', '000000000000', '$2y$10$zhCMRnzaCiHJFrkLzxP8sOJYgpUDZ27I6qPHDNNN4JHCytfmKsDju', 'Buyer'),
(15, 'testi', 'testi@gmail.com', '2023-11-30', 'Wanita', '1234', '$2y$10$NmmFWz8wqAGe7PfQVr5Tnu2fJD6g2/JRyK8WTa5x5RxAiuAFNUYbq', 'Buyer'),
(20, 'test1', 'test1@gmail.com', '2023-12-01', 'Pria', '000000000005', '$2y$10$JwxCYmSIQIQA4C6126shceOv0BCNgCj1O9Oi26Z4u51ITsQ2cGHTC', 'Buyer'),
(21, 'test2', 'test2@gmail.com', '2023-12-13', 'Pria', '000000000002', '$2y$10$M4rwuXATrYA9zgkOKIc9vu./GOMwwI0hgqCpMRgce8Wlu0ax9DvpK', 'Buyer'),
(22, 'test3', 'test3@gmail.com', '2023-12-14', 'Pria', '000000000003', '$2y$10$qjC1WQwHxJQGFB4v9unWtOtcNGDV5JnVH8LmoHYnEYby6RlEtN4Zi', 'Buyer'),
(25, 'test4', 'test4@gmail.com', '2023-12-15', 'Wanita', '000000000005', '$2y$10$WWEEvJa0nxODuS9LuWmmO.7ictbdAo0/eeJ0xK.rOXDlG45K4aJKW', 'Buyer'),
(26, 'test5', 'test5@gmail.com', '2023-12-19', 'Wanita', '000000000005', '$2y$10$V4b0PKfr05mFbIeFEBqGxeh/QktplF6Rcyc5d7b0GNudpXQbb3J4C', 'Buyer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carousel`
--
ALTER TABLE `carousel`
  ADD PRIMARY KEY (`carousel_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `cart_user` (`user_id`),
  ADD KEY `cart_product` (`product_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `form`
--
ALTER TABLE `form`
  ADD PRIMARY KEY (`form_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `order_user` (`order_user`) USING BTREE;

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `order_item_product` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `product_category` (`product_category`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carousel`
--
ALTER TABLE `carousel`
  MODIFY `carousel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `form`
--
ALTER TABLE `form`
  MODIFY `form_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `cart_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `order_user` FOREIGN KEY (`order_user`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_item_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_category` FOREIGN KEY (`product_category`) REFERENCES `category` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
