<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<p class="bold"><?php echo anchor('manage/awards/add', img($images['add']) .' '. $label['addaward'], array('class' => 'image'));?></p><br>

<?php if (isset($awards)): ?>
	<table class="table100 zebra">
		<tbody>
		<?php foreach ($awards as $a): ?>
			<tr>
				<td class="col_150"><?php echo img($a['img']);?></td>
				<td>
					<strong><?php echo $a['name'];?></strong><br />
					<?php echo text_output($a['desc'], 'span', 'fontSmall gray');?>
				</td>
				<td class="col_75 align_right">
					<a href="#" myAction="delete" myID="<?php echo $a['id'];?>" rel="facebox" class="image"><?php echo img($images['delete']);?></a>
					&nbsp;
					<?php echo anchor('manage/awards/edit/'. $a['id'], img($images['edit']), array('class' => 'image'));?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php else: ?>
	<?php echo text_output($label['noawards'], 'h3', 'orange');?>
<?php endif;?>