<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<div id="loader" class="loader">
	<?php echo img($loader);?>
	<?php echo text_output($label['loading'], 'h3', 'gray');?>
</div>

<div id="manifest" class="hidden">
	<?php if (isset($manifests)): ?>
		<div class="fontSmall line_height_18">
			<strong><?php echo $label['manifests'];?> &mdash;</strong>
			<?php $i = 1;?>
			<?php foreach ($manifests as $m): ?>
				<?php echo anchor('personnel/index/'.$m['id'], $m['name'], array('rel' => 'tooltip', 'title' => $m['desc']));?>
				<?php if ($i < count($manifests)): ?>
					&middot;
				<?php endif;?>
				<?php ++$i;?>
			<?php endforeach;?>
		</div>
		<hr />
	<?php endif;?>
	
	<?php echo text_output($manifest_header);?>
	
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
	
	<?php if (isset($top)): ?>
		<div id="top-open" class="hidden">
			<br />
			<h2 class="page-subhead"><?php echo $label['top_positions'];?></h2>
			
			<table class="table100" cellpadding="3" border="0">
				<tbody>
					<?php foreach ($top as $t): ?>
						<tr class="fontSmall">
							<td class="col_15"></td>
							<td class="col_150"><?php echo img($t['blank_img']);?></td>
							<td>
								<strong class="fontMedium"><?php echo $t['name'];?></strong><br />
								<?php echo anchor('main/join/'. $t['id'], $label['apply']);?>
							</td>
							<td></td>
							<td class="col_75"></td>
						</tr>
					<?php endforeach;?>
				</tbody>
			</table>
		</div>
	<?php endif;?>

	<?php if (isset($depts)): ?>
		<br /><table class="" cellpadding="3" border="0">
		
		<?php foreach ($depts as $dept): ?>
			<tr>
				<td colspan="5"><h3><?php echo $dept['name'];?></h3></td>
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
								<td class="col_150"><?php echo img($char['rank_img']);?></td>
								<td>
									<strong class="fontMedium"><?php echo $char['name'];?></strong><br />

									<?php if ( ! empty($char['metadata'])): ?>
										<span class="gray"><?php echo $char['metadata'];?></span><br />
									<?php endif;?>
									
									<?php echo $pos['name'];?>
									
									<?php if ($char['crew_type'] == 'npc'): ?>
										<br /><?php echo text_output($label['npc'], 'span', 'gray');?>
									<?php elseif ($char['crew_type'] == 'inactive'): ?>
										<br /><?php echo text_output($label['inactive'], 'span', 'gray');?>
									<?php endif; ?>
								</td>
								<td></td>
								<td class="col_75 align_right">
									<?php echo anchor('personnel/character/'. $char['char_id'], img($char['combadge']), array('class' => 'bold image'));?>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				
					<?php if ($pos['open'] > 0 && $dept['type'] == 'playing'): ?>
						<tr class="open fontSmall hidden">
							<td class="col_15"></td>
							<td class="col_150"><?php echo img($pos['blank_img']);?></td>
							<td>
								<strong class="fontMedium"><?php echo $pos['name'];?></strong><br />
								<?php echo anchor('main/join/'. $pos['pos_id'], $label['apply']);?>
							</td>
							<td></td>
							<td class="col_75"></td>
						</tr>
					<?php endif; ?>
				
				<?php endforeach; ?>
			<?php endif; ?>
		
			<?php if (isset($dept['sub'])): ?>
				<?php foreach ($dept['sub'] as $sub): ?>
					<tr>
						<td class="col_15"></td>
						<td colspan="4"><h4><?php echo $sub['name'];?></h4></td>
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
										<td class="col_150"><?php echo img($char['rank_img']);?></td>
										<td>
											<strong class="fontMedium"><?php echo $char['name'];?></strong><br />

											<?php if ( ! empty($char['metadata'])): ?>
												<span class="gray"><?php echo $char['metadata'];?></span><br />
											<?php endif;?>

											<?php echo $spos['name'];?>
											
											<?php if ($char['crew_type'] == 'npc'): ?>
												<br /><?php echo text_output($label['npc'], 'span', 'gray');?>
											<?php elseif ($char['crew_type'] == 'inactive'): ?>
												<br /><?php echo text_output($label['inactive'], 'span', 'gray');?>
											<?php endif; ?>
										</td>
										<td></td>
										<td class="col_75 align_right">
											<?php echo anchor('personnel/character/'. $char['char_id'], img($char['combadge']), array('class' => 'bold image'));?>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
						
							<?php if ($spos['open'] > 0 && $sub['type'] == 'playing'): ?>
								<tr class="open fontSmall hidden">
									<td class="col_15"></td>
									<td class="col_150"><?php echo img($spos['blank_img']);?></td>
									<td>
										<strong class="fontMedium"><?php echo $spos['name'];?></strong><br />
										<?php echo anchor('main/join/'. $spos['pos_id'], $label['apply']);?>
									</td>
									<td></td>
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