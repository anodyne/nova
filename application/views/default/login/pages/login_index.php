<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo form_open('login/check_login');?>
	<p>
		<kbd><?php echo $label['email'];?></kbd>
		<?php echo form_input($inputs['email']);?>
	</p>

	<p>
		<kbd><?php echo $label['password'];?></kbd>
		<?php echo form_password($inputs['password']);?>
	</p>

	<div class="controls">
		<div class="checkbox">
			<?php echo form_checkbox($inputs['remember_me']);?>
			<label class="remember" for="remember"><strong><?php echo $label['remember'];?></strong></label>
		</div>

		<?php echo anchor('login/reset_password', ucwords(lang('actions_reset') .' '. lang('labels_password')));?>
	</div>

	<?php echo form_button($button_login);?>

	<?php echo anchor('main/index', ucfirst(lang('actions_back') .' '. lang('labels_to') .' '. lang('labels_site')), 'class="button-sec"');?>
<?php echo form_close();?>