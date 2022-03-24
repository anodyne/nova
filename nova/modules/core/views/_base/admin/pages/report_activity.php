<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

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
	<?php foreach ($users as $u): ?>
		<tr>
			<td class="col_50pct">
				<?php if ($u['loa'] == '[LOA]'): ?>
					<?php echo text_output($u['loa'], 'span', 'red fontSmall bold');?>
				<?php elseif ($u['loa'] == '[ELOA]'): ?>
					<?php echo text_output($u['loa'], 'span', 'orange fontSmall bold');?>
				<?php endif;?>
				
				<?php echo text_output($u['main_char'], 'span', 'bold');?><br />
				<span class="fontTiny">
					<?php echo anchor('personnel/user/'. $u['id'], $label['biouser']);?>
					|
					<?php echo anchor('personnel/character/'. $u['charid'], $label['biochar']);?>
				</span><br /><br />
				
				<span class="fontSmall<?php echo $u['requirement_login'];?>">
					<?php echo text_output($label['lastlogin'], 'strong') .': '.$u['last_login'];?>
				</span><br />
				<span class="fontSmall<?php echo $u['requirement_post'];?>">
					<?php echo text_output($label['lastpost'], 'strong') .': '. $u['last_post'];?>
				</span>
			</td>
			
			<td class="align_center"><?php echo $u['posts']['timeframe'];?></td>
			<td class="align_center activity-border"><?php echo $u['posts']['month'];?></td>
			
			<td class="align_center"><?php echo $u['logs']['timeframe'];?></td>
			<td class="align_center activity-border"><?php echo $u['logs']['month'];?></td>
			
			<td class="align_center"><?php echo $u['news']['timeframe'];?></td>
			<td class="align_center activity-border"><?php echo $u['news']['month'];?></td>
			
			<td class="align_center">
				<?php echo $u['posts']['timeframe'] + $u['logs']['timeframe'] + $u['news']['timeframe'];?>
			</td>
			<td class="align_center">
				<?php echo $u['posts']['month'] + $u['logs']['month'] + $u['news']['month'];?>
			</td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>