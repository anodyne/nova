<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<style type="text/css">
	a.image { display: inline-block; }
	a.image span { padding: 0px; display: inline-block; }
	a.image span img { margin: 0px; padding: 0px; }
</style>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php if ($edit_valid === TRUE || $edit_valid_form === TRUE): ?>
	<p>
		<?php echo link_to_if($edit_valid, 'characters/bio/'. $character['id'], $label['edit'], array('class' => 'edit fontSmall bold'));?>
		<?php echo link_to_if($edit_valid_form, 'site/bioform', $label['edit_form'], array('class' => 'edit fontSmall bold'));?>
	</p>
<?php endif;?>

<?php if (isset($msg_error)): ?>
	<?php echo text_output($msg_error, 'h3', 'orange');?>
<?php endif; ?>

<?php if (isset($character['image']['src'])): ?>
	<div class="bio_main_image" id="gallery">
		<div class="fontTiny gray"><?php echo $label['gallery'];?></div><br />
		<a href="<?php echo $character['image']['src'];?>" class="image" rel="prettyPhoto[gallery]"><?php echo img($character['image']);?></a>
		
		<div class="hidden">
			<?php if (count($character['image_array']) > 0): ?>
				<?php foreach ($character['image_array'] as $image): ?>
					<a href="<?php echo $image['src'];?>" class="image" rel="prettyPhoto[gallery]"><?php echo img($image);?></a>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>

<?php if (isset($character_info)): ?>
	<table class="table560px" cellpadding="3">
		<?php foreach ($character_info as $a): ?>
			<?php if (!empty($a['value'])): ?>
				<tr>
					<td class="cell-label"><?php echo $a['label'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo $a['value'];?></td>
				</tr>
			<?php endif; ?>
		<?php endforeach; ?>
		
		<?php echo table_row_spacer(3, 10);?>
		
		<?php if (Auth::is_logged_in() and ! is_null($character['user'])): ?>
		<tr>
			<td colspan="2"></td>
			<td>
				<?php echo anchor('personnel/user/'. $character['user'], $label['view_user'], array('class' => 'bold'));?>
			</td>
		</tr>
		<?php endif; ?>
		
		<?php echo table_row_spacer(3, 10);?>
		
		<?php if ($postcount > 0): ?>
			<tr>
				<td colspan="2"></td>
				<td>
					<?php echo anchor('personnel/viewposts/c/'. $character['id'], $label['view_all_posts'], array('class' => 'bold'));?>
				</td>
			</tr>
		<?php endif;?>
		
		<?php if ($logcount > 0): ?>
			<tr>
				<td colspan="2"></td>
				<td>
					<?php echo anchor('personnel/viewlogs/c/'. $character['id'], $label['view_all_logs'], array('class' => 'bold'));?>
				</td>
			</tr>
		<?php endif;?>
		
		<?php if ($awardcount > 0): ?>
			<tr>
				<td colspan="2"></td>
				<td>
					<?php echo anchor('personnel/viewawards/c/'. $character['id'], $label['view_all_awards'], array('class' => 'bold'));?>
				</td>
			</tr>
		<?php endif;?>
	</table>
<?php endif;?>

<?php if (isset($tabs)): ?>
	<div id="tabs">
		<ul>
			<?php foreach ($tabs as $value): ?>
				<li><a href="#<?php echo $value['link'];?>"><span><?php echo $value['name'];?></span></a></li>
			<?php endforeach; ?>
		</ul>
		
		<?php foreach ($tabs as $id): ?>
			<div id="<?php echo $id['link'];?>">
				<?php if (isset($sections)): ?>
					<?php foreach ($sections[$id['id']] as $a): ?>
						<h3><?php echo $a['name'];?></h3>
						
						<?php if (isset($fields[$a['id']])): ?>
							<table class="table100 zebra" cellspacing="0" cellpadding="3">
								
							<?php foreach ($fields[$a['id']] as $b): ?>
								<tr>
									<td class="cell-label align_top"><?php echo $b['label'];?></td>
									<td class="cell-spacer"></td>
									<td><?php echo text_output($b['value'], '');?></td>
								</tr>
							<?php endforeach; ?>
							
						</table><br />
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
<?php else: ?>
	<?php if (isset($sections)): ?>
		<?php foreach ($sections as $a): ?>
			<h3><?php echo $a['name'];?></h3>
			
			<?php if (isset($fields[$a['id']])): ?>
				<table class="table100" cellspacing="0" cellpadding="3">
					
				<?php foreach ($fields[$a['id']] as $b): ?>
					<tr>
						<td class="cell-label align_top"><?php echo $b['label'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo $b['value'];?></td>
					</tr>
				<?php endforeach; ?>
				
				</table>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>
<?php endif; ?>