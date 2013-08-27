<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_User extends ORM {
	protected $_has_many = array(
		'user_tokens' => array('model' => 'user_token'),
		'user_resets' => array('model' => 'user_reset'),
		'roles'       => array('model' => 'role', 'through' => 'roles_users'),
	);

	public function rules()
	{
		return array(
			'username' => array(
				array('not_empty'),
				array('max_length', array(':value', 32)),
				array(array($this, 'unique'), array('username', ':value')),
			),
			'email' => array(
				array('not_empty'),
				array('email'),
				array(array($this, 'unique'), array('email', ':value')),
			),
		);
	}

	public function filters()
	{
		return array(
			'password' => array(
				array(array(Auth::instance(), 'hash'))
			)
		);
	}

	public function unique_key($value)
	{
		return Valid::email($value) ? 'email' : 'username';
	}

	public function complete_login()
	{
		if ($this->_loaded)
		{
			// Update the number of logins
			$this->logins = new Database_Expression('logins + 1');

			// Set the last login date
			$this->last_login = time();

			// Save the user
			$this->update();
		}
	}
}
