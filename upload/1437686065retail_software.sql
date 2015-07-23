-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 22, 2015 at 09:26 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `retail_software`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field` varchar(255) NOT NULL,
  `value` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `field`, `value`) VALUES
(1, 'site_url', 'http://localhost/productinventory'),
(2, 'username', 'admin'),
(3, 'password', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE IF NOT EXISTS `invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_number` varchar(50) NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `customer_mobile` int(11) NOT NULL,
  `customer_email` varchar(50) NOT NULL,
  `customer_address` text NOT NULL,
  `vat` float NOT NULL,
  `discount` float NOT NULL,
  `price` float NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `invoice`
--


-- --------------------------------------------------------

--
-- Table structure for table `invoice_product`
--

CREATE TABLE IF NOT EXISTS `invoice_product` (
  `id` int(11) NOT NULL DEFAULT '0',
  `product_code` int(50) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_price` float NOT NULL,
  `selling_price` float NOT NULL,
  `product_discound` float NOT NULL,
  `final_price` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_product`
--


-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `store_position` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `cost_price` float NOT NULL,
  `sale_price` float NOT NULL,
  `discount` int(11) NOT NULL,
  `vendor` int(11) NOT NULL,
  `details` longtext NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `products`
--


-- --------------------------------------------------------

--
-- Table structure for table `product_meta`
--

CREATE TABLE IF NOT EXISTS `product_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `field` varchar(50) NOT NULL,
  `value` longtext NOT NULL,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `product_meta`
--


-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `field` varchar(50) NOT NULL,
  `value` longtext NOT NULL,
  `date` datetime NOT NULL DEFAULT '2015-01-21 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `userid`, `field`, `value`, `date`) VALUES
(1, 0, 'vat', '', '0000-00-00 00:00:00'),
(2, 0, 'vat_type', '', '2015-01-21 00:00:00'),
(3, 0, 'discount', '', '2015-01-21 00:00:00'),
(4, 0, 'discount_type', '', '2015-01-21 00:00:00'),
(5, 0, 'service_tax', '', '2015-01-21 00:00:00'),
(6, 0, 'service_tax_type', '', '2015-01-21 00:00:00'),
(7, 0, 'currency', '', '2015-01-21 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `shop_name` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` int(11) NOT NULL,
  `mobile` int(11) NOT NULL,
  `address` text NOT NULL,
  `role` enum('owner','vendor','manager','customer','seller') NOT NULL,
  `ip` varchar(25) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `parent_id`, `username`, `password`, `name`, `shop_name`, `email`, `phone`, `mobile`, `address`, `role`, `ip`, `date`) VALUES
(1, 0, 'owner', '72122ce96bfec66e2396d2e25225d70a', 'owner', '', 'owner@gmail.com', 2147483647, 2147483647, 'ahmedabad, \r\ngujrat - 874563\r\nindia', 'owner', '198.324.12.345', '2015-07-18 22:10:01'),
(2, 0, '', '', 'Subrata Vendor', '', 'subratavendor@gmail.com', 339853763, 2147483647, 'Nabajiban , Birati\r\nKolkata -700051\r\nWest bengal.\r\nContact Person: Vicky Roy\r\nEmail: support@fastad.in', 'vendor', '198.324.12.345', '2015-07-19 00:07:56'),
(3, 0, '', '', 'Subrata Vendor', '', 'subratavendor@gmail.com', 339853763, 2147483647, 'Nabajiban , Birati\r\nKolkata -700051\r\nWest bengal.\r\nContact Person: Vicky Roy\r\nEmail: support@fastad.in', 'vendor', '198.324.12.345', '2015-07-19 00:07:56'),
(4, 0, '', '', 'Subrata Vendor', '', 'subratavendor@gmail.com', 339853763, 2147483647, 'Nabajiban , Birati\r\nKolkata -700051\r\nWest bengal.\r\nContact Person: Vicky Roy\r\nEmail: support@fastad.in', 'vendor', '198.324.12.345', '2015-07-19 00:07:56'),
(5, 0, '', '', 'Subrata Vendor', '', 'subratavendor@gmail.com', 339853763, 2147483647, 'Nabajiban , Birati\r\nKolkata -700051\r\nWest bengal.\r\nContact Person: Vicky Roy\r\nEmail: support@fastad.in', 'vendor', '198.324.12.345', '2015-07-19 00:07:56'),
(6, 0, '', '', 'Subrata Vendor', '', 'subratavendor@gmail.com', 339853763, 2147483647, 'Nabajiban , Birati\r\nKolkata -700051\r\nWest bengal.\r\nContact Person: Vicky Roy\r\nEmail: support@fastad.in', 'vendor', '198.324.12.345', '2015-07-19 00:07:56'),
(7, 0, '', '', 'Subrata Vendor', '', 'subratavendor@gmail.com', 339853763, 2147483647, 'Nabajiban , Birati\r\nKolkata -700051\r\nWest bengal.\r\nContact Person: Vicky Roy\r\nEmail: support@fastad.in', 'vendor', '198.324.12.345', '2015-07-19 00:07:56'),
(8, 0, '', '', 'Subrata Vendor', '', 'subratavendor@gmail.com', 339853763, 2147483647, 'Nabajiban , Birati\r\nKolkata -700051\r\nWest bengal.\r\nContact Person: Vicky Roy\r\nEmail: support@fastad.in', 'vendor', '198.324.12.345', '2015-07-19 00:07:56'),
(9, 0, '', '', 'Subrata Vendor', '', 'subratavendor@gmail.com', 339853763, 2147483647, 'Nabajiban , Birati\r\nKolkata -700051\r\nWest bengal.\r\nContact Person: Vicky Roy\r\nEmail: support@fastad.in', 'vendor', '198.324.12.345', '2015-07-19 00:07:56'),
(10, 0, '', '', 'Subrata Vendor', '', 'subratavendor@gmail.com', 339853763, 2147483647, 'Nabajiban , Birati\r\nKolkata -700051\r\nWest bengal.\r\nContact Person: Vicky Roy\r\nEmail: support@fastad.in', 'vendor', '198.324.12.345', '2015-07-19 00:07:56'),
(11, 0, '', '', 'Subrata Vendor', '', 'subratavendor@gmail.com', 339853763, 2147483647, 'Nabajiban , Birati\r\nKolkata -700051\r\nWest bengal.\r\nContact Person: Vicky Roy\r\nEmail: support@fastad.in', 'vendor', '198.324.12.345', '2015-07-19 00:07:56');
