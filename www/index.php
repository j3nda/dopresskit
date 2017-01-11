<?php


spl_autoload_register(function ($class)
{
    $filename = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (is_file(__DIR__ . '/' . $filename)) {
        require_once(__DIR__ . '/' . $filename);
    }
});


/* @var $config \Presskit\Config */
$config = require(__DIR__.'/index.config.php');
try
{
	$presskit = new Presskit\Presskit($config, $_GET, $_POST, $_REQUEST);
	switch($presskit->getRequest())
	{
		case \Presskit\Request::REQUEST_COMPANY_PAGE:
		{
			Presskit\TranslateTool::$languageDir = $config->languageDirname;
			$content = $presskit->parseCompany($config->dataXmlFilename);

			include_once($config->templateCompanyPhpFilename);
			exit;

			break;
		}
		case \Presskit\Request::REQUEST_RELEASE_PAGE:
		{
			Presskit\TranslateTool::$languageDir = $config->languageDirname;
			$companyContent = $presskit->parseCompany($config->dataXmlFilename);

			$release = $presskit->getRequestRelease();
			Presskit\TranslateTool::$languageDir = $config->currentDir
				.$release['dir']
				.DIRECTORY_SEPARATOR
				.$presskit->getRelativePath($config->languageDirname);

			$content = $presskit->parseRelease(
				$config->currentDir.$release['dir'].DIRECTORY_SEPARATOR.basename($config->dataXmlFilename)
			);
			$content->setCompany($companyContent);
			$content->setAdditionalInfo(array_merge(
				(array)$content->getAdditionalInfo(),
				array('release_name' => $release['dir'])
			));

			if ($content->getMonetization() == Presskit\Content\SharedContent::MONETIZATION_SHARED_COMPANY)
			{
				$content->setMonetization($companyContent->getMonetization());
			}

			include_once($config->templateReleasePhpFilename);
			exit;

			break;
		}
		case \Presskit\Request::REQUEST_CREDITS_PAGE:
		{
			include_once($config->templateCreditsPhpFilename);
			exit;
			break;
		}
		default:
		{
			throw new Exception('Invalid request!');
			break;
		}
	}
}
catch (Presskit\Exceptions\DataXmlFilenameMissingException $e)
{
	try
	{
		$presskitInstall = new Presskit\Install($config);
		switch($e->getCode())
		{
			case Presskit\Exceptions\DataXmlFilenameMissingException::CODE_COMPANY:
			{
				$presskitInstall->installCompany();
				break;
			}
			case Presskit\Exceptions\DataXmlFilenameMissingException::CODE_RELEASE:
			{
				$presskitInstall->installRelease($presskit->getRequestRelease());
				break;
			}
			default:
			{
				throw $e;
				break;
			}
		}
		header('Location: '.$_SERVER['REQUEST_URI']);
		exit;
	}
	catch(\Exception $e)
	{
		throw $e;
	}
}
catch (Presskit\Exceptions\ReleaseNotFoundException $e)
{
	header('HTTP/1.0 404 Not Found', true, 404);
	include_once($config->template404PhpFilename);
	exit;
}
