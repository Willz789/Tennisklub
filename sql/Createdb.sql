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
    `role` INT NOT NULL,
    `birthday` VARCHAR(40) NOT NULL
);

CREATE TABLE `courts`(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `court_number` INT NOT NULL,
    `time` VARCHAR(255) NOT NULL
);

CREATE TABLE `bookings`(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `court_id` INT NOT NULL
);

CREATE TABLE `teams`(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `trainer_user_id` INT NOT NULL
);

CREATE TABLE `team_members`(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `team_id` INT NOT NULL
);

INSERT INTO `users`(`username`, `password`, `phonenumber`, `mail`, `name`, `ranking`, `role`, `birthday`) VALUES (
    'William',
    '$2y$10$aqFnpecTrsohwx8bR.TZAuBYlhzXdFuLbfgDtQPZggtIuSAS.BOq2',
    '12345678',
    '@williammistarz@gmail.com',
    'William Egholm Mistarz',
    '10',
    '2',
    '01/10/2002'
);
INSERT INTO `users`(`username`, `password`, `phonenumber`, `mail`, `name`, `ranking`, `role`, `birthday`) VALUES (
    'Lucas',
    '$2y$10$aqFnpecTrsohwx8bR.TZAuBYlhzXdFuLbfgDtQPZggtIuSAS.BOq2',
    '12345678',
    '@lucassylvester02@gmail.com',
    'Lucas Sylvester',
    '10',
    '2',
    '23/03/2002'
);
INSERT INTO `users`(`username`, `password`, `phonenumber`, `mail`, `name`, `ranking`, `role`, `birthday`) VALUES (
    'Asger',
    '$2y$10$aqFnpecTrsohwx8bR.TZAuBYlhzXdFuLbfgDtQPZggtIuSAS.BOq2',
    '12345678',
    '@asger2860@gmail.com',
    'Asger Dyrholm',
    '10',
    '2',
    '11/01/2002'
);