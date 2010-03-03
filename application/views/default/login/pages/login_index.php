<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo form_open('login/check_login');?>
	<table class="table100">
		<tbody>
			<tr>
				<td>
					<strong><?php echo $label['email'];?></strong> &nbsp;&nbsp;
					<?php echo form_input($inputs['email']);?>
				</td>
				<td align="right">
					<strong><?php echo $label['password'];?></strong>&nbsp;&nbsp;
					<?php echo form_password($inputs['password']);?>
				</td>
			</tr>
			
			<?php echo table_row_spacer(4, 25);?>
			
			<tr>
				<td colspan="2" align="right">
					<label class="remember" for="remember"><?php echo $label['remember'];?></label>
					<?php echo form_checkbox($inputs['remember_me']);?>
					
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					
					<?php echo form_button($button_login);?>
				</td>
			</tr>
		</tbody>
	</table>
<?php echo form_close();?>