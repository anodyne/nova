<?php defined('BASEPATH') or exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>

<p class="bold fontMedium">
	<?php echo link_to_if(Auth::can('upload/manage', false), 'upload/manage', $label['manage_uploads']);?>
</p><br />

<?php echo form_open_multipart('upload/index');?>
	<p>
		<kbd><?php echo $label['type'];?></kbd>
		<?php echo form_dropdown('type', $values['type']);?>
	</p>
	<p>
		<kbd><?php echo $label['name'];?></kbd>
		<?php echo form_upload($inputs['file']);?>
	</p><br /><br />

	<p><?php echo form_button($button['upload']);?></p>
<?php echo form_close();?>