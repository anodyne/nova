<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<div id="tabs">
	<ul>
		<li><a href="#one"><span><?php echo $label['myskins'];?></span></a></li>
		<li><a href="#two"><span><?php echo $label['myranks'];?></span></a></li>
		<li><a href="#three"><span><?php echo $label['mylinks'];?></span></a></li>
	</ul>
	
	<div id="one">
		<?php if (Auth::check_access('site/settings', false)): ?>
			<?php echo text_output($label['skins_text']);?><br>
		<?php endif;?>
		
		<?php echo form_open('user/options/skins');?>
			<p>
				<kbd><?php echo $label['skin_main'];?></kbd>
				<?php echo form_dropdown('skin_main', $themes['main'], $default['skin_main'], 'class="skins" myType="main"');?>
				&nbsp;<a href="#" class="image preview-main" rel="prettyPhoto"><?php echo img($images['view']);?></a>
			</p>
			<p>
				<kbd><?php echo $label['skin_admin'];?></kbd>
				<?php echo form_dropdown('skin_admin', $themes['admin'], $default['skin_admin'], 'class="skins" myType="admin"');?>
				&nbsp;<a href="#" class="image preview-admin" rel="prettyPhoto"><?php echo img($images['view']);?></a>
			</p>
			<p>
				<kbd><?php echo $label['skin_wiki'];?></kbd>
				<?php echo form_dropdown('skin_wiki', $themes['wiki'], $default['skin_wiki'], 'class="skins" myType="wiki"');?>
				&nbsp;<a href="#" class="image preview-wiki" rel="prettyPhoto"><?php echo img($images['view']);?></a>
			</p><br />
			
			<p><?php echo form_button($buttons['update']);?></p>
		<?php echo form_close();?>
	</div>
	
	<div id="two">
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
	
	<div id="three">
		<?php echo form_open('user/options/links');?>
			<p>
				<kbd><?php echo $label['mylink_1'];?></kbd>
				<?php echo form_dropdown('link_1', $links, $defaults['links'][1]);?>
			</p>
			<p>
				<kbd><?php echo $label['mylink_2'];?></kbd>
				<?php echo form_dropdown('link_2', $links, $defaults['links'][2]);?>
			</p>
			<p>
				<kbd><?php echo $label['mylink_3'];?></kbd>
				<?php echo form_dropdown('link_3', $links, $defaults['links'][3]);?>
			</p>
			<p>
				<kbd><?php echo $label['mylink_4'];?></kbd>
				<?php echo form_dropdown('link_4', $links, $defaults['links'][4]);?>
			</p>
			<p>
				<kbd><?php echo $label['mylink_5'];?></kbd>
				<?php echo form_dropdown('link_5', $links, $defaults['links'][5]);?>
			</p><br />
			
			<p><?php echo form_button($buttons['update']);?></p>
		<?php echo form_close();?>
	</div>
</div>