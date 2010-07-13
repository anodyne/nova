<p class="fontMedium"><?php echo __("step3.text");?></p>

<hr />

<?php echo form::open('main/index');?>
	<h3><?php echo __('New Password');?></h3>
	
	<p class="fontMedium"><?php echo __("step3.passwords");?></p>
	
	<p>
		<?php echo form::input('password', 'default');?> &nbsp;
		
		<span class="hidden loading-password"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/loading-circle-large.gif');?></span>
		
		<span class="hidden error-password">
			<?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/exclamation-red.png', array('title' => ''));?>
		</span>
		
		<span class="hidden success-password">
			<?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/tick-circle.png');?>
		</span>
	</p>
	
	<hr />
	
	<h3><?php echo __('Admin Rights');?></h3>
	
	<p class="fontMedium"><?php echo __("step3.admin");?></p>
	
	<p>
		<?php echo form::select('admins', $options, NULL, array('multiple' => 'multiple', 'size' => 10));?> &nbsp;
		
		<span class="hidden loading-admins"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/loading-circle-large.gif');?></span>
		
		<span class="hidden error-admins">
			<?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/exclamation-red.png', array('title' => ''));?>
		</span>
		
		<span class="hidden success-admins">
			<?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/tick-circle.png');?>
		</span>
	</p>