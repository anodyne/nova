<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($label['genre_inst'], 'p', 'fontMedium');?>

<?php echo form_open('install/genre/change');?>
	<table>
		<tbody>
		<?php foreach ($files as $f): ?>
			<tr>
				<td width="25"><input type="radio" name="genre" value="<?php echo $f;?>" id="<?php echo $f;?>" /></td>
				<td><label for="<?php echo $f;?>"><strong><?php echo $f;?></strong></label></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>