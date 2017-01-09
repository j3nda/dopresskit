<?php

namespace Presskit;


class PresskitRequest
{
	const REQUEST_COMPANY_PAGE = 'company';
	const REQUEST_GAME_PAGE = 'game';
	const REQUEST_CREDITS_PAGE = 'credits';

	private $get;
	private $post;
	private $request;
	private $currentRequest;
	private $defaultRequest;

	private $reInvestigateRequest = true;

	
	public function __construct($phpGet = null, $phpPost = null, $phpRequest = null)
	{
		if (empty($phpGet)) { $phpGet = $_GET; }
		if (empty($phpPost)) { $phpPost = $_POST; }
		if (empty($phpRequest)) { $phpRequest = $_REQUEST; }

		if (!is_array($phpGet)) { throw new Exception('phpGet isn\'t array!'); }
		if (!is_array($phpPost)) { throw new Exception('phpPost isn\'t array!'); }
		if (!is_array($phpRequest)) { throw new Exception('phpRequest isn\'t array!'); }

		$this->get = $phpGet;
		$this->post = $phpPost;
		$this->request = $phpRequest;

		$this->investigateRequest();
	}

	public function setDefaultRequest($defaultRequest)
	{
		$this->defaultRequest = $defaultRequest;
		$this->reInvestigateRequest = true;
	}

	public function getRequest()
	{
		$this->investigateRequest();
		return $this->currentRequest;
	}

	protected function investigateRequest()
	{
		if (!$this->reInvestigateRequest)
		{
			return;
		}

		$page = (isset($this->request['p']) ? trim($this->request['p']) : $this->defaultRequest);

		if ($page == self::REQUEST_CREDITS_PAGE)
		{
			$this->currentRequest = self::REQUEST_CREDITS_PAGE;
		}

		$this->reInvestigateRequest = false;
	}
}
