<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>

<p class="bold">
	<?php echo anchor('site/menucats', img($images['cats']) .' '. $label['cats'], array('class' => 'image'));?><br /><br />
	<a href="#" rel="facebox" class="image" myAction="add">
		<?php echo img($images['add']) .' '. $label['add'];?>
	</a>
</p>

<div id="tabs">
	<ul>
		<li><a href="#one"><span><?php echo $label['nav_main'];?></span></a></li>
		<li><a href="#two"><span><?php echo $label['nav_sub'];?></span></a></li>
		<li><a href="#three"><span><?php echo $label['nav_adminsub'];?></span></a></li>
	</ul>
	
	<div id="one">
		<?php if (isset($menus['main'])): ?>
			<br />
			<table class="table100 zebra">
				<tbody>
					
				<?php foreach ($menus['main'] as $main): ?>
					<tr>
						<td>
							<?php if ($main['display'] == 'n'): ?>
								<span class="bold red fontSmall uppercase">
									[<?php echo $label['off'];?>]
								</span>
							<?php endif;?>
							<strong><?php echo $main['name'];?></strong><br />
							<span class="fontSmall gray">
								<?php echo $label['url'] .' '. $main['link'];?>
							</span>
						</td>
						<td class="col_75 align_right">
							<a href="#" rel="facebox" myAction="delete" myID="<?php echo $main['id'];?>" class="image"><?php echo img($images['delete']);?></a>
							&nbsp;
							<a href="#" rel="facebox" myAction="edit" myID="<?php echo $main['id'];?>" class="image"><?php echo img($images['edit']);?></a>
						</td>
					</tr>
				<?php endforeach; ?>
				
				</tbody>
			</table>
		<?php endif; ?>
	</div>
	
	<div id="two">
		<?php if (isset($menus['sub'])): ?>
			<?php foreach ($menus['sub'] as $sub): ?>
				<?php echo text_output($sub['category'], 'h3', 'page-subhead');?>
				<table class="table100 zebra">
					<tbody>
						
					<?php foreach ($sub['items'] as $s): ?>
						<tr>
							<td>
								<?php if ($s['display'] == 'n'): ?>
									<span class="bold red fontSmall uppercase">
										[<?php echo $label['off'];?>]
									</span>
								<?php endif;?>
								<strong><?php echo $s['name'];?></strong><br />
								<span class="fontSmall gray">
									<?php echo $label['url'] .' '. $s['link'];?>
								</span>
							</td>
							<td class="col_75 align_right">
								<a href="#" rel="facebox" myAction="delete" myID="<?php echo $s['id'];?>" class="image"><?php echo img($images['delete']);?></a>
								&nbsp;
								<a href="#" rel="facebox" myAction="edit" myID="<?php echo $s['id'];?>" class="image"><?php echo img($images['edit']);?></a>
							</td>
						</tr>
					<?php endforeach;?>
					
					</tbody>
				</table>
			<?php endforeach;?>
		<?php endif;?>
	</div>
	
	<div id="three">
		<?php if (isset($menus['adminsub'])): ?>
			<?php foreach ($menus['adminsub'] as $admin): ?>
				<?php echo text_output($admin['category'], 'h3', 'page-subhead');?>
				<table class="table100 zebra">
					<tbody>
						
					<?php foreach ($admin['items'] as $a): ?>
						<tr>
							<td>
								<?php if ($a['display'] == 'n'): ?>
									<span class="bold red fontSmall uppercase">
										[<?php echo $label['off'];?>]
									</span>
								<?php endif;?>
								<strong><?php echo $a['name'];?></strong><br />
								<span class="fontSmall gray">
									<?php echo $label['url'] .' '. $a['link'];?>
								</span>
							</td>
							<td class="col_75 align_right">
								<a href="#" rel="facebox" myAction="delete" myID="<?php echo $a['id'];?>" class="image"><?php echo img($images['delete']);?></a>
								&nbsp;
								<a href="#" rel="facebox" myAction="edit" myID="<?php echo $a['id'];?>" class="image"><?php echo img($images['edit']);?></a>
							</td>
						</tr>
					<?php endforeach;?>
					
					</tbody>
				</table>
			<?php endforeach;?>
		<?php endif;?>
	</div>
</div>