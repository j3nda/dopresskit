<?php
echo "<pre>
This file is OBSOLETE and also some development is needed.

Some features are still missing, eg:
- check-n-distribute key-files (and/or download them)

- press-can-request-copy is true, so template-update is needed,
  @see: release.php for whole section about \"Request Press Copy\"
  ~ elseif (isset(\$press_request_outdated_warning) && \$press_request_outdated_warning === true):

- case(promoter): @from this file.
";
exit;
if( file_exists('install.php') )
{
	header("Location: install.php");
	exit;
}

$game = $_GET['p'];

// Language logic

include 'lang/TranslateTool.php';
$language = TranslateTool::loadLanguage(isset($_GET['l']) ? $_GET['l'] : null, 'sheet.php');
$languageQuery = ($language != TranslateTool::getDefaultLanguage() ? '?l='. $language : '');

if (file_exists($game.'/data-'. $language .'.xml'))
	$xml = simplexml_load_file($game.'/data-'. $language .'.xml');
else if (file_exists($game.'/data.xml'))
	$xml = simplexml_load_file($game.'/data.xml');

if( !isset($xml) )
{
// TODO: remove commented schlitz!
//	if( $game == "credits" )
//	{
//		echo '<!DOCTYPE html>
//<html>
//	<head>
//		<meta charset="utf-8">
//		<meta name="viewport" content="width=device-width, initial-scale=1">
//
//		<title>Thanks!</title>
//		<link href="http://cdnjs.cloudflare.com/ajax/libs/uikit/1.2.0/css/uikit.gradient.min.css" rel="stylesheet" type="text/css">
//		<link href="style.css" rel="stylesheet" type="text/css">
//	</head>
//
//	<body>
//		<div class="uk-container uk-container-center">
//			<div class="uk-grid">
//			</div>
//		</div>
//		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
//		<script type="text/javascript">
//			$(function() {
//				$(".uk-grid").load("credits.php");
//			});
//		</script>
//	</body>
//</html>';
//		exit;
//	}
//	else
	if( is_dir($game) && $game != "lang" && $game != "images" && $game != "trailers" && $game != "_template" )
	{
		echo '<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Instructions</title>
		<link href="http://cdnjs.cloudflare.com/ajax/libs/uikit/1.2.0/css/uikit.gradient.min.css" rel="stylesheet" type="text/css">
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>

	<body>
		<div class="uk-container uk-container-center">
			<div class="uk-grid">
			</div>
		</div>
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script type="text/javascript">
			$(function() {
				$(".uk-grid").load("create.php?s=installation");

				setInterval(function() {
					$(".uk-grid").load("create.php?s=installation");
				}, 5000);
			});
		</script>
	</body>
</html>';

		// Todo: These steps will fail if safemode is turned on
		if( !is_dir($game.'/images') ) {
			mkdir($game.'/images');
		}
		if( !is_dir($game.'/trailers') ) {
			mkdir($game.'/trailers');
		}
		if( !file_exists($game.'/_data.xml') ) {
			copy('_template/_data.xml',$game.'/_data.xml');
		}

		exit;
	}
	else
	{
		header("Location: index.php");
		exit;
	}
}

$press_request = false;

/* check for distribute() keyfile */
$files = glob($game.'/ds_*');
foreach( $files as $keyfile ) {
	$keyfileContent = fopen($keyfile, 'r');
	$presskitURL = fgets($keyfileContent);
	$url = fgets($keyfileContent);
	$key = substr($keyfile, strpos($keyfile,'/ds_') + 4);
	$data = array('key' => $key, 'url' => $url);
	fclose($keyfileContent);

	if( function_exists('curl_version') ) {
		// curl exists. this is good. let's use it.
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($ch);
		if( $result != "FAIL" ) $press_request = TRUE;
		else {
			$press_request_fail = TRUE;
			$press_request_fail_msg = tl('There was an unexpected error retrieving data from distribute(). Please try again later.');
		}

		curl_close($ch);
	}
	else if( ini_get('allow_url') ) {
		// well maybe this is a good fallback who knows?
		$options = array(
			'http' => array(
				'header' => 'Content-type: application/x-www-form-urlencoded',
				'method' => 'POST',
				'content' => http_build_query($data),
			),
		);

		$context = stream_context_create($options);
		$result = file_get_contents($url);
		if( $result != "FAIL" ) $press_request = TRUE;
		else {
			$press_request_fail = TRUE;
			$press_request_fail_msg = tl('There was an unforeseen error retrieving data from distribute(). Please try again later.');
		}
	} else {
		// it doesn't matter you have a keyfile, you can't integrate
		$press_request = FALSE;
		$press_request_fail = TRUE;
		$press_request_fail_msg = tl('There is no method to communicate with distribute() available on your server. This functionality is not currently available. Remove the keyfile to remove this warning.');
	}
}

// Set default value for monetize
$monetize = 0;

foreach( $xml->children() as $child )
{
	switch( $child->getName() )
	{
		case("title"):
			define("GAME_TITLE", $child);
			break;
		case("release-date"):
			define("GAME_DATE", $child);
			break;
		case("website"):
			define("GAME_WEBSITE", $child);
			break;
		case("platforms"):
			$platforms = array();
			$i = 0;
			foreach( $child->children() as $subchild )
			{
				$platforms[$i][$subchild->getName()] = $subchild;
				$i++;
			}
			break;
		case("prices"):
			$prices = array();
			$i = 0;
			foreach( $child->children() as $subchild )
			{
				$prices[$i][$subchild->getName()] = $subchild;
				$i++;
			}
			break;
		case("description"):
			define("GAME_DESCRIPTION", $child);
			break;
		case("history"):
			define("GAME_HISTORY", $child);
			break;
		case("histories"):
			$histories = array();
			$i = 0;
			foreach( $child->children() as $subchild )
			{
				$histories[$i][$subchild->getName()] = $subchild;
				$i++;
			}
			break;
		case("features"):
			$features = array();
			$i = 0;
			foreach( $child->children() as $subchild )
			{
				$features[$i] = $subchild;
				$i++;
			}
			break;
		case("trailers"):
			$trailers = array();
			$i = 0;
			foreach( $child->children() as $subchild )
			{
				$trailers[$i][$subchild->getName()] = $subchild;
				$i++;
			}
			break;
		case("awards"):
			$awards = array();
			$i = 0;
			foreach( $child->children() as $subchild )
			{
				$awards[$i][$subchild->getName()] = $subchild;
				$i++;
			}
			break;
		case("quotes"):
			$quotes = array();
			$i = 0;
			foreach( $child->children() as $subchild )
			{
				$quotes[$i][$subchild->getName()] = $subchild;
				$i++;
			}
			break;
		case("press-can-request-copy"):
			if( strtolower($child) != "false" ) $press_request_outdated_warning = TRUE;
			break;
		case("monetization-permission"):
			if( strtolower($child) == "false" ) $monetize = 1;
			else if( strtolower($child) == "ask") $monetize = 2;
			else if( strtolower($child) == "non-commercial") $monetize = 3;
			else if( strtolower($child) == "monetize") $monetize = 4;
			break;
		case("additionals"):
			$additionals = array();
			$i = 0;
			foreach( $child->children() as $subchild )
			{
				$additionals[$i][$subchild->getName()] = $subchild;
				$i++;
			}
			break;
		case("credits"):
			$credits = array();
			$i = 0;
			foreach( $child->children() as $subchild )
			{
				$credits[$i][$subchild->getName()] = $subchild;
				$i++;
			}
			break;
		case("promoter"):
			$promoterawards = array();
			$promoterquotes = array();

			$promotercode = ($child->children());
			$promotercode = $promotercode->product;

			$promoterxml = simplexml_load_file('http://promoterapp.com/dopresskit/'.$promotercode);

			foreach( $promoterxml->children() as $promoterchild )
			{
				switch( $promoterchild->children()->getName() )
				{
					case("review"):
						$i = 0;
						foreach( $promoterchild->children() as $promotersubchild )
						{
							$promoterquotes[$i][$promotersubchild->getName()] = $promotersubchild;
							$i++;
						}
						break;
					case("award"):
						$i = 0;
						foreach( $promoterchild->children() as $promotersubchild )
						{
							$promoterawards[$i][$promotersubchild->getName()] = $promotersubchild;
							$i++;
						}
						break;
				}
			}

			break;
	}
}

if (file_exists('data-'. $language .'.xml'))
	$xml = simplexml_load_file('data-'. $language .'.xml');
else
	$xml = simplexml_load_file('data.xml');

foreach( $xml->children() as $child )
{
	switch( $child->getName() )
	{
		case("title"):
			define("COMPANY_TITLE", $child);
			break;
		case("based-in"):
			define("COMPANY_BASED", $child);
			break;
		case("description"):
			define("COMPANY_DESCRIPTION", $child);
			break;
		case("analytics"):
			define("ANALYTICS", $child);
			break;
		case("contacts"):
			$contacts = array();
			$i = 0;
			foreach( $child->children() as $subchild )
			{
				$contacts[$i][$subchild->getName()] = $subchild;
				$i++;
			}
			break;
	}
}

function parseLink($uri)
{
    $parsed = trim($uri);
    if( strpos($parsed, "http://") === 0 )
        $parsed = substr($parsed, 7);
    if (strpos($parsed, "https://") === 0 )
        $parsed = substr($parsed, 8);
    if( strpos($parsed, "www.") === 0 )
        $parsed = substr($parsed, 4);
    if( strrpos($parsed, "/") == strlen($parsed) - 1)
        $parsed = substr($parsed, 0, strlen($parsed) - 1);
    if( substr($parsed,-1,1) == "/" )
    	$parsed = substr($parsed, 0, strlen($parsed) - 1);

    return $parsed;
}

$languages = TranslateTool::getLanguages();

$company = array(
	'title' => COMPANY_TITLE,
	'location' => COMPANY_BASED,
	'description' => COMPANY_DESCRIPTION,
	'google_analytics' => NULL,
);

$release = array(
	'title' => GAME_TITLE,
	'awards' => array(),
	'quotes' => array(),
	'press_can_request_copy' => $press_request,
	'allow_monetization' => $monetize,
	'release_date' => GAME_DATE,
	'platforms' => array(),
	'websiteUrl' => 'http://'.parseLink(GAME_WEBSITE),
	'websiteName' => parseLink(GAME_WEBSITE),
	'prices' => array(),
	'description' => GAME_DESCRIPTION,
	'history' => array(),
	'features' => array(),
	'trailers' => array(),
	'images_archive_size' => 0,
	'images' => array(),
	'logo_archive_size' => 0,
	'logo' => NULL,
	'icon' => NULL,
	'additional_links' => array(),
	'credits' => array(),
	'contacts' => array(),
);

foreach ($awards as $award) {
	$release['awards'][] = array(
		'description' => $award['award']->description,
		'info' => $award['award']->info,
	);
}

if (isset($promoterawards)) {
	foreach ($promoterawards as $award) {
		$release['awards'][] = array(
			'description' => $award['award']->title,
			'info' => $award['award']->location,
		);
	}
}

foreach ($quotes as $quote) {
	$release['quotes'][] = array(
		'description' => $quote['quote']->description,
		'name' => $quote['quote']->name,
		'website' => $quote['quote']->website,
		'url' => 'http://'.parseLink($quote['quote']->link).'/',
	);
}

if (isset($promoterquotes)) {
	foreach($promoterquotes as $quote) {
		$release['awards'][] = array(
			'description' => $quote['review']->quote,
			'name' => $quote['review']->{'reviewer-name'},
			'website' => $quote['review']->{'publication-name'},
			'url' => 'http://'.parseLink($quote['review']->url).'/',
		);
	}
}

foreach ($platforms as $platform) {
	$release['platforms'][] = array(
		'name' => $platform['platform']->name,
		'url' => 'http://'.parseLink($platform['platform']->link),
	);
}

foreach($prices as $price) {
	$release['prices'][] = array(
		'currency' => $price['price']->currency,
		'value' => $price['price']->value,
	);
}

if (isset($histories)) {
	foreach ($histories as $history) {
		$release['history'][] = array(
			'header' => $history['history']->header,
			'text' => $history['history']->text,
		);
	}
}

foreach($features as $feature) {
	$release['features'][] = $feature->__toString();
}

foreach ($trailers as $trailer) {
	$arr = array(
		'name' => $trailer['trailer']->name,
		'urls' => '',
		'embedded' => NULL,
	);

	if (count($trailer['trailer']->youtube) !== 0) {
		$arr['urls'] .= '<a href="http://www.youtube.com/watch?v='.$trailer['trailer']->youtube.'">YouTube</a>, ';

		$arr['embedded'] = array(
			'platform' => 'youtube',
			'id' => $trailer['trailer']->youtube,
		);
	}

	if (count($trailer['trailer']->vimeo) !== 0) {
		$arr['urls'] .= '<a href="http://www.vimeo.com/'.$trailer['trailer']->vimeo.'">Vimeo</a>, ';

		if ($arr['embedded'] === NULL) {
			$arr['embedded'] = array(
				'platform' => 'vimeo',
				'id' => $trailer['trailer']->vimeo,
			);
		}
	}

	if (count($trailer['trailer']->mov) !== 0) {
		$arr['urls'] .= '<a href="trailers/'.$trailer['trailer']->mov.'">.mov</a>, ';
	}

	if (count($trailer['trailer']->mp4) !== 0) {
		$arr['urls'] .= '<a href="trailers/'.$trailer['trailer']->mp4.'">.mp4</a>, ';
	}

	$arr['urls'] = substr($arr['urls'], 0, -2);

	$release['trailers'][] = $arr;
}

if (file_exists($game.'/images/images.zip')) {
	$file = new SplFileInfo($game.'/images/images.zip');
	$bytes = $file->getSize();

	$units = ['B', 'KB', 'MB'];

	for ($unit = 0; $bytes > 1024 && $unit < (count($units) - 1); $unit++) {
		$bytes /= 1024;
	}

	$bytes = round($bytes, 2);
	$release['images_archive_size'] = $bytes . ' ' . $units[$unit];
}

$dir = new DirectoryIterator(dirname(__FILE__) . '/' . $game . '/images');
foreach ($dir as $file) {
	$finfo = finfo_open(FILEINFO_MIME_TYPE);

	if ($file->isFile()) {
		$info = new finfo;
		$mimeType = $info->file($file->getPathname(), FILEINFO_MIME);

		if (substr($mimeType, 0, 5) === 'image') {
			$filename = $file->getFilename();

			if (substr($filename, 0, 4) !== 'logo' && substr($filename, 0, 4) !== 'icon' && substr($filename, 0, 6) !== 'header') {
				$release['images'][] = $file->getFilename();
			}
		}
	}
}

if (file_exists($game.'/images/logo.zip')) {
	$file = new SplFileInfo($game.'/images/logo.zip');
	$bytes = $file->getSize();

	$units = ['B', 'KB', 'MB'];

	for ($unit = 0; $bytes > 1024 && $unit < (count($units) - 1); $unit++) {
		$bytes /= 1024;
	}

	$bytes = round($bytes, 2);
	$release['logo_archive_size'] = $bytes . ' ' . $units[$unit];
}

if (file_exists($game.'/images/logo.png')) {
	$release['logo'] = 'logo.png';
}

if (file_exists($game.'/images/icon.png')) {
	$release['icon'] = 'icon.png';
}

foreach ($additionals as $additional) {
	$urlName = parseLink($additional['additional']->link);

	if (strpos($urlName, '/') !== false) {
		$urlName = substr($urlName, 0, strpos($urlName, '/'));
	}

	$release['additional_links'][] = array(
		'title' => $additional['additional']->title,
		'description' => $additional['additional']->description,
		'url' => 'http://'.parseLink($additional['additional']->link),
		'urlName' => $urlName,
	);
}

foreach ($credits as $credit) {
	$url = NULL;

	if (isset($credit['credit']->website)) {
		$url = 'http://'.parseLink($credit['credit']->website).'/';
	}

	$release['credits'][] = array(
		'person' => $credit['credit']->person,
		'role' => $credit['credit']->role,
		'url' => $url,
	);
}

foreach ($contacts as $contact) {
	$arr = array(
		'name' => $contact['contact']->name,
		'url' => NULL,
		'urlName' => NULL,
		'email' => NULL,
	);

	if (count($contact['contact']->link) !== 0) {
		$arr['url'] = 'http://'.parseLink($contact['contact']->link);
		$arr['urlName'] = parseLink($contact['contact']->link);
	}

	if (count($contact['contact']->mail) !== 0) {
		$arr['email'] = $contact['contact']->mail;
	}

	$company['contacts'][] = $arr;
}

//if (defined("ANALYTICS") && strlen(ANALYTICS) > 10 )
if (defined('ANALYTICS')) {
	$company['google_analytics'] = ANALYTICS;
}

include('./_templates/release.php');