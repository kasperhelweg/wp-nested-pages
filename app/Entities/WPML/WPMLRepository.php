<?php namespace NestedPages\Entities\WPML;

class WPMLRepository {

	/**
	* Get Available Languages
	* @return array
	*/
	public function getLanguages()
	{
		return icl_get_languages('skip_missing=N&orderby=KEY&order=DIR&link_empty_to=str');
	}


	/**
	* Get the Default Language
	*/
	public function defaultLanguage()
	{
		global $sitepress;
		return $sitepress->get_default_language();
	}


	/**
	* Get Language Code Array
	* @return array
	*/
	public function getLanguageCodeArray()
	{
		$languages = array();
		foreach($this->getLanguages() as $key => $language)
		{
			array_push($languages, $key);
		}
		return $languages;
	}


	/**
	* Get Translations for a specified post
	* @return array
	*/
	public function getTranslations($post_id)
	{
		global $sitepress;
		$translations = $sitepress->get_element_translations($post_id);
		return $translations;
	}


}