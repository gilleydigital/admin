<?php
// Form
echo Formaid::form()
	->html('<h2>Change Info</h2>')
	->text('username')->label('Username')->value($me->username)
	->text('email')->label('Email')->value($me->email)
	->html('<h2>Change Password</h2>')
	->password('password')->label('New Password')
	->password('password_confirm')->label('Confirm Password')
	->submit('Update');
