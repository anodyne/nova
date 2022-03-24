<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<style type="text/css">
	a.image { display: inline-block; }
	a.image span { padding: 0px; display: inline-block; }
	a.image span img { margin: 0px; padding: 0px; }
</style>

<?php echo text_output($header, 'h1', 'page-head');?>

<p><?php echo anchor('sim/missions', $label['missions'], array('class' => 'bold'));?></p>

<?php if (isset($mission_img['src'])): ?>
	<div id="gallery">
		<?php echo text_output($label['open_gallery'], 'p', 'fontSmall gray bold');?>
		<a href="<?php echo base_url() . $mission_img['src'];?>" class="image" rel="prettyPhoto[gallery]"><?php echo img($mission_img);?></a>
		
		<div class="hidden">
			<?php if (count($image_array) > 0): ?>
				<?php foreach ($image_array as $image): ?>
					<a href="<?php echo base_url() . $image['src'];?>" class="image" rel="prettyPhoto[gallery]"><?php echo img($image);?></a>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>

<div id="tabs">
	<ul>
		<li><a href="#one"><span><?php echo $label['basicinfo'];?></span></a></li>
		<li><a href="#two"><span><?php echo $label['posts'];?></span></a></li>
		<li><a href="#three"><span><?php echo $label['summary'];?></span></a></li>
	</ul>
	
	<div id="one">
		<?php if (isset($basic)): ?>
			<?php echo text_output($info_header, 'h2', 'page-subhead');?>
			<table class="table100">
				<tr>
					<td class="cell-label"><?php echo $label['status'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo $basic['status'] .' '. $label['mission'];?></td>
				</tr>
				<?php echo table_row_spacer(3, 10);?>
				<tr>
					<td class="cell-label"><?php echo $label['desc'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo text_output($basic['desc']);?></td>
				</tr>
				<?php if (is_array($basic['group'])): ?>
					<?php echo table_row_spacer(3, 10);?>
					<tr>
						<td class="cell-label"><?php echo $label['group'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo anchor('sim/missions/group/'. $basic['group']['misgroup_id'], $basic['group']['misgroup_name']);?></td>
					</tr>
				<?php endif;?>
				
				<?php echo table_row_spacer(3, 10);?>
				<tr>
					<td class="cell-label"><?php echo $label['date_start'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo $basic['start'];?></td>
				</tr>
				
				<?php if (isset($basic['end'])): ?>
					<tr>
						<td class="cell-label"><?php echo $label['date_end'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo $basic['end'];?></td>
					</tr>
				<?php endif; ?>
			</table><br />
		<?php endif; ?>
	</div>
	
	<div id="two">
		<?php if (isset($posts)): ?>
			<?php echo text_output($posts_header, 'h2', 'page-subhead');?>
			<p><?php echo anchor('sim/listposts/mission/'. $mission, $label['view_all_posts'], array('class' => 'bold'));?></p>
			
			<table class="table100 zebra" cellspacing="0" cellpadding="3">
				<thead>
					<tr>
						<th><?php echo $label['title'];?></th>
						<th><?php echo $label['timeline'];?></th>
						<th><?php echo $label['location'];?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($posts as $post): ?>
					<tr>
						<td class="col_50pct">
							<strong>
								<?php echo anchor('sim/viewpost/'. $post['id'], $post['title'], array('class' => 'bold'));?>
							</strong><br />
							<span class="fontSmall gray">
								<?php echo $label['by'] .' '. $post['authors'];?>
							</span>
						</td>
						<td class="col_25pct"><?php echo $post['timeline'];?></td>
						<td class="col_25pct"><?php echo $post['location'];?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		<?php else: ?>
			<?php echo text_output($label['noposts'], 'h3', 'orange');?>
		<?php endif; ?>
	</div>
	
	<div id="three">
		<?php if (isset($summary)): ?>
			<?php echo text_output($summary['title'], 'h2', 'page-subhead');?>
			<?php echo text_output($summary['content']);?>
		<?php else: ?>
			<?php echo text_output($label['nosummary'], 'h3', 'orange');?>
		<?php endif; ?>
	</div>
</div>
