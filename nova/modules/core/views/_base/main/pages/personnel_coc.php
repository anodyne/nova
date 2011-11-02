<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<p><?php echo link_to_if($edit_valid, 'characters/coc', $label['edit'], array('class' => 'edit fontSmall bold'));?></p>

<?php if (isset($coc)): ?>
	<br /><table class="table100 zebra" cellpadding="5" cellspacing="0">
	<?php foreach ($coc as $v): ?>
		<tr>
			<td>
				<strong><?php echo $v['name'];?></strong><br />
				<span class="fontSmall"><?php echo $v['position'];?></span>
			</td>
			<td><?php echo img($v['img_rank']);?></td>
			<td class="align_right"><?php echo anchor('personnel/character/'. $v['id'], img($v['img_bio']), array('class' => 'image bold'));?></td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php else: ?>
	<?php echo text_output($error, 'h3', 'orange');?>
<?php endif; ?>