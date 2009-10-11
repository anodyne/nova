<?php echo text_output($header, 'h1', 'page-head');?>

<?php if (isset($players)): ?>
	<table class="table100 zebra">
		<thead>
			<tr>
				<th><?php echo $label['name'];?></th>
				<th class="align_right"><?php echo $label['timespan'];?></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($players as $p): ?>
			<tr>
				<td class="col_50pct">
					<strong><?php echo $p['name'];?></strong><br />
					<span class="fontTiny gray">
						<?php echo anchor('personnel/player/'. $p['id'], $label['bio_player']);?>
						|
						<?php echo anchor('personnel/character/'. $p['charid'], $label['bio_char']);?>
					</span>
				</td>
				<td class="align_right">
					<?php echo $p['timespan'];?><br />
					<?php echo text_output($p['join_date'], 'span', 'fontSmall gray');?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php endif;?>