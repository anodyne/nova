<fieldset>
	<legend><?php echo $s->name;?></legend>

	<?php if (is_array($fields) and array_key_exists($s->id, $fields)): ?>
		<?php foreach ($fields[$s->id] as $f): ?>
			
			<?php echo View::forge(Location::file('forms/field', $skin, 'partials'), array('f' => $f, 'data' => $data))->render();?>
			
		<?php endforeach;?>
	<?php endif;?>
</fieldset>