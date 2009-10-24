<?php echo text_output($header, 'h1', 'page-head');?>

<?php if (!isset($chars)): ?>
	<?php echo text_output($label['select'], 'h4', 'gray');?>
	
	<?php foreach ($all as $key => $a): ?>
		<?php echo anchor('user/characterlink/'. $key, $a, array('class' => 'bold'));?><br />
	<?php endforeach;?>
<?php else: ?>
	<?php echo text_output($text);?>
	
	<p class="bold fontMedium"><?php echo anchor('user/characterlink', $label['allchars']);?></p>
	
	<?php echo text_output($label['player'], 'h2', 'page-subhead');?>
	
	<strong><?php echo $label['name'];?></strong> &ndash; <?php echo $p_name;?><br />
	<strong><?php echo $label['email'];?></strong> &ndash; <?php echo $p_email;?>
	
	<?php echo text_output($label['current'], 'h2', 'page-subhead');?>
	
	<?php if (is_array($chars) && count($chars) > 0): ?>
		<table class="zebra table50">
			<tbody>
			<?php foreach ($chars as $key => $c): ?>
				<tr>
					<td>
						<?php if ($c['main'] === TRUE): ?>
							<?php echo img($images['main']) .' ';?>
						<?php elseif ($c['type'] == 'Inactive'): ?>
							<?php echo img($images['inactive']) .' ';?>
						<?php elseif ($c['type'] == 'NPC'): ?>
							<?php echo img($images['npc']) .' ';?>
						<?php elseif ($c['type'] == 'Active'): ?>
							<?php echo img($images['active']) .' ';?>
						<?php endif;?>
						
						<?php echo text_output($c['name'], 'span', 'bold gray');?><br />
						<?php echo text_output($c['position'], 'span', 'fontSmall gray');?><br />
						<?php echo text_output($c['type'], 'span', 'fontSmall gray');?>
					</td>
					<td class="cell-spacer"></td>
					<td class="col_30 align_right"><?php echo anchor('user/characterlink/'. $player .'/remove/'. $key, img($images['remove']), array('class' => 'image'));?></td>
					<td class="col_30 align_right">
						<?php if ($c['main'] === FALSE && $c['type'] == 'Active'): ?>
							<?php echo anchor('user/characterlink/'. $player .'/set/'. $key, img($images['star']), array('class' => 'image'));?>
						<?php endif;?>
					</td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
	<?php else: ?>
		<?php echo text_output($label['nocharacters'], 'h4', 'orange');?>
	<?php endif;?>
	
	<?php echo text_output($label['add'], 'h2', 'page-subhead');?>
	
	<div id="tabs">
		<ul>
			<li><a href="#one"><span><?php echo $label['chars_playing'];?></span></a></li>
			<li><a href="#two"><span><?php echo $label['chars_nonplaying'];?></span></a></li>
		</ul>
		
		<div id="one">
			<?php if (isset($unassigned['active'])): ?>
				<br /><table class="zebra table50">
					<tbody>
					<?php foreach ($unassigned['active'] as $key => $p): ?>
						<tr>
							<td>
								<?php echo text_output($p['name'], 'span', 'bold gray');?><br />
								<?php echo text_output($p['position'], 'span', 'fontSmall gray');?>
							</td>
							<td class="cell-spacer"></td>
							<td class="col_30">
								<?php if ($count_active < $this->options['allowed_chars_playing']): ?>
									<?php echo anchor('user/characterlink/'. $player .'/add/'. $key, img($images['add']), array('class' => 'image'));?>
								<?php endif;?>
							</td>
						</tr>
					<?php endforeach;?>
					</tbody>
				</table>
			<?php else: ?>
				<?php echo text_output($label['nocharacters'], 'h3', 'orange');?>
			<?php endif;?>
		</div>
		
		<div id="two">
			<?php if (isset($unassigned['npc'])): ?>
				<br /><table class="zebra table50">
					<tbody>
					<?php foreach ($unassigned['npc'] as $key => $n): ?>
						<tr>
							<td>
								<?php echo text_output($n['name'], 'span', 'bold gray');?><br />
								<?php echo text_output($n['position'], 'span', 'fontSmall gray');?>
							</td>
							<td class="cell-spacer"></td>
							<td class="col_30">
								<?php if ($count_npc < $this->options['allowed_chars_npc']): ?>
									<?php echo anchor('user/characterlink/'. $player .'/add/'. $key, img($images['add']), array('class' => 'image'));?>
								<?php endif;?>
							</td>
						</tr>
					<?php endforeach;?>
					</tbody>
				</table>
			<?php else: ?>
				<?php echo text_output($label['nocharacters'], 'h3', 'orange');?>
			<?php endif;?>
		</div>
	</div>
<?php endif;?>