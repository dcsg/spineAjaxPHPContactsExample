DROP TABLE IF EXISTS `contacts`;

CREATE TABLE `contacts` (
  `id` varchar(256) NOT NULL DEFAULT '',
  `name` varchar(256) DEFAULT '',
  `email` varchar(256) DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
