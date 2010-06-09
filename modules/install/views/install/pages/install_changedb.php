<p class="fontMedium"><?php echo $message;?></p>

<hr />

<?php if (!isset($_POST['submit']) || (isset($_POST['submit']) && !isset($success))): ?>
	<?php echo form::open();?>
		<?php echo View::factory('_common/partials/_login_form')->render();?>
<?php else: ?>
	<?php if (isset($success)): ?>
		<h2 class="page-subhead"><?php echo __('changedb.table_header');?></h2>
		<p class="fontMedium"><?php echo __('changedb.table_inst');?></p>
		
		<strong><?php echo Database::instance()->table_prefix();?></strong>
		<?php echo form::input('table_name');?>
		
		&nbsp;&nbsp;
		
		<?php echo form::button('submit', __('changedb.button_table'), $inputs['table']);?>
		
		&nbsp;&nbsp;
		
		<span class="loading-table hidden"><?php echo html::image($images['loading']['src'], $images['loading']['attr']);?></span>
		<strong class="success success-table hidden"><?php echo __('changedb.success_table');?></strong>
		<strong class="error error-table hidden"><?php echo __('changedb.failure_table');?></strong>
		
		<hr />
		
		<h2 class="page-subhead"><?php echo __('changedb.field_header');?></h2>
		<p class="fontMedium"><?php echo __('changedb.field_inst');?></p>
		
		<p>
			<kbd><?php echo __('changedb.field_choose');?></kbd>
			<span class="fontSmall subtle"><?php echo __('changedb.field_choose_desc');?></span><br />
			<?php echo form::select('table_name', $options);?>
		</p>
		
		<p>
			<kbd><?php echo __('changedb.field_name');?></kbd>
			<span class="fontSmall subtle"><?php echo __('changedb.field_name_desc');?></span><br />
			<?php echo form::input('field_name');?>
		</p>
		
		<p>
			<kbd><?php echo __('changedb.field_type');?></kbd>
			<span class="fontSmall subtle"><?php echo __('changedb.field_type_desc');?></span><br />
			<?php echo form::select('field_type', $fieldtypes);?>
		</p>
		
		<p>
			<kbd><?php echo __('changedb.field_constraint');?></kbd>
			<span class="fontSmall subtle"><?php echo __('changedb.field_constraint_desc');?></span><br />
			<?php echo form::input('field_constraint');?>
		</p>
		
		<p>
			<kbd><?php echo __('changedb.field_default');?></kbd>
			<span class="fontSmall subtle"><?php echo __('changedb.field_default_desc');?></span><br />
			<?php echo form::input('field_default');?>
		</p>
		
		<?php echo form::button('submit', __('changedb.button_table'), $inputs['table']);?>
		
		&nbsp;&nbsp;
		
		<span class="loading-table hidden"><?php echo html::image($images['loading']['src'], $images['loading']['attr']);?></span>
		<strong class="success success-table hidden"><?php echo __('changedb.success_table');?></strong>
		<strong class="error error-table hidden"><?php echo __('changedb.failure_table');?></strong>
	<?php endif;?>
<?php endif;?>