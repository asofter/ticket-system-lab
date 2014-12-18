-- phpMyAdmin SQL Dump
-- version 4.0.10
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 03 2014 г., 09:23
-- Версия сервера: 5.5.38-log
-- Версия PHP: 5.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `tickets`
--

-- --------------------------------------------------------

--
-- Структура таблицы `stations`
--

CREATE TABLE IF NOT EXISTS `stations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(135) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `stations`
--

INSERT INTO `stations` (`id`, `name`) VALUES
(1, 'Київ'),
(2, 'Чернівці'),
(3, 'Львів'),
(4, 'Хмельницький'),
(5, 'Харьків'),
(6, 'Одеса');

-- --------------------------------------------------------

--
-- Структура таблицы `tickets`
--

CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `train_id` int(11) NOT NULL,
  `from_station_id` int(11) NOT NULL,
  `to_station_id` int(11) NOT NULL,
  `status` smallint(2) NOT NULL DEFAULT '0',
  `pay_method` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `tickets`
--

INSERT INTO `tickets` (`id`, `user_id`, `created_at`, `updated_at`, `date`, `train_id`, `from_station_id`, `to_station_id`, `status`, `pay_method`) VALUES
(1, 1, 1417549164, 1417549164, '2014-12-17', 1, 2, 1, 1, 1),
(2, 1, 1417584152, 1417584152, '2014-12-17', 1, 2, 1, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `trains`
--

CREATE TABLE IF NOT EXISTS `trains` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `train_number` varchar(35) NOT NULL,
  `places_count` int(8) NOT NULL DEFAULT '0',
  `cars_count` int(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `trains`
--

INSERT INTO `trains` (`id`, `train_number`, `places_count`, `cars_count`) VALUES
(1, '608', 300, 4),
(2, '609', 200, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `train_prices`
--

CREATE TABLE IF NOT EXISTS `train_prices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_train_station_id` int(11) NOT NULL,
  `price` int(8) NOT NULL DEFAULT '0',
  `to_train_station_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Дамп данных таблицы `train_prices`
--

INSERT INTO `train_prices` (`id`, `from_train_station_id`, `price`, `to_train_station_id`) VALUES
(1, 1, 380, 3),
(2, 1, 80, 2),
(3, 3, 380, 1),
(4, 2, 80, 1),
(5, 3, 360, 1),
(6, 2, 120, 3),
(7, 3, 120, 2),
(8, 4, 120, 5),
(9, 5, 120, 4),
(10, 4, 600, 6),
(11, 6, 600, 4),
(12, 5, 400, 6),
(13, 6, 400, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `train_schedule`
--

CREATE TABLE IF NOT EXISTS `train_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `train_station_id` int(11) NOT NULL,
  `time` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `train_schedule`
--

INSERT INTO `train_schedule` (`id`, `train_station_id`, `time`) VALUES
(1, 1, '18:46:00'),
(2, 2, '00:40:00'),
(3, 3, '08:20:00'),
(4, 4, '19:45:00'),
(5, 5, '03:45:00'),
(6, 6, '14:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `train_stations`
--

CREATE TABLE IF NOT EXISTS `train_stations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `train_id` int(11) NOT NULL,
  `station_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `train_stations`
--

INSERT INTO `train_stations` (`id`, `train_id`, `station_id`) VALUES
(1, 1, 2),
(2, 1, 4),
(3, 1, 1),
(4, 2, 2),
(5, 2, 3),
(6, 2, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(32) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `role` int(11) NOT NULL DEFAULT '2',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL DEFAULT '',
  `last_name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `role`, `created_at`, `updated_at`, `first_name`, `last_name`) VALUES
(1, '1uXQXYV6PioTrG5tzEt9RLfVKPfywFYb', '$2y$13$YnuWdRdBaK34M2Pb58kAcuJ/X9YuYsHnSO5uzlvTVCO0PGasKqTNK', NULL, 'alwex10@gmail.com', 2, 1417549119, 1417549119, 'Alexander', 'Yaremchuk');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
