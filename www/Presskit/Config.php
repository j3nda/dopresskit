<?php

namespace Presskit;


class Config
{
	private $currentDir;

	private $dataXmlFilename      = 'data.xml';
	private $cssFilenames         = array('index.css');
	private $trailersDirname      = 'trailers';
	private $languageDirname      = 'lang';
	private $imagesDirname        = 'images';
	private $imageHeaderFilename  = 'images/header.png';
	private $imageZipFilename     = 'images/images.zip';
	private $imageLogoZipFilename = 'images/logo.zip';
	private $imageLogoFilename    = 'images/logo.png';
	private $imageIconFilename    = 'images/icon.png';
	/** array (it's possible to exclude filename or REGEX) */
	private $companyExcludeImageNames = array(
		'logo.png',
		'icon.png',
		'header.png',
	);
	/** array (it's possible to exclude filename or REGEX) */
	private $releaseExcludeImageNames = array(
		'logo.png',
		'icon.png',
		'header.png',
	);
	/** array (it's possible to exclude dirname or REGEX) */
	private $releaseExcludeDirs = array(
		'.',
		'..',
		'Presskit',
		'images',
		'lang',
		'trailers',
		\Presskit\Request::REQUEST_CREDITS_PAGE,
	);
	/** true if you want to've nice-url, otherwise false. */
	public static $isModRewriteEnabled = false;
	private $googleAnalytics = null;
	private $skipEmpty = array();
	private $autoCreateStaticHtml = false;

	private $templateCompanyDataXmlFilename = 'Presskit/Templates/company.xml';
	private $templateCompanyLangXmlFilename = 'Presskit/Templates/company.lang.xml';
	private $templateCompanyPhpFilename     = 'Presskit/Templates/company.php';
	private $templateReleaseDataXmlFilename = 'Presskit/Templates/release.xml';
	private $templateReleaseLangXmlFilename = 'Presskit/Templates/release.lang.xml';
	private $templateReleasePhpFilename     = 'Presskit/Templates/release.php';
	private $templateCreditsPhpFilename     = 'Presskit/Templates/credits.php';
	private $template404PhpFilename         = 'Presskit/Templates/404.php';


	public function __construct($currentDir)
	{
		if (!is_readable($currentDir))
		{
			throw new Exception('Invalid $currentDir = '.$currentDir);
		}
		if (substr($currentDir, -1) != DIRECTORY_SEPARATOR)
		{
			$currentDir .= DIRECTORY_SEPARATOR;
		}
		$this->currentDir = $currentDir;
	}

	public function __set($name, $value)
	{
		if ($name == 'currentDir')
		{
			throw new \Exception('Invalid $name! currentDir is reserved!');
		}
		if (!is_array($value) && in_array($name,
				array(
					'companyExcludeImageNames',
					'skipEmpty',
				)
		   ))
		{
			throw new \Exception('Invalid '.$name.'! It needs to be an array!');
		}
		$this->$name = $value;
	}

	public function __get($name)
	{
		if (isset($this->$name))
		{
			$prefix = '';
			$suffix = '';
			if (preg_match('/(Filename|Dirname)$/i', $name, $tmp))
			{
				if (preg_match('/^(template).+$/i', $name))
				{
					$prefix = realpath(__DIR__.DIRECTORY_SEPARATOR.'..').DIRECTORY_SEPARATOR;
				}
				else
				{
					$prefix = $this->currentDir;
				}
				$suffix = (strtolower($tmp[1]) == 'dirname'
					? DIRECTORY_SEPARATOR
					: ''
				);
			}
			if (is_array($this->$name))
			{
				return $this->$name;
			}
			else
			{
				return $prefix.$this->$name.$suffix;
			}
		}
		else
		{
			$ref = new \ReflectionClass($this);
			foreach($ref->getProperties(\ReflectionProperty::IS_PRIVATE) as $prop)
			{
				if ($prop->getName() === $name)
				{
					return $this->$name;
				}
			}
			throw new \Exception('Uninitialized variable '.$name);
		}
	}

	public function relativePath($absoluteResource)
	{
		return str_replace(
			$this->currentDir,
			'',
			$absoluteResource
		);
	}

	public function hasSkipEmpty($key)
	{
		return in_array($key, $this->skipEmpty);
	}
}
