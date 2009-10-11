<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?><br />

<?php if (isset($players)): ?>
	<table class="table100 zebra">
		<thead>
			<tr>
				<th class="align_middle"><?php echo $label['name'];?></th>
				<th class="fontTiny align_middle"><?php echo $label['posts'];?></th>
				<th class="fontTiny align_middle"><?php echo text_output($label['comments_p'], '');?></th>
				<th class="fontTiny align_middle"><?php echo $label['logs'];?></th>
				<th class="fontTiny align_middle"><?php echo text_output($label['comments_l'], '');?></th>
				<th class="fontTiny align_middle"><?php echo $label['news'];?></th>
				<th class="fontTiny align_middle"><?php echo text_output($label['comments_n'], '');?></th>
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
				<td class="align_center"><?php echo img($images[$p['posts']]);?></td>
				<td class="align_center"><?php echo img($images[$p['comments_p']]);?></td>
				<td class="align_center"><?php echo img($images[$p['logs']]);?></td>
				<td class="align_center"><?php echo img($images[$p['comments_l']]);?></td>
				<td class="align_center"><?php echo img($images[$p['news']]);?></td>
				<td class="align_center"><?php echo img($images[$p['comments_n']]);?></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php endif;?>