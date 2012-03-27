<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<p><?php echo link_to_if($edit_valid, 'user/account/'. $userid, $label['edit'], array('class' => 'edit fontSmall bold'));?></p>

<?php if (isset($msg_error)): ?>
	<?php echo text_output($msg_error, 'h3', 'orange');?>
<?php else: ?>
	<p>
		<kbd><?php echo $label['name'];?></kbd>
		<?php echo $name;?>
	</p>
	<p>
		<kbd><?php echo $label['email'];?></kbd>
		<?php echo $email;?>
	</p>
	<p>
		<kbd><?php echo $label['timezone'];?></kbd>
		<?php echo $timezone;?><br>
		<span class="fontSmall gray bold"><?php echo $timezone_span;?></span>
	</p>
	
	<div id="tabs">
		<ul>
			<li><a href="#one"><span><?php echo $label['basicinfo'];?></span></a></li>
			<li><a href="#two"><span><?php echo $label['stats'];?></span></a></li>
			<li><a href="#three"><span><?php echo $label['charinfo'];?></span></a></li>
			<li><a href="#four"><span><?php echo $label['rankhistory'];?></span></a></li>
			<li><a href="#five"><span><?php echo $label['postinginfo'];?></span></a></li>
			<li><a href="#six"><span><?php echo $label['awards'];?></span></a></li>
		</ul>
		
		<!-- BASIC INFO -->
		<div id="one">
			<br>
			<?php if ( ! empty($dob)): ?>
				<p>
					<kbd><?php echo $label['dob'];?></kbd>
					<?php echo $dob;?>
				</p>
			<?php endif;?>
			
			<?php if ( ! empty($location)): ?>
				<p>
					<kbd><?php echo $label['location'];?></kbd>
					<?php echo $location;?>
				</p>
			<?php endif;?>
			
			<?php if (count($im) > 0): ?>
				<p>
					<kbd><?php echo $label['im'];?></kbd>
					<?php foreach ($im as $value): ?>
						<?php echo $value;?><br>
					<?php endforeach;?>
				</p>
			<?php endif;?>
			
			<?php if ( ! empty($interests)): ?>
				<p>
					<kbd><?php echo $label['interests'];?></kbd>
					<?php echo text_output($interests, '');?>
				</p>
			<?php endif;?>
			
			<?php if ( ! empty($bio)): ?>
				<p>
					<kbd><?php echo $label['bio'];?></kbd>
					<?php echo text_output($bio, '');?>
				</p>
			<?php endif;?>
			
			<?php if (empty($dob) and empty($location) and count($im) == 0 and empty($interests) and empty($bio)): ?>
				<?php echo text_output($label['nobasic'], 'h3', 'orange');?>
			<?php endif;?>
		</div> <!-- end BASIC INFO -->
		
		<!-- STATS -->
		<div id="two">
			<br>
			<p>
				<kbd><?php echo $label['joined'];?></kbd>
				<?php echo $join_date_time;?>
				<span class="fontSmall gray">(<?php echo $join_date;?>)</span>
			</p>
			<p>
				<kbd><?php echo $label['lastlogin'];?></kbd>
				<?php if (isset($last_login_time)): ?>
					<?php echo $last_login_time;?>
					<span class="fontSmall gray">(<?php echo $last_login;?>)</span>
				<?php else: ?>
					<?php echo text_output($label['nologin'], 'span', 'orange bold');?>
				<?php endif;?>
			</p>
			<p>
				<kbd><?php echo $label['lastpost'];?></kbd>
				<?php if (isset($last_post_time)): ?>
					<?php echo $last_post_time;?>
					<span class="fontSmall gray">(<?php echo $last_post;?>)</span>
				<?php else: ?>
					<?php echo text_output($label['nopost'], 'span', 'orange bold');?>
				<?php endif;?>
			</p>
			
			<p>
				<kbd><?php echo $label['totalposts'];?></kbd>
				<?php echo $post_count;?>
				<span class="fontSmall gray">(<?php echo $label['average'].' '.$avg_posts.' '.$label['perweek'];?>)</span>
			</p>
			<p>
				<kbd><?php echo $label['totallogs'];?></kbd>
				<?php echo $log_count;?>
				<span class="fontSmall gray">(<?php echo $label['average'].' '.$avg_logs.' '.$label['perweek'];?>)</span>
			</p>
		</div> <!-- end STATS -->
		
		<!-- CHARACTER INFO -->
		<div id="three">
			<br>
			<p>
				<kbd><?php echo $label['activechars'];?></kbd>
				<?php if (isset($characters['active'])): ?>
					<ul class="margin0 padding0 none">
					<?php foreach ($characters['active'] as $a): ?>
						<li>
							<?php echo anchor('personnel/character/'.$a['id'], $a['name'], array('class' => 'bold'));?><br>
							<p class="fontSmall gray">
								<?php echo $label['activefor'] .' '. $a['active_time'];?><br>
								<em><?php echo $a['active_date'];?></em>
							</p>
						</li>
					<?php endforeach; ?>
					</ul>
				<?php else: ?>
					<?php echo text_output($label['none'], 'span', 'orange bold');?>
				<?php endif;?>
			</p><br>
			
			<p>
				<kbd><?php echo $label['npcs'];?></kbd>
				<?php if (isset($characters['npcs'])): ?>
					<?php foreach ($characters['npcs'] as $n): ?>
						<?php echo anchor('personnel/character/'.$n['id'], $n['name'], array('class' => 'bold'));?><br>
					<?php endforeach; ?>
				<?php else: ?>
					<?php echo text_output($label['none'], 'span', 'orange bold');?>
				<?php endif;?>
			</p><br>
			
			<p>
				<kbd><?php echo $label['inactivechars'];?></kbd>
				<?php if (isset($characters['inactive'])): ?>
					<?php foreach ($characters['inactive'] as $i): ?>
						<?php echo anchor('personnel/character/'.$i['id'], $i['name'], array('class' => 'bold'));?><br>
					<?php endforeach; ?>
				<?php else: ?>
					<?php echo text_output($label['none'], 'span', 'orange bold');?>
				<?php endif;?>
			</p>
		</div> <!-- end CHARACTER INFO -->
		
		<!-- RANK HISTORY -->
		<div id="four">
			<br>
			<?php if (is_array($rank_history) and count($rank_history) > 0): ?>
				<?php foreach ($rank_history as $row): ?>
					<h3><?php echo $row['name'];?></h3>
					
					<table class="table100 zebra">
					<?php foreach ($row['history'] as $item): ?>
						<tr height="30">
							<td width="5"></td>
							<td>
								<?php if ($item['old_order'] > $item['new_order']): ?>
									<?php echo $label['promoted'];?>
									<?php echo $item['new_rank'];?>
									<?php echo $label['from'];?>
									<?php echo $item['old_rank'];?>
								<?php else: ?>
									<?php echo $label['demoted'];?>
									<?php echo $item['old_rank'];?>
									<?php echo $label['to'];?>
									<?php echo $item['new_rank'];?>
								<?php endif;?>
							</td>
							<td class="col_200 align_center fontSmall"><?php echo $item['date'];?></td>
						</tr>
					<?php endforeach;?>
					</table>
				<?php endforeach;?>
			<?php else: ?>
				<?php echo text_output($label['norankhistory'], 'h3', 'orange');?>
			<?php endif;?>
		</div> <!-- end RANK HISTORY -->
		
		<!-- POSTING INFO -->
		<div id="five">
			<br>
			<?php echo text_output($label['missionposts'], 'h2');?>
			<?php if (isset($posts)): ?>
				<p class="bold"><?php echo anchor('personnel/viewposts/u/'. $userid, $label['viewposts']);?></p>
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
								<?php echo anchor('sim/viewpost/'. $p['post_id'], $p['title'], array('class' => 'bold'));?>
								<br />
								<span class="fontSmall gray">
									<?php echo $label['by'] .' '. $p['authors'];?><br />
									<strong><?php echo $label['mission'];?>:</strong>
									<?php echo anchor('sim/missions/id/'. $p['mission_id'], $p['mission']);?>
								</span>
							</td>
							<td class="col_30pct align_center fontSmall"><?php echo $p['date'];?></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table><br />
			<?php else: ?>
				<?php echo text_output($label['noposts'], 'h3', 'orange');?>
			<?php endif; ?>
			
			<?php echo text_output($label['personallogs'], 'h2');?>
			<?php if (isset($logs)): ?>
				<p class="bold"><?php echo anchor('personnel/viewlogs/u/'. $userid, $label['viewlogs']);?></p>
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
								<?php echo anchor('sim/viewlog/'. $l['log_id'], $l['title'], array('class' => 'bold'));?>
								<br />
								<span class="fontSmall gray">
									<?php echo $label['by'] .' '. $l['author'];?>
								</span>
							</td>
							<td class="col_30pct align_center fontSmall"><?php echo $l['date'];?></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table><br />
			<?php else: ?>
				<?php echo text_output($label['nologs'], 'h3', 'orange');?>
			<?php endif; ?>
		</div> <!-- end POSTING INFO -->
		
		<!-- AWARDS -->
		<div id="six">
			<?php if (isset($awards)): ?>
				<br>
				<table class="table100 zebra">
					<thead>
						<tr>
							<th><?php echo $label['award'];?></th>
							<th><?php echo $label['date'];?></th>
							<th><?php echo $label['reason'];?></th>
						</tr>
					</thead>
					
					<tbody>
					<?php foreach ($awards as $a): ?>
						<tr>
							<td class="col_30pct">
								<?php echo anchor('sim/awards/'. $a['award_id'], $a['award'], array('class' => 'bold'));?>
								<br />
								<span class="fontSmall gray">
									<?php echo $label['receivedby'] .' '. $a['name'];?>
								</span>
							</td>
							<td class="col_30pct"><?php echo $a['given'];?></td>
							<td><?php echo text_output($a['reason'], '');?></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
				
				<p class="bold"><?php echo anchor('personnel/viewawards/u/'. $userid, $label['viewawards']);?></p>
			<?php else: ?>
				<?php echo text_output($label['noawards'], 'h2', 'orange');?>
			<?php endif; ?>
		</div> <!-- end AWARDS -->
	</div>
<?php endif; ?>