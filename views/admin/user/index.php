<?php echo View::factory('formaid/messages') ?>
<p><?php echo HTML::anchor('admin/user/add', 'Add User', array('class' => 'button')) ?></p>
<table class="data_table">
	<thead>
		<tr>
			<th class="first">Username</th>
			<th>Email</th>
			<th class="delete_header">Delete</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($users AS $user): ?>
		<tr>
			<td class="first"><?php echo $user->username ?></td>
			<td><?php echo $user->email ?></td>
			<td class="delete last">
				<?php
					echo HTML::anchor(
						'admin/user/delete/'.$user->id,
						HTML::image('media/admin/graphics/delete.png', array('alt' => 'Delete')),
						array('class' => 'delete_button'))
				?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<p><?php echo HTML::anchor('admin/user/add', 'Add User', array('class' => 'button')) ?></p>
