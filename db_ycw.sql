-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017 年 11 月 15 日 13:38
-- 服务器版本: 5.6.13
-- PHP 版本: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `db_ycw`
--
CREATE DATABASE IF NOT EXISTS `db_ycw` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_ycw`;

-- --------------------------------------------------------

--
-- 表的结构 `task_info`
--

CREATE TABLE IF NOT EXISTS `task_info` (
  `id` varchar(128) NOT NULL COMMENT '任务id',
  `payType` varchar(128) NOT NULL COMMENT '付款方式',
  `platformName` varchar(128) NOT NULL COMMENT '平台名称',
  `shopName` varchar(128) NOT NULL COMMENT '店铺名称',
  `equipment` varchar(128) NOT NULL COMMENT '设备',
  `keywords` varchar(128) NOT NULL COMMENT '搜索关键词',
  `infoLogo` varchar(128) NOT NULL COMMENT '店外截图',
  `shopLogo` varchar(128) NOT NULL COMMENT '店内截图',
  `linkAddress` varchar(128) NOT NULL COMMENT '商品链接地址',
  `credibilityLevel` varchar(128) NOT NULL COMMENT '买号信誉等级要求',
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务详情字段';

-- --------------------------------------------------------

--
-- 表的结构 `user_account`
--

CREATE TABLE IF NOT EXISTS `user_account` (
  `account` varchar(128) NOT NULL COMMENT '账号',
  `password` varchar(128) NOT NULL COMMENT '密码',
  `telephone` varchar(128) NOT NULL COMMENT '用户手机号',
  `userType` varchar(128) NOT NULL DEFAULT '0' COMMENT '用户类型（商家0/刷手1）',
  PRIMARY KEY (`telephone`),
  UNIQUE KEY `telephone` (`telephone`),
  UNIQUE KEY `account_2` (`account`),
  KEY `account` (`account`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_account`
--

INSERT INTO `user_account` (`account`, `password`, `telephone`, `userType`) VALUES
('admin', '123456', '15527744217', '0'),
('root', 'abcdefg', '15527744218', '0'),
('xujinkai', '123456', '15527744219', '0'),
('xujinkai1', '123456', '15527744229', '1'),
('liuweimei', '123456', '15527744221', '1');

-- --------------------------------------------------------

--
-- 表的结构 `user_email`
--

CREATE TABLE IF NOT EXISTS `user_email` (
  `telephone` varchar(128) NOT NULL DEFAULT '' COMMENT '手机号',
  `email` varchar(128) DEFAULT NULL COMMENT '邮箱'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_email`
--

INSERT INTO `user_email` (`telephone`, `email`) VALUES
('15527744229', '1013204440@qq.com'),
('15527744221', '1013204440@qq.com');

-- --------------------------------------------------------

--
-- 表的结构 `user_info`
--

CREATE TABLE IF NOT EXISTS `user_info` (
  `telephone` varchar(128) NOT NULL COMMENT '手机号',
  `payword` varchar(128) NOT NULL DEFAULT '123456' COMMENT '支付密码',
  `qq` varchar(128) DEFAULT NULL COMMENT 'QQ号',
  `leader` varchar(128) DEFAULT NULL COMMENT '推荐人',
  `nickname` varchar(128) DEFAULT NULL COMMENT '昵称',
  PRIMARY KEY (`telephone`),
  UNIQUE KEY `telephone` (`telephone`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_info`
--

INSERT INTO `user_info` (`telephone`, `payword`, `qq`, `leader`, `nickname`) VALUES
('15527744219', '123456', '1137293945', '', ''),
('15527744229', '123456', '1137293945', 'liudong', 'å¾è¿›å‡¯'),
('15527744221', '123456', '1137293945', 'liudong', 'åˆ˜ä¼Ÿæ¢…');

-- --------------------------------------------------------

--
-- 表的结构 `user_task`
--

CREATE TABLE IF NOT EXISTS `user_task` (
  `id` varchar(128) NOT NULL COMMENT '任务id',
  `name` varchar(128) NOT NULL COMMENT '任务名称',
  `author` varchar(128) NOT NULL COMMENT '发布人',
  UNIQUE KEY `任务id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户任务列表';

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
