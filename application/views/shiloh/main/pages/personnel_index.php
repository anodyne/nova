<?php echo text_output($header, 'h1', 'page-head');?>

<div id="loader" class="loader">
	<?php echo img($loader);?>
	<?php echo text_output($label['loading'], 'h3', 'gray');?>
</div>

<div id="manifest" class="hidden">
	<!-- manifest navigation table -->
	<div class="fontSmall line_height_18">
		<strong><?php echo $label['show'];?></strong> &mdash;
			<?php echo anchor('#', $label['all_chars'], array('id' => 'all'));?> &middot;
			<?php echo anchor('#', $label['playing_chars'], array('id' => 'active'));?> &middot;
			<?php echo anchor('#', $label['npcs'], array('id' => 'npc'));?> &middot;
			<?php echo anchor('#', $label['open'], array('id' => 'open'));?> &middot;
			<?php echo anchor('#', $label['inactive_chars'], array('id' => 'inactive'));?>
	
		<br /><strong><?php echo $label['toggle'];?></strong> &mdash;
			<?php if($display == 'open'): ?>
			<?php else: ?>
				<?php echo anchor('#', $label['open'], array('id' => 'toggle_open'));?> &middot; 
			<?php endif; ?>
			<?php echo anchor('#', $label['npcs'], array('id' => 'toggle_npc'));?>
	</div>

	<?php if (isset($depts)): ?>
		<br /><table class="table100" cellpadding="3" border="0">
		
		<?php foreach ($depts as $dept): ?>
			<tr>
				<td colspan="6"><h3 class="page-subhead"><?php echo $dept['name'];?></h3></td>
			</tr>
		
			<?php if (isset($dept['pos'])): ?>
				<?php foreach ($dept['pos'] as $pos): ?>
				
					<?php if (isset($pos['chars'])): ?>
						<?php foreach ($pos['chars'] as $char): ?>
							<?php if ($char['crew_type'] == 'inactive'): ?>
								<?php $display = ' hidden'; ?>
							<?php else: ?>
								<?php $display = ''; ?>
							<?php endif; ?>
					
							<tr class="fontSmall hidden <?php echo $char['crew_type'] . $display;?>">
								<td class="col_15"></td>
								<td colspan="2" class="bold col_260"><?php echo $pos['name'];?></td>
								<td class="col_150 align_center"><?php echo img($char['rank_img']);?></td>
								<td class="col_260 bold">
									<?php echo $char['name'];?>
									
									<?php if ($char['crew_type'] == 'npc'): ?>
										<br /><?php echo text_output($label['npc'], 'span', 'gray');?>
									<?php elseif ($char['crew_type'] == 'inactive'): ?>
										<br /><?php echo text_output($label['inactive'], 'span', 'gray');?>
									<?php endif; ?>
								</td>
								<td class="col_75 align_right">
									<?php echo anchor('personnel/character/'. $char['char_id'], img($char['combadge']), array('class' => 'bold image'));?>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				
					<?php if ($pos['open'] > 0 && $dept['type'] == 'playing'): ?>
						<tr class="open fontSmall hidden">
							<td class="col_15"></td>
							<td colspan="2" class="bold col_260"><?php echo $pos['name'];?></td>
							<td class="col_150 align_center"><?php echo img($pos['blank_img']);?></td>
							<td class="col_260 bold"><?php echo anchor('main/join/'. $pos['pos_id'], $label['apply']);?></td>
							<td class="col_75"></td>
						</tr>
					<?php endif; ?>
				
				<?php endforeach; ?>
			<?php endif; ?>
		
			<?php if (isset($dept['sub'])): ?>
				<?php foreach ($dept['sub'] as $sub): ?>
					<tr>
						<td class="col_15"></td>
						<td colspan="5"><h4><?php echo $sub['name'];?></h4></td>
					</tr>
				
					<?php if (isset($sub['pos'])): ?>
						<?php foreach ($sub['pos'] as $spos): ?>
						
							<?php if (isset($spos['chars'])): ?>
								<?php foreach ($spos['chars'] as $char): ?>
									<?php if ($char['crew_type'] == 'inactive'): ?>
										<?php $display = ' hidden'; ?>
									<?php else: ?>
										<?php $display = ''; ?>
									<?php endif; ?>
							
									<tr class="fontSmall hidden <?php echo $char['crew_type'] . $display;?>">
										<td class="col_15"></td>
										<td class="col_15"></td>
										<td class="bold col_245"><?php echo $spos['name'];?></td>
										<td class="col_150 align_center"><?php echo img($char['rank_img']);?></td>
										<td class="col_260 bold">
											<?php echo $char['name'];?>
											
											<?php if ($char['crew_type'] == 'npc'): ?>
												<br /><?php echo text_output($label['npc'], 'span', 'gray');?>
											<?php elseif ($char['crew_type'] == 'inactive'): ?>
												<br /><?php echo text_output($label['inactive'], 'span', 'gray');?>
											<?php endif; ?>
										</td>
										<td class="col_75 align_right">
											<?php echo anchor('personnel/character/'. $char['char_id'], img($char['combadge']), array('class' => 'bold image'));?>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
						
							<?php if ($spos['open'] > 0 && $sub['type'] == 'playing'): ?>
								<tr class="open fontSmall hidden">
									<td class="col_15"></td>
									<td class="col_15"></td>
									<td class="bold col_245"><?php echo $spos['name'];?></td>
									<td class="col_150 align_center"><?php echo img($spos['blank_img']);?></td>
									<td class="col_260 bold"><?php echo anchor('main/join/'. $spos['pos_id'], $label['apply']);?></td>
									<td class="col_75"></td>
								</tr>
							<?php endif; ?>
					
						<?php endforeach; ?>
					<?php endif; ?>
				
				<?php endforeach; ?>
			<?php endif; ?>
		
		<?php endforeach; ?>
	
		</table>
	<?php endif; ?>
</div>