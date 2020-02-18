-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2019 at 11:00 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `cart_name` varchar(100) NOT NULL,
  `cart_description` varchar(200) NOT NULL,
  `product_price` double(20,2) NOT NULL,
  `quantity` int(50) NOT NULL,
  `total_amount` double(20,2) NOT NULL,
  `product_media` varchar(200) NOT NULL,
  `transaction_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cashier` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employee_id` int(11) NOT NULL,
  `employee_name` varchar(50) NOT NULL,
  `employee_username` varchar(50) NOT NULL,
  `employee_password` varchar(200) NOT NULL,
  `employee_access` varchar(15) NOT NULL,
  `employee_media` varchar(200) NOT NULL,
  `status` varchar(15) NOT NULL,
  `logs` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_id`, `employee_name`, `employee_username`, `employee_password`, `employee_access`, `employee_media`, `status`, `logs`) VALUES
(1, 'admin', 'admin', '$2y$10$2.nuwm/5OLXJ.zGT6ANfEOI6l1GVEz8vvuY8SwEEpkwy1fkKEwZYy', 'admin', 'upl/1550994995_upload.png', 'active', 'login'),
(2, 'Juris Daguplo', 'juris', '$2y$10$LeCmZtV0U.NJK32qz4wJ..8y2W9zXCu1UF5SlGHiMFQhrubRr2iX6', 'employee', 'upl/1550995212_upload.png', 'active', 'logout'),
(3, 'employee1', 'employee1', '$2y$10$msk19j69dL//0YlnWLwFP.JKHd76.98u.xgys.rpph4t/RDv2aJVe', 'employee', 'img/upload.png', 'active', 'logout'),
(4, 'fhvhgfv', 'employee2', '$2y$10$Vg7Fn349zoc6EmS.2z69de/XkL/bQTRcsHtOszRaXThcvHuuk4pV.', 'employee', 'img/upload.png', 'active', 'logout');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_description` varchar(200) NOT NULL,
  `product_price` double(20,2) NOT NULL,
  `total_stock` int(50) NOT NULL,
  `remaining_stock` int(50) NOT NULL,
  `barcode_no` varchar(200) NOT NULL,
  `product_media` varchar(200) NOT NULL,
  `notif_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_description`, `product_price`, `total_stock`, `remaining_stock`, `barcode_no`, `product_media`, `notif_status`) VALUES
(11, 'Gillettea', '2ml', 44.00, 23, 21, '4902430441896', 'upl/1549866143_Merry-Christmas.png', 1),
(12, 'Milo', '23g', 9.00, 58, 58, '4800361383301', 'upl/1550995866_upload-product.png', 1),
(13, 'Pilot G-Tech', '0.4', 60.00, 21, 21, '4902505139314', 'img/upload-product.png', 1),
(14, 'Rexona', '3ml', 6.00, 5, 5, '4800888150608', 'img/upload-product.png', 1),
(15, 'Gillette', '5ml', 7.00, 5, 5, '091230917293', 'img/upload-product.png', 1),
(16, 'Oppo', 'New Elite', 5000.00, 3, 3, '098109238', 'upl/1549632028_banner.jpg', 1),
(17, 'Jawe', 'asd', 900.00, 12, 12, '928301923', 'upl/1549632224_banner.jpg', 1),
(18, 'pitaka', 'lamion', 20.00, 2, 2, '00000000', 'upl/1549705471_banner.jpg', 1),
(19, 'Chocolate1', '1s', 22.00, 6, 6, '0910923801923', 'img/upload-product.png', 1),
(20, 'Mic', 'Ace', 20.00, 600, 600, '846212', 'upl/1550990547_image-7925964c-e90e-4b9c-9d91-b747cb12a0bf.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_price_updates`
--

CREATE TABLE `product_price_updates` (
  `price_inventory_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `prior_price` double(20,2) NOT NULL,
  `new_price` double(20,2) NOT NULL,
  `date_updated` varchar(100) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_price_updates`
--

INSERT INTO `product_price_updates` (`price_inventory_id`, `product_name`, `prior_price`, `new_price`, `date_updated`, `product_id`) VALUES
(1, 'Gillettea', 20.00, 18.00, '07:52 pm | 2019/02/19', 11),
(2, 'Chocolate1', 20.00, 22.00, '06:09 pm | 2019/02/21', 19),
(3, 'Gillettea', 18.00, 18.00, '01:59 pm | 2019/02/24', 11),
(4, 'Gillettea', 18.00, 40.00, '02:07 pm | 2019/02/24', 11),
(5, 'Gillettea', 40.00, 41.00, '02:40 pm | 2019/02/24', 11),
(6, 'Gillettea', 41.00, 44.00, '02:41 pm | 2019/02/24', 11),
(7, 'Mic', 12.00, 20.00, '03:45 pm | 2019/02/24', 20),
(8, 'Milo', 7.00, 9.00, '04:11 pm | 2019/02/24', 12);

-- --------------------------------------------------------

--
-- Table structure for table `product_stock_inventory`
--

CREATE TABLE `product_stock_inventory` (
  `stock_inventory_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `prior_stock` int(100) NOT NULL,
  `added_stock` int(100) NOT NULL,
  `new_stock` int(50) NOT NULL,
  `date_updated` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_stock_inventory`
--

INSERT INTO `product_stock_inventory` (`stock_inventory_id`, `product_id`, `product_name`, `prior_stock`, `added_stock`, `new_stock`, `date_updated`) VALUES
(5, 11, 'Gillettea', 5, 5, 10, '07:52 pm | 2019/02/19'),
(6, 19, 'Chocolate1', 2, 4, 6, '06:09 pm | 2019/02/21'),
(7, 11, 'Gillettea', 9, 2, 11, '01:59 pm | 2019/02/24'),
(8, 11, 'Gillettea', 11, 12, 23, '02:07 pm | 2019/02/24'),
(9, 20, 'Mic', 55, 555, 500, '03:45 pm | 2019/02/24'),
(10, 20, 'Mic', 500, 600, 100, '03:47 pm | 2019/02/24'),
(11, 20, 'Mic', 500, 600, 100, '03:47 pm | 2019/02/24'),
(12, 17, 'Jawe', 2, 12, 10, '03:50 pm | 2019/02/24'),
(13, 12, 'Milo', 16, 12, 28, '03:52 pm | 2019/02/24'),
(14, 13, 'Pilot G-Tech', 7, 17, 10, '04:09 pm | 2019/02/24'),
(15, 13, 'Pilot G-Tech', 10, 20, 10, '04:09 pm | 2019/02/24'),
(16, 13, 'Pilot G-Tech', 10, 20, 10, '04:09 pm | 2019/02/24'),
(17, 13, 'Pilot G-Tech', 10, 21, 11, '04:09 pm | 2019/02/24'),
(18, 12, 'Milo', 28, 58, 30, '04:11 pm | 2019/02/24');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sales_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `purchase_name` varchar(200) NOT NULL,
  `product_description` varchar(200) NOT NULL,
  `product_price` double(20,2) NOT NULL,
  `quantity` int(50) NOT NULL,
  `total_amount` double(20,2) NOT NULL,
  `product_media` varchar(200) NOT NULL,
  `cashier` varchar(100) NOT NULL,
  `transaction_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `invoice_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sales_id`, `product_id`, `employee_id`, `purchase_name`, `product_description`, `product_price`, `quantity`, `total_amount`, `product_media`, `cashier`, `transaction_time`, `invoice_number`) VALUES
(1, 11, 2, 'Gillette', '2ml', 18.00, 1, 18.00, 'upl/1549866143_Merry-Christmas.png', 'Juris Daguplo', '2019-02-22 15:23:08', 1),
(2, 12, 2, 'Milo', '22g', 7.00, 1, 7.00, 'img/upload-product.png', 'Juris Daguplo', '2019-02-22 15:33:20', 2),
(3, 17, 2, 'Jawe', 'asd', 900.00, 1, 900.00, 'upl/1549632224_banner.jpg', 'Juris Daguplo', '2019-02-22 15:33:20', 2),
(4, 11, 2, 'Gillette', '2ml', 18.00, 0, 0.00, 'upl/1549866143_Merry-Christmas.png', 'Juris Daguplo', '2019-02-23 03:56:49', 3),
(5, 12, 2, 'Milo', '22g', 7.00, 1, 7.00, 'img/upload-product.png', 'Juris Daguplo', '2019-02-23 03:56:49', 3),
(6, 11, 2, 'Gillettea', '2ml', 44.00, 2, 88.00, 'upl/1549866143_Merry-Christmas.png', 'Juris Daguplo', '2019-02-24 07:53:55', 4);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `total_amount` double(20,2) NOT NULL,
  `payment` double(20,2) NOT NULL,
  `change` double(20,2) NOT NULL,
  `cashier` varchar(200) NOT NULL,
  `transaction_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `total_amount`, `payment`, `change`, `cashier`, `transaction_date`) VALUES
(1, 18.00, 20.00, 2.00, 'Juris Daguplo', '2019-02-22'),
(2, 907.00, 1000.00, 93.00, 'Juris Daguplo', '2019-02-22'),
(3, 7.00, 10.00, 3.00, 'Juris Daguplo', '2019-02-23'),
(4, 88.00, 100.00, 12.00, 'Juris Daguplo', '2019-02-24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_price_updates`
--
ALTER TABLE `product_price_updates`
  ADD PRIMARY KEY (`price_inventory_id`);

--
-- Indexes for table `product_stock_inventory`
--
ALTER TABLE `product_stock_inventory`
  ADD PRIMARY KEY (`stock_inventory_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sales_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `product_price_updates`
--
ALTER TABLE `product_price_updates`
  MODIFY `price_inventory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_stock_inventory`
--
ALTER TABLE `product_stock_inventory`
  MODIFY `stock_inventory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
