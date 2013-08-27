CREATE TABLE `pages` (
  `pagename` varchar(32) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`pagename`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;