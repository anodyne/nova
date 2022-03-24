<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<p class="bold"><?php echo anchor('manage/missions', $label['back']);?></p>

<?php if ($id === FALSE): ?>
	<?php echo text_output($label['images_later'], 'p', 'bold orange');?>
<?php endif;?>

<?php if ($id !== FALSE): ?>
	<div id="tabs">
		<ul>
			<li><a href="#one"><span><?php echo $label['info'];?></span></a></li>
			<li><a href="#two"><span><?php echo $label['images'];?></span></a></li>
		</ul>
<?php endif;?>

<?php if ($id !== FALSE): ?>
	<div id="one">
<?php endif;?>
		<?php echo form_open('manage/missions/'. $form);?>
			<p>
				<kbd><?php echo $label['title'];?></kbd>
				<?php echo form_input($inputs['title']);?>
			</p>
			<p>
				<kbd><?php echo $label['status'];?></kbd>
				<?php echo form_dropdown('mission_status', $values['status'], $inputs['status']);?>
				<?php echo form_hidden('mission_oldstatus', $inputs['status']);?>
			</p>
			<p>
				<kbd><?php echo $label['order'];?></kbd>
				<?php echo form_input($inputs['order']);?>
			</p>
			<p>
				<kbd>
					<?php echo $label['group'];?>
					&nbsp;
					<span class="fontTiny"><?php echo anchor('manage/missiongroups', $label['managegroups'], array('class' => 'edit'));?></span>
				</kbd>
				<?php if (isset($groups)): ?>
					<?php echo form_dropdown('mission_group', $groups, $inputs['group']);?>
				<?php else: ?>
					<?php echo text_output($label['nogroups'], 'span', 'orange bold fontSmall');?>
					<?php echo form_hidden('mission_group', 0);?>
				<?php endif;?>
			</p><br />
			
			<p>
				<kbd><?php echo $label['start'];?></kbd>
				<?php echo form_input($inputs['start']);?>
			</p>
			<p>
				<kbd><?php echo $label['end'];?></kbd>
				<?php echo form_input($inputs['end']);?>
			</p><br />
			
			<p>
				<kbd><?php echo $label['desc'];?></kbd>
				<?php echo form_textarea($inputs['desc']);?>
			</p>
			<p>
				<kbd><?php echo $label['summary'];?></kbd>
				<?php echo form_textarea($inputs['summary']);?>
			</p>
			<p>
				<kbd><?php echo $label['notes'];?></kbd>
				<?php echo form_textarea($inputs['notes']);?>
				<?php echo form_hidden('mission_oldnotes', $inputs['notes']['value']);?>
			</p>
			
			<br />
			<?php echo form_hidden('id', $id);?>
			<?php echo form_button($buttons['submit']);?>
		
		<?php echo form_close();?>
<?php if ($id !== FALSE): ?>
	</div>
	
	<div id="two">
		<p><?php echo anchor('upload/index', img($images['upload']) .' '. $label['upload'], array('class' => 'image fontMedium bold'));?></p>
		
		<div class="subtabs">
			<ul>
				<li><a href="#five"><span><?php echo $label['mission_images'];?></span></a></li>
				<li><a href="#six"><span><?php echo $label['available_images'];?></span></a></li>
			</ul>
			
			<div id="five">
				<p>
					<?php echo form_button($buttons['update']);?> &nbsp;&nbsp;
					<span id="loading_upload_update" class="hidden"><?php echo img($images['loading']);?></span>
				</p><br />
				
				<ul id="list-grid">
				<?php if (is_array($inputs['images']) && count($inputs['images']) > 0): ?>
					<?php foreach ($inputs['images'] as $i): ?>
						<?php $image = array('src' => base_url().Location::asset('images/missions', $i), 'width' => 130);?>
						<li id="img_<?php echo str_replace('.', '\\.', $i);?>"><a href="#" class="image upload-close" remove="<?php echo str_replace('.', '\\.', $i);?>">x</a><?php echo img($image);?></li>
					<?php endforeach;?>
				<?php endif;?>
				</ul>
			</div>
			
			<div id="six">
				<?php if (isset($directory)): ?>
					<br />
					<table class="zebra">
						<tbody>
						<?php foreach ($directory as $d): ?>
							<tr>
								<td class="cell-label"><?php echo $d['file'];?></td>
								<td class="cell-spacer"></td>
								<td><?php echo img($d['image']);?></td>
								<td class="cell-spacer"></td>
								<td><?php echo form_button($buttons['use']);?></td>
							</tr>
						<?php endforeach;?>
						</tbody>
					</table>
				<?php endif;?>
			</div>
		</div>
	</div>
<?php endif;?>
	
<?php if ($id !== FALSE): ?>
	</div>
<?php endif;?>