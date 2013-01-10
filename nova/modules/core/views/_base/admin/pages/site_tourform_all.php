<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>

<p class="bold">
	<a href="#" rel="facebox" class="image" myAction="add">
		<?php echo img($images['add_field']) .' '. $label['add'];?>
	</a>
</p>
<br />

<?php if (isset($tour)): ?>
	<table class="table100 zebra">
		<tbody>
			
		<?php foreach ($tour as $t): ?>
			<tr>
				<td class="cell-label">
					<?php echo $t['label'];?>
					<?php if ($t['display'] == 'n'): ?>
						<?php echo text_output($label['off'], 'div', 'fontSmall red bold');?>
					<?php endif;?>
				</td>
				<td class="cell-spacer"></td>
				<td><?php echo $t['input'];?></td>
				<td class="col_75 align_right">
					<a href="#" rel="facebox" myAction="delete" myID="<?php echo $t['id'];?>" class="image"><?php echo img($images['delete']);?></a>
					&nbsp;
					<?php echo anchor('site/tourform/edit/'. $t['id'], img($images['edit']), array('class' => 'image'));?>
				</td>
			</tr>
		<?php endforeach; ?>
		
		</tbody>
	</table>
<?php endif; ?>