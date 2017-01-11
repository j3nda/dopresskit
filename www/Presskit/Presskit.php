<?php

namespace Presskit;

use finfo;
use Presskit\Parser\XML as XMLParser;


class Presskit
{
	const FORMAT_FILESIZE_AS_HUMAN = 'human';

	public static $isModRewriteEnabled = false;

	private $config;
	private $request;
	private $content;
	private $releases;


	public function __construct(
		Config $config = null,
		$phpGet = null,
		$phpPost = null,
		$phpRequest = null
	)
	{
		if ($config === null)
		{
			$config = new \Presskit\Config(__DIR__.'/../');
		}
		$this->config   = $config;
		$this->releases = $this->gatherReleases($this->config->currentDir);
		$this->request  = new Request(
			$this->config,
			$this->releases,
			$phpGet,
			$phpPost,
			$phpRequest
		);
	}

	public function parseCompany($dataXmlFilename)
	{
		try
		{
			$xml = $this->parseXml(
				($dataXml = Helpers::dataXmlToLanguageDataXml(
					$dataXmlFilename,
					$this->getCurrentLanguage()
				)),
				new Content\CompanyContent()
			);
			TranslateTool::loadLanguage(
				dirname($dataXmlFilename).DIRECTORY_SEPARATOR.$this->getRelativePath($this->config->languageDirname),
				$this->getCurrentLanguage()
			);

			$xml->setAdditionalInfo(array(
				'language'            => $this->getCurrentLanguage(),
				'languages'           => $this->getAvailableLanguages(),
				'releases'            => $this->getReleases(),
				'images_archive_size' => Helpers::filesizeToHumanReadable(Helpers::getFilesize($this->config->imageZipFilename)),
				'images'              => $this->getImages($this->config->imagesDirname, $this->config->companyExcludeImageNames),
				'logo_archive_size'   => Helpers::filesizeToHumanReadable(Helpers::getFilesize($this->config->imageLogoZipFilename)),
				'logo'                => $this->getRelativePath($this->config->imageLogoFilename, true),
				'icon'                => $this->getRelativePath($this->config->imageIconFilename, true),
				'google_analytics'    => $this->config->googleAnalytics[Request::REQUEST_COMPANY_PAGE],
			));

			return $xml;
		}
		catch (Exceptions\DataXmlFilenameMissingException $e)
		{
			throw new Exceptions\DataXmlFilenameMissingException(
				'',
				Exceptions\DataXmlFilenameMissingException::CODE_COMPANY
			);
		}
	}

	public function parseRelease($dataXmlFilename)
	{
		try
		{
			$xml = $this->parseXml(
				($dataXml = Helpers::dataXmlToLanguageDataXml(
					$dataXmlFilename,
					$this->getCurrentLanguage()
				)),
				new Content\ReleaseContent()
			);
			TranslateTool::loadLanguage(
				dirname($dataXmlFilename).DIRECTORY_SEPARATOR.$this->getRelativePath($this->config->languageDirname),
				$this->getCurrentLanguage()
			);

			$googleAnalytics = null;
			$gaList = array_change_key_case($this->config->googleAnalytics, CASE_LOWER);
			if (isset($gaList[basename(dirname($dataXmlFilename))]))
			{
				$googleAnalytics = $gaList[basename(dirname($dataXmlFilename))];
			}
			else
			if (isset($gaList[Request::REQUEST_COMPANY_PAGE]))
			{
				$googleAnalytics = $gaList[Request::REQUEST_COMPANY_PAGE];
			}

			$xml->setAdditionalInfo(array(
				'language'            => $this->getCurrentLanguage(),
				'languages'           => $this->getAvailableLanguages(),
//				'releases'            => $this->getReleases(),
				'images_archive_size' => Helpers::filesizeToHumanReadable(
					Helpers::getFilesize(
						dirname($dataXmlFilename)
						.DIRECTORY_SEPARATOR
						.$this->getRelativePath($this->config->imageZipFilename)
					)
				),
				'images'              => $this->getImages(
					dirname($dataXmlFilename)
					.DIRECTORY_SEPARATOR
					.$this->getRelativePath($this->config->imagesDirname),
					$this->config->companyExcludeImageNames
				),
				'logo_archive_size'   => Helpers::filesizeToHumanReadable(
					Helpers::getFilesize(
						dirname($dataXmlFilename)
						.DIRECTORY_SEPARATOR
						.$this->getRelativePath($this->config->imageLogoZipFilename)
					)
				),
				'logo'                => $this->getRelativePath($this->config->imageLogoFilename, true),
				'icon'                => $this->getRelativePath($this->config->imageIconFilename, true),
				'google_analytics'    => $googleAnalytics,
			));

			return $xml;
		}
		catch (Exceptions\DataXmlFilenameMissingException $e)
		{
			throw new Exceptions\DataXmlFilenameMissingException(
				'',
				Exceptions\DataXmlFilenameMissingException::CODE_RELEASE
			);
		}
	}

	private function parseXml($xmlFilename, $content)
	{
		$finfo = new finfo;
		$mimeType = $finfo->file($xmlFilename, FILEINFO_MIME);

		if (strpos($mimeType, 'application/xml') !== false)
		{
			$parser = new XMLParser($xmlFilename, $content);
			return $parser->parse();
		}
		else
		{
			throw new Exceptions\InvalidMimeTypeAppXmlException();
		}
	}

	public function getRequest()
	{
		return $this->request->getRequest();
	}

	public function getReleases()
	{
		return $this->releases;
	}

	public function getRequestRelease()
	{
		return $this->request->getRequestRelease();
	}



	private function gatherReleases($directory)
	{
		$dir = new \DirectoryIterator($directory);
		$rel = array();
		foreach ($dir as $file)
		{
			if (
				   $file->isDir()
				&& !in_array(basename($file->getFilename()), $this->config->releaseExcludeDirs)
			   )
			{
				$url = Helpers::url(
					'?p='.strtolower($file->getFilename()),
					strtolower($file->getFilename())
				);
//				if ($language !== \TranslateTool::getDefaultLanguage()) {
//					$url .= '&l=' . $language;
//				}
// TODO

				$dirname = basename($file->getFilename());
				if (isset($rel[strtolower($dirname)]))
				{
					throw new Exceptions\InvalidReleaseNameItIsNotUnique();
				}
				else
				{
					$rel[strtolower($dirname)] = array(
						'dir'  => $dirname,
						'name' => ucwords(str_replace(array('_', '-'), ' ', $file->getFilename())),
						'url'  => $url,
					);
				}
			}
		}

		return $rel;
	}

	public function getImages($directory, $excludeImageNames = null)
	{
		$img = array();
		$dir = new \DirectoryIterator($directory);
		foreach ($dir as $file)
		{
			$finfo = finfo_open(FILEINFO_MIME_TYPE);

			if ($file->isFile())
			{
				$info     = new finfo;
				$mimeType = $info->file($file->getPathname(), FILEINFO_MIME);

				if (substr($mimeType, 0, 5) === 'image')
				{
					list($filenameExt, $filenameName) = explode('.', strrev($file->getFilename()));
					$filenameName = strtolower(strrev($filenameName));
					if (!$excludeImageNames || empty($excludeImageNames) || !is_array($excludeImageNames))
					{
						$img[] = $file->getFilename();
					}
					else
					{
						if (!in_array($filenameName, $excludeImageNames))
						{
							$img[] = $file->getFilename();
						}
					}
				}
			}
		}
		return $img;
	}

	public function getRelativePath($absoluteResource, $checkAvailability = false)
	{
		if (!$checkAvailability || ($checkAvailability && is_readable($absoluteResource)))
		{
			return $this->config->relativePath($absoluteResource);
		}
		else
		{
			return null;
		}
	}

	public function getCurrentLanguage()
	{
		return $this->request->getCurrentLanguage();
	}

	public function getAvailableLanguages()
	{
		return TranslateTool::getLanguages();
	}
}
