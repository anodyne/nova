<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<p class="bold"><?php echo anchor('manage/tour', $label['back']);?></p>

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

	<?php echo form_open('manage/tour/'. $form);?>
	
<?php if ($id !== FALSE): ?>
	<div id="one">
<?php endif;?>
		<p>
			<kbd><?php echo $label['name'];?></kbd>
			<?php echo form_input($inputs['name']);?>
		</p>
		<p>
			<kbd><?php echo $label['order'];?></kbd>
			<?php echo form_input($inputs['order']);?>
		</p>
		<p>
			<kbd><?php echo $label['display'];?></kbd>
			<?php echo form_radio($inputs['display_y']) .' '. form_label($label['on'], 'display_y');?>
			<?php echo form_radio($inputs['display_n']) .' '. form_label($label['off'], 'display_n');?>
		</p>
		
		<?php if (isset($specs)): ?>
			<p>
				<kbd><?php echo $label['spec_item'];?></kbd>
				<?php echo form_dropdown('tour_spec_item', $specs, $inputs['spec_item']);?>
				<a rel="tooltip" title="<?php echo $label['specitem_select'];?>" class="image"><?php echo img($images['help']);?></a>
			</p>
		<?php endif;?>
		
		<p>
			<kbd><?php echo $label['summary'];?></kbd>
			<?php echo form_textarea($inputs['summary']);?>
		</p><br />
		
		<?php if (isset($inputs['fields'])): ?>
			<?php foreach ($inputs['fields'] as $f): ?>
				<p>
					<kbd><?php echo $f['field_label'];?></kbd>

					<?php if ( ! empty($f['field_help'])): ?>
						<p class="gray fontSmall"><?php echo $f['field_help'];?></p>
					<?php endif;?>
					
					<?php echo $f['input'];?>
				</p>
			<?php endforeach;?>
		<?php endif;?>
		
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
				<li><a href="#five"><span><?php echo $label['tour_images'];?></span></a></li>
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
						<?php $image = array('src' => base_url().Location::asset('images/tour', $i), 'width' => 130);?>
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