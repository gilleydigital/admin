<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_User extends Controller_Admin {
	public function action_index()
	{
		// Get the list of users
		$users = ORM::factory('user')->find_all()->as_array();

		// Compile Messages
		Formaid::messages('admin/user', $this->request->param('var'), $this->request->param('subvar'));

		// View
		$this->template->title = 'Users';
		$this->template->content = View::factory('admin/user/index')
			->set('users', $users);
	}
	
	public function action_add()
	{
		// Post
		if ($post = Formaid::post())
		{
			try
			{
				// Create the user
				$user = ORM::factory('user')->create($post, array(
					'username',
					'email',
				));

				// Generate random password
				$password = Text::random();

				// Send e-mail
				$subject = 'Your username and password';
	           
				$from = 'info@'.$_SERVER['HTTP_HOST'];
				$to = $user->email;
				$message = View::factory('admin/emails/newuser')
					->set('username', $user->username)
					->set('password', $password);

				Email::instance()
				  ->from($from)
				  ->to($to)
				  ->subject($subject)
				  ->message($message, true)
				  ->send();

				// Save
				$user->password = $password;
				$user->save();

				// Give the user login privilege
				$user->add('roles', ORM::factory('Role', array('name' => 'login')));

				// Success
				$this->redirect('/admin/user/index/success/added');
			}
			catch(ORM_Validation_Exception $e)
			{
				// Errors
				Formaid::errors($e->errors('admin/user'));
			}
		}
		
		// Form
		$form = Formaid::form()
			->text('username')->label('Username')
			->text('email')->label('Email')
			->submit('Add User');
		
		// View
		$this->template->content = View::factory('admin/user/add')
			->bind('form', $form);
		$this->template->title = 'Add User';
	}
	
	public function action_delete()
	{
		// Get the user to be deleted
		$user = ORM::factory('user', $this->request->param('var'));

		// Can't delete self
		if ($this->user->id === $user->id)
		{
			$this->redirect('/admin/user/index/error/deleteself');
		}

		// Can't delete me
		if ($user->username === 'chris')
		{
			$this->redirect('/admin/user/index/error/deletechris');
		}

		// Otherwise delete ok
		if ($post = Formaid::post())
		{
			if ($post['response'] === 'yes')
			{
				$id = $this->request->param('var');
				$obj = ORM::factory('user')->where('id', '=', $id)->find();
				$obj->delete();

				$this->redirect('/admin/user/index/success/deleted');
			}
			else{
				$this->redirect('/admin/user');
			}
		}
		
		// Form
		$yesform = Formaid::form()
			->hidden('response')->value('yes')
			->submit('Yes');

		$noform = Formaid::form()
			->hidden('response')->value('no')
			->submit('No');

		// View
		Styles::add('admin/delete', Styles::PAGE);
		$this->template->content = View::factory('admin/user/delete')
			->bind('user', $user)
			->bind('yesform', $yesform)
			->bind('noform', $noform);

		$this->template->title = 'Delete User';
	}
}
