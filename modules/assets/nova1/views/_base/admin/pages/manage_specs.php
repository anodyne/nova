<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>

<?php if ($this->auth->check_access('site/specsform', FALSE) !== FALSE): ?>
	<p class="bold">
		<?php echo anchor('site/specsform', img($images['form']) .' '. $label['specsform'], array('class' => 'image'));?>
	</p>
<?php endif;?>

<?php if (isset($specs)): ?>
	<?php echo form_open('manage/specs');?>
		<?php foreach ($specs as $s): ?>
			<?php echo text_output($s['name'], 'h3', 'page-subhead');?>
			
			<?php if (isset($s['fields'])): ?>
				<div class="indent-left">
				<?php foreach ($s['fields'] as $field): ?>
					<p>
						<kbd><?php echo $field['field_label'];?></kbd>
						<?php echo $field['input'];?>
					</p>
				<?php endforeach; ?>
				</div>
					
			<?php else: ?>
				<?php echo text_output($label['no_specs'], 'h4', 'orange');?>
			<?php endif; ?>
		<?php endforeach; ?>
		
		<br />
		<p><?php echo form_button($button_submit);?></p>
	<?php echo form_close();?>
<?php else: ?>
	<?php echo text_output($label['no_specs'], 'h3', 'orange');?>
<?php endif; ?>