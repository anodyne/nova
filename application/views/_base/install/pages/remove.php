<?php if (!isset($_POST['submit'])): ?>
	<br />
	<?php echo form_open('install/remove');?>
		<table>
			<tr>
				<td class="cell_label"><?php echo $label['email'];?></td>
				<td class="cell_spacer"></td>
				<td><input type="text" name="email" autocomplete="off" /></td>
			</tr>
			<?php echo table_row_spacer(3, 5);?>
			<tr>
				<td class="cell_label"><?php echo $label['password'];?></td>
				<td class="cell_spacer"></td>
				<td><input type="password" name="password" /></td>
			</tr>
			<?php echo table_row_spacer(3, 15);?>
			<tr>
				<td colspan="2"></td>
				<td><?php echo form_button($button_clear);?></td>
			</tr>
		</table>
	<?php echo form_close();?><br />
<?php endif; ?>

<?php echo anchor('install/index', $label['back'], array('class' => 'fontMedium bold'));?>