-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-06-13 10:12:35
-- サーバのバージョン： 10.4.32-MariaDB
-- PHP のバージョン: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `job`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `job_table`
--

CREATE TABLE `job_table` (
  `id` int(11) NOT NULL,
  `shop_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `slogan` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `job` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `station` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `hourly` int(11) NOT NULL,
  `flag` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- テーブルのデータのダンプ `job_table`
--

INSERT INTO `job_table` (`id`, `shop_name`, `slogan`, `job`, `station`, `hourly`, `flag`) VALUES
(1, 'セブンイレブン', '明るい方歓迎！', '接客業', '東京駅', 1200, 1),
(2, 'セブンイレブン', '明るい方歓迎！', '接客業', '東京駅', 1200, 1),
(3, 'セブンイレブン', '明るい方歓迎！', '接客業', '東京駅', 1100, 1),
(4, 'セブンイレブン', '明るい方歓迎！', '接客業', '東京駅', 1100, 1),
(5, '', '', '', '', 0, 1),
(6, 'セブンイレブン', '', '', '', 0, 1),
(7, 'セブンイレブン', '', '', '', 0, 1),
(8, 'セブンイレブン', '', '', '', 0, 1),
(9, 'セブンイレブン', '明るい方歓迎！', '接客業', '東京駅', 1100, 1),
(10, 'セブンイレブン', '明るい方歓迎！', '接客業', '東京駅', 1200, 1),
(11, 'セブンイレブン', '明るい方歓迎！', '接客業', '東京駅', 1200, 1),
(12, '', '', '', '', 0, 1),
(13, '', '', '', '', 0, 1),
(14, '', '', '', '', 0, 1),
(15, '', '', '', '', 0, 1),
(16, 'セブンイレブン', '学生歓迎', '接客業', '新橋', 1300, 1),
(17, 'セブンイレブン', '学生歓迎', '接客業', '新橋', 1300, 1),
(18, 'セブンイレブン', '学生歓迎', '接客業', '新橋', 1300, 1),
(19, 'セブンイレブン', '学生歓迎', '接客業', '新橋', 1300, 1),
(20, 'セブンイレブン', '学生歓迎', '接客業', '新橋', 1300, 1),
(21, 'セブンイレブン', '学生歓迎', '接客業', '新橋', 1300, 1),
(22, 'セブンイレブン', '学生歓迎', '接客業', '新橋', 1300, 1),
(23, 'セブンイレブン', '学生歓迎', '接客業', '新橋', 1300, 1),
(24, 'セブンイレブン', '学生歓迎', '接客業', '新橋', 1300, 1),
(25, 'セブンイレブン', '学生歓迎', '接客業', '新橋', 1300, 1),
(26, 'セブンイレブン', '学生歓迎', '接客業', '新橋', 1300, 1),
(27, '', '', '', '', 0, 1),
(28, '', '', '', '', 0, 1),
(29, '', '', '', '', 0, 1),
(30, '', '', '', '', 0, 1),
(31, '', '', '', '', 0, 1),
(32, '', '', '', '', 0, 1),
(33, '', '', '', '', 0, 1),
(34, '', '', '', '', 0, 1),
(35, 'セブンイレブン', '明るい方歓迎！', '接客業', '東京駅', 1200, 1),
(36, 'セブンイレブン新橋駅南口店', '未経験者大歓迎！', 'レジ・品出し', '新橋駅', 1050, 0),
(37, 'ファミリーマート新橋駅西口店', '学生の方積極採用中！', 'レジ・品出し', '新橋駅', 1200, 0),
(38, 'スターバックスコーヒー渋谷店', '社割あり！大好きなスタバで一緒に働こう！', 'レジ・調理', '渋谷駅', 1300, 0),
(39, '鳥貴族原宿店', '賄いあり！深夜まで入れる方大歓迎！', 'ホールスタッフ', '原宿駅', 1300, 0),
(40, 'マクドナルド神田店', '一週間ごとのシフト提出で学校との両立◎', 'レジ・調理', '神田駅', 1100, 0),
(41, 'マクドナルド神田店', '一週間ごとのシフト提出で学校との両立◎', 'レジ・調理', '神田駅', 1100, 1),
(42, '', '', '', '', 0, 1),
(43, '浜本塾神田教室', '小学生の算数の授業の講師をやっていただける方募集', '塾講師', '神田駅', 1500, 0);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `job_table`
--
ALTER TABLE `job_table`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `job_table`
--
ALTER TABLE `job_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
