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
			<?php echo text_output($s['name'], 'h3');?>
			
			<?php if (isset($s['fields'])): ?>
				<table class="table100 zebra" cellpadding="3">
					<tbody>
					<?php foreach ($s['fields'] as $field): ?>
						<tr>
							<td class="cell-label"><?php echo $field['field_label'];?></td>
							<td class="cell-spacer"></td>
							<td><?php echo $field['input'];?></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
					
			<?php else: ?>
				<?php echo text_output($label['no_specs'], 'h4', 'orange');?>
			<?php endif; ?>
		<?php endforeach; ?>
		
		<?php echo form_button($button_submit);?>
	<?php echo form_close();?>
<?php else: ?>
	<?php echo text_output($label['no_specs'], 'h3', 'orange');?>
<?php endif; ?>