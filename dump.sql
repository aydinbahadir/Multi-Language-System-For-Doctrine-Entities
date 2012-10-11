SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `bbr_translation`
-- ----------------------------
DROP TABLE IF EXISTS `bbr_translation`;
CREATE TABLE `bbr_translation` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT 'System given identifier.',
  `table` varchar(155) collate utf8_turkish_ci NOT NULL COMMENT 'Name of database table to be translated.',
  `column` varchar(155) collate utf8_turkish_ci NOT NULL COMMENT 'Name of database column to be translated.',
  `row` int(15) NOT NULL COMMENT 'Row id of database table to be translated.',
  `translation` text collate utf8_turkish_ci NOT NULL COMMENT 'Translation.',
  `language_id` int(5) unsigned NOT NULL COMMENT 'Language of translation.',
  PRIMARY KEY  (`id`),
  KEY `TranslationLanguage` (`language_id`),
  CONSTRAINT `TranslationLanguage` FOREIGN KEY (`language_id`) REFERENCES `bbr_language` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci COMMENT='Stores database translations.';

-- ----------------------------
-- Table structure for `bbr_language`
-- ----------------------------
DROP TABLE IF EXISTS `bbr_language`;
CREATE TABLE `bbr_language` (
  `id` int(5) unsigned NOT NULL auto_increment COMMENT 'System given identifier.',
  `name` varchar(255) collate utf8_turkish_ci NOT NULL COMMENT 'Name of language.',
  `name_safe` varchar(255) collate utf8_turkish_ci NOT NULL COMMENT 'URL identifier of name.',
  `iso_code` varchar(5) collate utf8_turkish_ci NOT NULL COMMENT 'Iso code of language.',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `LanguageISOCode` (`iso_code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci COMMENT='Stores a list of languages.';
