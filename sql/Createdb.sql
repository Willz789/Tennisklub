DROP DATABASE IF EXISTS `tennis_club`;
CREATE DATABASE `tennis_club`;
USE `tennis_club`;

CREATE TABLE `users`(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `phonenumber` INT NOT NULL,
    `mail` VARCHAR(255) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `ranking` INT,
    `role` VARCHAR(20) NOT NULL
);

CREATE TABLE `courts`(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `court_number` INT NOT NULL,
    `time` VARCHAR(255) NOT NULL
);

CREATE TABLE `bookings`(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL SECONDARY KEY,
    `court_id` INT NOT NULL SECONDARY KEY
);

CREATE TABLE `teams`(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `trainer_user_id` INT NOT NULL SECONDARY KEY
);

CREATE TABLE `team_members`(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL SECONDARY KEY,
    `team_id` INT NOT NULL SECONDARY KEY
);