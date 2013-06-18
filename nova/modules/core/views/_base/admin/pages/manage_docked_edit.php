<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<p class="bold"><?php echo anchor('manage/docked', $label['back']);?></p><br />

<?php echo form_open('manage/docked/edit/'. $id);?>
	<?php echo text_output($label['info'], 'h3', 'page-subhead');?>
	<div class="indent-left">
		<p>
			<kbd><?php echo $label['sim_name'];?></kbd>
			<?php echo form_input($inputs['sim_name']);?>
		</p>
		<p>
			<kbd><?php echo $label['sim_url'];?></kbd>
			<?php echo form_input($inputs['sim_url']);?>
		</p>
		<p>
			<kbd><?php echo $label['status'];?></kbd>
			<?php echo form_dropdown('docking_status', $values, $status);?>
		</p>
	</div><br />
	
	<?php echo text_output($label['gm_info'], 'h3', 'page-subhead');?>
	<div class="indent-left">
		<p>
			<kbd><?php echo $label['name'];?></kbd>
			<?php echo form_input($inputs['gm_name']);?>
		</p>
		<p>
			<kbd><?php echo $label['email'];?></kbd>
			<?php echo form_input($inputs['gm_email']);?>
		</p>
	</div><br />
	
	<?php if (isset($docking)): ?>
		<?php foreach ($docking as $a): ?>
			<?php if (isset($a['fields'])): ?>
				<?php echo text_output($a['name'], 'h3', 'page-subhead');?>
				
				<div class="indent-left">
					<?php foreach ($a['fields'] as $f): ?>
						<p>
							<kbd><?php echo $f['field_label'];?></kbd>

							<?php if ( ! empty($f['field_help'])): ?>
								<p class="gray fontSmall"><?php echo $f['field_help'];?></p>
							<?php endif;?>
							
							<?php echo $f['input'];?>
						</p>
					<?php endforeach; ?>
				</div><br />
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>
	
	<br />
	<?php echo form_hidden('action_id', $id);?>
	<?php echo form_button($buttons['update']);?>
<?php echo form_close();?>