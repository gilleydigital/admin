<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin extends Controller_Template {
	public $template = 'admin/template/inside';
	
	public function before()
	{
		parent::before();
		
		// User must be logged in to access admin page
		$this->user = Auth::instance()->get_user();
		if ( ! is_object($this->user))
		{
			// Send to login screen if not
			$this->redirect('admin/auth/login');
		}
		else
		{
			// Bind variable for "Hi Chris", profile, etc.
			View::bind_global('me', $this->user);
		}
	}
	
	public function after()
	{
		// Load modules from config
		View::set_global('modules', Kohana::$config->load('admin/modules'));

		if (class_exists('Info'))
		{
			// Header from info config
			$this->template->set('header', Info::get('name'));
		}
		else
		{
			// Header from info config
			$this->template->set('header', 'Admin');			
		}

		parent::after();
	}
}
