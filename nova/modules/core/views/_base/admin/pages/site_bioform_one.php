<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<p class="bold"><?php echo anchor('site/bioform', $label['back']);?></p>

<?php if (isset($inputs)): ?>
	<?php echo form_open('site/bioform/edit/'. $id);?>
		<p>
			<kbd><?php echo $label['section'];?></kbd>
			<?php echo form_dropdown('field_section', $values['section'], $defaults['section']);?>
		</p>
		<p>
			<kbd><?php echo $label['type'];?></kbd>
			<?php echo form_dropdown('field_type', $values['type'], $defaults['type']);?>
		</p>
		<p>
			<kbd><?php echo $label['label'];?></kbd>
			<?php echo form_input($inputs['label']);?>
		</p>
		<p>
			<kbd><?php echo $label['help'];?></kbd>
			<?php echo form_textarea($inputs['help']);?>
		</p>
		<p>
			<kbd><?php echo $label['order'];?></kbd>
			<?php echo form_input($inputs['order']);?>
		</p>
		<p>
			<kbd><?php echo $label['display'];?></kbd>
			<?php echo form_radio($inputs['display_y']);?>
			<?php echo form_label($label['yes'], 'field_display_y');?>
			
			<?php echo form_radio($inputs['display_n']);?>
			<?php echo form_label($label['no'], 'field_display_n');?>
		</p><br />
		
		<?php echo text_output($label['html'], 'h3', 'page-subhead');?>
		
		<div class="indent-left">
			<p>
				<kbd><?php echo $label['name'];?></kbd>
				<?php echo form_input($inputs['name']);?>
			</p>
			<p>
				<kbd><?php echo $label['id'];?></kbd>
				<?php echo form_input($inputs['fid']);?>
			</p>
			<p>
				<kbd><?php echo $label['class'];?></kbd>
				<?php echo form_input($inputs['class']);?>
			</p>
			<p>
				<kbd><?php echo $label['rows'];?></kbd>
				<?php echo form_input($inputs['rows']);?>
			</p>
		</div><br />
		
		<p>
			<?php echo form_hidden('field_id', $id);?>
			<?php echo form_button($buttons['submit']);?>
		</p>
	<?php echo form_close();?>
	
	<?php if (isset($select)): ?>
		<br /><hr /><br />
		<?php echo text_output($label['select_values'], 'h2', 'page-subhead');?>
		<?php echo text_output($label['bioval']);?>
		
		<p>
			<kbd><?php echo $label['value'];?></kbd>
			<?php echo form_input($inputs['val_add_value']);?>
		</p>
		<p>
			<kbd><?php echo $label['content'];?></kbd>
			<?php echo form_input($inputs['val_add_content']);?>
		</p><br />
		
		<?php echo form_button($buttons['add']);?>
		&nbsp;
		<span id="loading_add" class="hidden fontSmall gray"><?php echo img($loading);?></span>
		
		<p>&nbsp;</p>
		
		<div class="UITheme">
			<ul id="list">
				<?php foreach ($select as $key => $value): ?>
					<li class="ui-state-default" id="value_<?php echo $key;?>">
						<div class="float_right"><a href="#" class="remove image" name="remove" id="<?php echo $key;?>">x</a></div>
						<a href="#" rel="facebox" myAction="edit_val" myField="<?php echo $id;?>" class="image" myID="<?php echo $key;?>"/><?php echo $value;?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		
		<br />
		<?php echo form_button($buttons['update']);?>
		&nbsp;
		<span id="loading_update" class="hidden fontSmall gray"><?php echo img($loading);?></span>
	<?php endif; ?>
<?php endif; ?>