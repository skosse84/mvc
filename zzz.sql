CREATE TABLE `data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `text` varchar(200) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `edit` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
)  AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `pass` varchar(45) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
)  AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;



INSERT INTO `users`
(`name`,
`pass`,
`status`)
VALUES
('admin',
'123',
0);