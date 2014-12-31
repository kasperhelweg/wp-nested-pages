<?php namespace NestedPages\Entities\WPML;

use NestedPages\Entities\WPML\WPMLRepository;

class WPMLPresenter {

	/**
	* WPML Repository
	*/
	private $wpml_repo;

	public function __construct()
	{
		$this->wpml_repo = new WPMLRepository;
	}


	/**
	* Language Dropdown
	* @return html
	*/
	public function languageDropdown()
	{
		$out = '<select name="np-wpml-languages" id="np-wpml-languages">';
		foreach($this->wpml_repo->getLanguages() as $key => $language){
			$out .= '<option value="' . $key . '"';
			if ( ICL_LANGUAGE_CODE == $key ) $out .= ' selected';
			$out .= '>' . $language['translated_name'] . '</option>';
		}
		$out .= '</select>';
		return $out;
	}


	/**
	* Flags in Listing Header
	* @return html
	*/
	public function flagHeaderList()
	{
		//$current_lang = ( isset($_GET['lang']) ) ? $_GET['lang'] : ICL_LANGUAGE_CODE;
		$out = '<ul class="np-flag-header';
		if ( function_exists('wpseo_translate_score') )	$out .= ' yoast-enabled'; // Add extra margin if Yoast is enabled
		$out .= '">';
		foreach($this->wpml_repo->getLanguages() as $key => $lang){
			if ( $key !== ICL_LANGUAGE_CODE){
				$out .= '<li><img src="' . $lang['country_flag_url'] . '" alt="' . $lang['translated_name'] . '" /></li>';
			}
		}
		$out .= '</ul>';
		return $out;
	}


	/**
	* Edit/Add links in List Row
	* @param int post id
	* @return html
	*/
	public function editLinks($post_id, $post_type)
	{
		$translations = $this->wpml_repo->getTranslations($post_id);
		
		$languages = $this->wpml_repo->getLanguageCodeArray();
		$source_lang = ( ICL_LANGUAGE_CODE == 'all' ) ? $this->wpml_repo->defaultLanguage() : ICL_LANGUAGE_CODE;
		$out = '<ul class="np-wpml-editlinks">';
		foreach($languages as $lang){
			if ( $lang !== ICL_LANGUAGE_CODE ){
				if ( array_key_exists($lang, $translations) ){
					// There's already a translation
					$out .= '<li><a href="' . get_edit_post_link($translations[$lang]->element_id) . '" class="np-btn"><i class="np-icon-pencil"></i></a></li>';
				} else {
					// Link to New Translation
					$link = admin_url('post-new.php?post_type=' . $post_type . '&trid=' . $post_id . '&lang=' . $lang . '&source_lang=' . $source_lang);
					$out .= '<li><a href="' . $link . '" class="np-btn"><i class="np-icon-plus"></i></a></li>';
				}
			}
		}
		$out .= '</ul>';
		return $out;
	}

}