CREATE TABLE IF NOT EXISTS `neuro_Actu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` longtext NOT NULL,
  `message` longtext NOT NULL,
  `page` longtext NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

