<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>

<p class="bold">
	<?php echo anchor('site/bioform', img($images['form']) .' '. $label['bioform'], array('class' => 'image'));?><br />
	<?php echo anchor('site/biotabs', img($images['tabs']) .' '. $label['biotabs'], array('class' => 'image'));?><br /><br />
	<a href="#" rel="facebox" myAction="add" class="image"><?php echo img($images['add']) .' '. $label['addsection'];?></a>
</p>

<?php if (isset($sections)): ?>
	<table class="table100 zebra">
		<thead>
			<tr>
				<th><?php echo $label['name'];?></th>
				<th><?php echo $label['tab'];?></th>
				<th colspan="2"></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($sections as $sec): ?>
			<tr>
				<td class="bold col_50pct"><?php echo $sec['name'];?></td>
				<td>
					<?php echo (!empty($sec['tab'])) ? $sec['tab'] : text_output($label['invalid_tab'], 'span', 'red bold');?>
				</td>
				<td class="col_30 align_center">
					<a href="#" rel="facebox" class="delete image" myAction="delete" myID="<?php echo $sec['id'];?>" title="<?php echo $label['delete'];?>">
						<?php echo img($images['delete']);?>
					</a>
				</td>
				<td class="col_30 align_center">
					<a href="#" rel="facebox" class="edit image" myAction="edit" myID="<?php echo $sec['id'];?>" title="<?php echo $label['edit'];?>">
						<?php echo img($images['edit']);?>
					</a>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>