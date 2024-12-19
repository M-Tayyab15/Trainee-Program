/*
SQLyog Professional v13.1.1 (64 bit)
MySQL - 11.5.2-MariaDB : Database - db_userslaravel
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_userslaravel` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;

USE `db_userslaravel`;

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2014_10_12_000000_create_users_table',1);

/*Table structure for table `tbl_cart` */

DROP TABLE IF EXISTS `tbl_cart`;

CREATE TABLE `tbl_cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `payment_mode` varchar(20) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `total_amount` float DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `created_on` int(11) DEFAULT NULL,
  `updated_on` int(11) DEFAULT NULL,
  `transaction_details` text DEFAULT NULL,
  PRIMARY KEY (`cart_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=112 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `tbl_cart` */

insert  into `tbl_cart`(`cart_id`,`user_id`,`payment_mode`,`status`,`total_amount`,`ip_address`,`created_on`,`updated_on`,`transaction_details`) values 
(46,12,'Paypal',3,80,'::1',1733828388,1731885372,'{\"orderID\":\"7VV706779H7538033\",\"payer\":{\"name\":{\"given_name\":\"Tayyab\",\"surname\":\"Test\"},\"email_address\":\"sb-yeaky34077075@personal.example.com\",\"payer_id\":\"6JXDYQZEV9M3N\",\"address\":{\"country_code\":\"US\"}},\"amount\":\"80.00\"}'),
(49,30,'COD',3,20,'::1',1733890319,1733890319,'{\"orderID\":\"1TT10140U1645434F\",\"payer\":{\"name\":{\"given_name\":\"Tayyab\",\"surname\":\"Test\"},\"email_address\":\"sb-yeaky34077075@personal.example.com\",\"payer_id\":\"6JXDYQZEV9M3N\",\"address\":{\"country_code\":\"US\"}},\"amount\":\"20.00\"}'),
(48,30,'COD',3,10,'::1',1733890147,1733890147,NULL),
(47,13,'COD',3,360,'::1',1733889222,1733890104,NULL),
(45,12,'COD',3,5,'::1',1733828366,1733828366,NULL),
(44,12,'Paypal',3,60,'::1',1733828317,1733828317,'{\"orderID\":\"4HD44647L2244843U\",\"payer\":{\"name\":{\"given_name\":\"Tayyab\",\"surname\":\"Test\"},\"email_address\":\"sb-yeaky34077075@personal.example.com\",\"payer_id\":\"6JXDYQZEV9M3N\",\"address\":{\"country_code\":\"US\"}},\"amount\":\"60.00\"}'),
(52,30,'COD',3,60,'::1',1733894055,1733894055,NULL),
(53,30,'Paypal',3,25,'::1',1733894852,1733894852,'{\"orderID\":\"4KC45569SG6260848\",\"payer\":{\"name\":{\"given_name\":\"Tayyab\",\"surname\":\"Test\"},\"email_address\":\"sb-yeaky34077075@personal.example.com\",\"payer_id\":\"6JXDYQZEV9M3N\",\"address\":{\"country_code\":\"US\"}},\"amount\":\"25.00\"}'),
(54,30,'COD',3,25,'::1',1733894918,1733894918,NULL),
(55,30,'Paypal',3,40,'::1',1733897908,1733897908,'{\"orderID\":\"0YR99046YP844351X\",\"payer\":{\"name\":{\"given_name\":\"Tayyab\",\"surname\":\"Test\"},\"email_address\":\"sb-yeaky34077075@personal.example.com\",\"payer_id\":\"6JXDYQZEV9M3N\",\"address\":{\"country_code\":\"US\"}},\"amount\":\"40.00\"}'),
(57,11,'COD',3,300,'::1',1733898587,1733898587,NULL),
(58,30,'COD',3,60,'::1',1733898842,1733898842,NULL),
(59,30,'COD',3,60,'::1',1733901161,1733901161,NULL),
(60,30,'COD',3,80,'::1',1733901814,1733901814,NULL),
(61,30,'COD',3,60,'::1',1733902299,1733902299,NULL),
(62,30,'COD',3,180,'::1',1733902373,1733902373,NULL),
(63,30,'COD',3,265,'::1',1733902393,1733902393,NULL),
(64,30,'Paypal',3,20,'::1',1733902677,1733902677,'{\"orderID\":\"49N236519F390060P\",\"payer\":{\"name\":{\"given_name\":\"Tayyab\",\"surname\":\"Test\"},\"email_address\":\"sb-yeaky34077075@personal.example.com\",\"payer_id\":\"6JXDYQZEV9M3N\",\"address\":{\"country_code\":\"US\"}},\"amount\":\"20.00\"}'),
(65,30,'Paypal',3,70,'::1',1733903217,1733903414,'{\"orderID\":\"92S41184PP564881R\",\"payer\":{\"name\":{\"given_name\":\"Tayyab\",\"surname\":\"Test\"},\"email_address\":\"sb-yeaky34077075@personal.example.com\",\"payer_id\":\"6JXDYQZEV9M3N\",\"address\":{\"country_code\":\"US\"}},\"amount\":\"70.00\"}'),
(66,13,NULL,2,0,'::1',1733908748,1733908748,NULL),
(67,31,'Paypal',3,105,'::1',1733911336,1733919326,'{\"orderID\":\"3YH262781N115134D\",\"payer\":{\"name\":{\"given_name\":\"Tayyab\",\"surname\":\"Test\"},\"email_address\":\"sb-yeaky34077075@personal.example.com\",\"payer_id\":\"6JXDYQZEV9M3N\",\"address\":{\"country_code\":\"US\"}},\"amount\":\"105.00\"}'),
(68,12,'Paypal',3,135,'::1',1733911895,1733912150,'{\"orderID\":\"06H61452BT178952E\",\"payer\":{\"name\":{\"given_name\":\"Tayyab\",\"surname\":\"Test\"},\"email_address\":\"sb-yeaky34077075@personal.example.com\",\"payer_id\":\"6JXDYQZEV9M3N\",\"address\":{\"country_code\":\"US\"}},\"amount\":\"135.00\"}'),
(69,12,'COD',3,80,'::1',1733913149,1733913149,NULL),
(70,12,'COD',3,60,'::1',1733913824,1733913824,NULL),
(71,12,'COD',3,120,'::1',1733914030,1733914042,NULL),
(72,12,'COD',3,5,'::1',1733914180,1733914180,NULL),
(73,12,'COD',3,0,'::1',1733914942,1733914942,NULL),
(74,12,'COD',3,0,'::1',1733916276,1733916276,NULL),
(75,12,'COD',3,0,'::1',1733917893,1733917893,NULL),
(76,12,NULL,1,0,'::1',1733918894,1733918894,NULL),
(77,31,'COD',3,60,'::1',1733919803,1733919803,NULL),
(80,31,'Paypal',3,90,'127.0.0.1',1733979663,1733979663,'{\"orderID\":\"9BY95030AL419512J\",\"payer\":{\"name\":{\"given_name\":\"Tayyab\",\"surname\":\"Test\"},\"email_address\":\"sb-yeaky34077075@personal.example.com\",\"payer_id\":\"6JXDYQZEV9M3N\",\"address\":{\"country_code\":\"US\"}},\"amount\":\"90.00\"}'),
(79,31,'COD',3,60,'127.0.0.1',1733978688,1733978688,NULL),
(81,31,'Paypal',3,120,'127.0.0.1',1733985597,1733985597,'{\"orderID\":\"9Y846926XJ672412N\",\"payer\":{\"name\":{\"given_name\":\"Tayyab\",\"surname\":\"Test\"},\"email_address\":\"sb-yeaky34077075@personal.example.com\",\"payer_id\":\"6JXDYQZEV9M3N\",\"address\":{\"country_code\":\"US\"}},\"amount\":\"120.00\"}'),
(82,31,'COD',3,70,'127.0.0.1',1733989465,1733989465,NULL),
(83,32,'Paypal',3,130,'127.0.0.1',1734062343,1734062343,'{\"orderID\":\"2BB5176639346220X\",\"payer\":{\"name\":{\"given_name\":\"Tayyab\",\"surname\":\"Test\"},\"email_address\":\"sb-yeaky34077075@personal.example.com\",\"payer_id\":\"6JXDYQZEV9M3N\",\"address\":{\"country_code\":\"US\"}},\"amount\":\"130.00\"}'),
(84,32,'COD',3,60,'127.0.0.1',1734063654,1734063660,NULL),
(85,32,'Paypal',3,20,'127.0.0.1',1734065144,1734065184,'{\"orderID\":\"0T641895LR634682C\",\"payer\":{\"name\":{\"given_name\":\"Tayyab\",\"surname\":\"Test\"},\"email_address\":\"sb-yeaky34077075@personal.example.com\",\"payer_id\":\"6JXDYQZEV9M3N\",\"address\":{\"country_code\":\"US\"}},\"amount\":\"20.00\"}'),
(86,32,'COD',3,5,'127.0.0.1',1734085696,1734085718,NULL),
(87,32,'COD',3,180,'127.0.0.1',1734086970,1734087009,NULL),
(88,35,'COD',3,60,'127.0.0.1',1734087047,1734087063,NULL),
(89,35,'Paypal',3,10,'127.0.0.1',1734088183,1734089087,'{\"orderID\":\"8WT20923XT570024X\",\"payer\":{\"name\":{\"given_name\":\"Tayyab\",\"surname\":\"Test\"},\"email_address\":\"sb-yeaky34077075@personal.example.com\",\"payer_id\":\"6JXDYQZEV9M3N\",\"address\":{\"country_code\":\"US\"}},\"amount\":\"10.00\"}'),
(90,35,'Paypal',3,80,'127.0.0.1',1734090524,1734090565,'{\"orderID\":\"97D48964XF376853S\",\"payer\":{\"name\":{\"given_name\":\"Tayyab\",\"surname\":\"Test\"},\"email_address\":\"sb-yeaky34077075@personal.example.com\",\"payer_id\":\"6JXDYQZEV9M3N\",\"address\":{\"country_code\":\"US\"}},\"amount\":\"80.00\"}'),
(91,32,'Paypal',3,60,'127.0.0.1',1734323552,1734323757,'{\"orderID\":\"9Y214247FA888212K\",\"payer\":{\"name\":{\"given_name\":\"Tayyab\",\"surname\":\"Test\"},\"email_address\":\"sb-yeaky34077075@personal.example.com\",\"payer_id\":\"6JXDYQZEV9M3N\",\"address\":{\"country_code\":\"US\"}},\"amount\":\"60.00\"}'),
(92,32,'COD',3,80,'127.0.0.1',1734323878,1734324169,NULL),
(93,32,'COD',3,95,'127.0.0.1',1734332787,1734350017,NULL),
(94,32,'COD',3,140,'127.0.0.1',1734502568,1734503452,NULL),
(95,32,'COD',3,140,'127.0.0.1',1734503475,1734503537,NULL),
(96,32,'COD',3,180,'127.0.0.1',1734506024,1734506032,NULL),
(97,32,'COD',3,80,'127.0.0.1',1734508026,1734508033,NULL),
(98,32,'COD',3,105,'127.0.0.1',1734508138,1734508147,NULL),
(99,32,'COD',3,60,'127.0.0.1',1734517254,1734517263,NULL),
(100,32,'COD',3,60,'127.0.0.1',1734517376,1734517381,NULL),
(101,36,'COD',3,120,'127.0.0.1',1734518024,1734518040,NULL),
(102,36,'COD',3,60,'127.0.0.1',1734518510,1734518517,NULL),
(103,32,'COD',3,35,'127.0.0.1',1734518616,1734518628,NULL),
(104,37,'COD',3,340,'127.0.0.1',1734519010,1734519053,NULL),
(105,32,'Paypal',3,80,'127.0.0.1',1734519331,1734519396,'{\"orderID\":\"34674546GJ180932E\",\"payer\":{\"name\":{\"given_name\":\"Tayyab\",\"surname\":\"Test\"},\"email_address\":\"sb-yeaky34077075@personal.example.com\",\"payer_id\":\"6JXDYQZEV9M3N\",\"address\":{\"country_code\":\"US\"}},\"amount\":\"80.00\"}'),
(106,32,'COD',3,10,'127.0.0.1',1734520206,1734520212,NULL),
(107,32,'COD',3,60,'127.0.0.1',1734523102,1734582166,NULL),
(108,32,'COD',3,25,'127.0.0.1',1734582297,1734582303,NULL),
(109,32,'Paypal',3,60,'127.0.0.1',1734582595,1734582642,'{\"orderID\":\"78W35000BX174612M\",\"payer\":{\"name\":{\"given_name\":\"Tayyab\",\"surname\":\"Test\"},\"email_address\":\"sb-yeaky34077075@personal.example.com\",\"payer_id\":\"6JXDYQZEV9M3N\",\"address\":{\"country_code\":\"US\"}},\"amount\":\"60.00\"}'),
(110,32,'COD',3,5,'127.0.0.1',1734582844,1734582850,NULL),
(111,32,'Paypal',3,5,'127.0.0.1',1734582863,1734582879,'{\"orderID\":\"4DT4274065493425B\",\"payer\":{\"name\":{\"given_name\":\"Tayyab\",\"surname\":\"Test\"},\"email_address\":\"sb-yeaky34077075@personal.example.com\",\"payer_id\":\"6JXDYQZEV9M3N\",\"address\":{\"country_code\":\"US\"}},\"amount\":\"5.00\"}');

/*Table structure for table `tbl_cart_products` */

DROP TABLE IF EXISTS `tbl_cart_products`;

CREATE TABLE `tbl_cart_products` (
  `cart_product_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `pro_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `product_price` float DEFAULT NULL,
  `total_price` float DEFAULT NULL,
  `created_on` int(11) DEFAULT NULL,
  PRIMARY KEY (`cart_product_id`),
  KEY `user_id` (`user_id`),
  KEY `cart_id` (`cart_id`),
  KEY `pro_id` (`pro_id`)
) ENGINE=MyISAM AUTO_INCREMENT=161 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `tbl_cart_products` */

insert  into `tbl_cart_products`(`cart_product_id`,`user_id`,`cart_id`,`pro_id`,`quantity`,`product_price`,`total_price`,`created_on`) values 
(72,30,54,33,2,5,10,NULL),
(71,30,53,33,5,5,25,NULL),
(70,30,52,32,1,60,60,NULL),
(69,30,51,33,2,5,10,NULL),
(68,30,51,32,2,60,120,NULL),
(67,30,50,33,3,5,15,NULL),
(66,30,50,32,2,60,120,NULL),
(64,30,49,42,1,20,20,NULL),
(63,30,48,36,2,5,10,NULL),
(62,13,47,35,1,80,80,NULL),
(61,13,47,37,7,40,280,NULL),
(60,12,46,35,1,80,80,NULL),
(59,12,45,33,1,5,5,NULL),
(58,12,44,32,1,60,60,NULL),
(73,30,54,36,3,5,15,NULL),
(74,30,55,40,2,20,40,NULL),
(75,11,56,32,5,60,300,NULL),
(76,11,57,32,5,60,300,NULL),
(77,30,58,32,1,60,60,NULL),
(78,30,59,32,1,60,60,NULL),
(79,30,60,35,1,80,80,NULL),
(80,30,61,32,1,60,60,NULL),
(81,30,62,32,3,60,180,NULL),
(82,30,63,32,4,60,240,NULL),
(83,30,63,33,5,5,25,NULL),
(84,30,64,33,4,5,20,NULL),
(85,30,65,36,2,5,10,NULL),
(86,30,65,32,1,60,60,NULL),
(88,31,67,32,1,60,60,NULL),
(91,12,68,32,2,60,120,NULL),
(92,12,68,33,3,5,15,NULL),
(93,12,69,35,1,80,80,NULL),
(94,12,70,32,1,60,60,NULL),
(95,12,71,32,2,60,120,NULL),
(96,12,72,33,1,5,5,NULL),
(112,31,67,36,1,5,5,NULL),
(113,31,67,40,2,20,40,NULL),
(114,31,77,32,1,60,60,NULL),
(115,31,78,36,1,5,5,NULL),
(116,31,79,38,2,30,60,NULL),
(117,31,80,35,1,80,80,NULL),
(118,31,80,33,2,5,10,NULL),
(119,31,81,32,2,60,120,NULL),
(120,31,82,52,1,70,70,NULL),
(121,32,83,38,1,30,30,NULL),
(122,32,83,40,1,20,20,NULL),
(123,32,83,39,2,30,60,NULL),
(124,32,83,47,1,20,20,NULL),
(125,32,84,32,1,60,60,NULL),
(126,32,85,36,4,5,20,NULL),
(127,32,86,33,1,5,5,NULL),
(128,32,87,32,3,60,180,NULL),
(129,35,88,32,1,60,60,NULL),
(130,35,89,33,2,5,10,NULL),
(131,35,90,35,1,80,80,NULL),
(132,32,91,32,1,60,60,NULL),
(133,32,92,35,1,80,80,NULL),
(134,32,93,33,1,5,5,NULL),
(135,32,93,44,1,30,30,NULL),
(136,32,93,32,1,60,60,NULL),
(137,32,94,35,1,80,80,NULL),
(138,32,94,32,1,60,60,NULL),
(139,32,95,45,2,35,70,NULL),
(140,32,95,44,1,30,30,NULL),
(141,32,95,37,1,40,40,NULL),
(142,32,96,32,3,60,180,NULL),
(143,32,97,35,1,80,80,NULL),
(144,32,98,45,3,35,105,NULL),
(145,32,99,32,1,60,60,NULL),
(146,32,100,32,1,60,60,NULL),
(147,36,101,32,2,60,120,NULL),
(148,36,102,32,1,60,60,NULL),
(149,32,103,33,1,5,5,NULL),
(150,32,103,38,1,30,30,NULL),
(151,37,104,32,3,60,180,NULL),
(152,37,104,35,2,80,160,NULL),
(153,32,105,42,1,20,20,NULL),
(154,32,105,32,1,60,60,NULL),
(155,32,106,33,2,5,10,NULL),
(156,32,107,32,1,60,60,NULL),
(157,32,108,48,1,25,25,NULL),
(158,32,109,39,2,30,60,NULL),
(159,32,110,36,1,5,5,NULL),
(160,32,111,33,1,5,5,NULL);

/*Table structure for table `tbl_category` */

DROP TABLE IF EXISTS `tbl_category`;

CREATE TABLE `tbl_category` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `img_path` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `tbl_category` */

insert  into `tbl_category`(`cat_id`,`name`,`description`,`img_path`,`created_by`,`created_on`,`modified_by`,`modified_on`,`status`) values 
(1,'Football',NULL,'uploads/categories/football.jpg',11,NULL,11,NULL,1),
(2,'Cricket',NULL,'uploads/categories/cricket.jpg',11,NULL,11,NULL,1),
(3,'Tennis',NULL,'uploads/categories/tennis.jpg',11,NULL,11,NULL,1),
(4,'Hockey',NULL,'uploads/categories/hockey.jpg',11,NULL,11,NULL,1),
(5,'Badminton',NULL,'uploads/categories/badminton2.jpg',11,NULL,11,NULL,1);

/*Table structure for table `tbl_file` */

DROP TABLE IF EXISTS `tbl_file`;

CREATE TABLE `tbl_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `folder` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `tbl_file` */

insert  into `tbl_file`(`id`,`filename`,`size`,`folder`,`user_id`,`status`,`created_on`,`modified_on`) values 
(19,'26.docx','20374','F:\\tayyab\\example-app\\uploads/26',26,0,1733222641,1733222641),
(18,'19.docx','20374','F:\\tayyab\\example-app\\uploads/19',19,1,1733222468,1733222468),
(17,'24.docx','20374','F:\\tayyab\\example-app\\uploads/24',24,1,1733222370,1733222370),
(16,'24.docx','20374','F:\\tayyab\\example-app\\uploads/24',24,0,1733220994,1733222370),
(15,'22.docx','20374','F:\\tayyab\\example-app\\uploads/22',22,1,1733220741,1733220741),
(14,'22.pdf','1344970','F:\\tayyab\\example-app\\uploads/22',22,0,1733220713,1733220741),
(13,'27.pdf','1344970','F:\\tayyab\\example-app\\uploads/27',27,0,1733220196,1733222842),
(12,'27.docx','450787','F:\\tayyab\\example-app\\uploads/27',27,0,1733220181,1733220196),
(20,'27.docx','20374','F:\\tayyab\\example-app\\uploads/27',27,1,1733222686,1733222686),
(21,'25.docx','20374','F:\\tayyab\\example-app\\uploads/25',25,1,1733222714,1733222714),
(22,'27.pdf','1344970','F:\\tayyab\\example-app\\uploads/27',27,0,1733222724,1733222842),
(23,'18.pdf','156247','F:\\tayyab\\example-app\\uploads/18',18,1,1733222733,1733222733),
(24,'27.pdf','156247','F:\\tayyab\\example-app\\uploads/27',27,0,1733222834,1733222842),
(25,'27.pdf','1344970','F:\\tayyab\\example-app\\uploads/27',27,1,1733222842,1733222842),
(26,'23.docx','450787','F:\\tayyab\\example-app\\uploads/23',23,0,1733223095,1733223107),
(27,'23.docx','20374','F:\\tayyab\\example-app\\uploads/23',23,1,1733223107,1733223107),
(28,'28.pdf','562170','F:\\tayyab\\example-app\\uploads/28',28,0,1733227001,1733227016),
(29,'28.docx','20374','F:\\tayyab\\example-app\\uploads/28',28,1,1733227016,1733227016),
(30,'26.docx','23725','F:\\tayyab\\example-app\\uploads/26',26,1,1733285693,1733285693),
(31,'22.docx','23725','F:\\tayyab\\example-app\\uploads/22',22,1,1733287146,1733287146),
(32,'20.pdf','1344970','F:\\tayyab\\example-app\\uploads/20',20,1,1733287161,1733287161);

/*Table structure for table `tbl_product` */

DROP TABLE IF EXISTS `tbl_product`;

CREATE TABLE `tbl_product` (
  `pro_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `description` text DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `popularity` tinyint(4) DEFAULT 0,
  `created_on` int(11) DEFAULT NULL,
  `updated_on` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`pro_id`),
  KEY `cat_id` (`cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `tbl_product` */

insert  into `tbl_product`(`pro_id`,`name`,`price`,`description`,`cat_id`,`popularity`,`created_on`,`updated_on`,`status`) values 
(43,'WicketKeeper Gloves',20,'Gloves for wicket keeper',2,0,1733465764,NULL,1),
(42,'Football',20,'Full size football',1,0,1733465716,NULL,1),
(41,'tape ball',10,'Tape ball for cricket',2,0,1733465683,NULL,1),
(40,'Helmet',20,'Helmet for hard ball cricket',2,0,1733465640,NULL,1),
(39,'Racket',30,'Racket for Tennis',3,0,1733465606,NULL,1),
(37,'Net',40,'Net for tennis court',3,0,1733465176,NULL,1),
(38,'GoalKeeper Gloves',30,'Goalie Gloves for Football',1,0,1733465572,NULL,1),
(36,'Tennis Balls',5,'Tennis balls for tennis or soft cricket',3,1,1733465141,NULL,1),
(49,'Wicket',55,'full size wooden wickets for cricket',2,0,1733466241,NULL,1),
(48,'Badminton Net',25,'Full size net for badminton',5,0,1733466203,NULL,1),
(47,'Badminton Racket',20,'Badminton racket with cover',5,0,1733466093,NULL,1),
(46,'Hockey Helmet',40,'Good quality helmet for hocket goalie',4,0,1733466054,NULL,1),
(45,'Hockey Ball',35,'white hockey ball',4,0,1733466011,NULL,1),
(44,'Hockey stick',30,'Hockey stick',4,0,1733465967,NULL,1),
(32,'Arsenal Jersey',60,'Arsenal Football Club Kit\r\nFull kit of Arsenal Football Club.\r\nOnly Club to win Invincible title.\r\nPlayed 38, Won 26, Drawn 12 and lost EXACTLY NONE.',1,1,1733391886,NULL,1),
(33,'Shuttle',5,'Shuttle for badminton',5,1,1733462431,NULL,1),
(34,'Football Boots',50,'Professional Football Boots',1,1,1733462490,NULL,1),
(35,'Cricket Bat',80,'Bats for Hard ball cricket',2,1,1733462582,NULL,1),
(50,'Red Hard Ball',45,'Red hard ball for cricket',2,0,1733466303,NULL,1),
(51,'Batsman Helmet',40,'Helmet for batsman',2,0,1733466341,NULL,1),
(52,'Goal',70,'Full size goal for football field',1,0,1733466373,NULL,1),
(53,'Shin Guards',20,'Shin guards black color',1,0,1733466453,NULL,1),
(54,'test images pri',100,'test',2,0,1733975558,NULL,0),
(55,'tes pri',100,'ttest',1,0,1733975790,NULL,0),
(56,'test pr',100,'test',2,0,1733975988,NULL,0),
(57,'test pri',100,'test',1,0,1733976361,NULL,0),
(58,'test pri',100,'test',1,0,1733976820,NULL,0);

/*Table structure for table `tbl_product_images` */

DROP TABLE IF EXISTS `tbl_product_images`;

CREATE TABLE `tbl_product_images` (
  `img_id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) DEFAULT NULL,
  `folder` varchar(255) DEFAULT NULL,
  `pro_id` int(11) DEFAULT NULL,
  `priority` char(1) DEFAULT 'L',
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY (`img_id`),
  KEY `pro_id` (`pro_id`)
) ENGINE=MyISAM AUTO_INCREMENT=108 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `tbl_product_images` */

insert  into `tbl_product_images`(`img_id`,`filename`,`folder`,`pro_id`,`priority`,`created_on`,`modified_on`) values 
(1,'1733310832_Arsenal-Home-Jersey-2024-25-Back.jpg','uploads/products//',NULL,'L',1733310832,NULL),
(2,'1733310832_ArsenalJersey2.jpg','uploads/products//',NULL,'L',1733310832,NULL),
(3,'1733310832_ArsenalJersey.jpg','uploads/products//',NULL,'L',1733310832,NULL),
(4,'1733310832_footballShinGuards.jpg','uploads/products//',NULL,'L',1733310832,NULL),
(5,'1733310832_batcricket.jpg','uploads/products//',NULL,'L',1733310832,NULL),
(6,'1733311355_image_2024_11_14T05_45_18_654Z.png','uploads/products//',NULL,'L',1733311355,NULL),
(7,'1733311355_badminton2.jpg','uploads/products//',NULL,'L',1733311355,NULL),
(8,'1733311355_badminton1.jpg','uploads/products//',NULL,'L',1733311355,NULL),
(9,'1733311355_footballstadium.jpg','uploads/products//',NULL,'L',1733311355,NULL),
(10,'1733311355_goalpost2.jpg','uploads/products//',NULL,'L',1733311355,NULL),
(11,'1733311526_image_2024_11_14T05_45_18_654Z.png','uploads/products//',NULL,'L',1733311526,NULL),
(12,'1733311526_badminton2.jpg','uploads/products//',NULL,'L',1733311526,NULL),
(13,'1733311526_badminton1.jpg','uploads/products//',NULL,'L',1733311526,NULL),
(14,'1733311575_image_2024_11_14T05_45_18_654Z.png','uploads/products/11/',NULL,'L',1733311575,NULL),
(15,'1733311575_badminton2.jpg','uploads/products/11/',NULL,'L',1733311575,NULL),
(16,'1733311575_badminton1.jpg','uploads/products/11/',NULL,'L',1733311575,NULL),
(17,'1733313556_badminton2.jpg','uploads/products/12/',NULL,'L',1733313558,NULL),
(18,'1733313558_badmintonRacket.jpg','uploads/products/12/',NULL,'L',1733313558,NULL),
(36,'1733375276_badminton2.jpg','uploads/products/14',14,'L',1733375276,NULL),
(33,'1733374688_tapeball2.jpg','uploads/products/13',13,'L',1733374688,NULL),
(35,'1733375276_image_2024_11_14T05_45_18_654Z.png','uploads/products/14',14,'L',1733375276,NULL),
(34,'1733374688_tapeball.jpg','uploads/products/13',13,'L',1733374688,NULL),
(37,'1733375276_badminton1.jpg','uploads/products/14',14,'L',1733375276,NULL),
(38,'1733375276_footballstadium.jpg','uploads/products/14',14,'L',1733375276,NULL),
(40,'1733376384_helmet cricket.jpg','uploads/products/14',14,'L',1733376384,NULL),
(41,'1733378191_image_2024_11_14T05_45_18_654Z.png','uploads/products/15',15,'L',1733378191,NULL),
(42,'1733378191_badminton2.jpg','uploads/products/15',15,'L',1733378191,NULL),
(43,'1733378191_badminton1.jpg','uploads/products/15',15,'L',1733378191,NULL),
(44,'1733379564_footballGloves.jpg','uploads/products/15',15,'L',1733379564,NULL),
(45,'1733379564_football.jpg','uploads/products/15',15,'L',1733379564,NULL),
(46,'1733380251_badminton2.jpg','uploads/products/17',17,'L',1733380251,NULL),
(47,'1733380283_badminton2.jpg','uploads/products/18',18,'L',1733380283,NULL),
(48,'1733380615_helmet.png','uploads/products/12',12,'L',1733380615,NULL),
(49,'1733380615_tapeball2.jpg','uploads/products/12',12,'L',1733380615,NULL),
(50,'1733380648_bat2.jpg','uploads/products/12',12,'L',1733380648,NULL),
(51,'1733380648_ArsenalJersey2.jpg','uploads/products/12',12,'L',1733380648,NULL),
(52,'1733380658_Arsenal-Home-Jersey-2024-25-Back.jpg','uploads/products/17',17,'L',1733380658,NULL),
(53,'1733380845_badminton2.jpg','uploads/products/19',19,'L',1733380845,NULL),
(54,'1733382535_helmet.png','uploads/products/22',22,'L',1733382535,NULL),
(55,'1733382535_tapeball2.jpg','uploads/products/22',22,'L',1733382535,NULL),
(56,'1733382939_bat2.jpg','uploads/products/23',23,'L',1733382939,NULL),
(57,'1733382939_ArsenalJersey2.jpg','uploads/products/23',23,'L',1733382939,NULL),
(58,'1733382939_ArsenalJersey.jpg','uploads/products/23',23,'L',1733382939,NULL),
(59,'1733382939_GoalPost.jpg','uploads/products/23',23,'L',1733382939,NULL),
(60,'1733382950_batcricket.jpg','uploads/products/23',23,'L',1733382950,NULL),
(61,'1733383693_badminton1.jpg','uploads/products/13',13,'L',1733383693,NULL),
(62,'1733391049_tapeball2.jpg','uploads/products/28',28,'L',1733391049,NULL),
(63,'1733391083_badminton2.jpg','uploads/products/29',29,'L',1733391083,NULL),
(64,'1733391103_image_2024_11_14T05_45_18_654Z.png','uploads/products/30',30,'L',1733391103,NULL),
(65,'1733391103_badminton2.jpg','uploads/products/30',30,'L',1733391103,NULL),
(66,'1733391103_badminton1.jpg','uploads/products/30',30,'L',1733391103,NULL),
(67,'1733391103_footballstadium.jpg','uploads/products/30',30,'L',1733391103,NULL),
(68,'1733391103_goalpost2.jpg','uploads/products/30',30,'L',1733391103,NULL),
(69,'1733391886_Arsenal-Home-Jersey-2024-25-Back.jpg','uploads/products/32',32,'L',1733391886,NULL),
(70,'1733391886_ArsenalJersey2.jpg','uploads/products/32',32,'L',1733391886,NULL),
(71,'1733391886_ArsenalJersey.jpg','uploads/products/32',32,'H',1733391886,NULL),
(72,'1733462431_badmintonShuttle.jpg','uploads/products/33',33,'H',1733462431,NULL),
(73,'1733462490_footballBoots3.jpg','uploads/products/34',34,'H',1733462490,NULL),
(74,'1733462490_footballBoots2.jpg','uploads/products/34',34,'L',1733462490,NULL),
(75,'1733462490_footballBoots.jpg','uploads/products/34',34,'L',1733462490,NULL),
(76,'1733462582_bat2.jpg','uploads/products/35',35,'H',1733462582,NULL),
(77,'1733462582_batcricket.jpg','uploads/products/35',35,'L',1733462582,NULL),
(78,'1733465141_tenisballadidas.jpg','uploads/products/36',36,'H',1733465141,NULL),
(79,'1733465176_netTennis.jpg','uploads/products/37',37,'H',1733465176,NULL),
(80,'1733465572_footballGloves.jpg','uploads/products/38',38,'H',1733465572,NULL),
(81,'1733465606_racketTennis.jpg','uploads/products/39',39,'H',1733465606,NULL),
(82,'1733465640_helmet cricket.jpg','uploads/products/40',40,'H',1733465640,NULL),
(83,'1733465683_tapeball2.jpg','uploads/products/41',41,'H',1733465683,NULL),
(84,'1733465683_tapeball.jpg','uploads/products/41',41,'L',1733465683,NULL),
(85,'1733465716_football.jpg','uploads/products/42',42,'H',1733465716,NULL),
(86,'1733465764_WKGloves.jpg','uploads/products/43',43,'H',1733465764,NULL),
(87,'1733465967_hockeyStick.jpg','uploads/products/44',44,'H',1733465967,NULL),
(88,'1733466011_hockeyBall.jpg','uploads/products/45',45,'H',1733466011,NULL),
(89,'1733466054_hocketHelmet.jpg','uploads/products/46',46,'H',1733466054,NULL),
(90,'1733466093_badmintonRacket.jpg','uploads/products/47',47,'H',1733466093,NULL),
(91,'1733466203_badmintonNet.jpg','uploads/products/48',48,'H',1733466203,NULL),
(92,'1733466241_wickets.jpg','uploads/products/49',49,'H',1733466241,NULL),
(93,'1733466303_hardBall2.jpg','uploads/products/50',50,'L',1733466303,NULL),
(94,'1733466303_cricketBall.jpg','uploads/products/50',50,'H',1733466303,NULL),
(95,'1733466341_helmet.png','uploads/products/51',51,'H',1733466341,NULL),
(96,'1733466373_goalpost2.jpg','uploads/products/52',52,'H',1733466373,NULL),
(97,'1733466453_footballShinGuards.jpg','uploads/products/53',53,'H',1733466453,NULL),
(99,'1733975558_Screenshot 2024-06-27 114012.png','uploads/products/54',54,'L',1733975558,NULL),
(100,'1733975790_Screenshot 2024-06-27 114012.png','uploads/products/55',55,'L',1733975790,NULL),
(101,'1733975988_Screenshot 2024-06-27 113939.png','uploads/products/56',56,'L',1733975988,NULL),
(102,'1733976361_Screenshot 2024-06-27 114012.png','uploads/products/57',57,'L',1733976361,NULL),
(103,'1733976820_Screenshot 2024-06-27 114012.png','uploads/products/58',58,'H',1733976820,NULL),
(104,'1733976872_Screenshot 2024-09-05 112152.png','uploads/products/58',58,'L',1733976872,NULL),
(105,'1733976872_Screenshot 2024-09-05 140811.png','uploads/products/58',58,'L',1733976872,NULL),
(106,'1733976872_Screenshot 2024-09-06 120849.png','uploads/products/58',58,'L',1733976872,NULL),
(107,'1733976872_Screenshot 2024-11-04 122812.png','uploads/products/58',58,'L',1733976872,NULL);

/*Table structure for table `tbl_profile` */

DROP TABLE IF EXISTS `tbl_profile`;

CREATE TABLE `tbl_profile` (
  `profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` int(12) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`profile_id`),
  KEY `id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `tbl_profile` */

insert  into `tbl_profile`(`profile_id`,`user_id`,`address`,`phone`,`city`,`state`,`country`,`created_on`,`modified_on`,`ip_address`,`created_at`,`updated_at`) values 
(1,11,'test address',123456789,'karachi','sindh','pakistan',NULL,NULL,NULL,NULL,NULL),
(2,17,'test',987654321,'Los Angeles','California','USA',NULL,NULL,NULL,'2024-12-02 05:58:24','2024-12-02 05:58:24'),
(3,18,'test image',987654321,'Lahore','Punjab','Pakistan',NULL,NULL,NULL,'2024-12-02 06:40:53','2024-12-02 06:40:53'),
(4,19,'test',987654321,'Karachi','Sindh','Pakistan',NULL,NULL,NULL,'2024-12-02 06:52:35','2024-12-02 06:52:35'),
(5,20,'test',987654321,'San Francisco','California','USA',NULL,NULL,NULL,'2024-12-02 06:56:27','2024-12-02 06:56:27'),
(6,22,'test',987654321,'Quebec City','Quebec','Canada',NULL,NULL,NULL,'2024-12-02 07:01:21','2024-12-02 07:01:21'),
(7,23,'message',987654321,'Hyderabad','Sindh','Pakistan',NULL,NULL,NULL,'2024-12-02 11:21:57','2024-12-02 11:21:57'),
(8,24,'test image',987654321,'Lahore','Punjab','Pakistan',NULL,NULL,NULL,'2024-12-02 11:34:24','2024-12-02 11:34:24'),
(9,25,'test ip',123456789,'Toronto','Ontario','Canada',NULL,NULL,'::1',NULL,NULL),
(10,26,'test',98654321,'Lahore','Punjab','Pakistan',NULL,1733210611,'127.0.0.1',NULL,NULL),
(11,27,'test',987654321,'Quebec City','Quebec','Canada',1733200245,1733208688,'127.0.0.1',NULL,NULL),
(12,28,'test',987654321,'Karachi','Sindh','Pakistan',1733226896,1733226944,'127.0.0.1',NULL,NULL),
(13,29,'test',987654321,'Los Angeles','California','USA',1733298900,1733298900,'127.0.0.1',NULL,NULL),
(14,12,'abcdeavenue',887654321,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(15,30,'R321 abc society',369258147,'Toronto','Ontario','Canada',1733890064,1733890064,'127.0.0.1',NULL,NULL),
(16,13,'NA',987654321,'Karachi','Sindh','Pakistan',NULL,NULL,NULL,NULL,NULL),
(17,31,'R123 xyz avenue',987654321,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(18,33,'test',987654321,'Lahore','Punjab','Pakistan',1734003196,1734003196,'127.0.0.1',NULL,NULL),
(19,32,'check after new project creation',987654321,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(20,35,'test',963827410,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(21,36,'test',987654321,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(22,37,'test',987654321,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `tbl_users_pic` */

DROP TABLE IF EXISTS `tbl_users_pic`;

CREATE TABLE `tbl_users_pic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `tbl_users_pic` */

insert  into `tbl_users_pic`(`id`,`user_id`,`name`,`path`,`created_at`,`updated_at`) values 
(1,18,'mADUPcG5op.jpg','public/profile_images/18/mADUPcG5op.jpg','2024-12-02 06:40:54','2024-12-02 06:40:54'),
(2,19,'CZDQhQp8PH.jpg','public/profile_images/19//CZDQhQp8PH.jpg','2024-12-02 06:52:35','2024-12-02 06:52:35'),
(3,20,'dQbfKujVPd.jpg','public/profile_images/20//dQbfKujVPd.jpg','2024-12-02 06:56:27','2024-12-02 06:56:27'),
(4,22,'22.jpg','public/profile_images/22//22.jpg','2024-12-02 07:01:21','2024-12-02 07:01:21'),
(5,23,'23.jpg','public/profile_images/23//23.jpg','2024-12-02 11:21:57','2024-12-02 11:21:57'),
(6,24,'24.jpg','public/profile_images/24//24.jpg','2024-12-02 11:34:24','2024-12-02 11:34:24'),
(7,24,'1733140791.jpg','public/profile_images/24/1733140791.jpg','2024-12-02 11:59:51','2024-12-02 11:59:51'),
(8,25,'25.jpg','public/profile_images/25//25.jpg','2024-12-03 04:16:42','2024-12-03 04:16:42'),
(9,26,'26-1733210611.jpg','public/profile_images/26/26-1733210611.jpg','2024-12-03 04:19:26','2024-12-03 07:23:31'),
(10,27,'1733208444-1733208688.jpg','public/profile_images/27/1733208444-1733208688.jpg','2024-12-03 04:30:45','2024-12-03 06:51:28'),
(11,28,'28.jpg','public/profile_images/28//28.jpg','2024-12-03 11:54:56','2024-12-03 11:54:56'),
(12,29,'29.jpg','public/profile_images/29//29.jpg','2024-12-04 07:55:00','2024-12-04 07:55:00');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(4) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `ip_address` varchar(50) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`) USING HASH
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`password`,`is_admin`,`status`,`ip_address`,`email_verified_at`,`remember_token`,`created_at`,`updated_at`) values 
(35,'final test','f.test@test.com','$2y$10$sYtjGXdb/bJ/u2o/SlaUEud6/4/loNPovpD/9iZcfcdiMCsab19QW',0,1,NULL,NULL,NULL,NULL,NULL),
(33,'pass check','pass@test.com','$2y$10$/xsc.ypZfisDIUJFxVQxteZiSxrU8wCFyrMSs.J5a6k60EAZKjRHm',0,1,NULL,NULL,NULL,NULL,NULL),
(32,'user register','u5.tayyab@test.com','$2y$10$IP1ZlfAKxqMXRr6jO1z7wujeIkbY2dQjMifE8jGzub9jRGzC.lLTC',0,1,NULL,NULL,'RZarift8InVoQscwAsPwAuxTE8yZsm7lbACHV9Ee7TIcwzTprec9MOjVHmOM',NULL,NULL),
(31,'Tayyab Check','u4.tayyab@test.com','$2y$10$toWocpmuC42Tr5q2x9CAhu7iW53VGQhr0oIKwhmoZUhIURxqrImKS',0,1,NULL,NULL,'txhHNmAh1buTCLwZI8QvBFXG9oXw2wQbwIt2VYMpOEKVHjn7ojHEuGjbH240',NULL,NULL),
(30,'User Tayyab','u3.tayyab@test.com','$2y$10$XigCmoiIJMQreU40g81CuOTve3avsxfalD1k0wydQf80P/S93ypnK',0,1,NULL,NULL,NULL,NULL,NULL),
(29,'test test','testadd10@test.com','$2y$10$p93iJIrPWoy6jcWPcJGqlueqTwhSNdcH/sQzIrBjLB0I4b242qg9S',0,1,NULL,NULL,NULL,NULL,NULL),
(28,'kuch bhi','sirtest@test.com','$2y$10$Mhzsf65TYHWYGgqHIfCvFu38F6t30.epR3noSQ70zYANF7FBffpx6',0,1,NULL,NULL,NULL,NULL,NULL),
(11,'Admin Tayyab','a.tayyab@test.com','$2y$10$q9awXWhD/Wj8caZY..7.g.D/.i9bfHy34B/piTqFzmMJOato7GeCm',1,1,NULL,NULL,NULL,'2024-11-28 06:18:01','2024-11-28 06:18:01'),
(12,'tayyab mansoor','u.tayyab@test.com','$2y$10$o7UnI65CWfXCsdcqyLLhqOS8LmDDFEtwF7WYkO.YDTmqxWuKjSt5G',0,1,NULL,NULL,NULL,'2024-11-28 06:19:39','2024-11-28 06:19:39'),
(13,'tayyab mansoor','u2.tayyab@test.com','$2y$10$iB/hw0222HxAMl.7Aa5OiezM0Xgz.EChIU7d0zOuHP8.53Hpp.jjG',0,1,NULL,NULL,NULL,'2024-11-28 07:00:09','2024-11-28 07:00:09'),
(14,'Add User','testadd@test.com','$2y$10$06qEEJx3wN0gMp5d7MjcdunwL1JyW/tuxHVY9Wk8zmPjf44WhpddW',0,0,NULL,NULL,NULL,'2024-12-02 05:48:20','2024-12-02 05:51:50'),
(15,'Add User','testadd2@test.com','$2y$10$v9J1FSFREtCrkQqm7AC5XerWkH2WQEksyQgsMne.IMqBOAze.VsnW',0,0,NULL,NULL,NULL,'2024-12-02 05:52:52','2024-12-02 05:52:52'),
(16,'Add User','testadd3@test.com','$2y$10$cr0JZcEWx0Y1hSNncAoVBe7Pa64abvmuRVz/LCdE8KpEn5M5EApt.',0,0,NULL,NULL,NULL,'2024-12-02 05:56:17','2024-12-02 05:56:17'),
(17,'Add User','testadd4@test.com','$2y$10$Ff3NUz4Ecw5Wfa.8t491feVG0v3W8PYctZGYSl.Xu1/3mHSNIRZTa',0,1,NULL,NULL,NULL,'2024-12-02 05:58:24','2024-12-02 05:58:24'),
(18,'Add UserImage','testadd6@test.com','$2y$10$aM8NkhbbV4TvILB.7XsNjuCQE4p0AZpGh9qzj58b.pXD6jlTx3gN.',0,1,NULL,NULL,NULL,'2024-12-02 06:40:53','2024-12-02 06:40:53'),
(19,'Add UserImage','testadd7@test.com','$2y$10$49i8uEsN0y0CZUdWkOuXjuuZ/ejS.Al5y/e1h3KUYBaEllw4ZOTv.',0,1,NULL,NULL,NULL,'2024-12-02 06:52:35','2024-12-02 06:52:35'),
(20,'Add UserImage','testadd8@test.com','$2y$10$oowMsqcEanSxIG8kg51Lv.2H/BkbDH6MBBB6Bwtk93cjHNPoLn88G',0,1,NULL,NULL,NULL,'2024-12-02 06:56:27','2024-12-02 06:56:27'),
(21,'Add UserImage','testaddfinal@test.com','$2y$10$dWaoAxjCNhnG1AxD/8heLOylRzrGmwLKtGXwXCpPmrsMwU04mviBK',0,0,NULL,NULL,NULL,'2024-12-02 06:59:43','2024-12-02 11:01:51'),
(22,'testupdate UserImage','testadd9@test.com','$2y$10$Qceh9Uh5R/e6EjP6rfdapuLqD97jzuY.VhslP2S0dzkSVmXeJ5aMK',0,1,NULL,NULL,NULL,'2024-12-02 07:01:21','2024-12-02 11:01:20'),
(23,'test show','message@test.com','$2y$10$bL8S7I7gEwto1BmkWWGXKO/fFBgoXjNT7xYGPvlA2C0BcxVVYxfIC',0,1,NULL,NULL,NULL,'2024-12-02 11:21:57','2024-12-02 11:22:47'),
(24,'Happy Test','happy@test.com','$2y$10$UBK55uB44MaRI0RT3IFqAua65DUAtUAeu5RPihmIQMxurmtGr8AdS',0,1,NULL,NULL,NULL,'2024-12-02 11:34:24','2024-12-02 11:39:32'),
(25,'ip address','iptest@test.com','$2y$10$QL7BOnvab.LMkZHQvjFQ7ejGFstaV636llVHSkHGJVmULsrQLwTFa',0,1,NULL,NULL,NULL,NULL,NULL),
(26,'ip address','iptest2@test.com','$2y$10$nO26VT03B7ndKvuJqPMrieJ.vuN3zkeN4SfknucFGsZjbJE4pIGoy',0,1,NULL,NULL,NULL,NULL,NULL),
(27,'timestamp testupdate','timetest@test.com','$2y$10$/gd7a7FYIstQ1TksiOszHeorn2Q4/nyvzIEzvSArdj8hvmWB9Ukd.',0,1,NULL,NULL,NULL,NULL,NULL),
(36,'Hamza Amir','hamzaaamir248@gmail.com','$2y$10$/IIQXQIJSfxUy.CpT/qHLec3nZqeUvz8beWNf2jUTElLY6JZ5jY9K',0,1,NULL,NULL,NULL,NULL,NULL),
(37,'Muhammad Anas','muhammadanas@xolva.com','$2y$10$kvGeqqxI2jAQmEfvat0fneQJ5heta0BlLV5RCXUtSDSJkd2wBw1fS',0,1,NULL,NULL,NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
