<?php defined('SYSPATH') or die('No direct script access.');

class Validation extends Kohana_Validation {
	public function add_password_validation()
	{
		return $this
			->rule('password', 'min_length', array(':value', 8))
			->rule('password', 'matches', array(':validation', ':field', 'password_confirm'));
	}
}
