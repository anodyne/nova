<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php if ($edit_valid === TRUE || $edit_valid_form === TRUE): ?>
	<p>
		<?php echo link_to_if($edit_valid, 'manage/specs', $label['edit'], array('class' => 'edit fontSmall bold'));?>
		<?php echo link_to_if($edit_valid_form, 'site/specsform', $label['edit_form'], array('class' => 'edit fontSmall bold'));?>
	</p>
<?php endif;?>

<?php if (isset($sections)): ?>
	<?php foreach ($sections as $section): ?>
		<?php echo text_output($section['title'], 'h3', 'page-subhead');?>
		
		<?php if (isset($section['fields'])): ?>
		<table class="table100 zebra" cellpadding="3">
			<tbody>
			<?php foreach ($section['fields'] as $field): ?>
				<tr>
					<td class="cell-label"><?php echo $field['field'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo text_output($field['data'], '');?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table><br />
		<?php else: ?>
			<?php echo text_output($label['nospecs'], 'h4', 'orange');?>
		<?php endif; ?>
	<?php endforeach; ?>
<?php else: ?>
	<?php echo text_output($label['nospecs'], 'h3', 'orange');?>
<?php endif; ?>