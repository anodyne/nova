<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo form_open('manage/comments/'. $type .'/'. $status .'/'. $page .'/edit');?>
	<table class="table100">
		<tbody>
			<tr>
				<td class="cell-label"><?php echo $label['author'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo $inputs['author'];?></td>
			</tr>
			
			<?php echo table_row_spacer(3, 10);?>
			
			<tr>
				<td class="cell-label"><?php echo $label['content'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_textarea($inputs['content']);?></td>
			</tr>
		</tbody>
	</table>
	<?php echo form_hidden('id', $id);?>