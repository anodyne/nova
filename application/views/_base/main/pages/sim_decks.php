<?php echo text_output($header, 'h1', 'page-head');?>

<?php if (isset($specs)): ?>
	<?php if (count($specs) > 0): ?>
		<?php foreach ($specs as $key => $value): ?>
			<?php echo anchor('sim/decks/'.$key, $value['name'], array('class' => 'bold fontMedium')).' &ndash; '.text_output($value['desc'], 'span', 'fontSmall');?>
			<br />
		<?php endforeach;?>
	<?php else: ?>
		<?php echo text_output($label['nodecks'], 'h3', 'orange');?>
	<?php endif;?>
<?php else: ?>
	<p><?php echo link_to_if($edit_valid, 'manage/decks', $label['edit'], array('class' => 'edit fontSmall bold'));?></p>
	
	<?php if (isset($decks)): ?>
		<table class="zebra table100" cellpadding="3">
			<tbody>
			<?php foreach ($decks as $deck): ?>
				<tr>
					<td class="cell-label"><?php echo $deck['name'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo text_output($deck['content'], '');?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php else: ?>
		<?php echo text_output($label['nodecks'], 'h3', 'orange');?>
	<?php endif; ?>
<?php endif;?>