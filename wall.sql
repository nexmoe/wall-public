-- Adminer 4.6.3 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE `wall` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `wall`;

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `cid` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `count` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `category` (`cid`, `name`, `description`, `count`) VALUES
(2333,	'表白',	NULL,	0),
(2334,	'失物招领',	NULL,	0),
(2335,	'安利',	NULL,	0),
(2336,	'默认分类',	NULL,	0),
(2337,	'寻物启事',	NULL,	0);

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `coid` int(10) NOT NULL AUTO_INCREMENT,
  `mid` int(10) NOT NULL,
  `author` varchar(20) NOT NULL,
  `text` mediumtext NOT NULL,
  `time` int(15) NOT NULL,
  `parent` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`coid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `comment` (`coid`, `mid`, `author`, `text`, `time`, `parent`) VALUES
(2333,	2333,	'776194970',	'加快了第二次打开的速度',	1550993439,	0),
(2334,	2333,	'776194970',	'❤',	1550994000,	0),

DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `mid` int(10) NOT NULL AUTO_INCREMENT,
  `cid` int(10) NOT NULL,
  `author` varchar(20) NOT NULL,
  `article` mediumtext NOT NULL,
  `time` int(15) NOT NULL,
  `anonymous` varchar(10) NOT NULL DEFAULT 'false',
  PRIMARY KEY (`mid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `message` (`mid`, `cid`, `author`, `article`, `time`, `anonymous`) VALUES
(2333,	2333,	'776194970',	'[{\"type\":\"p\",\"text\":\"\\u6211\\u6c38\\u8fdc\\u559c\\u6b22\\u53cb\\u5229\\u5948\\u7eea\\uff01\\uff01\"},{\"type\":\"img\",\"text\":\"https:\\/\\/i.loli.net\\/2019\\/02\\/05\\/5c59887eda177.jpg\"}]',	1549371606,	'false'),
DROP TABLE IF EXISTS `notice`;
CREATE TABLE `notice` (
  `inid` int(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` int(15) NOT NULL,
  `mid` int(10) NOT NULL,
  `coid` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `read` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'false',
  PRIMARY KEY (`inid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `notice` (`inid`, `type`, `time`, `mid`, `coid`, `uid`, `read`) VALUES
(2333,	'reply',	1550941664,	2333,	2333,	776194970,	'false'),
(2334,	'reply',	1550941664,	2333,	2334,	776194970,	'false'),


-- 2019-04-06 08:12:19
