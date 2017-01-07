<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php if (isset($missions) and  ! $missions): ?>
	<?php echo text_output($label['no_mission'], 'p', 'bold');?>
<?php else: ?>
	<?php if ($this->options['use_mission_notes'] == 'y'): ?>
		<div id="notes">
			<p class="float_right fontSmall">
				<a href="#" id="toggle_notes"><strong><?php echo $label['showhide'];?></strong></a>
			</p>
			<h3><?php echo $label['mission_notes'];?> <small class="gray"><?php echo $label['note_last_updated'];?></small></h3>
			<div class="notes_content hidden">
				<?php if ($missionNotesUpdate === true): ?>
					<span class="label label-warning"><?php echo $label['updated'];?></span>
				<?php endif;?>
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
	
	<div id="editable">
		<?php echo form_open($form_action, array('id' => 'writepost'));?>
			<?php if (isset($all_characters) and is_array($all_characters)): ?>
				<p>
					<kbd><?php echo $label['authors'];?></kbd>
					<span id="chosen-incompat" class="gray fontSmall bold hidden"><?php echo $label['chosen_incompat'];?><br /><br /></span>
					<?php echo form_multiselect('authors[]', $all_characters, $authors_selected, 'id="all" class="chosen" title="'.$label['select'].'"');?>
				</p>
			<?php endif;?>
			
			<p>
				<kbd><?php echo $label['mission'];?></kbd>
				<?php if (isset($missions)): ?>
					<?php echo form_dropdown('mission', $missions, $inputs['mission'], 'class="chosen"');?>
				<?php else: ?>
					<?php echo anchor('sim/missions/id/'. $mission['id'], $mission['title']); ?>
					<?php echo form_hidden('mission', $mission['id']);?>
				<?php endif; ?>
			</p>
			
			<p>
				<kbd><?php echo $label['title'];?></kbd>
				<?php echo form_input($inputs['title']);?>
			</p>
			
			<p>
				<kbd><?php echo $label['location'];?></kbd>
				<?php echo form_input($inputs['location']);?>
			</p>
			
			<p>
				<kbd><?php echo $label['timeline'];?></kbd>
				<?php echo form_input($inputs['timeline']);?>
			</p>
			
			<p>
				<kbd><?php echo $label['content'];?></kbd>
				<?php echo form_textarea($inputs['content']);?>
			</p>
			
			<p>
				<kbd><?php echo $label['tags'];?></kbd>
				<?php echo text_output($label['tags_sep'], 'span', 'fontSmall gray bold');?><br />
				<?php echo form_input($inputs['tags']);?>
				<?php echo img($images['help']);?>
			</p><br />
			
			<p>
				<?php echo form_button($inputs['post']);?>
				&nbsp;
				<?php echo form_button($inputs['save']);?>
			
				<?php if ($this->uri->segment(3) !== false): ?>
					&nbsp;
					<?php echo form_button($inputs['delete']);?>
				<?php endif; ?>

				&nbsp;
				<?php echo anchor('write/index', $label['back_wcp']);?>
			</p>
		<?php echo form_close();?>
	</div>
	
	<div id="readonly" class="hidden">
		<p class="fontMedium">
			<?php echo anchor('write/index', $label['back_wcp']);?>
			&middot;
			<?php echo anchor('write/missionpost/'.$this->uri->segment(3), $label['more_edits']);?>
		</p><br />
		
		<?php if ($inputs['locked']): ?>
			<div id="notes">
				<p class="float_left"><?php echo img($images['excl']);?>&nbsp;&nbsp;</p>
				<?php echo text_output($label['locked'], 'h4');?>
			</div>
		<?php endif;?>
		
		<p>
			<kbd><?php echo $label['authors'];?></kbd>
			<?php echo $this->char->get_authors(implode(',', $authors_selected));?>
		</p>
		
		<p>
			<kbd><?php echo $label['mission'];?></kbd>
			<?php if (isset($missions)): ?>
				<?php echo anchor('sim/missions/id/'.$inputs['mission'], $this->mis->get_mission($inputs['mission'], 'mission_title'));?>
			<?php else: ?>
				<?php echo anchor('sim/missions/id/'. $mission['id'], $mission['title']); ?>
			<?php endif; ?>
		</p>
		
		<p>
			<kbd><?php echo $label['title'];?></kbd>
			<?php echo $inputs['title']['value'];?>
		</p>
		
		<p>
			<kbd><?php echo $label['location'];?></kbd>
			<?php echo $inputs['location']['value'];?>
		</p>
		
		<p>
			<kbd><?php echo $label['timeline'];?></kbd>
			<?php echo $inputs['timeline']['value'];?>
		</p>
		
		<p>
			<kbd><?php echo $label['content'];?></kbd>
			<?php echo nl2br($inputs['content']['value']);?>
		</p>
		
		<p>
			<kbd><?php echo $label['tags'];?></kbd>
			<?php echo $inputs['tags']['value'];?>
		</p>
	</div>
<?php endif;?>