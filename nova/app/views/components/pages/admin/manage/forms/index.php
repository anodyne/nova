<?php if ($forms): ?>
	<ul>
	<?php foreach ($forms as $form): ?>
		<li><a href="<?php echo Url::site('admin/manage/forms/edit/'.$form->key);?>"><?php echo $form->name;?></a></li>
	<?php endforeach;?>
	</ul>
<?php endif;?>