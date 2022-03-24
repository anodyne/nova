<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($label['inst_step4'], 'p', 'fontMedium');?>

<hr />

<?php echo form_open('install/step/5');?>
	<p>
		<kbd><?php echo $label['simname'];?></kbd>
		<?php echo form_input($inputs['sim_name']);?>
	</p>
	<p>
		<kbd><?php echo $label['sysemail'];?></kbd>
		<?php echo form_dropdown('s_system_email', $email_v, $this->settings->get_setting('system_email'));?>
	</p>
	<p>
		<kbd><?php echo $label['emailsubject'];?></kbd>
		<?php echo form_input($inputs['email_subject']);?>
	</p>
	<p>
		<kbd><?php echo $label['updates'];?></kbd>
		<?php echo form_dropdown('s_updates', $updates_v, $this->settings->get_setting('updates'));?>
	</p>
	<p>
		<kbd><?php echo $label['characters'];?></kbd>
		<?php echo form_input($inputs['num_chars']);?>
	</p>
	<p>
		<kbd><?php echo $label['npcs'];?></kbd>
		<?php echo form_input($inputs['num_npc']);?>
	</p>
	<p>
		<kbd><?php echo $label['dates'];?></kbd>
		<?php echo form_dropdown('s_date_format', $dates_v, $this->settings->get_setting('date_format'));?>
	</p>