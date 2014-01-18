<?php
/*
 * First authored by Brian Cray
 * License: http://creativecommons.org/licenses/by/3.0/
 * Contact the author at http://briancray.com/
 */

ini_set('display_errors', 0);

if(!preg_match('|^[0-9a-zA-Z]{1,6}$|', $_GET['url']))
{
	die('That is not a valid short url');
}

require('config.php');

$shortened_id = getIDFromShortenedURL($_GET['url']);

if(CACHE)
{
	$referrals = file_get_contents(CACHE_DIR . $shortened_id);
	if(empty($referrals) || !preg_match('|^https?://|', $referrals))
	{
		$referrals = mysql_result(mysql_query('SELECT referrals FROM ' . DB_TABLE . ' WHERE id="' . mysql_real_escape_string($shortened_id) . '"'), 0, 0);
		@mkdir(CACHE_DIR, 0777);
		$handle = fopen(CACHE_DIR . $shortened_id, 'w+');
		fwrite($handle, $referrals);
		fclose($handle);
	}
}
else
{
	$referrals = mysql_result(mysql_query('SELECT referrals FROM ' . DB_TABLE . ' WHERE id="' . mysql_real_escape_string($shortened_id) . '"'), 0, 0);
}

die($referrals);

function getIDFromShortenedURL ($string, $base = ALLOWED_CHARS)
{
	$length = strlen($base);
	$size = strlen($string) - 1;
	$string = str_split($string);
	$out = strpos($base, array_pop($string));
	foreach($string as $i => $char)
	{
		$out += strpos($base, $char) * pow($length, $size - $i);
	}
	return $out;
}