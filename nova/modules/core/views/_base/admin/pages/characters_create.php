<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<div id="tabs">
	<ul>
		<li><a href="#one"><span><?php echo $label['character'];?></span></a></li>
		<li><a href="#two"><span><?php echo $label['info'];?></span></a></li>
	</ul>

<?php echo form_open('characters/create');?>
	<div id="one">
		<p>
			<kbd><?php echo $label['type'];?></kbd>
			<?php echo form_dropdown('type', $type, 'npc');?>
		</p><br />
		
		<p>
			<kbd><?php echo $label['fname'];?></kbd>
			<?php echo form_input($inputs['first_name']);?>
		</p>
		<p>
			<kbd><?php echo $label['mname'];?></kbd>
			<?php echo form_input($inputs['middle_name']);?>
		</p>
		<p>
			<kbd><?php echo $label['lname'];?></kbd>
			<?php echo form_input($inputs['last_name']);?>
		</p>
		<p>
			<kbd><?php echo $label['suffix'];?></kbd>
			<?php echo form_input($inputs['suffix']);?>
		</p><br />
		
		<p>
			<kbd><?php echo $label['position1'];?></kbd>
			<?php echo form_dropdown_position('position_1', $inputs['position1_id'], 'id="position1"', 'open');?>
			&nbsp; <span id="loading_pos1" class="hidden fontSmall gray"><?php echo img($images['loading']);?></span>
			<p id="position1_desc" class="fontSmall gray"><?php echo text_output($inputs['position1_desc'], '');?></p>
		</p>
		<p>
			<kbd><?php echo $label['position2'];?></kbd>
			<?php echo form_dropdown_position('position_2', $inputs['position2_id'], 'id="position2"', 'open');?>
			&nbsp; <span id="loading_pos2" class="hidden fontSmall gray"><?php echo img($images['loading']);?></span>
			<p id="position2_desc" class="fontSmall gray"><?php echo text_output($inputs['position2_desc'], '');?></p>
		</p>
		<p>
			<kbd><?php echo $label['rank'];?></kbd>
			<?php echo form_dropdown_rank('rank', $inputs['rank_id'], 'id="rank"');?>
			&nbsp; <span id="loading_rank" class="hidden fontSmall gray"><?php echo img($images['loading']);?></span>
			<p id="rank_img" class="fontSmall gray"><?php echo img($inputs['rank']);?></p>
		</p>
	</div>
	
	<div id="two">
		<?php if (isset($join)): ?>
			<?php foreach ($join as $a): ?>
				<?php if (isset($a['fields'])): ?>
					<?php echo text_output($a['name'], 'h3', 'page-subhead');?>
					
					<div class="indent-left">
						<?php foreach ($a['fields'] as $f): ?>
							<p>
								<kbd><?php echo $f['field_label'];?></kbd>
								<?php echo $f['input'];?>
							</p>
						<?php endforeach; ?>
					</div><br />
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
	
	<br /><?php echo form_button($button['submit']);?>
<?php echo form_close();?>
</div>