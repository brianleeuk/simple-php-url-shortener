-- URL Shortener SQL Dump
START TRANSACTION;

-- Database: `url-shortener`
CREATE DATABASE IF NOT EXISTS `url_shortener` DEFAULT CHARACTER SET utf8mb4;
USE `url_shortener`;

-- Table structure for table `decode`
CREATE TABLE `decode` (
  `id` int UNSIGNED NOT NULL,
  `url` text CHARACTER SET utf8mb4 NOT NULL,
  `uri` varchar(6) CHARACTER SET utf8mb4 NOT NULL,
  `hits` int UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Indexes for table `decode`
ALTER TABLE `decode`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`,`uri`);

-- AUTO_INCREMENT for table `decode`
ALTER TABLE `decode`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;