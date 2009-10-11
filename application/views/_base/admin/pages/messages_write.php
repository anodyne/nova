<?php echo text_output($header, 'h1', 'page-head');?>

<p><?php echo anchor('messages/index', $label['inbox'], array('class' => 'bold'));?></p>

<?php echo form_open('messages/write');?>
	<table class="table100">
		<tr>
			<td class="cell-label"><?php echo $label['to'];?></td>
			<td class="cell-spacer"></td>
			<td>
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
			</td>
		</tr>
		<tr>
			<td class="cell-label"><?php echo $label['subject'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_input($inputs['subject']);?>
		</tr>
		
		<?php echo table_row_spacer(3, 10);?>
		
		<tr>
			<td class="cell-label"><?php echo $label['message'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_textarea($inputs['message']);?>
		</tr>
		
		<?php echo table_row_spacer(3, 20);?>
		
		<tr>
			<td colspan="2"></td>
			<td><?php echo form_button($inputs['submit']);?>
		</tr>
	</table>
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