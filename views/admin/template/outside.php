<!DOCTYPE html>
<html>
	<head>
		<?php echo View::factory('admin/includes/header')
				->bind('title', $title) ?>
	</head>
	<body class="<?php echo Request::current()->action(); ?>_page">
		<div class="wrapper">
			<div class="content">
				<?php echo $content ?>
			</div>
		</div>
	<?php Scripts::output('admin_outside') ?>
	</body>
</html>
