-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-11-22 03:18:33
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
-- 表的结构 `deal_records`
--

CREATE TABLE `deal_records` (
  `userid` varchar(128) NOT NULL COMMENT '用户id，默认为手机号',
  `dealType` varchar(128) NOT NULL DEFAULT '1' COMMENT '交易类型（0充值/1消费）',
  `dealTime` varchar(128) NOT NULL COMMENT '交易时间',
  `dealAmount` varchar(128) NOT NULL COMMENT '交易金额'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='交易记录';

-- --------------------------------------------------------

--
-- 表的结构 `task_code`
--

CREATE TABLE `task_code` (
  `id` varchar(128) CHARACTER SET utf8 COLLATE utf8_german2_ci NOT NULL COMMENT '任务id',
  `code` varchar(128) NOT NULL COMMENT '地区编码'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='任务地区表';

-- --------------------------------------------------------

--
-- 表的结构 `task_info`
--

CREATE TABLE `task_info` (
  `id` varchar(128) NOT NULL COMMENT '任务id',
  `payType` varchar(128) NOT NULL COMMENT '付款方式',
  `platformName` varchar(128) NOT NULL COMMENT '平台名称',
  `shopName` varchar(128) NOT NULL COMMENT '店铺名称',
  `equipment` varchar(128) NOT NULL COMMENT '设备',
  `fileUrl` varchar(128) NOT NULL COMMENT '任务图片路径',
  `linkAddress` varchar(128) NOT NULL COMMENT '商品链接地址',
  `credibilityLevel` varchar(128) NOT NULL COMMENT '买号信誉等级要求',
  `taskCommission` varchar(128) NOT NULL COMMENT '任务佣金'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务详情字段';

-- --------------------------------------------------------

--
-- 表的结构 `task_keyword`
--

CREATE TABLE `task_keyword` (
  `id` varchar(128) NOT NULL COMMENT '任务id',
  `keyword` varchar(128) NOT NULL COMMENT '关键词'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='任务关键词';

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

-- --------------------------------------------------------

--
-- 表的结构 `user_email`
--

CREATE TABLE `user_email` (
  `telephone` varchar(128) NOT NULL DEFAULT '' COMMENT '手机号',
  `email` varchar(128) DEFAULT NULL COMMENT '邮箱'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user_info`
--

CREATE TABLE `user_info` (
  `telephone` varchar(128) NOT NULL COMMENT '手机号',
  `payword` varchar(128) NOT NULL DEFAULT '123456' COMMENT '支付密码',
  `qq` varchar(128) DEFAULT NULL COMMENT 'QQ号',
  `leader` varchar(128) DEFAULT NULL COMMENT '推荐人',
  `nickname` varchar(128) DEFAULT NULL COMMENT '昵称',
  `asset` varchar(128) NOT NULL DEFAULT '0' COMMENT '用户资产'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user_task`
--

CREATE TABLE `user_task` (
  `id` varchar(128) NOT NULL COMMENT '任务id',
  `taskName` varchar(128) NOT NULL COMMENT '任务名称',
  `author` varchar(128) NOT NULL COMMENT '发布人'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户任务列表';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `task_info`
--
ALTER TABLE `task_info`
  ADD UNIQUE KEY `id` (`id`);

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

--
-- Indexes for table `user_task`
--
ALTER TABLE `user_task`
  ADD UNIQUE KEY `任务id` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
