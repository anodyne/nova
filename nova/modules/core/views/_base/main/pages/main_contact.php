<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<style type="text/css">
	.error-icon {
		margin-left: 1px;
		padding-left: 22px;
		background: transparent url('<?php echo base_url().APPFOLDER;?>/assets/images/exclamation-red.png') no-repeat left center;
	}
</style>
<?php echo text_output($header, 'h1', 'page-head');?>

<?php if ($this->options['system_email'] == 'on'): ?>
	<?php echo text_output($msg);?>
	
	<?php echo form_open('main/contact');?>
		<p>
			<kbd><?php echo $label['name'];?></kbd>
			<?php echo form_error('name');?>
			<?php echo form_input($inputs['name']);?>
		</p>
		<p>
			<kbd><?php echo $label['email'];?></kbd>
			<?php echo form_error('email');?>
			<?php echo form_input($inputs['email']);?>
		</p>
		<p>
			<kbd><?php echo $label['subject'];?></kbd>
			<?php echo form_error('subject');?>
			<?php echo form_input($inputs['subject']);?>
		</p>
		<p>
			<kbd><?php echo $label['message'];?></kbd>
			<?php echo form_error('message');?>
			<?php echo form_textarea($inputs['message']);?>
		</p><br />
		
		<p>
			<?php echo form_button($button['submit']);?>
		</p>
	<?php echo form_close();?>
<?php else: ?>
	<?php echo text_output($label['nosubmit'], 'h4', 'orange');?>
<?php endif;?>