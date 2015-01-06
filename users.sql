-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Дек 24 2014 г., 00:25
-- Версия сервера: 5.5.40-0ubuntu0.14.04.1
-- Версия PHP: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `ads-board2`
--
CREATE DATABASE IF NOT EXISTS `ads-board2`;
USE `ads-board2`;
-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `login` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `confrimDate` datetime NOT NULL,
  `statusId` BIGINT NOT NULL,
  `roleId` BIGINT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`,`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `statuses` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `roles` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `profiles` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `firstname` varchar(32),
  `lastname` varchar(32),
  `birthdate`DATETIME,
  `phone` varchar(32),
  `skype` VARCHAR(16),
  `userId` BIGINT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `advertisements` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `subject` varchar(256) NOT NULL ,
  `description` varchar(256),
  `price` DECIMAL NOT NULL ,
  `creationDate` DATETIME NOT NULL ,
  `categoryId` BIGINT,
  `userId` BIGINT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `payments` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `paymentType` varchar(128) NOT NULL ,
  `endDate` DATETIME,
  `price` DECIMAL NOT NULL ,
  `planId` BIGINT NOT NULL,
  `userId` BIGINT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `categories` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL ,
  `description` varchar(256),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `advertisementsImages` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `link` varchar(256) NOT NULL ,
  `advertisementId` BIGINT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `plans` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL ,
  `price` DECIMAL NOT NULL ,
  `term` VARCHAR(32) NOT NULL ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `profiles` ADD CONSTRAINT `fk_profiles_users` FOREIGN KEY (userId) REFERENCES users(id);
ALTER TABLE `advertisements` ADD CONSTRAINT `fk_advertisements_users` FOREIGN KEY (userId) REFERENCES users(id);
ALTER TABLE `advertisements` ADD CONSTRAINT `fk_advertisements_categories` FOREIGN KEY (categoryId) REFERENCES categories(id);
ALTER TABLE `payments` ADD CONSTRAINT `fk_payments_users` FOREIGN KEY (userId) REFERENCES users(id);
ALTER TABLE `payments` ADD CONSTRAINT `fk_payments_plans` FOREIGN KEY (planId) REFERENCES plans(id);
ALTER TABLE `advertisementsImages` ADD CONSTRAINT `fk_adsImages_ads` FOREIGN KEY (advertisementId) REFERENCES advertisements(id);
ALTER TABLE `users` ADD CONSTRAINT `fk_users_statuses` FOREIGN KEY (statusId) REFERENCES statuses(id);
ALTER TABLE `users` ADD CONSTRAINT `fk_users_roles` FOREIGN KEY (roleId) REFERENCES roles(id);


INSERT INTO `roles` (`name`) VALUES
  ('admin'),
  ('user');

INSERT INTO `statuses` (`name`) VALUES
  ('unconfirmed'),
  ('registered'),
  ('banned');

INSERT INTO `users` ( `login`, `email`, `password`, `confrimDate`, `statusId`, `roleId`) VALUES
  ('Vasya', 'vasya@gmail.com', '123', '2014-12-24 00:00:00', 1,  2),
  ('Vova', 'vova@gmail.com', '123', '2014-12-24 00:00:00', 1,  1),
  ('Kolya', 'kolya@gmail.com', '123', '0000-00-00 00:00:00', 2, 2);



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
