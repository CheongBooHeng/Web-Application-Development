-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 31, 2023 at 03:00 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `booheng`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `description`) VALUES
(1, 'Food', 'KFC,MCD'),
(2, 'Drink', 'Milo,Cola,Pepsi,A&amp;W'),
(3, 'Cooking Essentials', 'Cooking oil, powder, sauce'),
(4, 'Breakfast', 'Bread, Biscuits, Cookies'),
(6, 'Household Supplies', 'Household Cleaners, Floor Cleaners, Kitchen Cleaners, Toilet Cleaners');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `phone_number` text NOT NULL,
  `email` text NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `phone_number`, `email`, `message`) VALUES
(1, 'Hai', '-17849288', 'cheongbooheng0517@e.newera.edu.my', 'testing 123'),
(2, 'Cheong Boo Heng', '01117849299', 'cbh020517@gmail.com', 'testing'),
(3, 'Cheong Boo Heng', '01117849299', 'cbh020517@gmail.com', 'testing testing 123'),
(4, 'Cheong Boo Heng', '011-17849299', 'cbh020517@gmail.com', 'asasdasd');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(256) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `firstname` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `lastname` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `gender` enum('Male','Female') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `registration_date_time` datetime NOT NULL,
  `account_status` enum('Active','Inactive','','') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'Active',
  `email` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `username`, `password`, `firstname`, `lastname`, `gender`, `date_of_birth`, `registration_date_time`, `account_status`, `email`, `image`) VALUES
(1, 'BooHeng', '$2y$10$DsF43NiomVhIsnSW9fenWOKgpCBwDaG0ZKU5yJeIAwgt0ER7Gtcei', 'Boo Heng', 'Cheong', 'Male', '2002-05-17', '2023-08-30 22:49:59', 'Active', 'cbh020517@gmail.com', 'uploads/be52fda8cfc947da37fab121eb4457df99f2723f-profilepic5.jpg'),
(2, 'QianSheng', '$2y$10$jlv9CEYG1sRr6pcwpbpnQuMTYvnWCae417gngBa80LrPSh5RkueSG', 'Qian Sheng', 'Yew', 'Male', '2002-05-23', '2023-08-31 00:00:19', 'Active', 'qiansheng@gmail.com', 'uploads/2e82e343eebd389b51be6f83c40bcfb0f5584709-profilepic4.jpg'),
(3, 'KuiHeng', '$2y$10$rHz.3Sc88i.rgVHe7glze.9r6A0ibML8id/gAwORD2.ggypcEBTc.', 'Kui Heng', 'Chow', 'Male', '2002-10-18', '2023-08-31 00:01:33', 'Active', 'kuihengchow@gmail.com', 'uploads/9180ad1430d75778ee4fb40aa8471b13c5ef1037-profilepic3.jpg'),
(4, 'SinKuan', '$2y$10$FRgiOmkkl/JiR61kdi0OfO2SnbtJNWiHWottGcEUrh0oAaP//Pb2m', 'Sin Kuan', 'Lim', 'Male', '2002-04-15', '2023-08-31 00:02:02', 'Active', 'limsinkuan@gmail.com', 'uploads/8ebc90548cca98eb2d82cd06b6ee63d59d4c2008-profilepic.jpg'),
(5, 'EngHong', '$2y$10$QftinbFAmWlmeQFl2XK8HOLyZoQLgwmi.mGkKpUcHJi83AU73oL8q', 'Eng Hong', 'Haw', 'Male', '2002-02-14', '2023-08-31 00:04:00', 'Active', 'enghong@gmail.com', 'uploads/8566a40bd67847875068a689db44ea5623f83e5b-profilepic2.jpg'),
(6, 'Miaosen', '$2y$10$8zNUsralLzNn96AVmo8aU.iGwj8cFtICrTrYNsDE/zTcPNmrSgPRa', 'Miao Sen', 'Lew', 'Male', '2002-01-25', '2023-08-31 00:04:32', 'Active', 'miaosenlew@gmail.com', ''),
(7, 'YenShen', '$2y$10$pANK2Nbsnpyp5W4Rm5WQs.1bs4ygjYhH05SI9mlmAGt0EmHniZzNy', 'Yen Shen', 'Kwek', 'Male', '2002-11-05', '2023-08-31 00:05:13', 'Active', 'yenshen@gmail.com', ''),
(8, 'HanYuan', '$2y$10$gsrW5dyWOXmZuBmXBX8UHuUqPKwPJH/zdJiZP/HtscCaWC1uRM5Z.', 'Han Yuan', 'Yu', 'Male', '2002-08-02', '2023-08-31 00:05:37', 'Active', 'hanyuan@gmail.com', ''),
(9, 'Francis', '$2y$10$SBW/DxBn2Rj3wNNUa9ucNOI8QHYzOQhsJBkJY/AJ0x54AgStt8xNu', 'Wong', 'Francis', 'Male', '2002-01-24', '2023-08-31 00:05:58', 'Inactive', 'franciswong@gmail.com', ''),
(10, 'JieWei', '$2y$10$6.hgeltVZh2xFnqZB0bTL.R/i7y5Grc4UuKXo55eij6GbdWqUCShi', 'Jie Wei', 'Ling', 'Male', '2002-01-01', '2023-08-31 00:14:52', 'Inactive', 'jieweiling@gmail.com', ''),
(12, 'Alex00', '$2y$10$kbbygUpQ5.Vr6xEenfO5X.tSlaGk64hxHT/.KtsdoMW/DrVWKw4ze', 'Alex', 'Hu', 'Male', '2000-11-29', '2023-08-31 10:22:56', 'Active', 'alexhu@gmail.com', '');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
CREATE TABLE IF NOT EXISTS `order_details` (
  `orderdetail_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`orderdetail_id`)
) ENGINE=MyISAM AUTO_INCREMENT=82 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`orderdetail_id`, `order_id`, `product_id`, `quantity`) VALUES
(1, 1, 1, 1),
(2, 2, 2, 5),
(3, 2, 3, 3),
(4, 3, 5, 8),
(5, 3, 10, 10),
(81, 4, 5, 3),
(80, 4, 4, 4),
(79, 4, 8, 7),
(75, 5, 4, 1),
(74, 5, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_summary`
--

DROP TABLE IF EXISTS `order_summary`;
CREATE TABLE IF NOT EXISTS `order_summary` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `order_date` datetime NOT NULL,
  `total_amount` double NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_summary`
--

INSERT INTO `order_summary` (`order_id`, `customer_id`, `order_date`, `total_amount`) VALUES
(1, 1, '2023-08-31 00:06:30', 3.8),
(2, 2, '2023-08-31 00:06:42', 8.8),
(3, 3, '2023-08-31 00:06:55', 79),
(4, 5, '2023-08-31 09:51:16', 149),
(5, 7, '2023-08-31 01:24:59', 8.1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `price` double NOT NULL,
  `image` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `promotion_price` double NOT NULL,
  `manufacture_date` date DEFAULT NULL,
  `expired_date` date DEFAULT NULL,
  `category_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `created`, `modified`, `promotion_price`, `manufacture_date`, `expired_date`, `category_name`) VALUES
(1, 'Hupseng', 'Cream Cracker', 4.5, 'uploads/ca17ad3fc1966030aea813258b856084f7f41f51-hupseng.jpeg', '2023-08-27 17:07:52', '2023-08-27 10:21:35', 3.8, '2022-01-01', '2023-01-01', 'Food'),
(2, 'Gardenia Chocolate', 'Quick Bites Bread', 1.1, 'uploads/600a1fc47179af30c5569b182e0c1698f17179f9-chocolate.png', '2023-08-27 17:40:35', '2023-08-27 17:58:04', 0, '2023-01-01', '2023-07-01', 'Breakfast'),
(3, 'Gradenia Vanila', 'Quick Bites Bread', 1.1, 'uploads/385ddf81ed447ebc4a49c1f7108577fb275af5c2-vanila.jpeg', '2023-08-27 17:43:56', '2023-08-27 17:57:46', 0, '2023-01-01', '2023-01-02', 'Breakfast'),
(4, 'Gradenia Original Classic', 'White Bread', 4.3, 'uploads/985682bba275ed019c2e62fd7b9d29ec6245c15a-original.jpg', '2023-08-27 17:46:41', '2023-08-27 17:58:20', 0, '2023-01-01', '2023-01-07', 'Food'),
(5, 'Marigold Mixed Apple Aloe Vera', '1L', 6.5, 'uploads/122c77ae2b4f491e426f7e6deb5897e73ce5ba54-marigold-peel-fresh-aloe-vera.png', '2023-08-27 18:31:27', '2023-08-27 17:52:51', 4.5, '2022-01-01', '2023-05-01', 'Drink'),
(6, 'Marigold Peel Fresh Juice Orange', '1L', 6.3, 'uploads/d008efd6122deebec97c8b07b637b803a6272881-marigold-peel-fresh-orange.png', '2023-08-28 01:49:27', '2023-08-31 02:31:56', 0, '2022-01-01', '2023-01-01', 'Drink'),
(7, 'Adabi Chili Sauce', '500ML', 5.5, 'uploads/f0231e9f3248083fbfe205d4da57ab24f00f2f0c-adabi_chilli_sauce.png', '2023-08-28 01:52:08', '2023-08-28 06:16:43', 0, '2022-01-01', '2023-07-01', 'Cooking Essentials'),
(8, 'Daisy Corn Oil', '1KG', 16.9, 'uploads/66a9955abbee47633b51f8c5749feadf249e9dd0-daisy-corn-oil.png', '2023-08-28 01:54:21', '2023-08-30 14:34:01', 0, '2022-01-01', '2023-05-01', 'Food'),
(9, 'Baba\'s fish curry powder', '125G', 3, '', '2023-08-28 02:32:50', '2023-08-27 18:32:58', 0, '2022-05-05', '2023-05-05', 'Cooking Essentials'),
(10, 'Jack n Jill Roller Coaster', 'Sweet and Spicy 100G', 4.3, '', '2023-08-28 02:35:18', '2023-08-27 18:35:18', 0, '2022-12-31', '2024-01-01', 'Food'),
(14, 'HABHAL\'s Home Made Recipe Kaya', '520G', 8.5, 'uploads/0dbca158cda74bf2a44f2b65d8094bf9ec65a2cd-kaya.png', '2023-08-31 10:42:18', '2023-08-31 02:42:18', 0, '2020-12-31', '2023-01-01', 'Breakfast');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
