<?php if (isset($header)): ?>
	<h2 class="page-subhead"><?php echo $header;?></h2>
<?php endif;?>

<p><?php echo $message;?></p>

<?php if (Request::current()->param('id') != ''): ?>
	<p class="fontMedium bold"><a href="<?php echo Url::site('setup/install/changedb');?>">&laquo; Back to Change Database Panel</a></p>
<?php endif;?>

<hr>

<?php if (Request::current()->param('id') == 'table'): ?>
	<?php $data_array = array('images' => $images);?>
	<?php echo View::factory('components/pages/install/changedb_table', $data_array)->render();?>
<?php elseif (Request::current()->param('id') == 'field'): ?>
	<?php $data_array = array('images' => $images, 'options' => $options, 'fieldtypes' => $fieldtypes);?>
	<?php echo View::factory('components/pages/install/changedb_field', $data_array)->render();?>
<?php elseif (Request::current()->param('id') == 'query'): ?>
	<?php $data_array = array('images' => $images);?>
	<?php echo View::factory('components/pages/install/changedb_query', $data_array)->render();?>
<?php else: ?>
	<a href="<?php echo Url::site('setup/install/changedb/table');?>" class="install-secoptions">
		<span class="secoptions-dbtable">Create new database table</span>
	</a>
	
	<a href="<?php echo Url::site('setup/install/changedb/field');?>" class="install-secoptions">
		<span class="secoptions-dbfield">Create new database table field</span>
	</a>
	
	<a href="<?php echo Url::site('setup/install/changedb/query');?>" class="install-secoptions">
		<span class="secoptions-dbquery">Run a MySQL query</span>
	</a>
<?php endif;?>