<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>

<?php if (isset($uninstalled) && count($uninstalled) > 0): ?>
	<?php echo text_output($label['install_ranks'], 'h3', 'orange');?>
	<?php echo text_output($label['quick_install'], 'p', 'fontSmall gray');?>
	
	<table class="table100 zebra UITheme">
		<tbody>
		<?php foreach ($uninstalled as $u): ?>
			<tr class="height_40">
				<td><strong><?php echo ucfirst($u);?></strong></td>
				<td class="gray">assets/common/<?php echo GENRE;?>/ranks/<?php echo $u;?></td>
				<td class="col_75 align_right">
					<?php echo form_open('site/catalogueranks/install');?>
						<?php echo form_hidden('install_rank', $u);?>
						<?php echo form_button($buttons['install']);?>
					<?php echo form_close();?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table><br />
<?php endif;?>

<p class="bold">
	<a href="#" rel="facebox" myAction="add" class="image"><?php echo img($images['add']) .' '. $label['add'];?></a>
</p>

<?php if (isset($catalogue)): ?>
	<table class="zebra table100">
		<thead>
			<tr>
				<th><?php echo $label['name'];?></th>
				<th><?php echo $label['status'];?></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($catalogue as $c): ?>
			<tr>
				<td>
					<?php if ($c['default'] == 'y'): ?>
						<?php echo img($images['default']);?>
					<?php endif;?>
					
					<strong><?php echo $c['name'];?></strong><br />
					<span class="fontSmall gray">
						<?php echo $label['location'] .' '. APPFOLDER .'/assets/common/'. GENRE .'/ranks/'. $c['location'];?>
					</span>
				</td>
				<td class="col_150">
					<?php if ($c['status'] == 'active'): ?>
						<span class="green bold">
					<?php elseif ($c['status'] == 'inactive'): ?>
						<span class="red bold">
					<?php elseif ($c['status'] == 'development'): ?>
						<span class="orange bold">
					<?php endif;?>
					
					<?php echo ucfirst($c['status']);?></span>
				</td>
				<td class="col_75 align_right">
					<a href="#" rel="facebox" class="delete image" myAction="delete" myID="<?php echo $c['id'];?>" title="<?php echo $label['delete'];?>">
						<?php echo img($images['delete']);?>
					</a>
					&nbsp;
					<a href="#" rel="facebox" class="edit image" myAction="edit" myID="<?php echo $c['id'];?>" title="<?php echo $label['edit'];?>">
						<?php echo img($images['edit']);?>
					</a>
				</td>
		<?php endforeach;?>
		</tbody>
	</table>
<?php else: ?>
	<?php echo text_output($label['no_ranks'], 'h3', 'orange');?>
<?php endif;?>