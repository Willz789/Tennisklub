/* Droppper den tidligere database og skaber en ny */
DROP DATABASE IF EXISTS `tennis_club`;
CREATE DATABASE `tennis_club`;
USE `tennis_club`; 

/* Skaber tabeller til databasen. */

/* Tabel med brugere */
CREATE TABLE `users`(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(255) NOT NULL,
    `password_hash` VARCHAR(255) NOT NULL,
    `phonenumber` INT NOT NULL,
    `mail` VARCHAR(255) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `ranking_points` INT,
    `role` INT NOT NULL,
    `birthday` VARCHAR(40) NOT NULL
);


/* Tabel med baner der kan bookes. */
CREATE TABLE `courts`(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `court_number` INT NOT NULL,
    `date` VARCHAR(255) NOT NULL,
    `time` VARCHAR(255) NOT NULL
);


/* Tabel med opslag til forum. */
CREATE TABLE `information`(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `opslag` BLOB
);


/* Joins mellem baner der kan bookes og brugere som har booket dem. */
CREATE TABLE `bookings`(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `court_id` INT NOT NULL
);


/* Tabel med hold man kan tilmeld sig. */
CREATE TABLE `teams`(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `trainer_user_id` INT NOT NULL,
    `minBirthYear` INT
);


/* Joins mellem hold der kan tilmeldes */
CREATE TABLE `team_members`(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `team_id` INT NOT NULL
);


/* Indsætter nogle standard admin-brugere. */
INSERT INTO `users`(`username`, `password_hash`, `phonenumber`, `mail`, `name`, `ranking_points`, `role`, `birthday`) VALUES (
    'William',
    '$2y$10$aqFnpecTrsohwx8bR.TZAuBYlhzXdFuLbfgDtQPZggtIuSAS.BOq2',
    '12345678',
    'williammistarz@gmail.com',
    'William Egholm Mistarz',
    '8',
    '2',
    '01/10/2002'
);
INSERT INTO `users`(`username`, `password_hash`, `phonenumber`, `mail`, `name`, `ranking_points`, `role`, `birthday`) VALUES (
    'Lucas',
    '$2y$10$aqFnpecTrsohwx8bR.TZAuBYlhzXdFuLbfgDtQPZggtIuSAS.BOq2',
    '12345678',
    'lucassylvester02@gmail.com',
    'Lucas Sylvester',
    '10',
    '2',
    '23/03/2002'
);
INSERT INTO `users`(`username`, `password_hash`, `phonenumber`, `mail`, `name`, `ranking_points`, `role`, `birthday`) VALUES (
    'Asger',
    '$2y$10$aqFnpecTrsohwx8bR.TZAuBYlhzXdFuLbfgDtQPZggtIuSAS.BOq2',
    '12345678',
    'asger2860@gmail.com',
    'Asger Dyrholm',
    '12',
    '2',
    '11/01/2002'
);


/* Et hold man kan tilmelde sig. */
INSERT INTO `teams`(`name`, `trainer_user_id`, `minBirthYear`) VALUES (
    'Juniors',
    '2',
    '2002'
);


/* Har tilføjet nogle students til holdet */
INSERT INTO `team_members`(`user_id`, `team_id`) VALUES (
    '1',
    '1'
);
INSERT INTO `team_members`(`user_id`, `team_id`) VALUES (
    '3',
    '1'
);