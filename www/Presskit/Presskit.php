<?php

namespace Presskit;

use finfo;
use Presskit\Parser\XML as XMLParser;

class Presskit
{
	public static $hasModRewriteEnabled = false;

	private $config;
	private $request;
    private $content;

    public function __construct(
		PresskitConfig $config = null,
		PresskitRequest $request = null
	)
    {
		if ($config  === null) { $config  = new \Presskit\PresskitConfig(); }
		if ($request === null) { $request = new \Presskit\PresskitRequest(); }

		$this->config  = $config;
		$this->request = $request;
        $this->content = new Content;
    }

    public function parse($file)
    {
        if (is_file($file)) {
            $finfo = new finfo;
            $mimeType = $finfo->file($file, FILEINFO_MIME);

            if (strpos($mimeType, 'application/xml') !== false) {
                $parser = new XMLParser($file, $this->content);
                return $parser->parse();
            }
        }
        else
        {
            throw new Exceptions\DataXmlFilenameMissingException();
        }
    }

	public function getRequest()
	{
		return $this->request->getRequest();
	}

	public static function url($normalUrl, $rewriteUrl)
	{
		if (self::$hasModRewriteEnabled)
		{
			return $rewrite;
		}
		else
		{
			return $normalUrl;
		}
	}
}
