<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($message, 'p', 'fontMedium');?><br />

<?php echo form_open('login/reset_password');?>
	<table class="table100">
		<tbody>
			<tr>
				<td><strong><?php echo $label['email'];?></strong></td>
				<td colspan="2"><?php echo form_input($inputs['email']);?></td>
			</tr>
			
			<?php echo table_row_spacer(3, 15);?>
			
			<tr>
				<td><strong><?php echo $label['question'];?></strong></td>
				<td><?php echo form_dropdown('question', $questions);?></td>
				<td align="right">
					<strong><?php echo $label['answer'];?></strong> &nbsp;&nbsp;
					<?php echo form_input($inputs['answer']);?>
				</td>
			</tr>
			
			<?php echo table_row_spacer(3, 25);?>
			
			<tr>
				<td colspan="3" align="right"><?php echo form_button($button_submit);?></td>
			</tr>
		</tbody>
	</table>
<?php echo form_close();?>