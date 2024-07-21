-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2024 at 10:26 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `salon`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `product_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `username`, `product_id`, `total`, `created_at`) VALUES
(5, 'Admin', 6, '85.00', '2024-07-20 19:38:27'),
(7, 'Admin', 4, '85.00', '2024-07-20 23:52:10'),
(8, 'Admin', 5, '150.00', '2024-07-20 23:52:10');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `stock` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `created_at`, `stock`) VALUES
(1, 'LIVING PROOF perfect hair day dry shampoo', '89.90', 'image/lp2.jpg', '2024-07-16 05:37:32', 15),
(2, 'LIVING PROOF Conditioner', '79.90', 'image/conditioner.jpg', '2024-07-16 05:37:32', 28),
(3, 'LIVING PROOF Combo Shampoo & Conditioner', '140.00', 'image/shampoo&conditioner.jpg', '2024-07-16 05:37:32', 0),
(4, 'LIVING PROOF Perfect Hair Day Night Cap', '85.00', 'image/mask.jpg', '2024-07-16 05:37:32', 12),
(5, 'LIVING PROOF Flex Hairspray', '150.00', 'image/Hair spray.jpg', '2024-07-16 05:37:32', 12),
(6, 'LIVING PROOF Full Thickening Blow-Dry Cream', '85.00', 'image/tichkening.jpg', '2024-07-16 05:37:32', 11),
(7, 'LIVING PROOF dry volume & texture spray', '70.00', 'image/lp1.jpg', '2024-07-16 06:22:06', 0),
(8, 'LIVING PROOF perfect hair day advanced clean dry shampoo', '120.00', 'image/lp3.jpg', '2024-07-16 06:23:05', 10),
(9, 'LIVING PROOF instant de-frizzer', '89.00', 'image/lp4.jpg', '2024-07-16 06:23:48', 19),
(10, 'LIVING PROOF leave-in conditioner', '75.00', 'image/lp5.jpg', '2024-07-16 06:24:19', 15),
(11, 'Loreal Serioxyl Advanced Denser Hair Density Activator Serum', '160.00', 'image/serum.jpg', '2024-07-16 05:37:32', 7),
(12, 'Loreal Scalp Advanced Anti-Oiliness 2-In-1 Deep Purifier Clay', '90.00', 'image/scalp.jpg', '2024-07-16 05:37:32', 12),
(13, 'SCHWARZKOPF PROFESSIONAL Session Label The Powder Styling', '57.00', 'image/styling dust.png', '2024-07-16 05:37:32', 1),
(14, 'SCHWARZKOPF PROFESSIONAL Blow Dry Spray', '65.00', 'image/blow spray.jpg', '2024-07-16 05:37:32', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `service` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `username`, `name`, `email`, `date`, `time`, `service`) VALUES
(1, 'Admin', 'Syah', 'syahiran@gmail.com', '2024-07-23', '11:40:00', 'Colour'),
(2, 'Admin', 'hazim', '12121@gmail.com', '2024-07-30', '22:30:00', 'Perm'),
(3, 'Admin', 'Syah', 'syahiran@gmail.com', '2024-08-10', '22:40:00', 'Brazilian keratin');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`) VALUES
(3, 'Admin', 'Lawa Salon', 'Admin', 'admin@gmail.com', '$2y$10$dyH1x5H.2ImN185N3ug3lOoqON/yGFjpUg/HRFFPdCKjMxr7cTqu.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
