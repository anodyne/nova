<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($label['inst_step3'], 'p', 'fontMedium');?>

<hr />

<?php echo form_open('install/step/4');?>
	<?php echo text_output($label['user'], 'h3');?>
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
		</p><br />
		
		<p>
			<kbd><?php echo $label['question'];?></kbd>
			<?php echo form_dropdown('security_question', $questions);?>
		</p>
		<p>
			<kbd><?php echo $label['answer'];?></kbd>
			<?php echo text_output($label['remember'], 'span', 'fontSmall gray bold');?><br />
			<?php echo form_input($inputs['security_answer']);?>
		</p><br />
		
		<p>
			<kbd><?php echo $label['timezone'];?></kbd>
			<?php echo timezone_menu('UTC');?>
		</p>
	</div><br />
	
	<?php echo text_output($label['character'], 'h3');?>
	<div class="indent-left">
		<p>
			<kbd><?php echo $label['fname'];?></kbd>
			<?php echo form_input($inputs['first_name']);?>
		</p>
		<p>
			<kbd><?php echo $label['lname'];?></kbd>
			<?php echo form_input($inputs['last_name']);?>
		</p>
		<p>
			<kbd><?php echo $label['rank'];?></kbd>
			<?php echo form_dropdown_rank('rank', '', 'id="rank"');?>
			&nbsp; <span id="loading_update_rank" class="hidden fontSmall gray"><?php echo img($loading);?></span>
			<p id="rank_img" class="fontSmall gray"><?php echo img($default_rank);?></p>
		</p>
		<p>
			<kbd><?php echo $label['position'];?></kbd>
			<?php echo form_dropdown_position('position', '', 'id="position"', 'open');?>
			&nbsp; <span id="loading_update" class="hidden fontSmall gray"><?php echo img($loading);?></span>
			<p id="position_desc" class="fontSmall gray"></p>
		</p>
	</div>