<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<p><?php echo anchor('messages/index', $label['inbox'], array('class' => 'bold'));?></p>

<?php echo form_open('messages/write');?>
	<p>
		<kbd><?php echo $label['to'];?></kbd>
		<span id="chosen-incompat" class="gray fontSmall bold hidden"><?php echo $label['chosen_incompat'];?><br /><br /></span>
		<?php echo form_multiselect('recipients[]', $characters, $recipient_list, 'id="recip" class="chosen" title="'.$label['select'].'"');?>
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
			<strong><?php echo $label['on'].' '.$previous['date'].' '. $previous['from'].' '.$label['wrote'];?></strong>
			<br /><br />
			<?php echo text_output($previous['content'], '');?>
		</p>
	</div>
<?php endif; ?>