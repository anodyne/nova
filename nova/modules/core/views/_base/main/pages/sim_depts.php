<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php if ($edit_valid_dept === TRUE || $edit_valid_pos === TRUE): ?>
	<p>
	<?php echo link_to_if($edit_valid_dept, 'manage/depts', $label['edit_dept'], array('class' => 'edit fontSmall bold'));?>
	<?php echo link_to_if($edit_valid_pos, 'manage/positions', $label['edit_pos'], array('class' => 'edit fontSmall bold'));?>
	</p>
<?php endif;?>

<?php if (isset($msg_error)): ?>
	<?php echo $msg_error;?>
<?php else: ?>
	<ul class="none margin0 padding0">
		
	<?php foreach ($depts as $value): ?>
		<li>
			<?php echo text_output($value['name'], 'h2');?>
			<?php echo text_output($value['desc']);?>
			
			<?php if (isset($value['positions'])): ?>
				<p><?php echo anchor('#', $label['toggle'], array('myID' => $value['id'], 'class' => 'toggle bold'));?></p>
				
				<div id="<?php echo $value['id'];?>" class="hidden">
					<table class="table100 zebra" cellspacing="0" cellpadding="3">
					<?php foreach ($value['positions'] as $pos1): ?>
						<tr>
							<td class="cell-label align_top"><?php echo $pos1['name'];?></td>
							<td class="cell-spacer"></td>
							<td><?php echo text_output($pos1['desc'], '');?></td>
						</tr>
					<?php endforeach; ?>
					</table>
				</div>
			<?php endif; ?>
			
			<?php if (isset($value['subs'])): ?>
				<ul class="none margin1 padding1">
				<?php foreach ($value['subs'] as $sub): ?>
					<li>
						<h3><?php echo $sub['name'];?></h3>
						<p><?php echo $sub['desc'];?></p>
						
						<?php if (isset($sub['positions'])): ?>
							<p><?php echo anchor('#', $label['toggle'], array('myID' => $sub['id'], 'class' => 'toggle bold'));?></p>
							
							<div id="<?php echo $sub['id'];?>" class="hidden">
								<table class="table100 zebra" cellspacing="0" cellpadding="3">
								<?php foreach ($sub['positions'] as $pos2): ?>
									<tr>
										<td class="cell-label"><?php echo $pos2['name'];?></td>
										<td class="cell-spacer"></td>
										<td><?php echo text_output($pos2['desc'], '');?></td>
									</tr>
								<?php endforeach; ?>
								</table>
							</div>
						<?php endif; ?>
			
					</li>
				<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
	
	</ul>
<?php endif; ?>