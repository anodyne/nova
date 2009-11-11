<?php echo text_output($header, 'h1', 'page-head');?>

<?php if ($this->auth->check_access('write/missionpost', FALSE) === TRUE): ?>
	<p><?php echo anchor('write/missionpost', img($images['post']) .' '. $label['write_post'], array('class' => 'image bold'));?></p>
<?php endif; ?>

<?php if ($this->auth->check_access('write/personallog', FALSE) === TRUE): ?>
	<p><?php echo anchor('write/personallog', img($images['log']) .' '. $label['write_log'], array('class' => 'image bold'));?></p>
<?php endif; ?>

<?php if ($this->auth->check_access('write/newsitem', FALSE) === TRUE): ?>
	<p><?php echo anchor('write/newsitem', img($images['news']) .' '. $label['write_news'], array('class' => 'image bold'));?></p>
<?php endif; ?>

<div id="tabs">
	<ul>
		<li><a href="#one"><span><?php echo $label['saved'];?></span></a></li>
		<li><a href="#two"><span><?php echo $label['recent'];?></span></a></li>
		<li><a href="#three"><span><?php echo $label['all'];?></span></a></li>
	</ul>
	
	<div id="one">
		<?php echo text_output($label['missionposts'], 'h2');?>
		<?php if (isset($posts_saved)): ?>
			<table class="table100 zebra">
				<thead>
					<tr>
						<th><?php echo $label['title'];?></th>
						<th><?php echo $label['date'];?></th>
					</tr>
				</thead>
				
				<tbody>
				<?php foreach ($posts_saved as $p): ?>
					<tr>
						<td>
							<?php if ($p['saved'] != $this->session->userdata('main_char')): ?>
								<?php echo img($images['new']);?>
							<?php endif; ?>
							<?php echo anchor('write/missionpost/'. $p['post_id'], $p['title'], array('class' => 'bold'));?><br />
							<span class="fontSmall gray">
								<?php echo $label['by'] .' '. $p['authors'];?><br />
								<strong><?php echo $label['mission'];?></strong>
								<?php echo anchor('sim/missions/'. $p['mission_id'], $p['mission']);?>
							</span>
						</td>
						<td class="col_30pct align_center fontSmall"><?php echo $p['date'];?></td>
				<?php endforeach; ?>
				</tbody>
			</table><br />
		<?php else: ?>
			<?php echo text_output($label['no_posts'], 'h3', 'orange');?>
		<?php endif; ?>
		
		<?php echo text_output($label['personallogs'], 'h2');?>
		<?php if (isset($logs_saved)): ?>
			<table class="table100 zebra">
				<thead>
					<tr>
						<th><?php echo $label['title'];?></th>
						<th><?php echo $label['date'];?></th>
					</tr>
				</thead>
				
				<tbody>
				<?php foreach ($logs_saved as $l): ?>
					<tr>
						<td>
							<?php echo anchor('write/personallog/'. $l['log_id'], $l['title'], array('class' => 'bold'));?><br />
							<span class="fontSmall gray">
								<?php echo $label['by'] .' '. $l['author'];?>
							</span>
						</td>
						<td class="col_30pct align_center fontSmall"><?php echo $l['date'];?></td>
				<?php endforeach; ?>
				</tbody>
			</table><br />
		<?php else: ?>
			<?php echo text_output($label['no_logs'], 'h3', 'orange');?>
		<?php endif; ?>
		
		<?php echo text_output($label['newsitems'], 'h2');?>
		<?php if (isset($news_saved)): ?>
			<table class="table100 zebra">
				<thead>
					<tr>
						<th><?php echo $label['title'];?></th>
						<th><?php echo $label['date'];?></th>
					</tr>
				</thead>
				
				<tbody>
				<?php foreach ($news_saved as $n): ?>
					<tr>
						<td>
							<?php echo anchor('write/newsitem/'. $n['news_id'], $n['title'], array('class' => 'bold'));?><br />
							<span class="fontSmall gray">
								<strong><?php echo $label['category'] .'</strong> '. $n['category'];?>
							</span>
						</td>
						<td class="col_30pct align_center fontSmall"><?php echo $n['date'];?></td>
				<?php endforeach; ?>
				</tbody>
			</table><br />
		<?php else: ?>
			<?php echo text_output($label['no_news'], 'h3', 'orange');?>
		<?php endif; ?>
	</div>
	
	<div id="two">
		<?php echo text_output($label['missionposts'], 'h2');?>
		<?php if (isset($posts)): ?>
			<table class="table100 zebra">
				<thead>
					<tr>
						<th><?php echo $label['title'];?></th>
						<th><?php echo $label['date'];?></th>
					</tr>
				</thead>
				
				<tbody>
				<?php foreach ($posts as $p): ?>
					<tr>
						<td>
							<?php echo anchor('sim/viewpost/'. $p['post_id'], $p['title'], array('class' => 'bold'));?><br />
							<span class="fontSmall gray">
								<?php echo $label['by'] .' '. $p['authors'];?><br />
								<strong><?php echo $label['mission'];?></strong>
								<?php echo anchor('sim/missions/'. $p['mission_id'], $p['mission']);?>
							</span>
						</td>
						<td class="col_30pct align_center fontSmall"><?php echo $p['date'];?></td>
				<?php endforeach; ?>
				</tbody>
			</table>
			<p class="bold">
				<?php echo anchor('personnel/viewposts/p/'. $this->session->userdata('userid'), $label['view_user_posts']);?>
			</p><br />
		<?php else: ?>
			<?php echo text_output($label['no_posts'], 'h3', 'orange');?>
		<?php endif; ?>
		
		<?php echo text_output($label['personallogs'], 'h2');?>
		<?php if (isset($logs)): ?>
			<table class="table100 zebra">
				<thead>
					<tr>
						<th><?php echo $label['title'];?></th>
						<th><?php echo $label['date'];?></th>
					</tr>
				</thead>
				
				<tbody>
				<?php foreach ($logs as $l): ?>
					<tr>
						<td>
							<?php echo anchor('sim/viewlog/'. $l['log_id'], $l['title'], array('class' => 'bold'));?><br />
							<span class="fontSmall gray">
								<?php echo $label['by'] .' '. $l['author'];?>
							</span>
						</td>
						<td class="col_30pct align_center fontSmall"><?php echo $l['date'];?></td>
				<?php endforeach; ?>
				</tbody>
			</table>
			<p class="bold">
				<?php echo anchor('personnel/viewlogs/p/'. $this->session->userdata('userid'), $label['view_user_logs']);?>
			</p><br />
		<?php else: ?>
			<?php echo text_output($label['no_logs'], 'h3', 'orange');?>
		<?php endif; ?>
		
		<?php echo text_output($label['newsitems'], 'h2');?>
		<?php if (isset($news)): ?>
			<table class="table100 zebra">
				<thead>
					<tr>
						<th><?php echo $label['title'];?></th>
						<th><?php echo $label['date'];?></th>
					</tr>
				</thead>
				
				<tbody>
				<?php foreach ($news as $n): ?>
					<tr>
						<td>
							<?php echo anchor('main/viewnews/'. $n['news_id'], $n['title'], array('class' => 'bold'));?><br />
							<span class="fontSmall gray">
								<strong><?php echo $label['category'] .'</strong> '. $n['category'];?>
							</span>
						</td>
						<td class="col_30pct align_center fontSmall"><?php echo $n['date'];?></td>
				<?php endforeach; ?>
				</tbody>
			</table>
		<?php else: ?>
			<?php echo text_output($label['no_news'], 'h3', 'orange');?>
		<?php endif; ?>
	</div>
	
	<div id="three">
		<?php echo text_output($label['missionposts'], 'h2');?>
		<?php if (isset($posts_all)): ?>
			<table class="table100 zebra">
				<thead>
					<tr>
						<th><?php echo $label['title'];?></th>
						<th><?php echo $label['date'];?></th>
					</tr>
				</thead>
				
				<tbody>
				<?php foreach ($posts_all as $p): ?>
					<tr>
						<td>
							<?php echo anchor('sim/viewpost/'. $p['post_id'], $p['title'], array('class' => 'bold'));?><br />
							<span class="fontSmall gray">
								<?php echo $label['by'] .' '. $p['authors'];?><br />
								<strong><?php echo $label['mission'];?></strong>
								<?php echo anchor('sim/missions/'. $p['mission_id'], $p['mission']);?>
							</span>
						</td>
						<td class="col_30pct align_center fontSmall"><?php echo $p['date'];?></td>
				<?php endforeach; ?>
				</tbody>
			</table>
			<p class="bold"><?php echo anchor('sim/listposts', $label['view_all_posts']);?></p><br />
		<?php else: ?>
			<?php echo text_output($label['no_posts'], 'h3', 'orange');?>
		<?php endif; ?>
		
		<?php echo text_output($label['personallogs'], 'h2');?>
		<?php if (isset($logs_all)): ?>
			<table class="table100 zebra">
				<thead>
					<tr>
						<th><?php echo $label['title'];?></th>
						<th><?php echo $label['date'];?></th>
					</tr>
				</thead>
				
				<tbody>
				<?php foreach ($logs_all as $l): ?>
					<tr>
						<td>
							<?php echo anchor('sim/viewlog/'. $l['log_id'], $l['title'], array('class' => 'bold'));?><br />
							<span class="fontSmall gray">
								<?php echo $label['by'] .' '. $l['author'];?>
							</span>
						</td>
						<td class="col_30pct align_center fontSmall"><?php echo $l['date'];?></td>
				<?php endforeach; ?>
				</tbody>
			</table>
			<p class="bold"><?php echo anchor('sim/listlogs', $label['view_all_logs']);?></p><br />
		<?php else: ?>
			<?php echo text_output($label['no_logs'], 'h3', 'orange');?>
		<?php endif; ?>
		
		<?php echo text_output($label['newsitems'], 'h2');?>
		<?php if (isset($news_all)): ?>
			<table class="table100 zebra">
				<thead>
					<tr>
						<th><?php echo $label['title'];?></th>
						<th><?php echo $label['date'];?></th>
					</tr>
				</thead>
				
				<tbody>
				<?php foreach ($news_all as $n): ?>
					<tr>
						<td>
							<?php echo anchor('main/viewnews/'. $n['news_id'], $n['title'], array('class' => 'bold'));?><br />
							<span class="fontSmall gray">
								<?php echo $label['by'] .' '. $n['author'];?><br />
								<strong><?php echo $label['category'] .'</strong> '. $n['category'];?>
							</span>
						</td>
						<td class="col_30pct align_center fontSmall"><?php echo $n['date'];?></td>
				<?php endforeach; ?>
				</tbody>
			</table>
			<p class="bold"><?php echo anchor('main/news', $label['view_all_news']);?></p>
		<?php else: ?>
			<?php echo text_output($label['no_news'], 'h3', 'orange');?>
		<?php endif; ?>
	</div>
</div>