<?php
/*
 * First authored by Brian Cray
 * License: http://creativecommons.org/licenses/by/3.0/
 * Contact the author at http://briancray.com/
 */

ini_set('display_errors', 0);

// shorturl
$shorturl = "";

// 0 = redirect, 1 = preview, 2 = referrals
$urltype = 0;

// determine what action we're handling
if(isset($_GET['url'])) {
	$shorturl = $_GET['url'];
	$urltype = 0;
}elseif(isset($_GET['preview'])) {
	$shorturl = $_GET['preview'];
	$urltype = 1;
}elseif(isset($_GET['referrals'])) {
	$shorturl = $_GET['referrals'];
	$urltype = 2;
}else{
	die("That is not a valid command");
}

// validate $shorturl
if(!preg_match('|^[0-9a-zA-Z]{1,6}$|', $shorturl))
{
	die('That is not a valid short url');
}

// include config :)
require('config.php');

// get the numbered ID
$shortened_id = getIDFromShortenedURL($shorturl);

// caching functions
if(CACHE)
{
	$variable = file_get_contents(CACHE_DIR . $shortened_id);
	if(empty($variable) || !preg_match('|^https?://|', $variable))
	{
		// note the separator between SELECT referrals and SELECT long_url
		$variable = mysql_result(mysql_query('SELECT '.( $urltype == 2 ? 'referrals' : 'long_url').' FROM ' . DB_TABLE . ' WHERE id="' . mysql_real_escape_string($shortened_id) . '"'), 0, 0);
		@mkdir(CACHE_DIR, 0777); // is it really OK that this is 777?
		$handle = fopen(CACHE_DIR . $shortened_id, 'w+');
		fwrite($handle, $variable);
		fclose($handle);
	}
}else{
	// ordinary MySQL query
	// note the separator between SELECT referrals and SELECT long_url
	$variable = mysql_result(mysql_query('SELECT '.( $urltype == 2 ? 'referrals' : 'long_url').' FROM ' . DB_TABLE . ' WHERE id="' . mysql_real_escape_string($shortened_id) . '"'), 0, 0);
}

// tracking referrals
if(TRACK && $urltype == 0){
	mysql_query('UPDATE ' . DB_TABLE . ' SET referrals=referrals+1 WHERE id="' . mysql_real_escape_string($shortened_id) . '"');
}

// if it's an invalid url 
if(trim($variable)==""){
	if($urltype == 0){
		$variable = BASE_HREF;
	}else{
		die("");
	}
}

// handle the request
if($urltype == 0){
	header('HTTP/1.1 301 Moved Permanently');
	header('Location: ' .  $variable);
	exit;
}elseif($urltype == 1 or $urltype == 2){
	die($variable);
}

// getIDFromShortenedURL function
function getIDFromShortenedURL($string, $base = ALLOWED_CHARS)
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