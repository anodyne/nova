<?php echo $header;?>

<?php if (isset($msg)): ?>
	<?php echo text_output($msg);?>
<?php else: ?>
	<p><?php echo anchor('messages/index', $label['inbox'], array('class' => 'bold'));?></p>
	<p class="fontSmall bold gray">
		<?php echo $label['sent'] .' '. $date;?>
		<?php echo $label['by'] .' '. $author;?><br />
		<?php echo $label['to'] .' '. $to;?>
	</p>
	
	<hr />
	
	<?php echo text_output($content);?>
	
	<p>&nbsp;</p>
	
	<p><?php echo anchor('messages/write/reply/'. $id, img($images['reply']) .' '. $label['reply'], array('class' => 'bold image float_left right_1em'));?></p>
	<p><?php echo anchor('messages/write/replyall/'. $id, img($images['reply_all']) .' '. $label['replyall'], array('class' => 'bold image float_left right_1em'));?></p>
	<p><?php echo anchor('messages/write/forward/'. $id, img($images['forward']) .' '. $label['forward'], array('class' => 'bold image float_left right_1em'));?></p>
	
	<p>&nbsp;</p>
<?php endif; ?>