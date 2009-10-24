<?php echo text_output($header, 'h1', 'page-head');?>

<table class="table100 zebra">
	<thead>
		<tr>
			<th><?php echo $label['name'];?></th>
			<th colspan="2" width="12%"><?php echo $label['posts'];?></th>
			<th colspan="2" width="12%"><?php echo $label['logs'];?></th>
			<th colspan="2" width="12%"><?php echo $label['news'];?></th>
			<th colspan="2" width="12%"><?php echo $label['totals'];?></th>
		</tr>
		<tr>
			<th class="fontTiny"><?php echo $label['days'];?></th>
			
			<th class="fontTiny nobold"><?php echo $this->options['posting_requirement'];?></th>
			<th class="fontTiny nobold">30</th>
			
			<th class="fontTiny nobold"><?php echo $this->options['posting_requirement'];?></th>
			<th class="fontTiny nobold">30</th>
			
			<th class="fontTiny nobold"><?php echo $this->options['posting_requirement'];?></th>
			<th class="fontTiny nobold">30</th>
			
			<th class="fontTiny nobold"><?php echo $this->options['posting_requirement'];?></th>
			<th class="fontTiny nobold">30</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($players as $p): ?>
		<tr>
			<td class="col_50pct">
				<?php if ($p['loa'] == '[LOA]'): ?>
					<?php echo text_output($p['loa'], 'span', 'red fontSmall bold');?>
				<?php elseif ($p['loa'] == '[ELOA]'): ?>
					<?php echo text_output($p['loa'], 'span', 'orange fontSmall bold');?>
				<?php endif;?>
				
				<?php echo text_output($p['main_char'], 'span', 'bold');?><br />
				<span class="fontTiny">
					<?php echo anchor('personnel/player/'. $p['id'], $label['bioplayer']);?>
					|
					<?php echo anchor('personnel/character/'. $p['charid'], $label['biochar']);?>
				</span><br /><br />
				
				<span class="fontSmall<?php echo $p['requirement_login'];?>">
					<?php echo text_output($label['lastlogin'], 'strong') .': '.$p['last_login'];?>
				</span><br />
				<span class="fontSmall<?php echo $p['requirement_post'];?>">
					<?php echo text_output($label['lastpost'], 'strong') .': '. $p['last_post'];?>
				</span>
			</td>
			
			<td class="align_center"><?php echo $p['posts']['timeframe'];?></td>
			<td class="align_center activity-border"><?php echo $p['posts']['month'];?></td>
			
			<td class="align_center"><?php echo $p['logs']['timeframe'];?></td>
			<td class="align_center activity-border"><?php echo $p['logs']['month'];?></td>
			
			<td class="align_center"><?php echo $p['news']['timeframe'];?></td>
			<td class="align_center activity-border"><?php echo $p['news']['month'];?></td>
			
			<td class="align_center">
				<?php echo $p['posts']['timeframe'] + $p['logs']['timeframe'] + $p['news']['timeframe'];?>
			</td>
			<td class="align_center">
				<?php echo $p['posts']['month'] + $p['logs']['month'] + $p['news']['month'];?>
			</td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>