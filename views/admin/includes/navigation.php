<ul class="navigation">
	<?php foreach($modules AS $name => $label): ?>
		<li class="nav_item <?php echo $name ?>">
			<?php echo HTML::anchor('admin/'.$name, $label, array('class' => 'nav_item_link')) ?>
		</li>
	<?php endforeach; ?>
</ul>
