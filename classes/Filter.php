<?php defined('SYSPATH') or die('No direct script access.');

class Filter extends Kohana_Filter {
	public static function custom($input) {
		$base_url = Kohana::$base_url;
		$output = str_replace('../..', '/media/admin', $input);
		return $output;
	}
}
