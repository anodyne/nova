<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>

<p class="bold">
	<a href="#" class="addtoggle image"><?php echo img($images['add']) .' '. $label['add'];?></a>
</p>

<div class="addban info-full hidden">
	<?php echo form_open('site/bans/add');?>
		<p>
			<kbd><?php echo $label['level'];?></kbd>
			<?php echo form_radio($inputs['level_1']) .' '. form_label($label['level_1_label'], 'level_1');?>
			<?php echo form_radio($inputs['level_2']) .' '. form_label($label['level_2_label'], 'level_2');?>
		</p>
		<p>
			<kbd><?php echo $label['type'];?></kbd>
			<table>
				<tbody>
					<tr>
						<td class="gray fontSmall"><?php echo $label['email'] .' ('.$label['email_note'].')';?></td>
						<td class="col_15"></td>
						<td class="gray fontSmall"><?php echo $label['ip'];?></td>
					</tr>
					<tr>
						<td class="gray fontSmall"><?php echo form_input($inputs['email']);?></td>
						<td class="col_15"></td>
						<td class="gray fontSmall"><?php echo form_input($inputs['ip']);?></td>
					</tr>
				</tbody>
			</table>
		</p>
		<p>
			<kbd><?php echo $label['reason'];?></kbd>
			<?php echo form_textarea($inputs['reason']);?>
		</p>
		<?php echo form_input($inputs['date']);?>
		<p><?php echo form_button($buttons['add']);?></p>
	<?php echo form_close();?>
</div><br />

<hr size="1" /><br />

<div id="tabs">
	<ul>
		<li><a href="#one"><span><?php echo $label['level_1'];?></span></a></li>
		<li><a href="#two"><span><?php echo $label['level_2'];?></span></a></li>
	</ul>
	
	<div id="one">
		<?php if (isset($bans[1])): ?>
			<br />
			<table class="table100 zebra">
				<tbody>
					
				<?php foreach ($bans[1] as $b): ?>
					<tr>
						<td>
							<strong>
								<?php if (empty($b['ip'])): ?>
									<?php echo $b['email'];?>
								<?php else: ?>
									<?php echo $b['ip'];?>
								<?php endif;?>
							</strong><br />
							<span class="fontSmall gray">
								<?php echo $label['date'] .' '. $b['date'];?><br/>
								<?php echo $b['span'];?>
							</span>
						</td>
						<td class="col_50pct fontSmall gray"><?php echo $b['reason'];?></td>
						<td class="col_75 align_right">
							<a href="#" rel="facebox" myID="<?php echo $b['id'];?>" class="image"><?php echo img($images['delete']);?></a>
						</td>
					</tr>
				<?php endforeach; ?>
				
				</tbody>
			</table>
		<?php else: ?>
			<?php echo text_output($label['no_bans'], 'h3', 'orange');?>
		<?php endif; ?>
	</div>
	
	<div id="two">
		<?php if (isset($bans[2])): ?>
			<br />
			<table class="table100 zebra">
				<tbody>
					
				<?php foreach ($bans[2] as $b): ?>
					<tr>
						<td>
							<strong><?php echo $b['ip'];?></strong><br />
							<span class="fontSmall gray">
								<?php echo $label['date'] .' '. $b['date'];?><br/>
								<?php echo $b['span'];?>
							</span>
						</td>
						<td class="col_50pct fontSmall gray"><?php echo $b['reason'];?></td>
						<td class="col_75 align_right">
							<a href="#" rel="facebox" myID="<?php echo $b['id'];?>" class="image"><?php echo img($images['delete']);?></a>
						</td>
					</tr>
				<?php endforeach; ?>
				
				</tbody>
			</table>
		<?php else: ?>
			<?php echo text_output($label['no_bans'], 'h3', 'orange');?>
		<?php endif; ?>
	</div>
</div>