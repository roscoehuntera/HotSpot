-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 22, 2021 at 01:21 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotspot`
--

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

DROP TABLE IF EXISTS `destinations`;
CREATE TABLE IF NOT EXISTS `destinations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `img_url` varchar(400) NOT NULL,
  `quiz_recommend` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`id`, `name`, `img_url`, `quiz_recommend`) VALUES
(11, 'Los Angeles, California', 'https://www.viajarlosangeles.com/img/guia-viajar-los-angeles.jpg', '1a,1b,1c,2b,3a,3b,3c,4a,4b,5b,6b,7a,7b'),
(12, 'Las Vegas, Nevada', 'https://a.cdn-hotels.com/gdcs/production37/d1139/a8a147d0-c31d-11e8-825c-0242ac110006.jpg', '1b,1c,2b,2c,3a,3c,4b,4c,5a,5b,5c,6a,7a,7b'),
(13, 'Honolulu, Hawaii', 'https://www.mundoviajes.org/wp-content/uploads/waikiki.jpg', '1a,1b,1c,2b,2c,3a,3b,3c,4a,4b,4d,5b,5c,6a,7a,7b,7c,7d'),
(14, 'Paris, France', 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4b/La_Tour_Eiffel_vue_de_la_Tour_Saint-Jacques%2C_Paris_ao%C3%BBt_2014_%282%29.jpg/1200px-La_Tour_Eiffel_vue_de_la_Tour_Saint-Jacques%2C_Paris_ao%C3%BBt_2014_%282%29.jpg', '1a,1b,1c,2c,3a,3c,4b,4c,5a,5c,6b,6c,7a,7b,7c'),
(15, 'Barcelona, Spain', 'https://i.guim.co.uk/img/media/3317451386c7a646be48cbec024bb89c1402aad9/168_0_4844_2910/master/4844.jpg?width=465&quality=45&auto=format&fit=max&dpr=2&s=5000c4975910298670763292af8f3ace', '1a,1b,1c,2b,3a,3b,4a,4b,4c,4d,5a,5b,6b,6c,7a,7b,7c'),
(16, 'San Juan, Puerto Rico', 'https://img.ev.mu/images/villes/7195/600x400/7195.jpg', '1a,1b,1c,2b,3a,3b,4a,4b,4c,4d,5b,5c,6a,6b,7a,7b,7d'),
(17, 'Cape Town, South Africa', 'https://www.andbeyond.com/wp-content/uploads/sites/5/cape-town-aerial-view-greenpoint-stadium.jpg', '1a,1b,2c3a,3b,4a,4b,4c,4d,5b,5c,6a,6b,7a,7b,7d'),
(18, 'Miami, Florida', 'https://s3-us-west-2.amazonaws.com/public.travel2latam.com/imagenes/000/511/944/000511944.jpg', '1a,1b,2a,2b,3a,3b,4a,4b,4c,5a,5b,5c,6a,7a,7b'),
(19, 'Nashville, Tennessee', 'https://www.wallpapertip.com/wmimgs/43-432816_nashville-tn-nashville-tennessee.jpg', '1b,2a,3a,4b,4c,5b,5c,6a,6b,7a,7b'),
(20, 'Moscow, Russia', 'https://images.law.com/contrib/content/uploads/sites/378/2018/09/St-Basils-cathedral-Moscow-Russia-Article-201809192141.jpg', '1b,1c,2c,3a,4b,4c,5a,5c,6c,6d,7a,7c');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `id_destination_1` int(11) DEFAULT NULL,
  `id_destination_2` int(11) DEFAULT NULL,
  `id_destination_3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `destination_1_fk` (`id_destination_1`),
  KEY `destination_2_fk` (`id_destination_2`),
  KEY `destination_3_fk` (`id_destination_3`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `id_destination_1`, `id_destination_2`, `id_destination_3`) VALUES
(1, 'Jose', 12, 13, 14);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `destination_1_fk` FOREIGN KEY (`id_destination_1`) REFERENCES `destinations` (`id`),
  ADD CONSTRAINT `destination_2_fk` FOREIGN KEY (`id_destination_2`) REFERENCES `destinations` (`id`),
  ADD CONSTRAINT `destination_3_fk` FOREIGN KEY (`id_destination_3`) REFERENCES `destinations` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
