<?php echo text_output($header, 'h1', 'page-head');?>

<p class="fontMedium bold"><?php echo anchor('wiki/managepages', $label['back']);?></p>

<?php echo form_open('wiki/page/'. $id .'/edit');?>
	<?php echo text_output($label['title'], 'p', 'fontMedium bold');?>
	<?php echo form_input($inputs['title']);?>
	
	<br /><br />
	
	<?php echo text_output($label['summary'], 'p', 'fontMedium bold');?>
	<?php echo form_textarea($inputs['summary']);?>
	
	<br /><br />
	
	<?php echo form_textarea($inputs['content']);?>
	
	<br /><br />
	
	<?php echo text_output($label['categories'], 'p', 'fontMedium bold');?>
	<?php echo form_input($inputs['categories']);?>
	
	<br /><br />
	
	<?php echo text_output($label['changes'], 'p', 'fontMedium bold');?>
	<?php echo form_textarea($inputs['changes']);?>
	
	<br /><br />
	
	<?php echo text_output($label['comments'], 'p', 'fontMedium bold');?>
	<?php echo form_radio($inputs['comments_open']) .' '. form_label($label['open'], 'comments_open');?>
	<?php echo form_radio($inputs['comments_closed']) .' '. form_label($label['closed'], 'comments_closed');?>
	
	<br /><br />
	
	<?php echo form_button($buttons['update']);?>
<?php echo form_close();?>