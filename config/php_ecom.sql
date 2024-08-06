-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 14, 2024 at 05:46 AM
-- Server version: 8.0.30
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php_ecom`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(14, 'Kids'),
(9, 'Men\'s Clothing'),
(8, 'Sports'),
(11, 'Women');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `userId` int NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `order_details` text NOT NULL,
  `ref_no` varchar(200) DEFAULT NULL,
  `payment_method` varchar(100) NOT NULL,
  `user_details` text NOT NULL,
  `status` varchar(20) NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `userId`, `total`, `order_details`, `ref_no`, `payment_method`, `user_details`, `status`, `date`) VALUES
(1, 0, 33.00, '[{\"product_id\":16,\"name\":\"ball\",\"unit_price\":\"33.00\",\"quantity\":1,\"total_price\":33}]', 'cash_on_delivery', 'cash', '{\"name\":\"Nishat Tasnim\",\"email\":\"admin@example.com\",\"phone\":\"5468764\",\"address\":\"Tongi, Gazipur\"}', 'Accepted', '2024-07-12 04:40:10'),
(2, 0, 33.00, '[{\"product_id\":16,\"name\":\"ball\",\"unit_price\":\"33.00\",\"quantity\":1,\"total_price\":33}]', 'cash_on_delivery', 'cash', '{\"name\":\"Nishat Tasnim\",\"email\":\"admin@example.com\",\"phone\":\"5468764\",\"address\":\"Tongi, Gazipur\"}', 'Pending', '2024-07-12 04:40:44'),
(3, 0, 33.00, '[{\"product_id\":16,\"name\":\"ball\",\"unit_price\":\"33.00\",\"quantity\":1,\"total_price\":33},{\"product_id\":\"total_price\",\"name\":null,\"unit_price\":null,\"quantity\":null,\"total_price\":0}]', 'cash_on_delivery', 'cash', '{\"name\":\"Nishat Tasnim\",\"email\":\"admin@example.com\",\"phone\":\"5468764\",\"address\":\"Tongi, Gazipur\"}', 'Rejected', '2024-07-12 05:36:46'),
(4, 0, 165.00, '[{\"product_id\":16,\"name\":\"ball\",\"unit_price\":\"33.00\",\"quantity\":3,\"total_price\":99},{\"product_id\":14,\"name\":\"dfng\",\"unit_price\":\"33.00\",\"quantity\":2,\"total_price\":66}]', 'cash_on_delivery', 'cash', '{\"name\":\"Nishat Tasnim\",\"email\":\"admin@example.com\",\"phone\":\"5468764\",\"address\":\"Tongi, Gazipur\"}', 'Accepted', '2024-07-12 05:49:06'),
(5, 0, 33.00, '[{\"product_id\":16,\"name\":\"ball\",\"unit_price\":\"33.00\",\"quantity\":1,\"total_price\":33}]', 'cash_on_delivery', 'cash', '{\"name\":\"Nishat Tasnim\",\"email\":\"admin@example.com\",\"phone\":\"5468764\",\"address\":\"Tongi, Gazipur\"}', 'Rejected', '2024-07-12 05:49:39'),
(6, 0, 198.00, '[{\"product_id\":16,\"name\":\"ball\",\"unit_price\":\"33.00\",\"quantity\":3,\"total_price\":99},{\"product_id\":14,\"name\":\"dfng\",\"unit_price\":\"33.00\",\"quantity\":3,\"total_price\":99},{\"product_id\":\"total_price\",\"name\":null,\"unit_price\":null,\"quantity\":null,\"total_price\":0}]', 'cash_on_delivery', 'cash', '{\"name\":\"Nishat Tasnim\",\"email\":\"admin@example.com\",\"phone\":\"5468764\",\"address\":\"Tongi, Gazipur\"}', 'Pending', '2024-07-12 06:24:28'),
(7, 0, 33.00, '[{\"product_id\":16,\"name\":\"ball\",\"unit_price\":\"33.00\",\"quantity\":1,\"total_price\":33},{\"product_id\":\"total_price\",\"name\":null,\"unit_price\":null,\"quantity\":null,\"total_price\":0}]', 'cash_on_delivery', 'stripe', '{\"name\":\"Nishat Tasnim\",\"email\":\"admin@example.com\",\"phone\":\"5468764\",\"address\":\"Tongi, Gazipur\"}', 'Pending', '2024-07-14 03:52:44'),
(8, 0, 33.00, '[{\"product_id\":14,\"name\":\"dfng\",\"unit_price\":\"33.00\",\"quantity\":1,\"total_price\":33}]', 'cash_on_delivery', 'cash', '{\"name\":\"Nishat Tasnim\",\"email\":\"admin@example.com\",\"phone\":\"5468764\",\"address\":\"Tongi, Gazipur\"}', 'Pending', '2024-07-14 03:55:02'),
(9, 0, 33.00, '[{\"product_id\":16,\"name\":\"ball\",\"unit_price\":\"33.00\",\"quantity\":1,\"total_price\":33}]', 'cash_on_delivery', 'stripe', '{\"name\":\"Nishat Tasnim\",\"email\":\"admin@example.com\",\"phone\":\"5468764\",\"address\":\"Tongi, Gazipur\"}', 'Pending', '2024-07-14 04:26:10'),
(10, 0, 33.00, '[{\"product_id\":16,\"name\":\"ball\",\"unit_price\":\"33.00\",\"quantity\":1,\"total_price\":33}]', 'pi_3PcK4N2KWfFUQWKW0qFRjWoc', 'stripe', '{\"name\":\"Nishat Tasnim\",\"email\":\"admin@example.com\",\"phone\":\"5468764\",\"address\":\"Tongi, Gazipur\"}', 'Pending', '2024-07-14 04:29:57'),
(11, 0, 165.00, '[{\"product_id\":16,\"name\":\"ball\",\"unit_price\":\"33.00\",\"quantity\":5,\"total_price\":165},{\"product_id\":\"total_price\",\"name\":null,\"unit_price\":null,\"quantity\":null,\"total_price\":0}]', 'pi_3PcK8M2KWfFUQWKW0SYzynDi', 'stripe', '{\"name\":\"Nishat Tasnim\",\"email\":\"admin@example.com\",\"phone\":\"5468764\",\"address\":\"Tongi, Gazipur\"}', 'Pending', '2024-07-14 04:34:04');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text,
  `sub_categoryId` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `stock`, `image`, `description`, `sub_categoryId`) VALUES
(14, 'dfng', 33.00, 3, '../uploads/../uploads/products\\b20f11515ef99e748b7df0d930c993a9.png', 'In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before the final copy is available.', 2),
(16, 'ball', 33.00, 2, '../uploads/../uploads/../uploads/../uploads/products\\4e04fb2f614ba15e1d9b44f720bc50bd.png', 'In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before the final copy is available.', 4),
(17, 'toy', 33.00, 22, '../uploads/products\\e6c621e8b10d74243664e7b3fd4dfa6c.png', 'jsndjfs', 7);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int NOT NULL,
  `key` varchar(100) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

CREATE TABLE `sub_category` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `parent_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`id`, `name`, `parent_id`) VALUES
(4, 'Football', 8),
(7, 'Shirt', 9),
(8, 'Sharee', 11);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `phone`, `address`, `password`, `role`, `image`) VALUES
(1, 'Nishat Tasnim', 'admin@example.com', '5468764', 'Tongi, Gazipur', 'e10adc3949ba59abbe56e057f20f883e', 'admin', NULL),
(2, 'customer', 'customer@example.com', '43982649283', 'xf gjd', 'e10adc3949ba59abbe56e057f20f883e', 'customer', NULL),
(3, 'jnjsdfj', 'njknsdf@example.com', '4325345', 'dnfjkndkg', 'e10adc3949ba59abbe56e057f20f883e', 'customer', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`key`);

--
-- Indexes for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
