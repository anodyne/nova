<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>

<p class="bold">
	<?php echo anchor('site/biotabs', img($images['tabs']) .' '. $label['biotabs'], array('class' => 'image'));?><br />
	<?php echo anchor('site/biosections', img($images['sections']) .' '. $label['biosections'], array('class' => 'image'));?>
	<br /><br />
	<a href="#" rel="facebox" class="image" myAction="add">
		<?php echo img($images['add_field']) .' '. $label['biofield'];?>
	</a>
</p><br />

<?php if (isset($join)): ?>
	<?php foreach ($join as $a): ?>
		
		<?php echo text_output($a['name'], 'h3', 'page-subhead');?>
		
		<?php if (isset($a['fields'])): ?>
			<table class="table100 zebra">
				<tbody>
					
				<?php foreach ($a['fields'] as $f): ?>
					<tr>
						<td class="cell-label">
							<?php echo $f['field_label'];?>
							<?php if ($f['display'] == 'n'): ?>
								<?php echo text_output($label['off'], 'div', 'fontSmall red bold');?>
							<?php endif;?>
						</td>
						<td class="cell-spacer"></td>
						<td><?php echo $f['input'];?></td>
						<td class="col_75 align_right">
							<a href="#" rel="facebox" myAction="delete" myID="<?php echo $f['id'];?>" class="image"><?php echo img($images['delete']);?></a>
							&nbsp;
							<?php echo anchor('site/bioform/edit/'. $f['id'], img($images['edit']), array('class' => 'image'));?>
						</td>
					</tr>
				<?php endforeach; ?>
				
				</tbody>
			</table><br />
		<?php else: ?>
			<?php echo text_output($label['nofields'], 'h4', 'orange');?>
		<?php endif; ?>
	<?php endforeach; ?>
<?php else: ?>
	<?php echo text_output($label['nofields'], 'h3', 'orange');?>
<?php endif; ?>