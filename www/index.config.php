<?php

{
	$config = new Presskit\Config(__DIR__);

	// mod_rewite: uncomment below, if u need it...
//	$config::$isModRewriteEnabled = true;

	// GoogleAnalytics: uncomment below, if u need it...
//	$config->googleAnalytics[Presskit\Request::REQUEST_COMPANY_PAGE] = 123456789;
//	$config->googleAnalytics['release-name'] = 123456789;

	return $config;
}
