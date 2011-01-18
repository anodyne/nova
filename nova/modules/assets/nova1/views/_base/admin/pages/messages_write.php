<?php echo text_output($header, 'h1', 'page-head');?>

<p><?php echo anchor('messages/index', $label['inbox'], array('class' => 'bold'));?></p>

<?php echo form_open('messages/write');?>
	<p>
		<kbd><?php echo $label['to'];?></kbd>
		<?php echo form_dropdown('recipients', $characters, $key, 'id = "recip"');?>
		&nbsp;
		<a href="#" id="add_recipient" class="fontSmall"><?php echo $label['add'];?></a>
		<input type="hidden" name="to" id="to_hidden" value="<?php echo $to;?>" />
		<p id="recipients">
			<?php if (isset($recipient_list)): ?>
				<?php foreach ($recipient_list as $r): ?>
					<?php echo $r ."\r\n";?>
				<?php endforeach; ?>
			<?php endif; ?>
		</p>
	</p>
	
	<p>
		<kbd><?php echo $label['subject'];?></kbd>
		<?php echo form_input($inputs['subject']);?>
	</p>
	
	<p>
		<kbd><?php echo $label['message'];?></kbd>
		<?php echo form_textarea($inputs['message']);?>
	</p><br />
	
	<p><?php echo form_button($inputs['submit']);?></p>
<?php echo form_close();?>

<?php if (isset($previous)): ?>
	<div id="comments">
		<p>
			<strong><?php echo $label['on'] .' '. $previous['date'] .' '.  $previous['from'] .' '. $label['wrote'];?></strong>
			<br /><br />
			<?php echo text_output($previous['content'], '');?>
		</p>
	</div>
<?php endif; ?>