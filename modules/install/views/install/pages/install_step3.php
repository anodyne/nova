<p class="fontMedium"><?php echo $message;?></p>

<hr />

<?php echo form::open('install/step/4');?>
	<h3><?php echo __('step3.form.user');?></h3>
	<div class="indent-left">
		<p>
			<kbd><?php echo __('step3.form.name');?></kbd>
			<?php echo form::input($inputs['name']);?>
		</p>
		<p>
			<kbd><?php echo ucwords(__('word.email_address'));?></kbd>
			<?php echo form::input($inputs['email']);?>
		</p>
		<p>
			<kbd><?php echo ucfirst(__('word.password'));?></kbd>
			<?php echo form::password($inputs['password']);?>
		</p>
		<p>
			<kbd><?php echo __('step3.form.dob');?></kbd>
			<?php echo form::input($inputs['dob']);?>
		</p><br />
		
		<p>
			<kbd><?php echo __('step3.form.question');?></kbd>
			<?php echo form::dropdown('security_question', $questions);?>
		</p>
		<p>
			<kbd><?php echo __('step3.form.answer');?></kbd>
			<strong class="fontSmall subtle"><?php echo __('step3.form.remember_security_answer');?></strong><br />
			<?php echo form::input($inputs['security_answer']);?>
		</p><br />
		
		<p>
			<kbd><?php echo __('step3.form.timezone');?></kbd>
			<?php echo date::timezone_menu('UTC');?>
		</p>
	</div><br />
	
	<h3><?php echo __('step3.form.character');?></h3>
	<div class="indent-left">
		<p>
			<kbd><?php echo __('step3.form.fname');?></kbd>
			<?php echo form::input($inputs['first_name']);?>
		</p>
		<p>
			<kbd><?php echo __('step3.form.lname');?></kbd>
			<?php echo form::input($inputs['last_name']);?>
		</p>
		<p>
			<kbd><?php echo __('step3.form.rank');?></kbd>
			<?php echo form::dropdown_rank('rank', '', 'id="rank"');?>
			&nbsp; <span id="loading_update_rank" class="hidden fontSmall gray"><?php echo html::image($images['loading']);?></span>
			<p id="rank_img" class="fontSmall subtle"><?php echo html::image($images['default_rank']);?></p>
		</p>
		<p>
			<kbd><?php echo __('step3.form.position');?></kbd>
			<?php echo form::dropdown_position('position', '', 'id="position"', 'open');?>
			&nbsp; <span id="loading_update" class="hidden fontSmall gray"><?php echo html::image($images['loading']);?></span>
			<p id="position_desc" class="fontSmall subtle"></p>
		</p>
	</div>