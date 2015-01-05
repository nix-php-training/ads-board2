/*
SQLyog Ultimate v11.52 (64 bit)
MySQL - 5.5.40-0ubuntu0.14.04.1 : Database - ads-board2
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`ads-board2` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `ads-board2`;

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`) values (1,'user'),(2,'admin');

/*Table structure for table `status` */

DROP TABLE IF EXISTS `status`;

CREATE TABLE `status` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `status` */

insert  into `status`(`id`,`name`) values (1,'unconfirmed'),(2,'registered'),(3,'baned');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(32) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(64) NOT NULL,
  `startDate` datetime NOT NULL,
  `statusId` tinyint(1) unsigned NOT NULL,
  `roleId` tinyint(1) unsigned DEFAULT NULL,
  `hash` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`login`,`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`login`,`email`,`password`,`startDate`,`statusId`,`roleId`,`hash`) values (1,'Vasya','vasya@gmail.com','$2y$10$ppdxfhYHhdnvAeti02XQOep8YrvlucbZnlpIyA36/gQUB2ocyYIRm','2014-12-24 00:00:00',1,1,'64923e291fd19ab7b85c5cbb34a79cd38c0f5334'),(5,'Vova','vova@gmail.com','$2y$10$ppdxfhYHhdnvAeti02XQOep8YrvlucbZnlpIyA36/gQUB2ocyYIRm','2014-12-24 00:00:00',2,2,NULL),(6,'Kolya','kolya@gmail.com','$2y$10$ppdxfhYHhdnvAeti02XQOep8YrvlucbZnlpIyA36/gQUB2ocyYIRm','0000-00-00 00:00:00',1,2,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;