# xno.li
The official sourcecode for [xno.li](http://xno.li), based upon some open source code that I found somewhere. But I can't seem to find it right now, if anyone does, tell me so I can give credit!



## Installation
Clone this, copy config.sample.php to config.php and edit the settings, setup a new database using the code below:

```sql
CREATE TABLE IF NOT EXISTS `shortenedurls` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `long_url` varchar(255) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `creator` char(15) NOT NULL,
  `referrals` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `long` (`long_url`),
  KEY `referrals` (`referrals`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
```
