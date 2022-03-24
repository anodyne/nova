<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<style type="text/css">
	a.image { display: inline-block; }
	a.image span { padding: 0px; display: inline-block; }
	a.image span img { margin: 0px; padding: 0px; }
	
	.row ul li { line-height: 1.6; }
	
	.pp_pic_holder a {
		text-decoration: none;
		border-bottom: none;
	}
</style>

<link rel="stylesheet" href="<?php echo base_url().MODFOLDER;?>/assets/js/css/bootstrap.css">

<div class="row">
	<?php if (isset($character)): ?>
		<div class="span4">
			<?php if (isset($character['image']['src'])): ?>
				<ul class="gallery">
					<li><a href="<?php echo $character['image']['src'];?>" class="image" rel="prettyPhoto[gallery]"><?php echo img($character['image']);?></a></li>
					
					<?php if (count($character['image_array']) > 0): ?>
						<?php foreach ($character['image_array'] as $image): ?>
							<li class="hidden"><a href="<?php echo $image['src'];?>" class="image" rel="prettyPhoto[gallery]"><?php echo img($image);?></a></li>
						<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			<?php else: ?>
				<div id="gallery">
					<p><?php echo img($character['noavatar']);?></p>
				</div>
			<?php endif;?>
			
			<ul>
				<?php if ($postcount > 0): ?>
					<li><?php echo anchor('personnel/viewposts/c/'.$character['id'], $label['view_all_posts']);?></li>
				<?php endif;?>
				
				<?php if ($logcount > 0): ?>
					<li><?php echo anchor('personnel/viewlogs/c/'.$character['id'], $label['view_all_logs']);?></li>
				<?php endif;?>
				
				<?php if ($awardcount > 0): ?>
					<li><?php echo anchor('personnel/viewawards/c/'.$character['id'], $label['view_all_awards']);?></li>
				<?php endif;?>
				
				<?php if (Auth::is_logged_in() and $character['user'] !== null): ?>
					<li><?php echo anchor('personnel/user/'.$character['user'], $label['view_user']);?></li>
				<?php endif;?>
				
				<?php if ($edit_valid): ?>
					<li><?php echo anchor('characters/bio/'.$character['id'], $label['edit']);?></li>
				<?php endif;?>
			</ul><br>
			
			<?php if ($postcount > 0 or $logcount > 0 or $newscount > 0): ?>
				<h4 class="page-subhead"><?php echo $label['stats'];?></h4>
				
				<ul>
					<?php if ($postcount > 0): ?>
						<li><strong><?php echo $postcount;?></strong> <?php echo $label['mission_posts'];?></li>
					<?php endif;?>
					
					<?php if ($logcount > 0): ?>
						<li><strong><?php echo $logcount;?></strong> <?php echo $label['personal_logs'];?></li>
					<?php endif;?>
					
					<?php if ($newscount > 0): ?>
						<li><strong><?php echo $newscount;?></strong> <?php echo $label['news_items'];?></li>
					<?php endif;?>
				</ul><br>
			<?php endif;?>
			
			<?php if ($last_post !== false): ?>
				<h4 class="page-subhead"><?php echo $label['last_post'];?></h4>
			
				<p class="fontSmall"><?php echo $last_post;?></p>
			<?php endif;?>
		</div>
		
		<div class="span12">
			<?php echo text_output($header, 'h1', 'page-head');?>
			
			<?php if (isset($msg_error)): ?>
				<?php echo text_output($msg_error, 'h3', 'red');?>
			<?php endif; ?>
			
			<?php if (isset($character_info)): ?>
				<?php foreach ($character_info as $a): ?>
					<?php if ( ! empty($a['value'])): ?>
						<p>
							<kbd><?php echo $a['label'];?></kbd>
							<?php echo $a['value'];?>
						</p>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif;?><br>
			
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
											<?php if ( ! empty($b['value'])): ?>
												<tr>
													<td class="cell-label align_top"><?php echo $b['label'];?></td>
													<td class="cell-spacer"></td>
													<td><?php echo text_output($b['value'], '');?></td>
												</tr>
											<?php endif;?>
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
								<?php if ( ! empty($b['value'])): ?>
									<tr>
										<td class="cell-label align_top"><?php echo $b['label'];?></td>
										<td class="cell-spacer"></td>
										<td><?php echo $b['value'];?></td>
									</tr>
								<?php endif;?>
							<?php endforeach; ?>
							
							</table>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	<?php else: ?>
		<div class="span16">
			<?php echo text_output($header, 'h1', 'red');?>
			<?php echo text_output($msg_error);?>
		</div>
	<?php endif;?>
</div>