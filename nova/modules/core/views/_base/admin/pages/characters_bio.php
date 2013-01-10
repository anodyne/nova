<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<div id="loading" class="loader">
	<?php echo img($images['loader']);?>
	<?php echo text_output($label['loading'], 'h3', 'gray');?>
</div>

<div id="loaded" class="hidden">
	<?php if ($level == 3 and $inputs['crew_type'] != 'pending'): ?>
		<p>
			<kbd><?php echo $label['change'];?></kbd>
			
			<?php if ($inputs['crew_type'] == 'inactive'): ?>
				<?php echo form_button($button['activate']);?>
			<?php endif;?>
			
			<?php if ($inputs['crew_type'] == 'active'): ?>
				<?php echo form_button($button['deactivate']);?>
			<?php endif;?>
			
			<?php if ($inputs['crew_type'] != 'npc'): ?>
				<?php echo form_button($button['npc']);?>
			<?php endif;?>
			
			<?php if ($inputs['crew_type'] == 'npc'): ?>
				<?php echo form_button($button['playing']);?>
			<?php endif;?>
		</p><br />
	<?php endif;?>
	
	<div id="tabs">
			<ul>
				<li><a href="#one"><span><?php echo $label['character'];?></span></a></li>
				<li><a href="#two"><span><?php echo $label['info'];?></span></a></li>
				<li><a href="#three"><span><?php echo $label['images'];?></span></a></li>
			</ul>
	
	<?php echo form_open('characters/bio/'.$id);?>
		<div id="one">
			<?php echo text_output($label['character'], 'h3', 'page-subhead');?>
		
			<div class="indent-left">
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
				
				<?php if ($level >= 2): ?>
					<?php if (($level == 2 and $inputs['crew_type'] == 'npc') or $level == 3): ?>
						<p>
							<kbd><?php echo $label['position1'];?></kbd>
							<?php echo form_dropdown_position('position_1', $inputs['position1_id'], 'id="position1"', 'all');?>
							&nbsp; <span id="loading_pos1" class="hidden fontSmall gray"><?php echo img($images['loading']);?></span>
							<p id="position1_desc" class="fontSmall gray"><?php echo text_output($inputs['position1_desc'], '');?></p>
							<?php echo form_hidden('position_1_old', $inputs['position1_id']);?>
						</p>
						
						<p>
							<kbd><?php echo $label['position2'];?></kbd>
							<?php echo form_dropdown_position('position_2', $inputs['position2_id'], 'id="position2"', 'all');?>
							&nbsp; <span id="loading_pos2" class="hidden fontSmall gray"><?php echo img($images['loading']);?></span>
							<p id="position2_desc" class="fontSmall gray"><?php echo text_output($inputs['position2_desc'], '');?></p>
							<?php echo form_hidden('position_2_old', $inputs['position2_id']);?>
						</p>
						
						<p>
							<kbd><?php echo $label['rank'];?></kbd>
							<?php echo form_dropdown_rank('rank', $inputs['rank_id'], 'id="rank"');?>
							&nbsp; <span id="loading_rank" class="hidden fontSmall gray"><?php echo img($images['loading']);?></span>
							<p id="rank_img" class="fontSmall gray"><?php echo img($inputs['rank']);?></p>
							<?php echo form_hidden('rank_old', $inputs['rank_id']);?>
						</p>
					<?php endif;?>
				<?php else: ?>
					<p>
						<kbd><?php echo $label['position1'];?></kbd>
						<?php echo $inputs['position1_name'];?>
					</p>
					
					<p>
						<kbd><?php echo $label['position2'];?></kbd>
						<?php echo $inputs['position2_name'];?>
					</p>
					
					<p>
						<kbd><?php echo $label['rank'];?></kbd>
						<?php echo img($inputs['rank']);?><br />
						<?php echo text_output($inputs['rank_name'], 'span', 'fontSmall gray');?>
					</p>
				<?php endif;?>
				
				<br /><?php echo form_button($button['submit']);?>
			</div>
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
			
			<br /><?php echo form_button($button['submit']);?>
		</div>
	<?php echo form_close();?>
		
		<div id="three">
			<p><?php echo link_to_if(Auth::check_access('upload/index', false), 'upload/index', img($images['upload']) .' '. $label['upload'], array('class' => 'image fontMedium bold'));?></p>
			
			<div class="subtabs">
				<ul>
					<li><a href="#five"><span><?php echo $label['character_images'];?></span></a></li>
					<li><a href="#six"><span><?php echo $label['available_images'];?></span></a></li>
				</ul>
				
				<div id="five">
					<p>
						<?php echo form_button($button['update']);?> &nbsp;&nbsp;
						<span id="loading_upload_update" class="hidden"><?php echo img($images['loading']);?></span>
					</p><br />
					
					<ul id="list-grid">
					<?php if (is_array($inputs['images']) && count($inputs['images']) > 0): ?>
						<?php foreach ($inputs['images'] as $i): ?>
							<?php if (strpos($i, '://') === FALSE): ?>
								<?php $image = array('src' => base_url().Location::asset('images/characters', $i), 'height' => 140);?>
							<?php else: ?>
								<?php $image = array('src' => $i, 'height' => 140);?>
							<?php endif;?>
							<li id="img_<?php echo str_replace('.', '\\.', $i);?>"><a href="#" class="image upload-close" remove="<?php echo str_replace('.', '\\.', $i);?>">x</a><?php echo img($image);?></li>
						<?php endforeach;?>
					<?php endif;?>
					</ul>
				</div>
				
				<div id="six">
					<?php if (isset($myuploads)): ?>
						<?php echo text_output($label['myuploads'], 'h3');?>
						<br />
						<table class="zebra">
							<tbody>
							<?php foreach ($myuploads as $d): ?>
								<tr>
									<td class="cell-label"><?php echo $d['file'];?></td>
									<td class="cell-spacer"></td>
									<td><?php echo img($d['image']);?></td>
									<td class="cell-spacer"></td>
									<td><?php echo form_button($button['use']);?></td>
								</tr>
							<?php endforeach;?>
							</tbody>
						</table><br />
					<?php endif;?>
					
					<?php if (isset($directory)): ?>
						<br />
						<table class="zebra all-uploads">
							<tbody>
							<?php foreach ($directory as $d): ?>
								<tr>
									<td class="cell-label"><?php echo $d['file'];?></td>
									<td class="cell-spacer"></td>
									<td><?php echo img($d['image']);?></td>
									<td class="cell-spacer"></td>
									<td><?php echo form_button($button['use']);?></td>
								</tr>
							<?php endforeach;?>
							</tbody>
						</table>
					<?php endif;?>
				</div>
			</div>
		</div>
	</div>
</div>