-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2022-03-23 05:19:15
-- 伺服器版本： 10.4.18-MariaDB
-- PHP 版本： 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `chuanshin_db`
--

-- --------------------------------------------------------

--
-- 資料表結構 `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `pnum` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT '商品編號',
  `pname` varchar(128) NOT NULL COMMENT '產品名稱',
  `price` int(11) UNSIGNED NOT NULL COMMENT '價格',
  `sprice` int(10) UNSIGNED NOT NULL COMMENT '特惠價',
  `cost` int(11) NOT NULL COMMENT '成本價',
  `sdate` date DEFAULT NULL COMMENT '優惠到期日',
  `opts` varchar(1000) DEFAULT NULL COMMENT '選項',
  `main_id` int(11) UNSIGNED NOT NULL COMMENT '主類別',
  `sub_id` int(11) UNSIGNED DEFAULT NULL COMMENT '次類別',
  `images` text CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL COMMENT '圖片連結',
  `info_images` text CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL COMMENT '說明圖',
  `info` longtext DEFAULT NULL COMMENT '圖文介紹',
  `youtube` text CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL COMMENT '影片網址',
  `stock` int(11) NOT NULL COMMENT '庫存',
  `buy_limited` int(10) UNSIGNED NOT NULL COMMENT '購買數量限制',
  `volume` int(11) NOT NULL COMMENT '售出量',
  `related_items` varchar(256) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL COMMENT '關聯商品',
  `opt_asign` tinyint(4) NOT NULL COMMENT '規格配圖',
  `status` tinyint(4) NOT NULL COMMENT '狀態0:正常, 1:隱藏',
  `views` int(11) NOT NULL COMMENT '開啟次數',
  `cdate` datetime NOT NULL COMMENT '上架日期'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `products`
--

INSERT INTO `products` (`id`, `pnum`, `pname`, `price`, `sprice`, `cost`, `sdate`, `opts`, `main_id`, `sub_id`, `images`, `info_images`, `info`, `youtube`, `stock`, `buy_limited`, `volume`, `related_items`, `opt_asign`, `status`, `views`, `cdate`) VALUES
(23, 'P00002', '滴雞精包裝', 120, 0, 20, NULL, '包', 18, NULL, 'http://127.0.0.1/D/images/jdpro.jpg', '???', '<p style=\"text-align: center;\">全家取貨付款 — 單件運費$60、消費滿$1000免運費</p><p style=\"text-align: center;\"><br></p>', NULL, 10000, 0, 0, NULL, 0, 0, 0, '2022-01-03 21:58:00'),
(24, 'P00003', '滴雞精包裝-2', 120, 0, 20, NULL, '包', 18, NULL, 'http://127.0.0.1/D/images/jdpro.jpg', '???', '<p style=\"text-align: center;\">全家取貨付款 — 單件運費$60、消費滿$1000免運費</p><p style=\"text-align: center;\"><br></p>', NULL, 10000, 0, 0, NULL, 0, 0, 0, '2022-01-03 21:58:00');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
