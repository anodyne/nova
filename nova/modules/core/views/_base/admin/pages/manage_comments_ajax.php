<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($label[$subheader], 'h2', 'page-subhead');?>

<?php if (isset($entries)): ?>
	<table class="table100 zebra">
		<tbody>
		<?php foreach ($entries as $e): ?>
			<tr>
				<td class="col_40pct">
					<strong><?php echo $e['author'];?></strong><br />
					<span class="fontSmall gray">
						<?php echo $e['source'];?><br />
						<?php echo $label['on'] .' '. $e['date'];?>
					</span>
				</td>
				<td class="fontSmall"><?php echo $e['content'];?></td>
				<td class="col_75 align_right">
					<?php if ($e['status'] == 'pending'): ?>
						<a href="#" rel="facebox" class="image" myAction="approve" myID="<?php echo $e['id'];?>" myType="<?php echo $type;?>_comment"><?php echo img($images['approve']);?></a>
						&nbsp;
					<?php endif;?>
					<a href="#" rel="facebox" class="image" myAction="delete" myID="<?php echo $e['id'];?>" myType="<?php echo $type;?>" myStatus="<?php echo $status;?>" myPage="<?php echo $page;?>">
						<?php echo img($images['delete']);?>
					</a>
					&nbsp;
					<a href="#" rel="facebox" class="image" myAction="edit" myID="<?php echo $e['id'];?>" myType="<?php echo $type;?>" myStatus="<?php echo $status;?>" myPage="<?php echo $page;?>">
						<?php echo img($images['edit']);?>
					</a>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table><br />
	
	<?php echo $pagination;?>
<?php else: ?>
	<?php echo text_output($label['error'], 'h3', 'orange');?>
<?php endif;?>