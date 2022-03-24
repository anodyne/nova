<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>

<?php if (count($uninstalled) > 0): ?>
	<?php echo text_output($label['install_skins'], 'h3', 'orange');?>
	<?php echo text_output($label['quick_install'], 'p', 'fontSmall gray');?>
	
	<table class="table100 zebra UITheme">
		<tbody>
		<?php foreach ($uninstalled as $u): ?>
			<tr class="height_40">
				<td><strong><?php echo ucfirst($u);?></strong></td>
				<td class="gray">views/<?php echo $u;?></td>
				<td class="col_75 align_right">
					<?php echo form_open('site/catalogueskins/install');?>
						<?php echo form_hidden('install_skin', $u);?>
						<?php echo form_button($buttons['install']);?>
					<?php echo form_close();?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table><br />
<?php endif;?>

<p class="bold">
	<a href="#" rel="facebox" myAction="add" mySec="skin" class="image"><?php echo img($images['add']) .' '. $label['addskin'];?></a><br />
	<a href="#" rel="facebox" myAction="add" mySec="section" class="image"><?php echo img($images['add']) .' '. $label['addskinsec'];?></a>
</p>

<?php if (isset($catalogue)): ?>
	<?php foreach ($catalogue as $c): ?>
		<table class="zebra table100 border-1">
			<tbody>
				<tr>
					<td colspan="2"><?php echo text_output($c['name'], 'h4');?></td>
					<td class="fontSmall bold gray align_center col_50pct">
						<?php echo $label['location'] .' '.APPFOLDER .'/views/'. $c['location'];?>
					</td>
					<td class="col_75 align_right">
						<a href="#" rel="facebox" class="delete image" myAction="delete" myID="<?php echo $c['id'];?>" mySec="skin" title="<?php echo $label['delete'];?>">
							<?php echo img($images['delete']);?>
						</a>
						&nbsp;
						<a href="#" rel="facebox" class="edit image" myAction="edit" myID="<?php echo $c['id'];?>" mySec="skin" title="<?php echo $label['edit'];?>">
							<?php echo img($images['edit']);?>
						</a>
					</td>
				</tr>
				
				<?php if (isset($c['sec'])): ?>
					<?php foreach ($c['sec'] as $sec): ?>
						<tr>
							<td class="col_5"></td>
							<td>
								<?php if ($sec['default'] == 'y'): ?>
									<?php echo img($images['default']);?>
								<?php endif;?>
								
								<strong><?php echo ucfirst($sec['name']);?></strong>
							</td>
							<td class="align_center">
								<?php if ($sec['status'] == 'active'): ?>
									<span class="green bold">
								<?php elseif ($sec['status'] == 'inactive'): ?>
									<span class="red bold">
								<?php elseif ($sec['status'] == 'development'): ?>
									<span class="orange bold">
								<?php endif;?>
								
								<?php echo ucfirst($sec['status']);?></span>
							</td>
							<td class="col_75 align_right">
								<a href="#" rel="facebox" class="delete image" myAction="delete" mySec="section" myID="<?php echo $sec['id'];?>" title="<?php echo $label['delete'];?>">
									<?php echo img($images['delete']);?>
								</a>
								&nbsp;
								<a href="#" rel="facebox" class="edit image" myAction="edit" mySec="section" myID="<?php echo $sec['id'];?>" title="<?php echo $label['edit'];?>">
									<?php echo img($images['edit']);?>
								</a>
							</td>
						</tr>
					<?php endforeach;?>
				<?php endif;?>
			</tbody>
		</table><br />
	<?php endforeach;?>
<?php else: ?>
	<?php echo text_output($label['no_skins'], 'h3', 'orange');?>
<?php endif;?>