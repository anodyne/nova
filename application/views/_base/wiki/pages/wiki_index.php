<?php echo text_output($title, 'h1', 'page-head');?>

<?php echo $syspage;?>
<br />

<?php if (isset($recent['updates'])): ?>
	<?php echo text_output($label['recent_updates'], 'h3', 'page-subhead');?>
	
	<table class="table100 zebra">
		<thead>
			<tr>
				<th><?php echo $label['page'];?></th>
				<th></th>
				<th><?php echo $label['updates'];?></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($recent['updates'] as $r): ?>
			<tr>
				<td class="col_40pct">
					<?php if ($r['type'] == 'system'): ?>
						<?php echo text_output($label['system'], 'span', 'label-system');?>
					<?php endif;?>
					<strong>
						<?php if ($r['type'] == 'system'): ?>
							<?php echo $r['title'];?>
						<?php else: ?>
							<?php echo anchor('wiki/view/page/'. $r['id'], $r['title']);?>
						<?php endif;?>
					</strong><br />
					<span class="fontSmall gray">
						<?php echo $label['by'] .' '. $r['author'] .' '. $r['timespan'] .' '. $label['ago'];?>
					</span>
				</td>
				<td class="cell-spacer"></td>
				<td class="gray fontSmall">
					<?php if ( ! empty($r['comments'])): ?>
						<em><?php echo text_output($r['comments'], '');?></em>
					<?php endif;?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table><br />
<?php endif;?>

<?php if (isset($recent['created'])): ?>
	<?php echo text_output($label['recent_created'], 'h3', 'page-subhead');?>
	
	<table class="table100 zebra">
		<thead>
			<tr>
				<th><?php echo $label['page'];?></th>
				<th></th>
				<th><?php echo $label['summary'];?></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($recent['created'] as $r): ?>
			<tr>
				<td class="col_40pct">
					<?php if ($r['type'] == 'system'): ?>
						<?php echo text_output($label['system'], 'span', 'label-system');?>
					<?php endif;?>
					<strong>
						<?php if ($r['type'] == 'system'): ?>
							<?php echo $r['title'];?>
						<?php else: ?>
							<?php echo anchor('wiki/view/page/'. $r['id'], $r['title']);?>
						<?php endif;?>
					</strong>
					
					<?php if ($r['type'] == 'standard'): ?>
						<br />
						<span class="fontSmall gray">
							<?php echo $label['by'] .' '. $r['author'] .' '. $r['timespan'] .' '. $label['ago'];?>
						</span>
					<?php endif;?>
				</td>
				<td class="cell-spacer"></td>
				<td class="gray fontSmall">
					<?php if ( ! empty($r['summary'])): ?>
						<em><?php echo text_output($r['summary'], '');?></em>
					<?php endif;?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php endif;?>