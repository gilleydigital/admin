<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Auth extends Controller_Template {
	public $template = 'admin/template/outside';

	public function action_login()
	{
		// If they're already logged in, bump them to the main screen
		$this->user = Auth::instance()->get_user();
		if (is_object($this->user))
		{
			$this->redirect('admin');
		}

		// Post
		if ($post = Formaid::post())
		{
			// Attempt Login
			$success = Auth::instance()->login($post['username'], $post['password'], isset($post['remember_me']));			

			if ($success)
			{
				// Success
				$this->redirect('admin');
			}
			else
			{
				// Failure
				Formaid::error('admin/auth', 'bad_login');
			}
		}
		
		// Form
		$form = Formaid::form()
			->text('username')->label('Username')
			->password('password')->label('Password')
			->checkbox('remember_me')->label('Remember Me')
			->submit('Login');
		
		// View
		Styles::add('admin/login', Styles::PAGE);
		Scripts::add('admin/login', Scripts::CONTROLLER);
		
		$this->template->content = View::factory('admin/auth/login')
			->bind('form', $form);
		
		$this->template->title = 'Login';
	}

	public function action_logout()
	{
		Auth::instance()->logout();
		$this->redirect('admin/auth/login');
	}
	
	public function action_forgotpassword()
	{
		// Post
		if ($post = Formaid::post())
		{
			// Get user
			$user = ORM::factory('user')
				->where('email', '=', $post['email'])
				->find();

			if ($user->loaded())
			{
				// Reset Data
				$data = array(
					'user_id' => $user->id,
					'expires' => time() + (60 * 60 * 48), // 48 hours
				);

				// Create a new reset token
				$token = ORM::factory('user_reset')
							->values($data)
							->create();
				
				$link = URL::base('http').'admin/auth/reset/'.$token->token;

				//Mail
				$subject = 'Password request for '.$user->username;
				$from = 'info@'.$_SERVER['HTTP_HOST'];
				$to = $user->email;
				$message = View::factory('admin/emails/forgotpassword')
					->set('link', $link);
				
				Email::instance()
				  ->from($from)
				  ->to($to)
				  ->subject($subject)
				  ->message($message, true)
				  ->send();				
								
				// Success
				Formaid::success('admin/auth', 'password_email_sent');
			}
			else
			{
				// Email does not belong to any user
				Formaid::error('admin/auth', 'no_such_email');
			}
		}
		
		// Messages
		Formaid::messages('admin/auth', $this->request->param('var'), $this->request->param('subvar'));
		
		// Form
		$form = Formaid::form()
			->text('email')->label('Email')->id('email')
			->submit('Send');
		
		// View
		$this->template->content = View::factory('admin/auth/forgotpassword')
			->bind('form', $form);
		$this->template->title = 'Forgot Password';
	}
	
	public function action_reset()
	{
		// Get the user
		$token = $this->request->param('var');
		$reset = ORM::factory('user_reset', array('token' => $token));
		$user = ORM::factory('user', $reset->user_id);

		if ($user->loaded())
		{
			// Post
			if ($post = Formaid::post())
			{
				// Rules
				$post->add_password_validation();

				if ($post->check())
				{
					// Save profile
					$user->password = $post['password'];
					$user->save();

					// Delete the reset codes for this user
					$user_resets = ORM::factory('user_reset')
						->where('user_id', '=', $user->id)
						->find_all();

					foreach($user_resets AS $row)
					{
						$row->delete();
					}

					// Success
					Auth::instance()->force_login($user);
					$this->redirect('admin/dashboard/index/success/password_reset');
				}
				else{
					// Failure
					Formaid::errors($post->errors('contact'));
				}
			}
			
			// Form
			$form = Formaid::form()
				->password('password')->label('New Password')
				->password('password_confirm')->label('Confirm Password')
				->submit('Update');

			// View
			$this->template->content = View::factory('admin/auth/reset')
				->set('me', $user)
				->bind('form', $form);
			$this->template->title = 'Set New Password';
		}
		else
		{
			// User didn't load, token is out of date
			$this->redirect('admin/auth/forgotpassword/error/reset_expired');
		}
	}
}
