<?php


spl_autoload_register(function ($class)
{
    $filename = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (is_file(__DIR__ . '/' . $filename)) {
        require_once(__DIR__ . '/' . $filename);
    }
});


/* @var $config \Presskit\PresskitConfig $config  */
$config = require(__DIR__.'/index.config.php');
try
{
	$presskit = new Presskit\Presskit(
		$config,
		new Presskit\PresskitRequest($_GET, $_POST, $_REQUEST)
	);

	switch($presskit->getRequest())
	{
		case \Presskit\PresskitRequest::REQUEST_CREDITS_PAGE:
		{
			include_once($config->templateCreditsPhpFilename);
			exit;
			break;
		}
	}



	$content = $presskit->parse($config->dataXmlFilename);

	// Language logic
	include 'lang/TranslateTool.php';
	$language = TranslateTool::loadLanguage(isset($_GET['l']) ? $_GET['l'] : null, 'index.php');
	$languageQuery = ($language != TranslateTool::getDefaultLanguage() ? '?l='. $language : '');

	if (file_exists('data-'. $language .'.xml'))
		$xml = simplexml_load_file('data-'. $language .'.xml');
	else
		$xml = simplexml_load_file('data.xml');

	foreach( $xml->children() as $child )
	{
		switch( $child->getName() )
		{
			case("analytics"):
				define("ANALYTICS", $child);
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
		'releases' => array(),
		'images_archive_size' => 0,
		'images' => array(),
		'logo_archive_size' => 0,
		'logo' => NULL,
		'icon' => NULL,
		'google_analytics' => NULL,
	);


	// Releases...
	$dir = new DirectoryIterator(dirname(__FILE__));
	foreach ($dir as $file)
	{
		if (
			   $file->isDir()
			&& !in_array(basename($file->getFilename()), $config->releaseExcludeDirs)
		   )
		{
				$url = 'sheet.php?p=' . $file->getFilename();
				if ($language !== TranslateTool::getDefaultLanguage()) {
					$url .= '&l=' . $language;
				}

				$company['releases'][] = array(
					'name' => ucwords(str_replace('_', ' ', $file->getFilename())),
					'url' => $url,
				);
		}
	}


	// Images: images/images.zip
	if (is_readable($config->imagesZipFilename))
	{
		$file  = new SplFileInfo($config->imagesZipFilename);
		$bytes = $file->getSize();
		$units = ['B', 'KB', 'MB'];

		for ($unit = 0; $bytes > 1024 && $unit < (count($units) - 1); $unit++) {
			$bytes /= 1024;
		}

		$bytes = round($bytes, 2);
		$company['images_archive_size'] = $bytes . ' ' . $units[$unit];
	}


	// Images: whole dir: images/*
	$dir = new DirectoryIterator($config->imagesDirname);
	foreach ($dir as $file) {
		$finfo = finfo_open(FILEINFO_MIME_TYPE);

		if ($file->isFile()) {
			$info = new finfo;
			$mimeType = $info->file($file->getPathname(), FILEINFO_MIME);

			if (substr($mimeType, 0, 5) === 'image')
			{
				list($filenameExt, $filenameName) = explode('.', strrev($file->getFilename()));
				$filenameName = strtolower(strrev($filenameName));
				if (!in_array($filenameName, $config->companyExcludeImageNames))
				{
					$company['images'][] = $file->getFilename();
				}
			}
		}
	}


	// Images: images/logo.zip
	if (is_readable($config->imageLogoZipFilename))
	{
		$file  = new SplFileInfo($config->imageLogoZipFilename);
		$bytes = $file->getSize();
		$units = ['B', 'KB', 'MB'];

		for ($unit = 0; $bytes > 1024 && $unit < (count($units) - 1); $unit++) {
			$bytes /= 1024;
		}

		$bytes = round($bytes, 2);
		$company['logo_archive_size'] = $bytes . ' ' . $units[$unit];
	}


	// Images: images/logo.png
	if (is_readable($config->imageLogoFilename)) {
		$company['logo'] = $config->relativePath($config->imageLogoFilename);
	}


	// Images: images/icon.png
	if (is_readable($config->imageIconFilename)) {
		$company['logo'] = $config->relativePath($config->imageIconFilename);
	}

	
	//if (defined("ANALYTICS") && strlen(ANALYTICS) > 10 )
	if (defined('ANALYTICS')) {
		$company['google_analytics'] = ANALYTICS;
	}

	include_once($config->templateCompanyPhpFilename);
	exit;

}
catch (Presskit\Exceptions\DataXmlFilenameMissingException $e)
{
	try
	{
		$presskitInstall = new Presskit\PresskitInstall($config);
		$presskitInstall->installCompany();

		header('Location: '.$_SERVER['REQUEST_URI']);
		exit;
	}
	catch(\Exception $e)
	{
		throw $e;
	}
}
