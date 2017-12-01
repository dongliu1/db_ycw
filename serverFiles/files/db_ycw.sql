-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2017-12-01 03:44:15
-- 服务器版本： 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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

--
-- 转存表中的数据 `task_code`
--

INSERT INTO `task_code` (`id`, `code`) VALUES
('liudong_1512047010634', '201'),
('liudong_1512047010634', '302');

-- --------------------------------------------------------

--
-- 表的结构 `task_info`
--

CREATE TABLE `task_info` (
  `id` varchar(128) NOT NULL COMMENT '任务id',
  `payType` varchar(128) NOT NULL COMMENT '付款方式',
  `platformType` varchar(128) NOT NULL COMMENT '平台名称',
  `shopName` varchar(128) NOT NULL COMMENT '店铺名称',
  `equipment` varchar(128) NOT NULL COMMENT '设备',
  `fileUrl` varchar(128) NOT NULL COMMENT '任务图片路径',
  `linkAddress` varchar(128) NOT NULL COMMENT '商品链接地址',
  `credibilityLevel` varchar(128) NOT NULL COMMENT '买号信誉等级要求',
  `taskCommission` varchar(128) NOT NULL COMMENT '任务佣金',
  `integral` varchar(128) CHARACTER SET utf32 NOT NULL COMMENT '任务点数',
  `timeOfReceipt` varchar(128) CHARACTER SET utf32 NOT NULL COMMENT '好评时间要求',
  `commentOfReceipt` varchar(128) NOT NULL COMMENT '好评内容要求',
  `orders` varchar(128) NOT NULL COMMENT '任务执行状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务详情字段';

--
-- 转存表中的数据 `task_info`
--

INSERT INTO `task_info` (`id`, `payType`, `platformType`, `shopName`, `equipment`, `fileUrl`, `linkAddress`, `credibilityLevel`, `taskCommission`, `integral`, `timeOfReceipt`, `commentOfReceipt`, `orders`) VALUES
('liudong_1512047010634', '1', '2', '三只松鼠', '1', 'http://localhost/ycw/serverFiles/img/mi.png', 'http://www.baidu.com', 'LV5', '50', '8.1', '10天内', 'lv2以上', '1');

-- --------------------------------------------------------

--
-- 表的结构 `task_keyword`
--

CREATE TABLE `task_keyword` (
  `id` varchar(128) NOT NULL COMMENT '任务id',
  `keyword` varchar(128) NOT NULL COMMENT '关键词'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='任务关键词';

--
-- 转存表中的数据 `task_keyword`
--

INSERT INTO `task_keyword` (`id`, `keyword`) VALUES
('liudong_1512047010634', '坚果'),
('liudong_1512047010634', '核桃');

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
('liudong', '123456', '15527744217', '1'),
('xujinkai', 'admin', '15787845679', '1');

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
('15527744217', 'Array'),
('15787845679', '1013204440@qq.com');

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

--
-- 转存表中的数据 `user_info`
--

INSERT INTO `user_info` (`telephone`, `payword`, `qq`, `leader`, `nickname`, `asset`) VALUES
('15527744217', '520131', '1137293945', '徐进凯', 'liudong', '0'),
('15787845679', '123456', '1013204440', 'liudong', 'xujinkai', '0');

-- --------------------------------------------------------

--
-- 表的结构 `user_task`
--

CREATE TABLE `user_task` (
  `id` varchar(128) NOT NULL COMMENT '任务id',
  `taskName` varchar(128) NOT NULL COMMENT '任务名称',
  `modifiTime` varchar(128) NOT NULL COMMENT '发布时间',
  `author` varchar(128) NOT NULL COMMENT '发布人'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户任务列表';

--
-- 转存表中的数据 `user_task`
--

INSERT INTO `user_task` (`id`, `taskName`, `modifiTime`, `author`) VALUES
('liudong_1512047010634', '衣品天成', '1512047010634', 'liudong');

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
