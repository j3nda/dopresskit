<?php

namespace Presskit;

use finfo;
use Presskit\Parser\XML as XMLParser;


class Presskit
{
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
			$config = new \Presskit\Config(
				realpath(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR
			);
		}
		$this->config   = $config;
		$this->releases = $this->gatherReleases(
			$this->config->currentDir,
			$this->config->releaseExcludeDirs
		);
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
				$this->config->languageDirname,
				$this->getCurrentLanguage()
			);

			$xml->setAdditionalInfo(array(
				'config'              => $this->config,
				'language'            => $this->getCurrentLanguage(),
				'languages'           => $this->getAvailableLanguages(),
				'releases'            => $this->getReleases(),
				'images_archive_size' => Helpers::filesizeToHumanReadable(Helpers::getFilesize($this->config->imageZipFilename)),
				'images'              => $this->getImages($this->config->imagesDirname, $this->config->companyExcludeImageNames),
				'logo_archive_size'   => Helpers::filesizeToHumanReadable(Helpers::getFilesize($this->config->imageLogoZipFilename)),
				'header'              => $this->getRelativePath($this->config->imageHeaderFilename, true),
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

	public function parseRelease($dataXmlFilename, $releaseName)
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
				$this->config->languageDirname,
				$this->getCurrentLanguage()
			);

			$googleAnalytics = null;
			$gaList = array_change_key_case($this->config->googleAnalytics, CASE_LOWER);
			if (isset($gaList[strtolower($releaseName)]))
			{
				$googleAnalytics = $gaList[strtolower($releaseName)];
			}
			else
			if (isset($gaList[Request::REQUEST_COMPANY_PAGE]))
			{
				$googleAnalytics = $gaList[Request::REQUEST_COMPANY_PAGE];
			}

			$xml->setAdditionalInfo(array(
				'config'              => $this->config,
				'language'            => $this->getCurrentLanguage(),
				'languages'           => $this->getAvailableLanguages(),
				'images_archive_size' => Helpers::filesizeToHumanReadable(Helpers::getFilesize($this->config->imageZipFilename)),
				'images'              => $this->getImages($this->config->imagesDirname, $this->config->releaseExcludeImageNames),
				'logo_archive_size'   => Helpers::filesizeToHumanReadable(Helpers::getFilesize($this->config->imageLogoZipFilename)),
				'header'              => $this->getRelativePath($this->config->imageHeaderFilename, true),
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

	private function gatherReleases($directory, $releaseExcludeDirs)
	{
		$dir = new \DirectoryIterator($directory);
		$rel = array();
		foreach ($dir as $file)
		{
			if (
				   $file->isDir()
				&& !in_array(basename($file->getFilename()), $releaseExcludeDirs)
			   )
			{
				$url = Helpers::url(
					'?'
						.(count($this->getAvailableLanguages()) > 1
							? 'l='.$this->getCurrentLanguage()
							: ''
						)
						.'p='.strtolower($file->getFilename())
					,
					(count($this->getAvailableLanguages()) > 1
							? $this->getCurrentLanguage().'/'
							: ''
					)
					.strtolower($file->getFilename())
				);

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

        // excludeReleaseNames: REGEX!
		$relKeys = array_keys($rel);
        $matches = array();
        foreach($releaseExcludeDirs as $excludeRegex)
        {
			if (in_array($excludeRegex, array('.', '..')))
			{
				continue;
			}
            $tmp = preg_grep('/'.$excludeRegex.'/', $relKeys);
            if (!empty($tmp))
            {
                $matches = array_unique(array_merge($matches, $tmp));
            }
        }
		foreach($matches as $excludeReleaseName)
		{
			unset($rel[$excludeReleaseName]);
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

        // excludeImageNames: REGEX!
        $matches = array();
        foreach($excludeImageNames as $excludeRegex)
        {
            $tmp = preg_grep('/'.$excludeRegex.'/', $img);
            if (!empty($tmp))
            {
                $matches = array_unique(array_merge($matches, $tmp));
            }
        }

		return array_diff($img, $matches);
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
