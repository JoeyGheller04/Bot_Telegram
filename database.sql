CREATE DATABASE IF NOT EXISTS telegram_bot;

USE telegram_bot;

CREATE TABLE `records`(
	`id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `username` varchar(120) NOT NULL,
    `chatId` varchar(120) NOT NULL,
    `command` varchar(150) NOT NULL,
    `reply` varchar(150) NOT NULL
);