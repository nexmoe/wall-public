SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `cid` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `count` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `category` (`cid`, `name`, `description`, `count`) VALUES
(2333,	'表白',	'表白，或称告白意为向他人表示自己的想法或心意，特指表达爱意，又称示爱，在这种情况下通常被认为是建立恋爱关系的方式。',	0),
(2334,	'失物招领',	NULL,	0),
(2335,	'安利',	NULL,	0),
(2336,	'默认分类',	NULL,	0),
(2337,	'寻物启事',	NULL,	0);

SET NAMES utf8mb4;

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
(2333,	2403,	'776194970',	'意见反馈区',	1549544960,	0);

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
(2403,	2336,	'776194970',	'[{\"type\":\"p\",\"text\":\"\\u610f\\u89c1\\u53cd\\u9988\\uff0c\"},{\"type\":\"p\",\"text\":\"\\u5173\\u4e8eAPP\\u7684\\u610f\\u89c1\\u8bf7\\u5728\\u8fd9\\u91cc\\u53cd\\u9988\\u3002\"}]',	0,	'false');

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

INSERT INTO `notice` (`inid`, `type`, `time`, `mid`, `coid`, `uid`, `read`);