/*
SQLyog Ultimate v11.52 (64 bit)
MySQL - 5.5.40-0ubuntu0.14.04.1 : Database - ads-board2
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE = '' */;

/*!40014 SET @OLD_UNIQUE_CHECKS = @@UNIQUE_CHECKS, UNIQUE_CHECKS = 0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0 */;
/*!40101 SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES = @@SQL_NOTES, SQL_NOTES = 0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS */`ads-board2` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `ads-board2`;

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id`   INT(2) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(12)     NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE =InnoDB
  AUTO_INCREMENT =3
  DEFAULT CHARSET =utf8;

/*Data for the table `roles` */

INSERT INTO `roles` (`id`, `name`) VALUES (1, 'user'), (2, 'admin');

/*Table structure for table `status` */

DROP TABLE IF EXISTS `status`;

CREATE TABLE `status` (
  `id`   INT(2) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(12)     NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE =InnoDB
  AUTO_INCREMENT =4
  DEFAULT CHARSET =utf8;

/*Data for the table `status` */

INSERT INTO `status` (`id`, `name`) VALUES (1, 'unconfirmed'), (2, 'registered'), (3, 'baned');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id`        INT(11) UNSIGNED    NOT NULL AUTO_INCREMENT,
  `login`     VARCHAR(32)         NOT NULL,
  `email`     VARCHAR(250)        NOT NULL,
  `password`  VARCHAR(64)         NOT NULL,
  `startDate` DATETIME            NOT NULL,
  `statusId`  TINYINT(1) UNSIGNED NOT NULL,
  `roleId`    TINYINT(1) UNSIGNED DEFAULT NULL,
  `hash`      VARCHAR(64)         DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`login`, `email`)
)
  ENGINE =InnoDB
  AUTO_INCREMENT =7
  DEFAULT CHARSET =utf8;

/*Data for the table `users` */

INSERT INTO `users` (`id`, `login`, `email`, `password`, `startDate`, `statusId`, `roleId`, `hash`) VALUES
  (1, 'Vasya', 'vasya@gmail.com', '$2y$10$ppdxfhYHhdnvAeti02XQOep8YrvlucbZnlpIyA36/gQUB2ocyYIRm', '2014-12-24 00:00:00',
   1, 1, '64923e291fd19ab7b85c5cbb34a79cd38c0f5334'),
  (5, 'Vova', 'vova@gmail.com', '$2y$10$ppdxfhYHhdnvAeti02XQOep8YrvlucbZnlpIyA36/gQUB2ocyYIRm', '2014-12-24 00:00:00',
   2, 2, NULL),
  (6, 'Kolya', 'kolya@gmail.com', '$2y$10$ppdxfhYHhdnvAeti02XQOep8YrvlucbZnlpIyA36/gQUB2ocyYIRm', '0000-00-00 00:00:00',
   1, 2, NULL);

/*!40101 SET SQL_MODE = @OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES = @OLD_SQL_NOTES */;