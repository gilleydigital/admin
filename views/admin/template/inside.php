<!DOCTYPE html>
<html>
	<head>
		<?php echo View::factory('admin/includes/header')
				->bind('title', $title) ?>
	</head>
	<body class="<?php echo Request::current()->action(); ?>_page">
		<div class="wrapper">
			<div class="menu">
				<h1 class="site_name">
					<?php echo HTML::anchor('admin', $header, array('class' => 'site_name_link')) ?>
				</h1>
				<?php echo View::factory('admin/includes/navigation'); ?>
			</div>
			<div class="content">
				<div class="header clear">
					<h2 class="page_title"><?php echo $title ?></h2>
					<h3 class="user_info">
						Logged in as <?php echo HTML::anchor('admin/profile', $me->username, array('class' => 'user_info_link')) ?>.
						<?php echo HTML::anchor('admin/auth/logout', 'Logout', array('class' => 'user_info_link')) ?>
					</h3>
				</div>
				<div class="inner_content">
					<?php echo $content ?>
				</div>
			</div>
		</div>
		<div id="preload">
			<?php echo HTML::image('media/admin/graphics/button-hover.png', array('alt' => '')) ?>
		</div>
	</body>
	<?php Scripts::output('admin') ?>
</html>
