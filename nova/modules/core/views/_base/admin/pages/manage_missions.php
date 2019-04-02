<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>

<p class="bold">
	<?php echo anchor('manage/missions/add', img($images['add']) .' '. $label['add'], array('class' => 'image'));?>
</p>

<div id="tabs">
	<ul>
		<li><a href="#one"><span><?php echo $label['s_current'];?></span></a></li>
		<li><a href="#two"><span><?php echo $label['s_upcoming'];?></span></a></li>
		<li><a href="#three"><span><?php echo $label['s_completed'];?></span></a></li>
	</ul>
	
	<div id="one">
		<?php if (isset($missions['current'])): ?>
			<?php echo text_output($label['current'], 'h2', 'page-subhead');?>
			
			<table class="table100 zebra">
				<tbody>
				<?php foreach ($missions['current'] as $i): ?>
					<tr>
						<td>
							<strong class="fontMedium"><?php echo $i['title'];?></strong><br />
							<span class="fontSmall gray">
								<?php echo text_output($label['posts'], 'strong') . $i['posts'];?><br />
								<?php echo text_output($i['desc']);?>
							</span>
						</td>
						<td class="col_100 align_right">
							<?php echo anchor('sim/missions/id/'. $i['id'], img($images['view']), array('class' => 'image'));?>
							&nbsp;
							<a href="#" myAction="delete" myID="<?php echo $i['id'];?>" rel="facebox" class="image"><?php echo img($images['delete']);?></a>
							&nbsp;
							<?php echo anchor('manage/missions/edit/'. $i['id'], img($images['edit']), array('class' => 'image'));?>
						</td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		<?php else: ?>
			<?php echo text_output($label['error'], 'h3', 'orange');?>
		<?php endif;?>
	</div>
	
	<div id="two">
		<?php if (isset($missions['upcoming'])): ?>
			<?php echo text_output($label['upcoming'], 'h2', 'page-subhead');?>
			
			<table class="table100 zebra">
				<tbody>
				<?php foreach ($missions['upcoming'] as $i): ?>
					<tr>
						<td>
							<strong class="fontMedium"><?php echo $i['title'];?></strong><br />
							<?php echo text_output($i['desc'], 'span', 'fontSmall gray');?>
						</td>
						<td class="col_100 align_right">
							<a href="#" myAction="delete" myID="<?php echo $i['id'];?>" rel="facebox" class="image"><?php echo img($images['delete']);?></a>
							&nbsp;
							<?php echo anchor('manage/missions/edit/'. $i['id'], img($images['edit']), array('class' => 'image'));?>
						</td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		<?php else: ?>
			<?php echo text_output($label['error'], 'h3', 'orange');?>
		<?php endif;?>
	</div>
	
	<div id="three">
		<?php if (isset($missions['completed'])): ?>
			<?php echo text_output($label['completed'], 'h2', 'page-subhead');?>
			
			<table class="table100 zebra">
				<tbody>
				<?php foreach ($missions['completed'] as $i): ?>
					<tr>
						<td>
							<strong class="fontMedium"><?php echo $i['title'];?></strong><br />
							<?php echo text_output($i['desc'], 'span', 'fontSmall gray');?>
						</td>
						<td class="col_100 align_right">
							<?php echo anchor('sim/missions/id/'. $i['id'], img($images['view']), array('class' => 'image'));?>
							&nbsp;
							<a href="#" myAction="delete" myID="<?php echo $i['id'];?>" rel="facebox" class="image"><?php echo img($images['delete']);?></a>
							&nbsp;
							<?php echo anchor('manage/missions/edit/'. $i['id'], img($images['edit']), array('class' => 'image'));?>
						</td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		<?php else: ?>
			<?php echo text_output($label['error'], 'h3', 'orange');?>
		<?php endif;?>
	</div>
</div>
