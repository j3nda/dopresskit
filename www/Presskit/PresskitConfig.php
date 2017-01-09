<?php

namespace Presskit;


class PresskitConfig
{
	private $currentDir;

	private $dataXmlFilename = 'data.xml';
	private $trailersDirname = 'trailers';

	private $imagesDirname        = 'images';
	private $imagesZipFilename    = 'images/images.zip';
	private $imageLogoZipFilename = 'images/logo.zip';
	private $imageLogoFilename    = 'images/logo.png';
	private $imageIconFilename    = 'images/icon.png';
	private $companyExcludeImageNames = array(
		'logo',
		'icon',
		'header',
	);

	private $releaseExcludeDirs = array(
		'.',
		'..',
		'Presskit',
		'images',
		'lang',
		'trailers',
	);

	private $templateCompanyDataXmlFilename = 'Presskit/Templates/company.xml';
	private $templateCompanyPhpFilename = 'Presskit/Templates/company.php';
	private $templateCreditsPhpFilename = 'Presskit/Templates/credits.php';


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
		if (in_array($name,
				array(
					'companyExcludeImageNames',
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
			if (preg_match('/(Filename|Dirname)$/i', $name))
			{
				$prefix = $this->currentDir;
			}
			if (is_array($this->$name))
			{
				return $this->$name;
			}
			else
			{
				return $prefix.$this->$name;
			}
		}
	}

	public function relativePath($absoluteResource)
	{
		return str_replace(
			$this->currentDir,
			$absoluteResource,
			''
		);
	}
}
