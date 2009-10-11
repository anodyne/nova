<?php echo text_output($header, 'h1', 'page-head');?>

<?php if (isset($missions) && $missions === FALSE): ?>
	<?php echo text_output($label['no_mission'], 'p', 'bold');?>
<?php else: ?>
	<?php if ($this->settings['use_mission_notes'] == 'y'): ?>
		<div id="notes">
			<p class="float_right fontSmall">
				<a href="#" id="toggle_notes"><strong><?php echo $label['showhide'];?></strong></a>
			</p>
			<?php echo text_output($label['mission_notes'], 'h3');?>
			<div class="notes_content hidden">
				<?php if (isset($mission)): ?>
					<?php echo text_output($mission['notes']);?>
				<?php elseif (isset($mission_notes)): ?>
					<?php foreach ($mission_notes as $m): ?>
						<?php echo text_output($m['title'], 'p', 'bold');?>
						<?php echo text_output($m['notes']);?>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>

	<?php echo form_open($form_action);?>
		<table class="table100">
	
			<?php if ($this->uri->segment(3) === FALSE): ?>
				<tr>
					<td class="cell-label"><?php echo $label['myauthor'];?></td>
					<td class="cell-spacer"></td>
					<td>
						<?php if (isset($characters)): ?>
							<?php echo form_dropdown('author', $characters, $key['my_author']);?>
						<?php else: ?>
							<?php echo text_output($character['name'], ''); ?>
							<?php echo form_hidden('author', $character['id']);?>
						<?php endif; ?>
					</td>
				</tr>
			
				<?php echo table_row_spacer(3, 10);?>
			<?php endif; ?>
			
			<?php if (isset($all) && is_array($all)): ?>
				<tr>
					<td class="cell-label">
						<?php if ($this->uri->segment(3) === FALSE): ?>
							<?php echo $label['otherauthors'];?>
						<?php else: ?>
							<?php echo $label['authors'];?>
						<?php endif; ?>
					</td>
					<td class="cell-spacer"></td>
					<td>
						<?php echo form_dropdown('other_authors', $all, $key['all'], 'id = "all"');?>
						&nbsp;
						<a href="#" id="add_author" class="fontSmall"><?php echo $label['addauthor'];?></a>
						<input type="hidden" name="to" id="authors_hidden" value="<?php echo $to;?>" />
						<p id="authors">
							<?php if (isset($recipient_list)): ?>
								<?php foreach ($recipient_list as $r): ?>
									<?php echo $r ."\r\n";?>
								<?php endforeach; ?>
							<?php endif; ?>
						</p>
					</td>
				</tr>
				
				<?php echo table_row_spacer(3, 10);?>
			<?php endif;?>
		
			<tr>
				<td class="cell-label"><?php echo $label['mission'];?></td>
				<td class="cell-spacer"></td>
				<td>
					<?php if (isset($missions)): ?>
						<?php echo form_dropdown('mission', $missions, $key['missions']);?>
					<?php else: ?>
						<?php echo anchor('sim/missions/'. $mission['id'], $mission['title']); ?>
						<?php echo form_hidden('mission', $mission['id']);?>
					<?php endif; ?>
				</td>
			</tr>
		
			<?php echo table_row_spacer(3, 10);?>
		
			<tr>
				<td class="cell-label"><?php echo $label['title'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['title']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['location'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['location']);?></td>
			</tr>
			<tr>
				<td class="cell-label"><?php echo $label['timeline'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_input($inputs['timeline']);?></td>
			</tr>
		
			<?php echo table_row_spacer(3, 10);?>
		
			<tr>
				<td class="cell-label"><?php echo $label['content'];?></td>
				<td class="cell-spacer"></td>
				<td><?php echo form_textarea($inputs['content']);?></td>
			</tr>
		
			<?php echo table_row_spacer(3, 10);?>
		
			<tr>
				<td class="cell-label"><?php echo $label['tags'];?></td>
				<td class="cell-spacer"></td>
				<td>
					<?php echo text_output($label['tags_sep'], 'span', 'fontSmall gray bold');?><br />
					<?php echo form_input($inputs['tags']);?>
				</td>
			</tr>
		
			<?php echo table_row_spacer(3, 20);?>
		
			<tr>
				<td colspan="2"></td>
				<td>
					<?php echo form_button($inputs['post']);?>
					&nbsp;
					<?php echo form_button($inputs['save']);?>
				
					<?php if ($this->uri->segment(3) !== FALSE): ?>
						&nbsp;
						<?php echo form_button($inputs['delete']);?>
					<?php endif; ?>
				</td>
			</tr>
		</table>
	<?php echo form_close();?>
<?php endif;?>