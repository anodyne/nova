<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<p class="fontMedium"><?php echo $message;?></p>

<hr />

<?php echo form_open('main/index');?>
	<h3>New Password</h3>
	
	<p class="fontMedium"><?php echo $password;?></p>
	
	<p>
		<?php echo form_input('password', 'default');?> &nbsp;
		
		<span class="hidden loading-password"><?php echo img(MODFOLDER.'/core/views/_base/update/images/loading-circle-large.gif');?></span>
		
		<span class="hidden error-password">
			<?php echo img(MODFOLDER.'/core/views/_base/update/images/exclamation-red.png', array('class' => 'tiptip', 'title' => ''));?>
		</span>
		
		<span class="hidden success-password">
			<?php echo img(MODFOLDER.'/core/views/_base/update/images/tick-circle.png');?>
		</span>
	</p>
	
	<hr />
	
	<h3>Admin Rights</h3>
	
	<p class="fontMedium"><?php echo $admin;?></p>
	
	<p>
		<?php echo form_dropdown('admins', $options, null, 'multiple="multiple" size="10"');?> &nbsp;
		
		<span class="hidden loading-admins"><?php echo img(MODFOLDER.'/core/views/_base/update/images/loading-circle-large.gif');?></span>
		
		<span class="hidden error-admins">
			<?php echo img(MODFOLDER.'/core/views/_base/update/images/exclamation-red.png', array('class' => 'tiptip', 'title' => ''));?>
		</span>
		
		<span class="hidden success-admins">
			<?php echo img(MODFOLDER.'/core/views/_base/update/images/tick-circle.png');?>
		</span>
	</p>