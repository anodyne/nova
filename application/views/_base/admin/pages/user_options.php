<?php echo text_output($header, 'h1', 'page-head');?>

<div id="tabs">
	<ul>
		<li><a href="#one"><span><?php echo $label['mylinks'];?></span></a></li>
		<li><a href="#two"><span><?php echo $label['myskins'];?></span></a></li>
		<li><a href="#three"><span><?php echo $label['myranks'];?></span></a></li>
	</ul>
	
	<div id="one">
		<br />
		<?php echo form_open('user/options/links');?>
			<table class="zebra table75">
				<tbody>
					<tr>
						<td class="cell-label"><?php echo $label['mylink_1'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo form_dropdown('link_1', $links, $defaults['links'][1]);?></td>
					</tr>
					<tr>
						<td class="cell-label"><?php echo $label['mylink_2'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo form_dropdown('link_2', $links, $defaults['links'][2]);?></td>
					</tr>
					<tr>
						<td class="cell-label"><?php echo $label['mylink_3'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo form_dropdown('link_3', $links, $defaults['links'][3]);?></td>
					</tr>
					<tr>
						<td class="cell-label"><?php echo $label['mylink_4'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo form_dropdown('link_4', $links, $defaults['links'][4]);?></td>
					</tr>
					<tr>
						<td class="cell-label"><?php echo $label['mylink_5'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo form_dropdown('link_5', $links, $defaults['links'][5]);?></td>
					</tr>
				</tbody>
			</table>
			
			<br />
			<?php echo form_button($buttons['update']);?>
		<?php echo form_close();?>
	</div>
	
	<div id="two">
		<br />
		<?php echo form_open('user/options/skins');?>
			<table class="table100 zebra">
				<tbody>
					<tr class="height_40">
						<td class="cell-label"><?php echo $label['skin_main'];?></td>
						<td class="cell-spacer"></td>
						<td>
							<?php echo form_dropdown('skin_main', $themes['main'], $default['skin_main'], 'class="skins" myType="main"');?>
							&nbsp;<a href="#" class="image cb preview-main"><?php echo img($images['view']);?></a>
						</td>
					</tr>
					<tr class="height_40">
						<td class="cell-label"><?php echo $label['skin_admin'];?></td>
						<td class="cell-spacer"></td>
						<td>
							<?php echo form_dropdown('skin_admin', $themes['admin'], $default['skin_admin'], 'class="skins" myType="admin"');?>
							&nbsp;<a href="#" class="image cb preview-admin"><?php echo img($images['view']);?></a>
						</td>
					</tr>
					<tr class="height_40">
						<td class="cell-label"><?php echo $label['skin_wiki'];?></td>
						<td class="cell-spacer"></td>
						<td>
							<?php echo form_dropdown('skin_wiki', $themes['wiki'], $default['skin_wiki'], 'class="skins" myType="wiki"');?>
							&nbsp;<a href="#" class="image cb preview-wiki"><?php echo img($images['view']);?></a>
						</td>
					</tr>
				</tbody>
			</table>
			
			<br />
			<?php echo form_button($buttons['update']);?>
		<?php echo form_close();?>
	</div>
	
	<div id="three">
		<br />
		<?php echo form_open('user/options/ranks');?>
			<table class="zebra table75">
				<tbody>
				<?php foreach ($ranks as $r): ?>
					<tr>
						<td class="col_15 align_center"><?php echo form_radio($r['input']);?></td>
						<td class="cell-spacer"></td>
						<td>
							<label for="<?php echo 'rank_'. $r['id'];?>"><?php echo img($r['preview']);?></label><br />
							<?php echo text_output($r['name'], 'span', 'fontSmall gray');?>
						</td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
			
			<br />
			<?php echo form_button($buttons['update']);?>
		<?php echo form_close();?>
	</div>
</div>