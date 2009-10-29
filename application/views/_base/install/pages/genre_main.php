<?php echo text_output($label['genre_inst']);?>

<p class="fontMedium bold"><?php echo anchor('install/index', $label['back']);?></p>

<?php echo form_open('install/genre/change');?>
	<table>
		<tbody>
		<?php foreach ($files as $f): ?>
			<tr>
				<td><input type="radio" name="genre" value="<?php echo $f;?>" id="<?php echo $f;?>" /></td>
				<td><label for="<?php echo $f;?>"><strong><?php echo $f;?></strong></label></td>
			</tr>
		<?php endforeach;?>
			<?php echo table_row_spacer(2, 25);?>
			
			<tr>
				<td colspan="2"><?php echo form_button($inputs['submit']);?></td>
			</tr>
		</tbody>
	</table>
<?php echo form_close();?>