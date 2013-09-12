<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Info {
	public static function get($key)
	{
		$info = Kohana::$config->load('info/values');
		if ($key == 'address')
		{
			return View::factory('includes/address')
				->set('address_1', $info->get('address_1'))
				->set('address_2', $info->get('address_2'))
				->set('city', $info->get('city'))
				->set('zip', $info->get('zip'));
		}
		else
		{
			return $info->get($key);
		}
	}
}
