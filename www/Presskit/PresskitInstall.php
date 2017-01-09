<?php

namespace Presskit;


class PresskitInstall
{
	private $config;


	public function __construct(PresskitConfig $config)
	{
		$this->config = $config;
	}

	public function installCompany()
	{
		if (!is_readable($this->config->dataXmlFilename))
		{
			$this->copy(
				$this->config->templateCompanyDataXmlFilename,
				$this->config->dataXmlFilename
			);
		}
		if (!is_readable($this->config->imagesDirname))
		{
			mkdir($this->config->imagesDirname);
		}
		if (!is_readable($this->config->trailersDirname))
		{
			mkdir($this->config->trailersDirname);
		}
	}

	protected function copy($source, $target)
	{
		if (!is_readable($source))
		{
			throw new Exception(
				'Unable to installCompany! templateFilename is missing!'
				.' path: '.$source
			);
		}
		copy($source, $target);
	}
}
