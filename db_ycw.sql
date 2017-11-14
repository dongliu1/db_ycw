-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-11-14 06:44:47
-- 服务器版本： 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ycw`
--

-- --------------------------------------------------------

--
-- 表的结构 `user_account`
--

CREATE TABLE `user_account` (
  `account` varchar(128) NOT NULL COMMENT '账号',
  `password` varchar(128) NOT NULL COMMENT '密码',
  `telephone` varchar(128) NOT NULL COMMENT '用户手机号',
  `userType` varchar(128) NOT NULL DEFAULT '0' COMMENT '用户类型（商家0/刷手1）'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_account`
--

INSERT INTO `user_account` (`account`, `password`, `telephone`, `userType`) VALUES
('admin', '123456', '15527744217', '0'),
('root', 'abcdefg', '15527744218', '0'),
('xujinkai', '123456', '15527744219', '0'),
('xujinkai1', '123456', '15527744229', '1');

-- --------------------------------------------------------

--
-- 表的结构 `user_email`
--

CREATE TABLE `user_email` (
  `telephone` varchar(128) NOT NULL DEFAULT '' COMMENT '手机号',
  `email` varchar(128) DEFAULT NULL COMMENT '邮箱'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_email`
--

INSERT INTO `user_email` (`telephone`, `email`) VALUES
('15527744229', '1013204440@qq.com');

-- --------------------------------------------------------

--
-- 表的结构 `user_info`
--

CREATE TABLE `user_info` (
  `telephone` varchar(128) NOT NULL COMMENT '手机号',
  `payword` varchar(128) NOT NULL DEFAULT '123456' COMMENT '支付密码',
  `qq` varchar(128) DEFAULT NULL COMMENT 'QQ号',
  `leader` varchar(128) DEFAULT NULL COMMENT '推荐人',
  `nickname` varchar(128) DEFAULT NULL COMMENT '昵称'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_info`
--

INSERT INTO `user_info` (`telephone`, `payword`, `qq`, `leader`, `nickname`) VALUES
('15527744219', '123456', '1137293945', '', ''),
('15527744229', '123456', '1137293945', 'liudong', 'å¾è¿›å‡¯');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`telephone`),
  ADD UNIQUE KEY `telephone` (`telephone`),
  ADD UNIQUE KEY `account_2` (`account`),
  ADD KEY `account` (`account`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`telephone`),
  ADD UNIQUE KEY `telephone` (`telephone`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
