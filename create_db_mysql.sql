CREATE DATABASE `tasks` /*!40100 DEFAULT CHARACTER SET latin1 */;

CREATE TABLE `data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `text` varchar(200) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `edit` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `pass` varchar(45) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

CREATE USER 'guest'@'localhost' IDENTIFIED BY '1';

GRANT ALL PRIVILEGES ON *.* TO 'guest'@'localhost';

FLUSH PRIVILEGES;
