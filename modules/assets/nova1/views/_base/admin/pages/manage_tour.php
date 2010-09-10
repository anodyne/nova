<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>

<?php if ($this->auth->check_access('site/tourform', FALSE) !== FALSE): ?>
	<p class="bold">
		<?php echo anchor('site/tourform', img($images['form']) .' '. $label['form'], array('class' => 'image'));?>
	</p>
<?php endif;?>

<p class="bold">
	<?php echo anchor('manage/tour/add', img($images['add']) .' '. $label['add'], array('class' => 'image'));?>
</p>

<?php if (isset($tour)): ?>
	<br />
	
	<table class="table100 zebra">
		<tbody>
		<?php foreach ($tour as $t): ?>
			<tr>
				<td>
					<strong><?php echo $t['name'];?></strong><br />
					<span class="gray fontSmall">
						<strong><?php echo $label['summary'];?></strong>
						<?php echo $t['summary'];?>
					</span>
				</td>
				<td class="col_75 align_right">
					<a href="#" myAction="delete" myID="<?php echo $t['id'];?>" rel="facebox" class="image"><?php echo img($images['delete']);?></a>
					&nbsp;
					<?php echo anchor('manage/tour/edit/'. $t['id'], img($images['edit']), array('class' => 'image'));?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php else: ?>
	<?php echo text_output($label['no_tour'], 'h3', 'orange');?>
<?php endif;?>