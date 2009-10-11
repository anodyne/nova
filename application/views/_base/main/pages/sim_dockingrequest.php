<?php echo text_output($header, 'h1', 'page-head');?>
<?php echo text_output($docking_inst);?>

<?php echo form_open('sim/dockingrequest');?>
	<table class="table100">
		<tr>
			<td colspan="3"><h3><?php echo $label['info'];?></h3></td>
		</tr>
		<tr>
			<td class="cell-label"><?php echo $label['name'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_input($inputs['sim_name']);?></td>
		</tr>
		<tr>
			<td class="cell-label"><?php echo $label['class'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_input($inputs['sim_class']);?></td>
		</tr>
		<tr>
			<td class="cell-label"><?php echo $label['url'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_input($inputs['sim_url']);?></td>
		</tr>
		
		<?php echo table_row_spacer(3, 10);?>
		
		<tr>
			<td colspan="3"><h3><?php echo $label['gm_info'];?></h3></td>
		</tr>
		<tr>
			<td class="cell-label"><?php echo $label['gm_name'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_input($inputs['gm_name']);?></td>
		</tr>
		<tr>
			<td class="cell-label"><?php echo $label['gm_email'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_input($inputs['gm_email']);?></td>
		</tr>
		
		<?php echo table_row_spacer(3, 10);?>
		
		<tr>
			<td colspan="3"><h3><?php echo $label['r_info'];?></h3></td>
		</tr>
		<tr>
			<td class="cell-label"><?php echo $label['r_duration'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_input($inputs['reason_duration']);?></td>
		</tr>
		<tr>
			<td class="cell-label"><?php echo $label['r_explain'];?></td>
			<td class="cell-spacer"></td>
			<td><?php echo form_textarea($inputs['reason_explain']);?></td>
		</tr>
		
		<?php echo table_row_spacer(3, 10);?>
		
		<tr>
			<td class="cell-label"></td>
			<td class="cell-spacer"></td>
			<td>
				<?php echo text_output($label['check'], 'p', 'fontSmall gray bold');?>
				<?php echo form_input($inputs['check']);?>
			</td>
		</tr>
		
		<?php echo table_row_spacer(3, 20);?>
		
		<tr>
			<td colspan="2"></td>
			<td><?php echo form_button($button_submit);?></td>
		</tr>
	</table>
<?php echo form_close();?>