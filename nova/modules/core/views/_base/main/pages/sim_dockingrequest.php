<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>
<?php echo text_output($docking_inst);?>

<?php echo form_open('sim/dockingrequest');?>
	<?php echo text_output($label['info'], 'h3', 'page-subhead');?>
	<div class="indent-left">
		<p>
			<kbd><?php echo $label['name'];?></kbd>
			<?php echo form_input($inputs['sim_name']);?>
		</p>
		
		<p>
			<kbd><?php echo $label['url'];?></kbd>
			<?php echo form_input($inputs['sim_url']);?>
		</p>
	</div><br />
	
	<?php echo text_output($label['gm_info'], 'h3', 'page-subhead');?>
	<div class="indent-left">
		<p>
			<kbd><?php echo $label['gm_name'];?></kbd>
			<?php echo form_input($inputs['gm_name']);?>
		</p>
		
		<p>
			<kbd><?php echo $label['gm_email'];?></kbd>
			<?php echo form_input($inputs['gm_email']);?>
		</p>
	</div><br />
	
	<?php if (isset($docking)): ?>
		<?php foreach ($docking as $a): ?>
			<?php if (isset($a['fields'])): ?>
				<?php echo text_output($a['name'], 'h3', 'page-subhead');?>
				
				<div class="indent-left">
					<?php foreach ($a['fields'] as $f): ?>
						<p>
							<kbd><?php echo $f['field_label'];?></kbd>

							<?php if ( ! empty($f['field_help'])): ?>
								<p class="gray fontSmall"><?php echo $f['field_help'];?></p>
							<?php endif;?>
							
							<?php echo $f['input'];?>
						</p>
					<?php endforeach; ?>
				</div><br />
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>
	
	<p>
		<?php echo form_input($inputs['check']);?>
	</p>
	
	<p>
		<?php echo form_button($button_submit);?>
	</p>
			
	<!--<table class="table100">
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
	</table>-->
<?php echo form_close();?>