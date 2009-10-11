<?php echo text_output($header, 'h1', 'page-head');?>

<p class="fontMedium bold"><?php echo anchor('manage/posts', $label['back']);?></p>

<?php echo form_open('manage/posts/edit/'. $id .'/update');?>
	<table class="table100">
		<tr>
			<td class="cell-label"><?php echo $label['authors'];?></td>
			<td class="cell-spacer"></td>
			<td>
				<?php echo form_dropdown('other_authors', $all, '', 'id = "all"');?>
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
		
		<tr>
			<td class="cell-label"><?php echo $label['mission'];?></td>
			<td class="cell-spacer"></td>
			<td>
				<?php if ($this->auth->get_access_level() == 2): ?>
					<?php echo form_dropdown('post_mission', $missions, $inputs['mission']);?>
				<?php else: ?>
					<?php echo text_output(ucfirst($inputs['mission_name']), ''); ?>
					<?php echo form_hidden('post_mission', $inputs['mission']);?>
				<?php endif;?>
			</td>
		</tr>
		
		<?php echo table_row_spacer(3, 10);?>
		
		<tr>
			<td class="cell-label"><?php echo $label['status'];?></td>
			<td class="cell-spacer"></td>
			<td>
				<?php if ($this->auth->get_access_level() == 2): ?>
					<?php echo form_dropdown('post_status', $status, $inputs['status']);?>
				<?php else: ?>
					<?php echo text_output(ucfirst($inputs['status']), ''); ?>
					<?php echo form_hidden('post_status', $inputs['status']);?>
				<?php endif;?>
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
				<?php echo text_output($label['tags_inst'], 'span', 'fontSmall gray bold');?><br />
				<?php echo form_input($inputs['tags']);?>
			</td>
		</tr>
		
		<?php echo table_row_spacer(3, 20);?>
		
		<tr>
			<td colspan="2"></td>
			<td><?php echo form_button($buttons['update']);?></td>
		</tr>
	</table>
<?php echo form_close();?>