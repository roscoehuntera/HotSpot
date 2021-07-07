-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 30, 2021 at 11:49 PM
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
-- Table structure for table `archives`
--

DROP TABLE IF EXISTS `archives`;
CREATE TABLE IF NOT EXISTS `archives` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user_archives_fk` (`id_user`),
  KEY `id_post_archives_fk` (`id_post`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `archives`
--

INSERT INTO `archives` (`id`, `id_user`, `id_post`) VALUES
(38, 3, 53),
(40, 3, 24);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` varchar(400) NOT NULL,
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_post_comments_fk` (`id_post`),
  KEY `id_user_comments_fk` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `comment`, `id_post`, `id_user`) VALUES
(2, 'Hello World', 21, 2),
(3, 'This is another comment', 21, 2),
(4, 'I join the party', 21, 3),
(5, 'This is a test comment from timeline page', 20, 2),
(6, 'This is another test comment', 20, 2),
(7, 'This is another test comment', 20, 2),
(8, 'This is a test comment from the same user that posts&#039; page.', 17, 2),
(9, 'Test comment', 20, 2),
(11, 'I commented this post!', 53, 3),
(12, 'I comment my own post', 54, 3),
(13, 'hey', 53, 8);

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

DROP TABLE IF EXISTS `contact_us`;
CREATE TABLE IF NOT EXISTS `contact_us` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(800) NOT NULL,
  `name` varchar(80) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user_contactus_fk` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `subject`, `name`, `email`, `id_user`) VALUES
(1, 'test', 'rewq', 'qwer@gmail.com', NULL),
(2, 'test', NULL, NULL, 3);

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
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`id`, `name`, `img_url`, `quiz_recommend`) VALUES
(11, 'Los Angeles, California', 'https://www.viajarlosangeles.com/img/guia-viajar-los-angeles.jpg', '1a,1b,1c,2b,3a,3b,3c,4a,4b,5b,6b,7a,7b'),
(12, 'Las Vegas, Nevada', 'https://a.cdn-hotels.com/gdcs/production37/d1139/a8a147d0-c31d-11e8-825c-0242ac110006.jpg', '1b,1c,2b,2c,3a,3c,4b,4c,5a,5b,5c,6a,7a,7b'),
(13, 'Honolulu, Hawaii', 'https://www.mundoviajes.org/wp-content/uploads/waikiki.jpg', '1a,1b,1c,2b,2c,3a,3b,3c,4a,4b,4d,5b,5c,6a,7a,7b,7c,7d'),
(14, 'Paris, France', 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4b/La_Tour_Eiffel_vue_de_la_Tour_Saint-Jacques%2C_Paris_ao%C3%BBt_2014_%282%29.jpg/1200px-La_Tour_Eiffel_vue_de_la_Tour_Saint-Jacques%2C_Paris_ao%C3%BBt_2014_%282%29.jpg', '1a,1b,1c,2c,3a,3c,4b,4c,5a,5c,5d,6b,6c,7a,7b,7c'),
(15, 'Barcelona, Spain', 'https://i.guim.co.uk/img/media/3317451386c7a646be48cbec024bb89c1402aad9/168_0_4844_2910/master/4844.jpg?width=465&quality=45&auto=format&fit=max&dpr=2&s=5000c4975910298670763292af8f3ace', '1a,1b,1c,2b,3a,3b,4a,4b,4c,4d,5a,5b,6b,6c,7a,7b,7c'),
(16, 'San Juan, Puerto Rico', 'https://img.ev.mu/images/villes/7195/600x400/7195.jpg', '1a,1b,1c,2b,3a,3b,4a,4b,4c,4d,5b,5c,5d,6a,6b,7a,7b,7d'),
(17, 'Cape Town, South Africa', 'https://www.andbeyond.com/wp-content/uploads/sites/5/cape-town-aerial-view-greenpoint-stadium.jpg', '1a,1b,2c3a,3b,4a,4b,4c,4d,5b,5c,6a,6b,7a,7b,7d'),
(18, 'Miami, Florida', 'https://s3-us-west-2.amazonaws.com/public.travel2latam.com/imagenes/000/511/944/000511944.jpg', '1a,1b,2a,2b,3a,3b,4a,4b,4c,5a,5b,5c,5d,6a,7a,7b'),
(19, 'Nashville, Tennessee', 'https://www.wallpapertip.com/wmimgs/43-432816_nashville-tn-nashville-tennessee.jpg', '1b,2a,3a,4b,4c,5b,5c,5d,6a,6b,7a,7b'),
(20, 'Moscow, Russia', 'https://images.law.com/contrib/content/uploads/sites/378/2018/09/St-Basils-cathedral-Moscow-Russia-Article-201809192141.jpg', '1b,1c,2c,3a,4b,4c,5a,5c,6c,6d,7a,7c'),
(32, 'Cancun, Mexico', 'https://a57.foxnews.com/static.foxbusiness.com/foxbusiness.com/content/uploads/2020/06/0/0/Cancun-iStock.jpg?ve=1&tl=1', '1a,1b,2c,3b,4a,4c 5a,5b,5c,6a,7a,7b'),
(33, 'Bora Bora, French Polynesia', 'https://cache.marriott.com/marriottassets/marriott/BOBXR/bobxr-exterior-aerialview-1580-hor-wide.jpg?interpolation=progressive-bilinear&downsize=1440px:*', '1a,1b,1c,2c,3b,4a,4d,5c,5d,6a,7a,7b,7d'),
(34, 'Tenerife, Spain', 'https://static.india.com/wp-content/uploads/2018/08/Tenerife-Spain-photo-2.jpg?impolicy=Medium_Resize&w=1200&h=800', '1a,1b,1c,2c,3a,3b,3c,4a,4b,4c,4d,5a,5b,5c,6a,6b,7a,7b,7c,7d'),
(35, 'Bali, Indonesia', 'https://a.cdn-hotels.com/gdcs/production143/d1112/c4fedab1-4041-4db5-9245-97439472cf2c.jpg', '1a,1b,1c,2c,4a,4b,4c,4d,5b,5d,6a,7a,7b,7c,7d'),
(36, 'Cabo San Lucas, Mexico', 'https://rccl-h.assetsadobe.com/is/image/content/dam/royal/data/ports/cabo-san-lucas-mexico/things-to-do/cabo-san-lucas-mexico-famous-arch.jpg?$472x300$', '1a,1b,2c,3b,4a,4c,5a,5b,5c,6a,7a,7b'),
(37, 'New York City, New York', 'https://static.onecms.io/wp-content/uploads/sites/28/2021/02/19/new-york-city-evening-NYCTG0221.jpg', '1b,1c,2a,3a,3c,4b,4c,5a,5b,5c,5d,6a,6b,6c,6d,7a,7b,7c'),
(38, 'Chicago, Illinois', 'https://images.squarespace-cdn.com/content/v1/55565d52e4b0d497d6e37c1f/1454121307325-0KMB8BLQBPGQ5N75BUL1/ke17ZwdGBToddI8pDm48kBuwICQjQMJQahJ5KJ5aY1N7gQa3H78H3Y0txjaiv_0fDoOvxcdMmMKkDsyUqMSsMWxHk725yiiHCCLfrh8O1z4YTzHvnKhyp6Da-NYroOW3ZGjoBKy3azqku80C789l0s2R59z2HWVKMNU9GXmUK4VrT1aqlJYifDwNF_CFn3dSwi7Smtqz3iKYKp1WZtwPNw/Chicago+Illinois+law+firm.jpg?format=1500w', '1b,1c,2b,3a,3c,4a,4b,4c,4d,5a,5b,6a,6b,6c,6d,7a,7b,7c'),
(39, 'Toronto, Canada', 'https://cdn.britannica.com/93/94493-050-35524FED/Toronto.jpg', '1c,2c,3a,4b,4c,5a,5b,5c,6b,6c,6d,7a,7b,7c'),
(40, 'San Francisco, California', 'https://www.mymove.com/wp-content/uploads/2020/05/GettyImages-923244752-scaled.jpg', '1c,2c,3a,4b,4c,5a,5b,5c,6b,6c,6d,7a,7b,7c'),
(41, 'Berlin, Germany', 'https://www.savoredjourneys.com/wp-content/uploads/2019/09/berlin-germany.jpg', '1b,1c,2c,3a,4b,4c,5a,5b,5c,5d,6b,6c,6d,7a,7b,7c'),
(42, 'London, UK', 'https://www.ft.com/__origami/service/image/v2/images/raw/http%3A%2F%2Fcom.ft.imagepublish.upp-prod-us.s3.amazonaws.com%2F4d3a6426-35fe-11ea-ac3c-f68c10993b04?fit=scale-down&source=next&width=700', '1c,2c,3a,4b,5a,5b,5c,6b,6c,6d,7a,7b,7c'),
(43, 'Tokyo, Japan', 'https://www.touristsecrets.com/wp-content/uploads/2019/05/photo-1540959733332-eab4deabeeaf.jpeg', '1b,1c,2c,3a,4b,4c,5a,5c,6b,6c,7a,7b,7c'),
(44, 'Shanghai, China', 'https://www.thespiritsbusiness.com/content/http://www.thespiritsbusiness.com/media/2019/03/Shanghai.jpg', '1b,1c,2c,3a,4b,4c,5a,5c,6b,6c,7a,7b,7c'),
(45, 'Bangkok, Thailand', 'https://media.istockphoto.com/photos/bangkok-thailand-at-the-temple-of-the-emerald-buddha-and-grand-palace-picture-id1146493663?k=6&m=1146493663&s=612x612&w=0&h=X7UmEk1nkFaH2e2HsdDs4qeOAtHPuXbqTjLar9nELis=', '1b,1c,2a,3a,3c,4a,4b,4c,4d,5b,5c,5d,6a,6b,7a,7c,7d'),
(46, 'Rio de Janeiro, Brazil', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTW-QfqwzZ9VPrBFLJPo0eTvDZUF48Ncx8CKw&usqp=CAU', '1a,1b,1c,2b,3a,3b,4a,4b,4c,4d,5a,5b,5c,5d,6a,6b,6c,7a,7b,7c'),
(47, 'Tromso, Norway', 'https://cdn.kimkim.com/files/a/images/90de00f17753a8c23857d1bfd7334f436c66ce8c/big-61a3b668024587b70e78dab51c4c579a.jpg', '1a,1b,1c,2b,2c,3a,3c,4b,4c,4d,5b,5c,6a,6b,6c,6d,7a,7b,7c,7d');

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

DROP TABLE IF EXISTS `follows`;
CREATE TABLE IF NOT EXISTS `follows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user_follows` int(11) NOT NULL,
  `id_user_followed` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user_follows_fk` (`id_user_follows`),
  KEY `id_user_followed_fk` (`id_user_followed`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `follows`
--

INSERT INTO `follows` (`id`, `id_user_follows`, `id_user_followed`) VALUES
(11, 2, 3),
(12, 3, 2),
(14, 8, 3);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user_likes_fk` (`id_user`),
  KEY `id_post_likes_fk` (`id_post`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `id_user`, `id_post`) VALUES
(22, 2, 16),
(23, 2, 19),
(29, 2, 23),
(43, 2, 21),
(44, 2, 20),
(45, 2, 24),
(46, 3, 52),
(47, 3, 53);

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

DROP TABLE IF EXISTS `photos`;
CREATE TABLE IF NOT EXISTS `photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photo_path` varchar(400) NOT NULL,
  `id_post` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_post_photos_fk` (`id_post`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`id`, `photo_path`, `id_post`) VALUES
(29, '../server/uploads/2/photos/16248159104990.jpg', 52),
(30, '../server/uploads/2/photos/16248159105081.jpg', 52),
(31, '../server/uploads/2/photos/16248165880910.jpg', 53),
(32, '../server/uploads/2/photos/16248165880931.jpg', 53),
(33, '../server/uploads/2/photos/16248165880942.jpg', 53),
(34, '../server/uploads/2/photos/16248165880943.jpg', 53),
(35, '../server/uploads/2/photos/16248165880954.jpg', 53),
(36, '../server/uploads/2/photos/16248165880955.jpg', 53),
(37, '../server/uploads/3/photos/16248328636200.jpg', 54),
(38, '../server/uploads/3/photos/16248328636271.jpg', 54),
(39, '../server/uploads/3/photos/16248328636272.jpg', 54),
(45, '../server/uploads/8/photos/16249107098270.jpg', 56);

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

DROP TABLE IF EXISTS `places`;
CREATE TABLE IF NOT EXISTS `places` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `place` varchar(20) NOT NULL,
  `name` varchar(60) NOT NULL,
  `img_url` varchar(400) NOT NULL,
  `link` varchar(400) NOT NULL,
  `id_destination` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_destination_fk` (`id_destination`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`id`, `place`, `name`, `img_url`, `link`, `id_destination`) VALUES
(9, 'stay', 'Marriott Hotel', 'https://content.r9cdn.net/rimg/himg/e5/23/b0/leonardo-1072671-isbpk-guestroom-3945-hor-clsc_O-776938.jpg?width=660&height=400&xhint=1620&yhint=1000&crop=true&outputtype=webp', 'https://www.marriott.com/default.mi', 11),
(10, 'eat', 'Pink&#039;s Hot Dog Home', 'https://content.tripster.com/travelguide/wp-content/uploads/2016/01/Pinks-LA-1024x576.jpg', 'http://www.pinkshollywood.com/', 11),
(11, 'fun', 'Universal Studios Hollywood', 'https://www.busytourist.com/wp-content/uploads/2020/08/Universal-Studios-Hollywood.jpg.webp', 'https://www.universalstudioshollywood.com/web/en/us', 11),
(12, 'eat', 'Oste', 'https://www.welikela.com/wp-content/uploads/2021/01/things-oste.jpg', 'https://www.ostelosangeles.com/', 11),
(13, 'stay', 'Hotel Figueroa', 'https://media-exp1.licdn.com/dms/image/C561BAQFGCJV2sL_Olw/company-background_10000/0/1584913696878?e=2159024400&v=beta&t=iBWlnawrCGRdd7p8lyrTow37t_00Dx1ljhbC05xOlcY', 'https://www.hotelfigueroa.com/?utm_source=TripAdvisor&utm_medium=BusinessListings&utm_campaign=websitelink&TAHotelCode=124956', 11),
(14, 'eat', 'The Front Yard', 'https://s3-media0.fl.yelpcdn.com/bphoto/GN7koGrpEIpGef2tdi1bBA/348s.jpg', 'https://www.thefrontyardla.com/', 11),
(15, 'fun', 'Warner Bros. Studio Tour Hollywood', 'https://media.tacdn.com/media/attractions-splice-spp-674x446/0b/e0/36/11.jpg', 'https://www.viator.com/tours/Los-Angeles/Warner-Bros-Studio-Tour-Hollywood/d645-148509P1', 11),
(16, 'stay', 'Caesars Palace', 'https://www.caesars.com/content/dam/clv/Property/Exterior/Caesars-Palace%20Las%20Vegas-Property-Exterior-1.jpg.transform/slider-img/image.jpg', 'https://www.caesars.com/book/hotel-calendar?dateSearchFormat=flexible-dates&flexibleMonth=June&roomDetails=[{%22adults%22:2,%22children%22:0}]&propCode=clv&roomCount=1&viewrates=dollars&roomFilters=[{%22accessible%22:[%22N%22]}]&dclid=CNOlvuvbuvECFcPryAodGnEDNQ&utm_campaign=CET_Occ_TripAdListings&utm_content=1x1&utm_medium=local&utm_source=tripadvisor', 12),
(17, 'eat', 'Carson Kitchen', 'https://s3-media0.fl.yelpcdn.com/bphoto/v7ZXaFShFynU6r27CW80dQ/348s.jpg', 'https://carsonkitchen.com/las/index.html', 12),
(18, 'fun', 'Big Bus Las Vegas Open Top Night Tour', 'https://media.tacdn.com/media/attractions-splice-spp-360x240/07/72/f5/37.jpg', 'https://www.viator.com/tours/Las-Vegas/Big-Bus-Las-Vegas-Night-Tour/d684-5096LASNIGHT', 12),
(19, 'stay', 'Shoreline Hotel Waikiki', 'https://media-cdn.tripadvisor.com/media/photo-s/13/d6/72/43/shoreline-hotel-waikiki.jpg', 'https://shorelinehotelwaikiki.com/', 13),
(20, 'eat', 'Highway Inn', 'https://www.myhighwayinn.com/wp-content/uploads/Hawaii_food_slider-3.jpg', 'https://www.myhighwayinn.com/location-kakaako/', 13),
(21, 'fun', 'Turtle Canyon Catamaran Snorkel Cruise', 'https://media.tacdn.com/media/attractions-splice-spp-674x446/06/77/93/9b.jpg', 'https://www.viator.com/tours/Oahu/Turtle-Canyon-Snorkel-Cruise-by-Catamaran/d672-2774TURTLES', 13);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post` varchar(400) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `id_user` int(11) NOT NULL,
  `id_destination` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user_fk` (`id_user`),
  KEY `id_destination_posts_fk` (`id_destination`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `post`, `created_at`, `id_user`, `id_destination`) VALUES
(16, 'I went to Spain.', '2021-06-24 19:48:31', 2, 11),
(17, 'This is my first post.', '2021-06-24 19:53:31', 3, 11),
(19, 'new&#039;s post', '2021-06-24 20:10:47', 2, 11),
(20, 'New post today.', '2021-06-25 12:22:12', 3, 11),
(21, 'This is my first POST!', '2021-06-25 13:24:09', 4, 11),
(23, 'This is a test for a long, very long, post with a lot of text to display on screen.', '2021-06-25 23:08:34', 2, 11),
(24, 'This is a new post.', '2021-06-26 22:02:44', 2, 11),
(52, 'This is a post with 2 photos', '2021-06-27 13:45:10', 2, 11),
(53, 'This is a post with 6 photos', '2021-06-27 13:56:28', 2, 11),
(54, 'My travel to Bahamas', '2021-06-27 18:27:43', 3, 11),
(56, 'My Hawaii Trip', '2021-06-28 16:05:09', 8, 11);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `img_path` varchar(400) DEFAULT NULL,
  `cover_img_path` varchar(400) DEFAULT NULL,
  `about` varchar(400) DEFAULT NULL,
  `id_destination_1` int(11) DEFAULT NULL,
  `id_destination_2` int(11) DEFAULT NULL,
  `id_destination_3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `destination_1_fk` (`id_destination_1`),
  KEY `destination_2_fk` (`id_destination_2`),
  KEY `destination_3_fk` (`id_destination_3`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `img_path`, `cover_img_path`, `about`, `id_destination_1`, `id_destination_2`, `id_destination_3`) VALUES
(2, 'Jose Yebrin', 'joseantonioyebrin@hotmail.com', '@2000chucky', '$2y$10$I2EN8e1Wj.xhVZz9u89OUuTztjSQiT9JJ6yWyZCEA/aRTkhcaVcPO', '../server/uploads/2/1624802157625.jpg', '../server/uploads/2/cover/1624802164492.jpg', 'Hello my name is Jose and I like to travel.', 13, 14, 16),
(3, 'Test User', 'test@gmail.com', '@test', '$2y$10$i7rmbA7141KYOOYfFO9Diee5PUnQuh8GcEvDWWo845VMPX.UwgZVO', '../server/uploads/3/1624758440983.jpg', '../server/uploads/3/cover/1624832827298.jpg', 'Hi my name is @test', 18, 13, 15),
(4, 'new', 'new@gmail.com', '@new', '$2y$10$dreaFolUWp2YTiTTHkcCOe08w1LTSLSdKarvweYtf.wUMx2XMvR2.', NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'One more', 'onemore@email.com', '@onemore', '$2y$10$Ld63k0ABh.8WkKUKN4lNQO5hsUM7ELlnDU.4kOS4zKi7tHBeN5tBa', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Danielle', 'dummy@gmail.com', '@Dummy', '$2y$10$xpDaNWYDQYldmXOQwp0Vhe7IhhsYJFWL2QEHIyRpe/moqbBYLnqze', '../server/uploads/8/1624980312535.jpg', '../server/uploads/8/cover/1624980312540.jpg', 'Hey, I love to travel', 16, 46, 17);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `archives`
--
ALTER TABLE `archives`
  ADD CONSTRAINT `id_post_archives_fk` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `id_user_archives_fk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `id_post_comments_fk` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `id_user_comments_fk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD CONSTRAINT `id_user_contactus_fk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `id_user_followed_fk` FOREIGN KEY (`id_user_followed`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `id_user_follows_fk` FOREIGN KEY (`id_user_follows`) REFERENCES `users` (`id`);

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `id_post_likes_fk` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `id_user_likes_fk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `id_post_photos_fk` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `places`
--
ALTER TABLE `places`
  ADD CONSTRAINT `id_destination_fk` FOREIGN KEY (`id_destination`) REFERENCES `destinations` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `id_destination_posts_fk` FOREIGN KEY (`id_destination`) REFERENCES `destinations` (`id`),
  ADD CONSTRAINT `id_user_fk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

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
