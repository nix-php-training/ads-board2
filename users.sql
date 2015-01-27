
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
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
  `id`          BIGINT       NOT NULL AUTO_INCREMENT,
  `login`       VARCHAR(32)  NOT NULL,
  `email`       VARCHAR(255) NOT NULL,
  `password`    VARCHAR(64)  NOT NULL,
  `confirmDate` DATETIME,
  `statusId`    TINYINT(1)   NOT NULL,
  `roleId`      TINYINT(1)   NOT NULL,
  `hash`        VARCHAR(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`, `email`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =1;

CREATE TABLE IF NOT EXISTS `statuses` (
  `id`   TINYINT(1)  NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(16) NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =1;

CREATE TABLE IF NOT EXISTS `roles` (
  `id`   TINYINT(1)  NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(16) NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =1;

CREATE TABLE IF NOT EXISTS `profiles` (
  `id`        BIGINT NOT NULL AUTO_INCREMENT,
  `fullName` VARCHAR(32),
  `birthday` DATE DEFAULT '0000-00-00',
  `phone`     VARCHAR(32),
  `skype`     VARCHAR(16),
  `userId`    BIGINT NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =1;

CREATE TABLE IF NOT EXISTS `advertisements` (
  `id`           BIGINT         NOT NULL AUTO_INCREMENT,
  `subject`      VARCHAR(256)   NOT NULL,
  `description`  VARCHAR(256),
  `price`        DECIMAL(10, 2) NOT NULL,
  `creationDate` DATETIME       NOT NULL,
  `categoryId`   BIGINT,
  `userId`       BIGINT         NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =1;

CREATE TABLE IF NOT EXISTS `currentPlan` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `endDate` DATETIME,
  `adsCounter` BIGINT,
  `price` DOUBLE(10,2),
  `planId` BIGINT,
  `userId` BIGINT,
  PRIMARY KEY (`id`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =1;

CREATE TABLE IF NOT EXISTS `categories` (
  `id`          BIGINT       NOT NULL AUTO_INCREMENT,
  `title`       VARCHAR(128) NOT NULL,
  `description` VARCHAR(256),
  PRIMARY KEY (`id`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =1;

CREATE TABLE IF NOT EXISTS `advertisementsImages` (
  `id`              BIGINT       NOT NULL AUTO_INCREMENT,
  `imageName`       VARCHAR(256) NOT NULL,
  `advertisementId` BIGINT,
  PRIMARY KEY (`id`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =1;

CREATE TABLE IF NOT EXISTS `plans` (
  `id`    BIGINT        NOT NULL AUTO_INCREMENT,
  `name`  VARCHAR(128)  NOT NULL,
  `price` DOUBLE(10, 2) NOT NULL,
  `term`  VARCHAR(32)   NOT NULL,
  `posts` INT           NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =1;

CREATE TABLE IF NOT EXISTS `confirmationLinks` (
  `id`     BIGINT NOT NULL AUTO_INCREMENT,
  `link`   VARCHAR(128),
  `userId` BIGINT NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =1;

CREATE TABLE IF NOT EXISTS `payments` (
  `id` BIGINT NOT NULL AUTO_INCREMENT ,
  `date` DATETIME ,
  `paymentType` VARCHAR(128) NOT NULL ,
  `planName` VARCHAR(128) NOT NULL ,
  `planCost` DOUBLE(10,2) NOT NULL ,
  `transactionId` VARCHAR(128)  NOT NULL,
  `userId`        BIGINT        NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =1;

CREATE TABLE restoreLinks
(
  id          BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  link        VARCHAR(128)       NOT NULL,
  userId      BIGINT             NOT NULL,
  newPassword VARCHAR(64)        NOT NULL,
  FOREIGN KEY (userId) REFERENCES users (id)
    ON DELETE CASCADE
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8
  AUTO_INCREMENT =1;
CREATE INDEX fk_restLinks_users ON restoreLinks (userId);

CREATE OR REPLACE VIEW catalog AS
  SELECT
    advertisements.id              AS id,
    advertisements.subject         AS subject,
    advertisements.price           AS price,
    advertisements.creationDate    AS cDate,
    advertisements.userId          AS userId,
    advertisementsImages.imageName AS img
  FROM advertisements
    JOIN advertisementsImages ON advertisements.id = advertisementsImages.advertisementId
  GROUP BY id;

ALTER TABLE `profiles` ADD CONSTRAINT `fk_profiles_users` FOREIGN KEY (userId) REFERENCES users(id);
ALTER TABLE `advertisements` ADD CONSTRAINT `fk_advertisements_users` FOREIGN KEY (userId) REFERENCES users(id);
ALTER TABLE `advertisements` ADD CONSTRAINT `fk_advertisements_categories` FOREIGN KEY (categoryId) REFERENCES categories(id);
ALTER TABLE `currentPlan` ADD CONSTRAINT `fk_currentPlan_users` FOREIGN KEY (userId) REFERENCES users(id);
ALTER TABLE `currentPlan` ADD CONSTRAINT `fk_currentPlan_plans` FOREIGN KEY (planId) REFERENCES plans(id);
ALTER TABLE `advertisementsImages` ADD CONSTRAINT `fk_adsImages_ads` FOREIGN KEY (advertisementId) REFERENCES advertisements(id) ON DELETE CASCADE;
ALTER TABLE `users` ADD CONSTRAINT `fk_users_statuses` FOREIGN KEY (statusId) REFERENCES statuses(id);
ALTER TABLE `users` ADD CONSTRAINT `fk_users_roles` FOREIGN KEY (roleId) REFERENCES roles(id);
ALTER TABLE `confirmationLinks` ADD CONSTRAINT `fk_confLinks_users` FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE;
ALTER TABLE `payments` ADD CONSTRAINT `fk_payments_users` FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE;


INSERT INTO `roles` (`name`) VALUES
  ('admin'),
  ('user');

INSERT INTO `statuses` (`name`) VALUES
  ('unconfirmed'),
  ('registered'),
  ('banned');

INSERT INTO `users` (`login`, `email`, `password`, `confirmDate`, `statusId`, `roleId`, `hash`) VALUES
  ('Vasya', 'vasya@gmail.com', '$2y$10$ppdxfhYHhdnvAeti02XQOep8YrvlucbZnlpIyA36/gQUB2ocyYIRm', '0000-00-00 00:00:00', 1,
   2, NULL),
  ('Vova', 'vova@gmail.com', '$2y$10$ppdxfhYHhdnvAeti02XQOep8YrvlucbZnlpIyA36/gQUB2ocyYIRm', '0000-00-00 00:00:00', 1,
   1, NULL),
  ('Kolya', 'kolya@gmail.com', '$2y$10$ppdxfhYHhdnvAeti02XQOep8YrvlucbZnlpIyA36/gQUB2ocyYIRm', '0000-00-00 00:00:00', 2,
   2, NULL),
  ('admin', 'admin@gmail.com', '$2y$10$ppdxfhYHhdnvAeti02XQOep8YrvlucbZnlpIyA36/gQUB2ocyYIRm', '0000-00-00 00:00:00', 2,
  1, NULL);

INSERT INTO `categories` (`title`, `description`) VALUES
  ('Automobiles', 'Description'),
  ('Toys', 'Description'),
  ('Furniture', 'Description');

INSERT INTO `confirmationLinks` (`link`, `userId`) VALUES
  ('somelink', 1),
  ('somelink', 2),
  ('somelink', 3);

# INSERT INTO `profiles` ( `firstname`, `lastname`, `birthdate`, `phone`, `skype`, `userId`,) VALUES
#   ('vasya','ivanov,','0000-00-00 00:00:00','123456',null,1);

INSERT INTO `plans` (`name`, `price`, `term` , `posts`) VALUES ('free','0.0','month','1'),('pro','99.99','month','1000'),('business','199.99','month','-1');

/*Data for the table `profiles` */

INSERT INTO `profiles` (`id`, `fullName`, `birthday`, `phone`, `skype`, `userId`)
VALUES (1, 'Vasiliy Lee', '2000-01-21', '+380505556677', 'Lee', 1),
  (4, 'Vladimir Den', '2015-01-19', '+80501112233', 'Denchik', 2),
  (7, 'Nikolay Popov', '2008-01-11', '+380679998877', 'PopovN', 3);

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
