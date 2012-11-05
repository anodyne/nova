<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>

<?php if (Auth::check_access('site/specsform', false)): ?>
	<p class="bold">
		<?php echo anchor('site/specsform', img($images['form']) .' '. $label['form'], array('class' => 'image'));?>
	</p>
<?php endif;?>

<p class="bold">
	<?php echo anchor('manage/specs/add', img($images['add']) .' '. $label['add'], array('class' => 'image'));?>
</p>

<?php if (isset($specs)): ?>
	<br />
	
	<table class="table100 zebra">
		<tbody>
		<?php foreach ($specs as $s): ?>
			<tr>
				<td>
					<strong><?php echo $s['name'];?></strong><br />
					<span class="gray fontSmall">
						<strong><?php echo $label['summary'];?></strong>
						<?php echo $s['summary'];?>
					</span>
				</td>
				<td class="col_75 align_right">
					<a href="#" myAction="delete" myID="<?php echo $s['id'];?>" rel="facebox" class="image"><?php echo img($images['delete']);?></a>
					&nbsp;
					<?php echo anchor('manage/specs/edit/'. $s['id'], img($images['edit']), array('class' => 'image'));?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
	<?php echo form_open().form_close();?>
<?php else: ?>
	<?php echo text_output($label['no_specs'], 'h3', 'orange');?>
<?php endif;?>