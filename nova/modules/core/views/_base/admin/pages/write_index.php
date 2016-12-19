<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php if (Auth::check_access('write/missionpost', false)): ?>
	<p><?php echo anchor('write/missionpost', img($images['post']).' '.$label['write_post'], array('class' => 'image bold'));?></p>
<?php endif;?>

<?php if (Auth::check_access('write/personallog', false)): ?>
	<p><?php echo anchor('write/personallog', img($images['log']).' '.$label['write_log'], array('class' => 'image bold'));?></p>
<?php endif;?>

<?php if (Auth::check_access('write/newsitem', false)): ?>
	<p><?php echo anchor('write/newsitem', img($images['news']).' '.$label['write_news'], array('class' => 'image bold'));?></p>
<?php endif;?>

<div id="tabs">
	<ul>
		<?php if (isset($posts_saved) or isset($logs_saved) or isset($news_saved)): ?>
			<li><a href="#one"><span><?php echo $label['saved'];?></span></a></li>
		<?php endif;?>
		
		<li><a href="#two"><span><?php echo $label['recent'];?></span></a></li>
		<li><a href="#three"><span><?php echo $label['all'];?></span></a></li>
	</ul>
	
	<?php if (isset($posts_saved) or isset($logs_saved) or isset($news_saved)): ?>
		<div id="one">
			<?php if (isset($posts_saved)): ?>
				<?php echo text_output($label['missionposts'], 'h2');?>
				
				<p class="fontSmall bold gray"><?php echo img($images['lock']);?> &ndash; <span class="blue"><?php echo $label['locked'];?></span></p>
				
				<table class="table100 zebra">
					<tbody>
					<?php foreach ($posts_saved as $p): ?>
						<tr>
							<td>
								<?php if ($p['saved'] != $this->session->userdata('main_char')): ?>
									<?php echo img($images['new']);?>
								<?php endif;?>
								
								<?php if ($p['locked']): ?>
									<?php echo img(array('src' => $images['lock']['src'], 'class' => $images['lock']['class'], 'alt' => $images['lock']['alt'], 'rel' => 'tooltip', 'title' => $p['lock_owner']));?>
								<?php endif;?>
								
								<?php echo anchor('write/missionpost/'.$p['post_id'].'/view', $p['title'], array('class' => 'bold'));?>
								
								<span class="fontSmall gray">
									<a href="#" rel="popover" class="image" title="<?php echo $label['authors'];?>" data-content="<?php echo $p['authors'];?>"><?php echo img($images['authors']);?></a><br />
									
									<strong><?php echo $label['mission'];?></strong>
									<?php echo anchor('sim/missions/id/'. $p['mission_id'], $p['mission']);?><br />
									
									<?php echo $p['date'];?>
								</span>
							</td>
							<td class="col_100 align_right fontSmall">
								<?php if ($p['locked'] and Auth::get_access_level('manage/posts') == 2): ?>
									<a href="#" rel="facebox" myAction="unlock" myID="<?php echo $p['post_id'];?>" class="image"><?php echo img($images['unlock']);?></a>
									&nbsp;
								<?php endif;?>
								
								<a href="<?php echo site_url('write/missionpost/'.$p['post_id'].'/view');?>" class="image"><?php echo img($images['view']);?></a>
								&nbsp;
								<a href="<?php echo site_url('write/missionpost/'.$p['post_id']);?>" class="image"><?php echo img($images['edit']);?></a>
							</td>
					<?php endforeach;?>
					</tbody>
				</table><br />
			<?php endif;?>
			
			<?php if (isset($logs_saved)): ?>
				<?php echo text_output($label['personallogs'], 'h2');?>
				
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
					<?php endforeach;?>
					</tbody>
				</table><br />
			<?php endif;?>
			
			<?php if (isset($news_saved)): ?>
				<?php echo text_output($label['newsitems'], 'h2');?>
				
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
					<?php endforeach;?>
					</tbody>
				</table><br />
			<?php endif;?>
		</div>
	<?php endif;?>
	
	<div id="two">
		<div class="subtabs">
			<ul>
				<li><a href="#four"><span><?php echo $label['missionposts'];?></span></a></li>
				<li><a href="#five"><span><?php echo $label['personallogs'];?></span></a></li>
				<li><a href="#six"><span><?php echo $label['newsitems'];?></span></a></li>
			</ul>
			
			<div id="four">
				<?php if (isset($posts)): ?>
					<table class="table100 zebra">
						<thead>
							<tr>
								<th colspan="2"><?php echo $label['title'];?></th>
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
										<?php echo anchor('sim/missions/id/'. $p['mission_id'], $p['mission']);?>
									</span>
								</td>
								<td class="col_30 align_center">
									<?php if ($p['has_recent_comments']): ?>
										<a href="<?php echo site_url('sim/viewpost/'.$p['post_id'].'#comments');?>" rel="tooltip" class="image" title="<?php echo $label['recent_comments'];?>"><?php echo img($images['comments']);?></a>
									<?php endif;?>
								</td>
								<td class="col_30pct align_center fontSmall"><?php echo $p['date'];?></td>
						<?php endforeach;?>
						</tbody>
					</table>
					<p class="bold">
						<?php echo anchor('personnel/viewposts/u/'. $this->session->userdata('userid'), $label['view_user_posts']);?>
					</p><br />
				<?php else: ?>
					<?php echo text_output($label['no_posts'], 'h3', 'orange');?>
				<?php endif;?>
			</div>
			
			<div id="five">
				<?php if (isset($logs)): ?>
					<table class="table100 zebra">
						<thead>
							<tr>
								<th colspan="2"><?php echo $label['title'];?></th>
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
								<td class="col_30 align_center">
									<?php if ($l['has_recent_comments']): ?>
										<a href="<?php echo site_url('sim/viewlog/'.$l['log_id'].'#comments');?>" rel="tooltip" class="image" title="<?php echo $label['recent_comments'];?>"><?php echo img($images['comments']);?></a>
									<?php endif;?>
								</td>
								<td class="col_30pct align_center fontSmall"><?php echo $l['date'];?></td>
						<?php endforeach;?>
						</tbody>
					</table>
					<p class="bold">
						<?php echo anchor('personnel/viewlogs/u/'. $this->session->userdata('userid'), $label['view_user_logs']);?>
					</p><br />
				<?php else: ?>
					<?php echo text_output($label['no_logs'], 'h3', 'orange');?>
				<?php endif;?>
			</div>
			
			<div id="six">
				<?php if (isset($news)): ?>
					<table class="table100 zebra">
						<thead>
							<tr>
								<th colspan="2"><?php echo $label['title'];?></th>
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
								<td class="col_30 align_center">
									<?php if ($n['has_recent_comments']): ?>
										<a href="<?php echo site_url('main/viewnews/'.$n['news_id'].'#comments');?>" rel="tooltip" class="image" title="<?php echo $label['recent_comments'];?>"><?php echo img($images['comments']);?></a>
									<?php endif;?>
								</td>
								<td class="col_30pct align_center fontSmall"><?php echo $n['date'];?></td>
						<?php endforeach;?>
						</tbody>
					</table>
				<?php else: ?>
					<?php echo text_output($label['no_news'], 'h3', 'orange');?>
				<?php endif;?>
			</div>
		</div>
	</div>
	
	<div id="three">
		<div class="subtabs">
			<ul>
				<li><a href="#seven"><span><?php echo $label['missionposts'];?></span></a></li>
				<li><a href="#eight"><span><?php echo $label['personallogs'];?></span></a></li>
				<li><a href="#nine"><span><?php echo $label['newsitems'];?></span></a></li>
			</ul>
			
			<div id="seven">
				<?php if (isset($posts_all)): ?>
					<table class="table100 zebra">
						<thead>
							<tr>
								<th colspan="2"><?php echo $label['title'];?></th>
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
										<?php echo anchor('sim/missions/id/'. $p['mission_id'], $p['mission']);?>
									</span>
								</td>
								<td class="col_30 align_center">
									<?php if ($p['has_recent_comments']): ?>
										<a href="<?php echo site_url('sim/viewpost/'.$p['post_id'].'#comments');?>" rel="tooltip" class="image" title="<?php echo $label['recent_comments'];?>"><?php echo img($images['comments']);?></a>
									<?php endif;?>
								</td>
								<td class="col_30pct align_center fontSmall"><?php echo $p['date'];?></td>
						<?php endforeach;?>
						</tbody>
					</table>
					<p class="bold"><?php echo anchor('sim/listposts', $label['view_all_posts']);?></p><br />
				<?php else: ?>
					<?php echo text_output($label['no_posts'], 'h3', 'orange');?>
				<?php endif;?>
			</div>
			
			<div id="eight">
				<?php if (isset($logs_all)): ?>
					<table class="table100 zebra">
						<thead>
							<tr>
								<th colspan="2"><?php echo $label['title'];?></th>
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
								<td class="col_30 align_center">
									<?php if ($l['has_recent_comments']): ?>
										<a href="<?php echo site_url('sim/viewlog/'.$l['log_id'].'#comments');?>" rel="tooltip" class="image" title="<?php echo $label['recent_comments'];?>"><?php echo img($images['comments']);?></a>
									<?php endif;?>
								</td>
								<td class="col_30pct align_center fontSmall"><?php echo $l['date'];?></td>
						<?php endforeach;?>
						</tbody>
					</table>
					<p class="bold"><?php echo anchor('sim/listlogs', $label['view_all_logs']);?></p><br />
				<?php else: ?>
					<?php echo text_output($label['no_logs'], 'h3', 'orange');?>
				<?php endif;?>
			</div>
			
			<div id="nine">
				<?php if (isset($news_all)): ?>
					<table class="table100 zebra">
						<thead>
							<tr>
								<th colspan="2"><?php echo $label['title'];?></th>
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
								<td class="col_30 align_center">
									<?php if ($n['has_recent_comments']): ?>
										<a href="<?php echo site_url('main/viewnews/'.$n['news_id'].'#comments');?>" rel="tooltip" class="image" title="<?php echo $label['recent_comments'];?>"><?php echo img($images['comments']);?></a>
									<?php endif;?>
								</td>
								<td class="col_30pct align_center fontSmall"><?php echo $n['date'];?></td>
						<?php endforeach;?>
						</tbody>
					</table>
					<p class="bold"><?php echo anchor('main/news', $label['view_all_news']);?></p>
				<?php else: ?>
					<?php echo text_output($label['no_news'], 'h3', 'orange');?>
				<?php endif;?>
			</div>
		</div>
	</div>
</div>