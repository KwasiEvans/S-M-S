<?php

/**
 * Project Language Class/ Interface
 */

class Lang
{
	public $phrases = array();

	function __construct()
	{
		$l = get_cookie('lang');
		$lang = (!empty($l) ? $l : DEFAULT_LANGUAGE);

		if (file_exists("languages/$lang.ini")) {
			$this->phrases = parse_ini_file("languages/$lang.ini");
		}
	}
	/**
	 * Get user langauge or return the default language
	 * @return string
	 */
	public static function get_user_language()
	{
		$l = get_cookie('lang');
		$lang = (!empty($l) ? $l : DEFAULT_LANGUAGE);
		return $lang;
	}

	/**
	 * Get a language phrase with a key
	 * @return string
	 */
	public function get_phrase($key)
	{
		$phrase = isset($this->phrases[$key]) ? $this->phrases[$key] : null;
		return $phrase;
	}
}
