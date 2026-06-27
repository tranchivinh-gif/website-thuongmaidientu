-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2026 at 04:40 PM
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
-- Database: `websitebanhang`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `CartID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_detail`
--

CREATE TABLE `cart_detail` (
  `CartID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Price` decimal(18,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category_product`
--

CREATE TABLE `category_product` (
  `CategoryID` int(11) NOT NULL,
  `CategoryName` varchar(255) DEFAULT NULL,
  `Description` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_product`
--

INSERT INTO `category_product` (`CategoryID`, `CategoryName`, `Description`) VALUES
(0, 'Chưa phân loại', NULL),
(1, 'Thời trang', NULL),
(2, 'Đồ ăn', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `CommentID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `Content` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_request`
--

CREATE TABLE `customer_request` (
  `RequestID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `OrderID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Content` varchar(500) DEFAULT NULL,
  `Status` varchar(50) NOT NULL DEFAULT 'pending',
  `Image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `UserID` int(11) NOT NULL,
  `ShopID` int(11) NOT NULL,
  `Position` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`UserID`, `ShopID`, `Position`) VALUES
(2, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `OrderID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `OrderDate` datetime DEFAULT NULL,
  `Total` decimal(18,2) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `ShippingAddress` varchar(255) DEFAULT NULL,
  `Note` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `OrderID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `UnitPrice` decimal(18,2) DEFAULT NULL,
  `Discount` decimal(5,2) DEFAULT NULL,
  `Status` varchar(255) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `PaymentID` int(11) NOT NULL,
  `OrderID` int(11) DEFAULT NULL,
  `PaymentMethod` varchar(100) DEFAULT NULL,
  `Amount` decimal(18,2) DEFAULT NULL,
  `PaymentDate` datetime DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProductID` int(11) NOT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `ShopID` int(11) DEFAULT NULL,
  `ProductName` varchar(255) DEFAULT NULL,
  `Price` decimal(18,2) DEFAULT NULL,
  `Discount` decimal(18,2) DEFAULT 0.00,
  `Description` varchar(500) DEFAULT NULL,
  `Image` varchar(255) NOT NULL DEFAULT 'default.jpg',
  `Stock` int(11) DEFAULT NULL,
  `Status` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `CategoryID`, `ShopID`, `ProductName`, `Price`, `Discount`, `Description`, `Image`, `Stock`, `Status`) VALUES
(1, 1, 1, 'ví dụ 1', 99000.00, 87000.00, '', 'vidu1.png', 10, 1),
(2, 0, 1, 'ví dụ 2', 190000.00, 99000.00, '', 'vidu2.png', 10, 1),
(3, 0, 1, 'ví dụ 3', 199000.00, 100000.00, '', 'vidu3.png', 10, 1),
(4, 2, 2, 'ví dụ 4', 69000.00, 40000.00, '', 'vidu4.png', 10, 1),
(5, 2, 2, 'ví dụ 5', 59000.00, 20000.00, '', 'vidu5.png', 10, 1),
(6, 0, 2, 'ví dụ 6', 70000.00, 50000.00, 'khá', 'vidu6.png', 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `ReviewID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `Rating` tinyint(4) DEFAULT NULL,
  `Content` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `RoleID` int(11) NOT NULL,
  `RoleName` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`RoleID`, `RoleName`) VALUES
(1, 'admin'),
(2, 'employee'),
(3, 'member'),
(4, 'owner');

-- --------------------------------------------------------

--
-- Table structure for table `seller_request`
--

CREATE TABLE `seller_request` (
  `RequestID` int(11) NOT NULL,
  `ShopID` int(11) DEFAULT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Content` varchar(500) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shop`
--

CREATE TABLE `shop` (
  `ShopID` int(11) NOT NULL,
  `OwnerID` int(11) DEFAULT NULL,
  `ShopName` varchar(255) DEFAULT NULL,
  `Description` varchar(500) DEFAULT NULL,
  `Logo` varchar(255) DEFAULT NULL,
  `Status` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shop`
--

INSERT INTO `shop` (`ShopID`, `OwnerID`, `ShopName`, `Description`, `Logo`, `Status`) VALUES
(1, 4, 'Shop quần áo', NULL, NULL, 1),
(2, 5, 'Shop đồ ăn', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `RoleID` int(11) DEFAULT 3,
  `UserName` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Status` tinyint(4) DEFAULT 1,
  `LoginCount` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `RoleID`, `UserName`, `Email`, `Password`, `Image`, `Phone`, `Address`, `Status`, `LoginCount`) VALUES
(1, 1, 'tranchivinh', 'vinh@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, NULL, NULL, 1, 10),
(2, 2, 'nguyenthuydanchinh', 'chinh@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, NULL, NULL, 1, 16),
(3, 3, 'nguyenhoangvu', 'vu@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, NULL, NULL, 1, 2),
(4, 4, 'huynhhuutuan', 'tuan@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, NULL, NULL, 1, 33),
(5, 4, 'nguyentiendung', 'dung@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, NULL, NULL, 1, 11);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`CartID`),
  ADD UNIQUE KEY `UserID` (`UserID`);

--
-- Indexes for table `cart_detail`
--
ALTER TABLE `cart_detail`
  ADD PRIMARY KEY (`CartID`,`ProductID`),
  ADD KEY `fk_cd_product` (`ProductID`);

--
-- Indexes for table `category_product`
--
ALTER TABLE `category_product`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`CommentID`),
  ADD KEY `fk_comment_user` (`UserID`),
  ADD KEY `fk_comment_product` (`ProductID`);

--
-- Indexes for table `customer_request`
--
ALTER TABLE `customer_request`
  ADD PRIMARY KEY (`RequestID`),
  ADD KEY `fk_cr_user` (`UserID`),
  ADD KEY `OrderID` (`OrderID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`UserID`,`ShopID`),
  ADD KEY `fk_employee_shop` (`ShopID`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `fk_order_user` (`UserID`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`OrderID`,`ProductID`),
  ADD KEY `fk_od_product` (`ProductID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`PaymentID`),
  ADD UNIQUE KEY `OrderID` (`OrderID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `fk_product_category` (`CategoryID`),
  ADD KEY `fk_product_shop` (`ShopID`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`ReviewID`),
  ADD KEY `fk_review_user` (`UserID`),
  ADD KEY `fk_review_product` (`ProductID`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`RoleID`),
  ADD UNIQUE KEY `RoleName` (`RoleName`);

--
-- Indexes for table `seller_request`
--
ALTER TABLE `seller_request`
  ADD PRIMARY KEY (`RequestID`),
  ADD KEY `fk_sr_shop` (`ShopID`);

--
-- Indexes for table `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`ShopID`),
  ADD KEY `fk_shop_owner` (`OwnerID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `fk_user_role` (`RoleID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `CartID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category_product`
--
ALTER TABLE `category_product`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_request`
--
ALTER TABLE `customer_request`
  MODIFY `RequestID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `RoleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `seller_request`
--
ALTER TABLE `seller_request`
  MODIFY `RequestID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shop`
--
ALTER TABLE `shop`
  MODIFY `ShopID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_cart_user` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `cart_detail`
--
ALTER TABLE `cart_detail`
  ADD CONSTRAINT `fk_cd_cart` FOREIGN KEY (`CartID`) REFERENCES `cart` (`CartID`),
  ADD CONSTRAINT `fk_cd_product` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fk_comment_product` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`),
  ADD CONSTRAINT `fk_comment_user` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `customer_request`
--
ALTER TABLE `customer_request`
  ADD CONSTRAINT `customer_request_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `order_detail` (`ProductID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `customer_request_ibfk_2` FOREIGN KEY (`OrderID`) REFERENCES `order_detail` (`OrderID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cr_user` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `fk_employee_shop` FOREIGN KEY (`ShopID`) REFERENCES `shop` (`ShopID`),
  ADD CONSTRAINT `fk_employee_user` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk_order_user` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `fk_od_order` FOREIGN KEY (`OrderID`) REFERENCES `order` (`OrderID`),
  ADD CONSTRAINT `fk_od_product` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `fk_payment_order` FOREIGN KEY (`OrderID`) REFERENCES `order` (`OrderID`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`CategoryID`) REFERENCES `category_product` (`CategoryID`),
  ADD CONSTRAINT `fk_product_shop` FOREIGN KEY (`ShopID`) REFERENCES `shop` (`ShopID`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `fk_review_product` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`),
  ADD CONSTRAINT `fk_review_user` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `seller_request`
--
ALTER TABLE `seller_request`
  ADD CONSTRAINT `fk_sr_shop` FOREIGN KEY (`ShopID`) REFERENCES `shop` (`ShopID`);

--
-- Constraints for table `shop`
--
ALTER TABLE `shop`
  ADD CONSTRAINT `fk_shop_owner` FOREIGN KEY (`OwnerID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_role` FOREIGN KEY (`RoleID`) REFERENCES `role` (`RoleID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
