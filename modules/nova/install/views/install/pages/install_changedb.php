<?php if (isset($header)): ?>
	<h2 class="page-subhead"><?php echo $header;?></h2>
<?php endif;?>

<p class="fontMedium"><?php echo $message;?></p>

<?php if (Request::instance()->param('id') != ''): ?>
	<p class="fontMedium bold"><?php echo html::anchor('install/changedb', '&laquo; '.__('Back to Change Database Panel'));?></p>
<?php endif;?>

<hr />

<?php if (Request::instance()->param('id') == 'table'): ?>
	<?php $data_array = array('images' => $images);?>
	<?php echo View::factory(location::view('install_changedb_table', NULL, 'install', 'pages'), $data_array)->render();?>
<?php elseif (Request::instance()->param('id') == 'field'): ?>
	<?php $data_array = array('images' => $images, 'options' => $options, 'fieldtypes' => $fieldtypes);?>
	<?php echo View::factory(location::view('install_changedb_field', NULL, 'install', 'pages'), $data_array)->render();?>
<?php elseif (Request::instance()->param('id') == 'query'): ?>
	<?php $data_array = array('images' => $images);?>
	<?php echo View::factory(location::view('install_changedb_query', NULL, 'install', 'pages'), $data_array)->render();?>
<?php else: ?>
	<a href="<?php echo url::site('install/changedb/table');?>" class="install-secoptions">
		<span class="secoptions-dbtable"><?php echo __('Create new database table');?></span>
	</a>
	
	<a href="<?php echo url::site('install/changedb/field');?>" class="install-secoptions">
		<span class="secoptions-dbfield"><?php echo __('Create new database table field');?></span>
	</a>
	
	<a href="<?php echo url::site('install/changedb/query');?>" class="install-secoptions">
		<span class="secoptions-dbquery"><?php echo __('Run a MySQL query');?></span>
	</a>
<?php endif;?>