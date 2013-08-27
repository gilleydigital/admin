<?php defined('SYSPATH') or die('No direct script access.');

class ORM extends Kohana_ORM {
	// Simplified "create" wrapper
	public function create(Validation $validation = NULL)
	{
		// Can be called with array as second parameter in controller
		if (func_num_args() >= 2)
		{
			// Validate second parameter
			$values = func_get_arg(1);
			if ( ! is_array($values))
			{
				throw new Kohana_Exception('second argument must be array');
			}

			// New function
			return $this->values($validation->data(), $values)->parent_create($validation);
		}
		else
		{
			// Default function
			return parent::create($validation);
		}
	}
	
	private function parent_create(Validation $validation = NULL)
	{
		return parent::create($validation);
	}
	
	// Simplified "update" wrapper
	public function update(Validation $validation = NULL)
	{
		// Can be called with array as second parameter in controller
		if (func_num_args() >= 2)
		{
			// Validate second parameter
			$values = func_get_arg(1);
			if ( ! is_array($values))
			{
				throw new Kohana_Exception('second argument must be array');
			}

			// New function
			return $this->values($validation->data(), $values)->parent_update($validation);
		}
		else
		{
			// Default function
			return parent::update($validation);
		}
	}

	private function parent_update(Validation $validation = NULL)
	{
		return parent::update($validation);
	}
}
