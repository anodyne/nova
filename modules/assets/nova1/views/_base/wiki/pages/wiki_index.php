<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>
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
					<strong><?php echo anchor('wiki/view/page/'. $r['id'], $r['title']);?></strong><br />
					<span class="fontSmall gray">
						<?php echo $label['by'] .' '. $r['author'] .' '. $r['timespan'] .' '. $label['ago'];?>
					</span>
				</td>
				<td class="cell-spacer"></td>
				<td class="gray fontSmall">
					<?php if (!empty($r['comments'])): ?>
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
					<strong><?php echo anchor('wiki/view/page/'. $r['id'], $r['title']);?></strong><br />
					<span class="fontSmall gray">
						<?php echo $label['by'] .' '. $r['author'] .' '. $r['timespan'] .' '. $label['ago'];?>
					</span>
				</td>
				<td class="cell-spacer"></td>
				<td class="gray fontSmall">
					<?php if (!empty($r['summary'])): ?>
						<em><?php echo text_output($r['summary'], '');?></em>
					<?php endif;?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php endif;?>