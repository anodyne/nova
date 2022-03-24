<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<div id="loading" class="loader">
	<?php echo img($loader);?>
	<?php echo text_output($label['loading'], 'h3', 'gray');?>
</div>

<div id="loaded" class="hidden">
	<div id="acp-panel">
		<div class="panelnav">
			<ul id="panelmenu" class="UITheme ui-widget">
				<?php if ($update !== FALSE): ?>
					<li><a href="#" id="update"><span>
						<?php if ($update['severity'] == 'red'): ?>
							<div class="count ui-state-error"><div class="ui-icon ui-icon-notice"></div></div>
						<?php endif;?><?php echo $label['update'];?></span></a></li>
				<?php endif;?>
				<li><a href="#" id="stats"><span><?php echo $label['mynova'];?></span></a></li>
				<li><a href="#" id="notifications"><span>
				<?php if ($notifycount > 0): ?>
					<div class="count ui-state-highlight"><?php echo $notifycount;?></div>
				<?php endif;?><?php echo $label['mynotify'];?></span></a></li>
				
				<?php if (Auth::is_gamemaster($this->session->userdata('userid')) and $activitycount > 0): ?>
					<li><a href="#" id="activity"><span>
						<div class="count ui-state-highlight"><?php echo $activitycount;?></div>
						<?php echo $label['activity'];?></span></a></li>
				<?php endif;?>
				
				<li><a href="#" id="milestones"><span>
					<?php if ($milestonecount > 0): ?>
						<div class="count ui-state-highlight"><?php echo $milestonecount;?></div>
					<?php endif;?><?php echo $label['milestones'];?></span></a></li>
			</ul>
		</div>
		<div class="panel">
			<?php if ($update !== FALSE): ?>
				<div class="update hidden">
					<span class="bold fontMedium <?php echo $update['severity'];?>"><?php echo $update['version'];?></span>
					
					<?php echo text_output($update['desc'], 'p', 'fontSmall gray');?>
					
					<?php if ($update['status'] == 1): ?>
						<p class="fontSmall">
							<a href="<?php echo $update['link'];?>" target="_blank"><?php echo $label['getupdate'];?></a>
						</p>
						
						<p class="fontSmall">
							<a href="<?php echo $update['link'];?>" class="ignore" target="_blank" myVersion="<?php echo $update['version_only'];?>"><?php echo $label['ignore'];?></a>
						</p>
					<?php elseif ($update['status'] == 2): ?>
						<p class="fontSmall">
							<a href="<?php echo $update['link'];?>" target="_blank"><?php echo $label['runupdate'];?></a>
						</p>
					<?php endif;?>
				</div>
			<?php endif;?>
			
			<div class="stats hidden">
				<table class="table100 zebra">
					<tbody>
						<tr>
							<td class="col1"><?php echo $posts['entries'];?></td>
							<td class="cell-spacer"></td>
							<td class="col2"><?php echo $label['posts'];?></td>
						</tr>
						<tr>
							<td class="col1"><?php echo $posts['comments'];?></td>
							<td class="cell-spacer"></td>
							<td class="col2"><?php echo $label['post_comments'];?></td>
						</tr>
						<tr>
							<td class="col1"><?php echo $logs['entries'];?></td>
							<td class="cell-spacer"></td>
							<td class="col2"><?php echo $label['logs'];?></td>
						</tr>
						<tr>
							<td class="col1"><?php echo $logs['comments'];?></td>
							<td class="cell-spacer"></td>
							<td class="col2"><?php echo $label['log_comments'];?></td>
						</tr>
						<tr>
							<td class="col1"><?php echo $news['entries'];?></td>
							<td class="cell-spacer"></td>
							<td class="col2"><?php echo $label['news'];?></td>
						</tr>
						<tr>
							<td class="col1"><?php echo $news['comments'];?></td>
							<td class="cell-spacer"></td>
							<td class="col2"><?php echo $label['news_comments'];?></td>
						</tr>
					</tbody>
				</table>
			</div>
			
			<div class="notifications hidden">
				<?php if ($notifycount > 0): ?>
					<table class="table100 zebra">
						<tbody>
							<?php if ($notification['saved_posts'] > 0): ?>
								<tr>
									<td class="col1"><?php echo $notification['saved_posts'];?></td>
									<td class="cell-spacer"></td>
									<td class="col2"><?php echo anchor('write/index', $label['s_posts']);?></td>
								</tr>
							<?php endif; ?>
								
							<?php if ($notification['saved_logs'] > 0): ?>
								<tr>
									<td class="col1"><?php echo $notification['saved_logs'];?></td>
									<td class="cell-spacer"></td>
									<td class="col2"><?php echo anchor('write/index', $label['s_logs']);?></td>
								</tr>
							<?php endif; ?>
							
							<?php if ($notification['saved_news'] > 0): ?>
								<tr>
									<td class="col1"><?php echo $notification['saved_news'];?></td>
									<td class="cell-spacer"></td>
									<td class="col2"><?php echo anchor('write/index', $label['s_news']);?></td>
								</tr>
							<?php endif; ?>
							
							<?php if ($notification['unread_pms'] > 0): ?>
								<tr>
									<td class="col1"><?php echo $notification['unread_pms'];?></td>
									<td class="cell-spacer"></td>
									<td class="col2"><?php echo anchor('messages/index', $label['pm']);?></td>
								</tr>
							<?php endif; ?>
							
							<?php if ($notification['pending_users'] > 0): ?>
								<tr>
									<td class="col1"><?php echo $notification['pending_users'];?></td>
									<td class="cell-spacer"></td>
									<td class="col2"><?php echo anchor('characters/index/pending', $label['p_users']);?></td>
								</tr>
							<?php endif; ?>
							
							<?php if ($notification['pending_posts'] > 0): ?>
								<tr>
									<td class="col1"><?php echo $notification['pending_posts'];?></td>
									<td class="cell-spacer"></td>
									<td class="col2"><?php echo anchor('manage/posts/pending', $label['p_posts']);?></td>
								</tr>
							<?php endif; ?>
							
							<?php if ($notification['pending_logs'] > 0): ?>
								<tr>
									<td class="col1"><?php echo $notification['pending_logs'];?></td>
									<td class="cell-spacer"></td>
									<td class="col2"><?php echo anchor('manage/logs/pending', $label['p_logs']);?></td>
								</tr>
							<?php endif; ?>
							
							<?php if ($notification['pending_news'] > 0): ?>
								<tr>
									<td class="col1"><?php echo $notification['pending_news'];?></td>
									<td class="cell-spacer"></td>
									<td class="col2"><?php echo anchor('manage/news/pending', $label['p_news']);?></td>
								</tr>
							<?php endif; ?>
							
							<?php if ($notification['pending_comments'] > 0): ?>
								<tr>
									<td class="col1"><?php echo $notification['pending_comments'];?></td>
									<td class="cell-spacer"></td>
									<td class="col2"><?php echo anchor('manage/comments', $label['p_comments']);?></td>
								</tr>
							<?php endif; ?>
							
							<?php if ($notification['pending_awards'] > 0): ?>
								<tr>
									<td class="col1"><?php echo $notification['pending_awards'];?></td>
									<td class="cell-spacer"></td>
									<td class="col2"><?php echo anchor('user/nominate/queue', $label['p_awards']);?></td>
								</tr>
							<?php endif; ?>
							
							<?php if ($notification['pending_docked'] > 0): ?>
								<tr>
									<td class="col1"><?php echo $notification['pending_docked'];?></td>
									<td class="cell-spacer"></td>
									<td class="col2"><?php echo anchor('manage/docked/pending', $label['p_docked']);?></td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>
				<?php else: ?>
					<?php echo text_output($label['nonotifications'], 'h4', 'orange');?>
				<?php endif;?>
			</div>
			
			<div class="activity hidden">
				<?php if ($activitycount > 0): ?>
					<table class="table100 zebra">
						<tbody>
						<?php foreach ($activity as $a): ?>
							<tr height="30">
								<td width="2"></td>
								<td>
									<strong class="fontMedium"><?php echo $a['name'];?></strong><br />
									<span class="gray fontSmall">
										&nbsp;&nbsp;<strong><?php echo $label['last_post'];?></strong>
										<?php if (is_numeric($a['post'])): ?>
											<?php echo timespan($a['post'], now()) .' '. $label['ago'];?>
										<?php else: ?>
											<?php echo text_output($a['post'], 'span', 'orange bold');?>
										<?php endif;?><br />
										
										&nbsp;&nbsp;<strong><?php echo $label['last_login'];?></strong>
										<?php if (is_numeric($a['login'])): ?>
											<?php echo timespan($a['login'], now()) .' '. $label['ago'];?>
										<?php else: ?>
											<?php echo text_output($a['login'], 'span', 'orange bold');?>
										<?php endif;?>
									</span>
								</td>
							</tr>
						<?php endforeach;?>
						</tbody>
					</table>
				<?php else: ?>
					<?php echo text_output($label['noactivity'], 'h4', 'orange');?>
				<?php endif;?>
			</div>
			
			<div class="milestones hidden">
				<?php if ($milestonecount > 0): ?>
					<table class="table100 zebra">
						<tbody>
						<?php foreach ($milestones as $m): ?>
							<tr height="30">
								<td width="2"></td>
								<td>
									<strong class="fontMedium"><?php echo $m['name'];?></strong><br />
									<span class="gray fontSmall">
										&nbsp;&nbsp;<strong><?php echo $label['joined'];?></strong>
										<?php echo $m['timespan'] .' '. $label['ago'];?>
									</span>
								</td>
							</tr>
						<?php endforeach;?>
						</tbody>
					</table>
				<?php else: ?>
					<?php echo text_output($label['nomilestones'], 'h4', 'orange');?>
				<?php endif;?>
			</div>
		</div>
	</div>
	<div id="online" class="fontSmall">
		<?php echo text_output($label['online'], 'span', 'bold') .' '. whos_online();?>
	</div>
	
	<div id="tabs">
		<ul>
			<li><a href="#one"><span><?php echo $label['r_posts'];?></span></a></li>
			<li><a href="#two"><span><?php echo $label['r_logs'];?></span></a></li>
			<li><a href="#three"><span><?php echo $label['r_news'];?></span></a></li>
		</ul>
		
		<div id="one">
			<?php echo text_output($label['posts'], 'h2');?>
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
								<?php echo anchor('sim/viewpost/'. $p['post_id'], $p['title'], array('class' => 'bold'));?>
								<br />
								<span class="fontSmall gray">
									<?php echo $label['by'] .' '. $p['authors'];?><br />
									<strong><?php echo $label['mission'];?></strong>
									<?php echo anchor('sim/missions/id/'. $p['mission_id'], $p['mission']);?>
								</span>
							</td>
							<td class="col_30pct align_center fontSmall"><?php echo $p['date'];?></td>
					<?php endforeach; ?>
					</tbody>
				</table>
				<p class="bold"><?php echo anchor('sim/listposts', $label['view_all_posts']);?></p>
			<?php else: ?>
				<?php echo text_output($label['noposts'], 'h3', 'orange');?>
			<?php endif; ?>
		</div>
		
		<div id="two">
			<?php echo text_output($label['logs'], 'h2');?>
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
								<?php echo anchor('sim/viewlog/'. $l['log_id'], $l['title'], array('class' => 'bold'));?>
								<br />
								<span class="fontSmall gray">
									<?php echo $label['by'] .' '. $l['author'];?>
								</span>
							</td>
							<td class="col_30pct align_center fontSmall"><?php echo $l['date'];?></td>
					<?php endforeach; ?>
					</tbody>
				</table>
				<p class="bold"><?php echo anchor('sim/listlogs', $label['view_all_logs']);?></p>
			<?php else: ?>
				<?php echo text_output($label['nologs'], 'h3', 'orange');?>
			<?php endif; ?>
		</div>
		
		<div id="three">
			<?php echo text_output($label['news'], 'h2');?>
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
								<?php echo anchor('main/viewnews/'. $n['news_id'], $n['title'], array('class' => 'bold'));?>
								<br />
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
				<?php echo text_output($label['nonews'], 'h3', 'orange');?>
			<?php endif; ?>
		</div>
	</div>
</div>

<br /> <!-- need this because IE is stupid beyond stupid ... of course it doesn't fix IE7 tho -->

<?php echo form_open().form_close();?>