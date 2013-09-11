<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Dashboard extends Controller_Admin {
	public function action_index()
	{
		// Compile Messages
		Formaid::messages('admin/dashboard', $this->request->param('var'), $this->request->param('subvar'));
		
		// View
		$this->template->content = View::factory('admin/index');
		$this->template->title = 'Dashboard';
	}
}
