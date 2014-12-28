<?php namespace NestedPages\Form\Handlers;

use NestedPages\Entities\WPML\WPMLRepository;

class LanguageSelectHandler {

	
	/**
	* URL to redirect to
	* @var string
	*/
	private $url;

	/**
	* WPML Repository
	* @var object
	*/
	private $wpml;


	public function __construct()
	{
		$this->wpml = new WPMLRepository;
		$this->setURL();
		$this->redirect();
	}


	/**
	* Build the URL to Redirect to
	*/
	private function setURL()
	{
		$this->url = sanitize_text_field($_POST['page']);
		$this->addLanguageParameter();
	}


	/**
	* Set Order by parameters
	*/
	private function addLanguageParameter()
	{
		if ( ( $_POST['np-wpml-languages'] !== "" ) 
			&& ( in_array($_POST['np-wpml-languages'], $this->wpml->getLanguageCodeArray()) ) ) 
			$this->url .= '&lang=' . $_POST['np-wpml-languages'];
	}


	/**
	* Redirect to new URL
	*/
	private function redirect()
	{
		header('Location:' . $this->url);
	}

}