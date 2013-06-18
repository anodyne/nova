<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($msg);?><br />

<?php echo form_open('main/join');?>
	<div id="tabs">
		<ul>
			<li><a href="#one"><span><?php echo $label['user_info'];?></span></a></li>
			<li><a href="#two"><span><?php echo $label['character'];?></span></a></li>
			<li><a href="#three"><span><?php echo $label['character_info'];?></span></a></li>
			
			<?php if ($this->options['use_sample_post'] == 'y'): ?>
				<li><a href="#four"><span><?php echo $label['samplepost'];?></span></a></li>
			<?php endif;?>
		</ul>
		
		<div id="one">
			<?php echo text_output($label['user_info'], 'h3', 'page-subhead');?>
			<div class="indent-left">
				<p>
					<kbd><?php echo $label['name'];?></kbd>
					<?php echo form_input($inputs['name']);?>
				</p>
				
				<p>
					<kbd><?php echo $label['email'];?></kbd>
					<?php echo form_input($inputs['email']);?>
				</p>
				
				<p>
					<kbd><?php echo $label['password'];?></kbd>
					<?php echo form_password($inputs['password']);?>
				</p>
				
				<p>
					<kbd><?php echo $label['dob'];?></kbd>
					<?php echo form_input($inputs['dob']);?>
				</p>
				
				<p>
					<kbd><?php echo $label['im'];?></kbd>
					<?php echo text_output($label['im_inst'], 'span', 'fontSmall gray');?><br />
					<?php echo form_textarea($inputs['im']);?>
				</p>
			</div>
		</div>
		
		<div id="two">
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
				</p>
				
				<p>
					<kbd><?php echo $label['position'];?></kbd>
					<?php echo form_dropdown_position('position_1', $selected_position, 'id="position"', 'open');?>
					&nbsp; <span id="loading_update" class="hidden fontSmall gray"><?php echo img($loading);?></span>
					<p id="position_desc" class="fontSmall gray"><?php echo text_output($pos_desc, '');?></p>
				</p>
			</div>
		</div>
		
		<div id="three">
			<?php if (isset($join)): ?>
				<?php foreach ($join as $a): ?>
					<?php if (isset($a['fields'])): ?>
						<?php echo text_output($a['name'], 'h3', 'page-subhead');?>
						
						<div class="indent-left">
							<?php foreach ($a['fields'] as $f): ?>
								<p>
									<kbd><?php echo $f['field_label'];?></kbd>
									
									<?php if ( ! empty($f['field_help'])): ?>
										<p class="gray fontSmall"><?php echo $f['field_help'];?></p>
									<?php endif;?>

									<?php echo $f['input'];?>
								</p>
							<?php endforeach; ?>
						</div><br />
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
		
		<?php if ($this->options['use_sample_post'] == 'y'): ?>
			<div id="four">
				<?php echo text_output($label['samplepost'], 'h3', 'page-subhead');?>
				
				<div class="indent-left">
					<?php echo text_output($sample_post_msg, 'p', 'bold gray');?>
					<?php echo form_textarea($inputs['sample_post']);?>
				</div>
			</div>
		<?php endif; ?>
	</div>
	
	<div class="indent-left">
		<?php echo form_hidden('submit', 'y');?>
		<p>
			<?php echo form_button($button['submit']);?>
			&nbsp;
			<?php echo form_button($button['next']);?>
		</p>
	</div>
<?php echo form_close();?>