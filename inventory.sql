-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2025 at 11:09 AM
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
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

CREATE TABLE `order_product` (
  `id` int(11) NOT NULL,
  `supplier` int(11) DEFAULT NULL,
  `product` int(11) DEFAULT NULL,
  `quantity_ordered` int(11) DEFAULT NULL,
  `quantity_received` int(11) DEFAULT NULL,
  `quantity_remaining` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `batch` int(20) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_product`
--

INSERT INTO `order_product` (`id`, `supplier`, `product`, `quantity_ordered`, `quantity_received`, `quantity_remaining`, `status`, `batch`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 2, 20, 34, 2, 32, 'complete', 1735096566, 1, '2024-12-25 04:16:06', '2024-12-25 04:16:06'),
(2, 3, 16, 44, 2, 42, 'incomplete', 1735096566, 1, '2024-12-25 04:16:06', '2024-12-25 04:16:06'),
(3, 1, 15, 45, 2, 43, 'pending', 1735096566, 1, '2024-12-25 04:16:06', '2024-12-25 04:16:06'),
(4, 2, 15, 54, 2, 52, 'complete', 1735096566, 1, '2024-12-25 04:16:06', '2024-12-25 04:16:06'),
(5, 1, 12, 3, 2, 1, 'complete', 1735096566, 1, '2024-12-25 04:16:06', '2024-12-25 04:16:06'),
(6, 1, 15, 4, 0, 4, 'incomplete', 1735097976, 1, '2024-12-25 04:39:36', '2024-12-25 04:39:36'),
(7, 2, 15, 65, 5, 60, 'incomplete', 1735097976, 1, '2024-12-25 04:39:36', '2024-12-25 04:39:36'),
(8, 1, 15, 34, 10, 24, 'incomplete', 1735100664, 1, '2024-12-25 05:24:24', '2024-12-25 05:24:24'),
(9, 2, 15, 43, 14, 29, 'incomplete', 1735100664, 1, '2024-12-25 05:24:24', '2024-12-25 05:24:24'),
(10, 3, 16, 45, 9, 36, 'incomplete', 1735101182, 1, '2024-12-25 05:33:02', '2024-12-25 05:33:02'),
(11, 1, 15, 23, 10, 13, 'complete', 1735101182, 1, '2024-12-25 05:33:02', '2024-12-25 05:33:02'),
(12, 2, 15, 32, 7, 25, 'pending', 1735101182, 1, '2024-12-25 05:33:02', '2024-12-25 05:33:02'),
(13, 1, 14, 24, 25, -1, 'complete', 1735745921, 1, '2025-01-01 16:38:41', '2025-01-01 16:38:41'),
(14, 10, 21, 10, 9, 1, 'pending', 1735915931, 1, '2025-01-03 15:52:11', '2025-01-03 15:52:11'),
(15, 1, 14, 1, 3, -2, 'complete', 1736855122, 28, '2025-01-14 12:45:22', '2025-01-14 12:45:22'),
(16, 14, 24, 10, 3, 7, 'incomplete', 1737203292, 28, '2025-01-18 13:28:12', '2025-01-18 13:28:12'),
(17, 1, 14, 7, 5, 2, 'incomplete', 1737205465, 28, '2025-01-18 14:04:25', '2025-01-18 14:04:25');

-- --------------------------------------------------------

--
-- Table structure for table `order_product_history`
--

CREATE TABLE `order_product_history` (
  `id` int(11) NOT NULL,
  `order_product_id` int(11) NOT NULL,
  `qty_received` int(11) NOT NULL,
  `date_received` datetime NOT NULL,
  `date_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_product_history`
--

INSERT INTO `order_product_history` (`id`, `order_product_id`, `qty_received`, `date_received`, `date_updated`) VALUES
(26, 3, 10, '2024-12-31 03:43:29', '2025-01-02 03:43:29'),
(27, 5, 1, '2025-01-01 03:43:29', '2025-01-02 03:43:29'),
(28, 2, 19, '2025-01-01 03:44:02', '2025-01-02 03:44:02'),
(29, 1, 1, '2025-01-02 03:44:02', '2025-01-02 03:44:02'),
(30, 4, 1, '2025-01-02 03:44:02', '2025-01-02 03:44:02'),
(31, 3, 1, '2025-01-02 03:44:02', '2025-01-02 03:44:02'),
(32, 5, 1, '2025-01-02 03:44:02', '2025-01-02 03:44:02'),
(33, 13, 1, '2025-01-02 04:44:07', '2025-01-02 04:44:07'),
(34, 13, 20, '2025-01-02 04:57:50', '2025-01-02 04:57:50'),
(35, 13, 3, '2025-01-02 04:59:48', '2025-01-02 04:59:48'),
(36, 13, 1, '2025-01-03 05:01:41', '2025-01-02 05:01:41'),
(37, 13, 1, '2025-01-02 15:06:47', '2025-01-02 15:06:47'),
(38, 11, 2, '2024-12-30 15:13:10', '2025-01-02 15:13:10'),
(39, 8, 5, '2025-01-03 05:48:31', '2025-01-03 05:48:31'),
(40, 9, 10, '2025-01-03 05:48:31', '2025-01-03 05:48:31'),
(41, 14, 8, '2025-01-03 15:53:10', '2025-01-03 15:53:10'),
(42, 14, 1, '2025-01-03 15:54:53', '2025-01-03 15:54:53'),
(43, 15, 1, '2025-01-14 12:45:56', '2025-01-14 12:45:56'),
(44, 15, 2, '2025-01-18 13:23:24', '2025-01-18 13:23:24'),
(45, 17, 5, '2025-01-18 14:06:36', '2025-01-18 14:06:36'),
(46, 16, 3, '2025-01-18 14:07:18', '2025-01-18 14:07:18');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(191) NOT NULL,
  `description` varchar(300) DEFAULT NULL,
  `img` varchar(200) DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `description`, `img`, `stock`, `created_by`, `created_at`, `updated_at`) VALUES
(11, 'Nestley', 'Good food, good brand', 'product-1736078364.jpg', 0, 2, '2024-12-10 05:54:28', '2024-12-10 05:54:28'),
(12, 'Fruity', 'Fresh Mango Juice', 'product-1736859679.jpeg', 0, 2, '2024-12-10 14:38:53', '2024-12-10 14:38:53'),
(14, 'Aloevera ', 'Herbal Beauty Products', 'product-1733916550.jpeg', 33, 1, '2024-12-11 12:17:45', '2024-12-11 12:17:45'),
(15, 'Male Cosmetic', 'Male Beauty Product', 'product-1735032373.jpg', 17, 1, '2024-12-11 12:25:13', '2024-12-11 12:25:13'),
(16, 'Beauty Cream', 'Cream ', 'product-1734755256.jpeg', 0, 1, '2024-12-11 12:25:57', '2024-12-11 12:25:57'),
(20, 'Apple', 'Premium Quality ', 'product-1736823669.jpg', 0, 2, '2024-12-19 14:44:53', '2024-12-19 14:44:53'),
(21, 'Microsoft Devices', 'From Microsoft', 'product-1736859662.jpg', 9, 1, '2025-01-03 15:50:55', '2025-01-03 15:50:55'),
(24, 'Denver ', 'Caliber Perfume', 'product-1736859909.jpeg', 3, 28, '2025-01-14 14:05:09', '2025-01-14 14:05:09');

-- --------------------------------------------------------

--
-- Table structure for table `productsuppliers`
--

CREATE TABLE `productsuppliers` (
  `id` int(11) NOT NULL,
  `supplier` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productsuppliers`
--

INSERT INTO `productsuppliers` (`id`, `supplier`, `product`, `created_at`, `updated_at`) VALUES
(5, 3, 16, '2024-12-21 05:27:36', '2024-12-21 05:27:36'),
(11, 1, 14, '2024-12-21 05:47:19', '2024-12-21 05:47:19'),
(17, 1, 15, '2024-12-24 10:26:13', '2024-12-24 10:26:13'),
(18, 2, 15, '2024-12-24 10:26:13', '2024-12-24 10:26:13'),
(22, 1, 11, '2025-01-05 12:59:24', '2025-01-05 12:59:24'),
(24, 2, 20, '2025-01-14 04:01:09', '2025-01-14 04:01:09'),
(31, 1, 12, '2025-01-14 14:01:19', '2025-01-14 14:01:19'),
(32, 14, 24, '2025-01-14 14:05:09', '2025-01-14 14:05:09');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `supplier_name` varchar(191) NOT NULL,
  `supplier_location` varchar(191) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_name`, `supplier_location`, `email`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Nestle', 'Kathmandu', 'nastle@gmail.com', 22, '2024-12-11 14:59:24', '2024-12-11 14:59:24'),
(2, 'Apple', 'Californiaa', 'apple@ims.comm', 12, '2024-12-11 14:59:24', '2024-12-11 14:59:24'),
(3, 'Samsung', 'India', 'samu@gmail.com', 1, '2024-12-11 15:04:39', '2024-12-11 15:04:39'),
(10, 'Microsoft', 'USA', 'microsoft@gmail.com', 1, '2025-01-03 15:45:49', '2025-01-03 15:45:49'),
(14, 'Denver', 'Npl', 'denver@ims.com', 28, '2025-01-14 14:04:13', '2025-01-14 14:04:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `password` varchar(300) NOT NULL,
  `email` varchar(50) NOT NULL,
  `permissions` varchar(5000) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `password`, `email`, `permissions`, `created_at`, `updated_at`) VALUES
(1, 'pramod', 'singh', '123', 'a@ims.com', NULL, '2024-12-02 12:14:06', '2024-12-02 12:14:06'),
(2, 'jha', 'alok', 'alokba', 'aalu@ims.com', NULL, '2024-12-02 14:21:42', '2025-01-14 01:13:33'),
(12, 'James', 'Bond', '$2y$10$7bAfi8Onj9cp2vx76hjHKusiXqr0pufYendOg.sZNkkEvAzKWLn5.', 'jb@ims.com', NULL, '2024-12-05 17:26:56', '2024-12-05 17:26:56'),
(22, 'Jackie', 'Chan', '$2y$10$7Vy9Nv6go.737HRd254kkeLumLWGWvV1uwR9t0uLIg3JipeQrCMRG', 'jacky@ims.com', NULL, '2024-12-09 15:42:32', '2024-12-09 15:42:32'),
(26, 'abc', 'def', '$2y$10$m2/pFmXtGbQw4Wx1DfaTj.OJL7UFH.xf8CwbjP498VMQErr9B9jnK', 'z@ims.com', 'pos,user_view,supplier_view,supplier_create,product_create,po_create,po_edit,supplier_delete,user_edit,report_view,po_view,dashboard_view,', '2025-01-10 12:28:48', '2025-01-10 12:28:48'),
(27, 'jayant', 'joci', '$2y$10$FstR0WArGjhlMYdbs0Z93umyCcnTY3YaZ2NoDQNjlqLnNY2iqHRcS', 'jayant@ims.com', ' user_delete,user_view,user_create,user_edit', '2025-01-10 12:31:23', '2025-01-10 12:31:23'),
(28, 'Harish', 'Kumar', '$2y$10$hlsUtIbm0RlWbxKTm3fAYOlmsA9cxk2zlTrJnVKxP/8iTB9ORCohW', 'hs@ims.com', 'dashboard_view,report_view,po_view,po_create,po_edit,product_view,product_create,product_edit,product_delete,supplier_delete,user_delete,user_edit,supplier_edit,supplier_create,user_create,user_view,supplier_view', '2025-01-14 03:59:50', '2025-01-14 03:59:50'),
(32, 'Gita', 'sha', '$2y$10$h2AudNg5EueYrodfhcQwxOjEnvS/21fV5BsM9EARpmATQaW0YPQdO', 'sha@gmail.com', 'dashboard_view,report_view', '2025-02-20 18:16:56', '2025-02-20 18:16:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier` (`supplier`),
  ADD KEY `product` (`product`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `order_product_history`
--
ALTER TABLE `order_product_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_product_id` (`order_product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`created_by`);

--
-- Indexes for table `productsuppliers`
--
ALTER TABLE `productsuppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product` (`product`),
  ADD KEY `supplier` (`supplier`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order_product`
--
ALTER TABLE `order_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `order_product_history`
--
ALTER TABLE `order_product_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `productsuppliers`
--
ALTER TABLE `productsuppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `order_product_ibfk_1` FOREIGN KEY (`supplier`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `order_product_ibfk_2` FOREIGN KEY (`product`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `order_product_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_product_history`
--
ALTER TABLE `order_product_history`
  ADD CONSTRAINT `order_product_history_ibfk_1` FOREIGN KEY (`order_product_id`) REFERENCES `order_product` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `productsuppliers`
--
ALTER TABLE `productsuppliers`
  ADD CONSTRAINT `productsuppliers_ibfk_1` FOREIGN KEY (`product`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `productsuppliers_ibfk_2` FOREIGN KEY (`supplier`) REFERENCES `suppliers` (`id`);

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `fk_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
