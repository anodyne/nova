<?php echo text_output($header, 'h1', 'page-head');?>

<p><?php echo link_to_if($edit_valid, 'user/account/'. $userid, $label['edit'], array('class' => 'edit fontSmall bold'));?></p>

<?php if (isset($msg_error)): ?>
	<?php echo text_output($msg_error, 'h3', 'orange');?>
<?php else: ?>
	<div id="tabs">
		<ul>
			<li><a href="#one"><span><?php echo $label['basicinfo'];?></span></a></li>
			<li><a href="#two"><span><?php echo $label['charinfo'];?></span></a></li>
			<li><a href="#three"><span><?php echo $label['rankhistory'];?></span></a></li>
			<li><a href="#four"><span><?php echo $label['stats'];?></span></a></li>
			<li><a href="#five"><span><?php echo $label['postinginfo'];?></span></a></li>
			<li><a href="#six"><span><?php echo $label['awards'];?></span></a></li>
		</ul>
		
		<!-- BASIC INFO -->
		<div id="one">
			<br /><table class="table100">
				<tr>
					<td class="cell-label"><?php echo $label['name'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo $name;?></td>
				</tr>
				
				<?php if (!empty($dob)): ?>
					<tr>
						<td class="cell-label"><?php echo $label['dob'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo $dob;?></td>
					</tr>
				<?php endif; ?>
				
				<?php if (!empty($location)): ?>
					<tr>
						<td class="cell-label"><?php echo $label['location'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo $location;?></td>
					</tr>
				<?php endif; ?>
				
				<?php echo table_row_spacer(3, 10);?>
				<tr>
					<td class="cell-label"><?php echo $label['email'];?></td>
					<td class="cell-spacer"></td>
					<td><?php echo $email;?></td>
				</tr>
				
				<?php if (!empty($im)): ?>
					<tr>
						<td class="cell-label"><?php echo $label['im'];?></td>
						<td class="cell-spacer"></td>
						<td>
							<?php foreach ($im as $value): ?>
								<?php echo $value;?><br />
							<?php endforeach; ?>
						</td>
					</tr>
				<?php endif; ?>
				
				<?php echo table_row_spacer(3, 10);?>
				<tr>
					<td class="cell-label"><?php echo $label['timezone'];?></td>
					<td class="cell-spacer"></td>
					<td>
						<?php echo $timezone;?><br />
						<span class="fontSmall gray bold"><?php echo $timezone_span;?></span>
					</td>
				</tr>
				
				<?php if (!empty($interests)): ?>
					<?php echo table_row_spacer(3, 10);?>
					<tr>
						<td class="cell-label"><?php echo $label['interests'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo text_output($interests, '');?></td>
					</tr>
				<?php endif; ?>
				
				<?php if (!empty($bio)): ?>
					<?php echo table_row_spacer(3, 10);?>
					<tr>
						<td class="cell-label"><?php echo $label['bio'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo text_output($bio, '');?></td>
					</tr>
				<?php endif; ?>
			</table>
		</div> <!-- end BASIC INFO -->
		
		<!-- CHARACTER INFO -->
		<div id="two">
			<br /><table class="table100">
				<tr>
					<td class="cell-label"><?php echo $label['activechars'];?></td>
					<td class="cell-spacer"></td>
					<td>
						<?php if (isset($characters['active'])): ?>
							<ul class="margin0 padding0 none">
							<?php foreach ($characters['active'] as $a): ?>
								<li>
									<?php echo anchor('personnel/character/'. $a['id'], $a['name'], array('class' => 'bold'));?><br />
									<p class="fontSmall gray">
										<?php echo $label['activefor'] .' '. $a['active_time'];?><br />
										<em><?php echo $a['active_date'];?></em>
									</p>
								</li>
							<?php endforeach; ?>
							</ul>
						<?php else: ?>
							<?php echo text_output($label['none'], 'span', 'orange bold');?>
						<?php endif; ?>
					</td>
				</tr>
				<?php echo table_row_spacer(3, 10);?>
				<tr>
					<td class="cell-label"><?php echo $label['npcs'];?></td>
					<td class="cell-spacer"></td>
					<td>
						<?php if (isset($characters['npcs'])): ?>
							<?php foreach ($characters['npcs'] as $n): ?>
								<?php echo anchor('personnel/character/'. $n['id'], $n['name'], array('class' => 'bold'));?>
								<br />
							<?php endforeach; ?>
						<?php else: ?>
							<?php echo text_output($label['none'], 'span', 'orange bold');?>
						<?php endif; ?>
					</td>
				</tr>
				<?php echo table_row_spacer(3, 10);?>
				<tr>
					<td class="cell-label"><?php echo $label['inactivechars'];?></td>
					<td class="cell-spacer"></td>
					<td>
						<?php if (isset($characters['inactive'])): ?>
							<?php foreach ($characters['inactive'] as $i): ?>
								<?php echo anchor('personnel/character/'. $i['id'], $i['name'], array('class' => 'bold'));?>
								<br />
							<?php endforeach; ?>
						<?php else: ?>
							<?php echo text_output($label['none'], 'span', 'orange bold');?>
						<?php endif; ?>
					</td>
				</tr>
			</table>
		</div> <!-- end CHARACTER INFO -->
		
		<!-- RANK HISTORY -->
		<div id="three">
			<?php if (is_array($rank_history)): ?>
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
								<?php endif; ?>
							</td>
							<td class="col_200 align_center fontSmall"><?php echo $item['date'];?></td>
						</tr>
					<?php endforeach; ?>
					</table>
				<?php endforeach; ?>
			<?php else: ?>
				<?php echo text_output($label['norankhistory'], 'h3', 'orange');?>
			<?php endif; ?>
		</div> <!-- end RANK HISTORY -->
		
		<!-- STATS -->
		<div id="four">
			<br /><table class="table100">
				<tr>
					<td class="cell-label"><?php echo $label['joined'];?></td>
					<td class="cell-spacer"></td>
					<td>
						<strong><?php echo $join_date_time .' '. $label['ago'];?></strong><br />
						<span class="fontSmall gray"><?php echo $join_date;?></spa>
					</td>
				</tr>
				<?php echo table_row_spacer(3, 10);?>
				<tr>
					<td class="cell-label"><?php echo $label['lastlogin'];?></td>
					<td class="cell-spacer"></td>
					<td>
						<?php if (isset($last_login_time)): ?>
							<strong><?php echo $last_login_time .' '. $label['ago'];?></strong><br />
							<span class="fontSmall gray"><?php echo $last_login;?></span>
						<?php else: ?>
							<?php echo text_output($label['nologin'], 'span', 'orange bold');?>
						<?php endif; ?>
					</td>
				</tr>
				<?php echo table_row_spacer(3, 10);?>
				<tr>
					<td class="cell-label"><?php echo $label['lastpost'];?></td>
					<td class="cell-spacer"></td>
					<td>
						<?php if (isset($last_post_time)): ?>
							<strong><?php echo $last_post_time .' '. $label['ago'];?></strong><br />
							<span class="fontSmall gray"><?php echo $last_post;?></span>
						<?php else: ?>
							<?php echo text_output($label['nopost'], 'span', 'orange bold');?>
						<?php endif; ?>
					</td>
				</tr>
				<?php echo table_row_spacer(3, 10);?>
				<tr>
					<td class="cell-label"><?php echo $label['totalposts'];?></td>
					<td class="cell-spacer"></td>
					<td>
						<?php echo $post_count;?><br />
						<span class="fontSmall gray">
							<?php echo $label['average'] .' '. $avg_posts .' '. $label['perweek'];?>
						</span>
					</td>
				</tr>
				<tr>
					<td class="cell-label"><?php echo $label['totallogs'];?></td>
					<td class="cell-spacer"></td>
					<td>
						<?php echo $log_count;?><br />
						<span class="fontSmall gray">
							<?php echo $label['average'] .' '. $avg_logs .' '. $label['perweek'];?>
						</span>
					</td>
				</tr>
			</table>
		</div> <!-- end STATS -->
		
		<!-- POSTING INFO -->
		<div id="five">
			<?php echo text_output($label['missionposts'], 'h2');?>
			<?php if (isset($posts)): ?>
				<p class="bold"><?php echo anchor('personnel/viewposts/p/'. $userid, $label['viewposts']);?></p>
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
									<?php echo anchor('sim/missions/'. $p['mission_id'], $p['mission']);?>
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
				<p class="bold"><?php echo anchor('personnel/viewlogs/p/'. $userid, $label['viewlogs']);?></p>
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
				<br />
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
				
				<p class="bold"><?php echo anchor('personnel/viewawards/p/'. $userid, $label['viewawards']);?></p>
			<?php else: ?>
				<?php echo text_output($label['noawards'], 'h2', 'orange');?>
			<?php endif; ?>
		</div> <!-- end AWARDS -->
	</div>
<?php endif; ?>