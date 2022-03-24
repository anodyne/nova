<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php if (isset($roles)): ?>
	<?php echo text_output($label['roles'], 'h3');?>
	
	<?php $i = 0;?>
	<table class="table100">
		<tbody>
		<?php foreach ($roles as $key => $role): ?>
			<?php if ($i % 4 == 0): ?>
				<tr>
			<?php endif;?>
					
					<td>
						<?php echo form_checkbox('roles[]', $key, in_array($key, $checked), 'id="'.$key.'"');?>
						<label for="<?php echo $key;?>"><?php echo $role;?></label>
					</td>
					
					<?php if($i == (count($roles) - 1)): ?>
						<?php while (($i + 1) % 4 != 0): ?>
							<td>&nbsp;</td>
							<?php $i++;?>
						<?php endwhile; ?>
					<?php endif;?>
					
				<?php if (($i + 1) % 4 == 0): ?>
					</tr>
				<?php endif;?>
			<?php $i++;?>
		<?php endforeach;?>
		</tbody>
	</table><br />
	
	<?php echo form_button($submit);?>
	&nbsp;
	<span id="submit-loading" class="hidden"><?php echo img($images['loading']);?></span>
	<span id="submit-success" class="hidden"><?php echo img($images['success']);?></span>
	<span id="submit-failure" class="hidden"><?php echo img($images['failure']);?></span>
<?php else: ?>
	<?php echo text_output($label['no_roles'], 'h3', 'orange');?>
<?php endif;?>