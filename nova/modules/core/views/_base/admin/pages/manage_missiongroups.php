<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>

<p class="bold"><a href="#" rel="facebox" myAction="add" class="image"><?php echo img($images['add']) .' '. $label['addgroup'];?></a></p>

<?php if (isset($groups)): ?>
	<table class="table100 zebra">
		<tbody>
			<?php foreach ($groups as $g): ?>
			<tr>
				<td colspan="2" class="bold col-30pct"><?php echo $g['name'];?></td>
				<td><?php echo text_output($g['desc']);?></td>
				<td class="col_100 align_right">
					<?php echo anchor('sim/missions/group/'. $g['id'], img($images['view']), array('class' => 'image'));?>
					&nbsp;
					<a href="#" myAction="delete" myID="<?php echo $g['id'];?>" rel="facebox" class="image"><?php echo img($images['delete']);?></a>
					&nbsp;
					<a href="#" myAction="edit" myID="<?php echo $g['id'];?>" rel="facebox" class="image"><?php echo img($images['edit']);?></a>
				</td>
			</tr>
				<?php if (isset($g['children'])): ?>
					<?php foreach ($g['children'] as $g): ?>
					<tr>
						<td class="col-30"></td>
						<td class="bold col-30pct"><?php echo $g['name'];?></td>
						<td><?php echo text_output($g['desc']);?></td>
						<td class="col_100 align_right">
							<?php echo anchor('sim/missions/group/'. $g['id'], img($images['view']), array('class' => 'image'));?>
							&nbsp;
							<a href="#" myAction="delete" myID="<?php echo $g['id'];?>" rel="facebox" class="image"><?php echo img($images['delete']);?></a>
							&nbsp;
							<a href="#" myAction="edit" myID="<?php echo $g['id'];?>" rel="facebox" class="image"><?php echo img($images['edit']);?></a>
						</td>
					</tr>
					<?php endforeach;?>
				<?php endif;?>
			<?php endforeach;?>
		</tbody>
	</table>
<?php else: ?>
	<?php echo text_output($label['nogroups'], 'h3', 'orange');?>
<?php endif;?>