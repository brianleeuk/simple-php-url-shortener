-- URL Shortener SQL Dump

-- Database: `url-shortener`
CREATE DATABASE IF NOT EXISTS `url-shortener` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `url-shortener`;

-- Table structure for table `decode`
CREATE TABLE `decode` (
  `id` int UNSIGNED NOT NULL,
  `url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `uri` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `hits` int UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Indexes for table `decode`
ALTER TABLE `decode`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`,`uri`);

-- AUTO_INCREMENT for table `decode`
ALTER TABLE `decode`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;