<?php echo text_output($header, 'h1', 'page-head');?>

<p class="bold"><?php echo anchor('site/usersettings', img($images['gear']) .' '. $label['manageuser']);?></p>

<div id="tabs">
	<ul>
		<li><a href="#one"><span><?php echo $label['general'];?></span></a></li>
		<li><a href="#two"><span><?php echo $label['system'];?></span></a></li>
		<li><a href="#three"><span><?php echo $label['appearance'];?></span></a></li>
		
		<?php if (isset($user)): ?>
			<li><a href="#four"><span><?php echo $label['user'];?></span></a></li>
		<?php endif; ?>
	</ul>
	
	<div id="one">
		<?php echo form_open('site/settings');?>
			<?php echo text_output($label['header_gen'], 'h2', 'page-subhead');?>
			<table class="table100 zebra">
				<tbody>
					<tr class="height_40">
						<td class="cell-label"><?php echo $label['name'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo form_input($inputs['sim_name']);?></td>
					</tr>
					<tr class="height_40">
						<td class="cell-label"><?php echo $label['year'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo form_input($inputs['sim_year']);?></td>
					</tr>
					<tr class="height_40">
						<td class="cell-label">
							<?php echo $label['type'];?><br />
							<?php echo anchor('site/simtypes', '['. $label['edit'] .']', array('class' => 'fontTiny'));?>
						</td>
						<td class="cell-spacer"></td>
						<td>
							<?php echo form_dropdown('sim_type', $values['sim_type'], $default['sim_type']);?>
							<?php echo form_hidden('old_sim_type', $default['sim_type']);?>
						</td>
					</tr>
				</tbody>
			</table>
			
			<table class="table100">
				<tbody>
					<?php echo table_row_spacer(3, 15);?>
					<tr>
						<td class="cell-label"></td>
						<td class="cell-spacer"></td>
						<td align="right"><?php echo form_button($button_submit);?></td>
					</tr>
				</tbody>
			</table>
		<?php echo form_close();?>
	</div>
	
	<div id="two">
		<?php echo form_open('site/settings/1');?>
			<?php echo text_output($label['header_system'], 'h2', 'page-subhead');?>
			<table class="table100 zebra">
				<tbody>
					<tr class="height_50">
						<td class="cell-label"><?php echo $label['allowed_chars'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo form_input($inputs['allowed_playing_chars']);?></td>
					</tr>
					<tr class="height_50">
						<td class="cell-label"><?php echo $label['allowed_npcs'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo form_input($inputs['allowed_npcs']);?></td>
					</tr>
					<tr class="height_40">
						<td class="cell-label"><?php echo $label['maint'];?></td>
						<td class="cell-spacer"></td>
						<td>
							<?php echo form_radio($inputs['maintenance_on']) .' '. form_label($label['on'], 'maintenance_on');?>
							<?php echo form_radio($inputs['maintenance_off']) .' '. form_label($label['off'], 'maintenance_off');?>
						</td>
					</tr>
					<tr class="height_40">
						<td class="cell-label"><?php echo $label['date'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo form_dropdown('date_format', $values['date_format'], $default['date_format']);?></td>
					</tr>
					<tr class="height_40">
						<td class="cell-label"><?php echo $label['timezone'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo timezone_menu($this->timezone, '', 'timezone');?></td>
					</tr>
					<tr class="height_40">
						<td class="cell-label"><?php echo $label['dst'];?></td>
						<td class="cell-spacer"></td>
						<td>
							<?php echo form_radio($inputs['dst_y']) .' '. form_label($label['yes'], 'dst_y');?>
							<?php echo form_radio($inputs['dst_n']) .' '. form_label($label['no'], 'dst_n');?>
						</td>
					</tr>
					<tr class="height_40">
						<td class="cell-label"><?php echo $label['updates'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo form_dropdown('updates', $values['updates'], $default['updates']);?></td>
					</tr>
					<tr class="height_40">
						<td class="cell-label">
							<?php echo $label['online'];?><br />
							<a href="#" rel="tooltip" class="fontTiny image" tooltip="<?php echo $label['tt_online_timespan'];?>"><?php echo img($images['help']);?></a>
						</td>
						<td class="cell-spacer"></td>
						<td>
							<?php echo form_input($inputs['online_timespan']);?>
							<span class="gray"><?php echo $label['minutes'];?>
						</td>
					</tr>
					<tr class="height_40">
						<td class="cell-label">
							<?php echo $label['requirement'];?><br />
							<a href="#" rel="tooltip" class="fontTiny image" tooltip="<?php echo $label['tt_posting_requirement'];?>"><?php echo img($images['help']);?></a>
						</td>
						<td class="cell-spacer"></td>
						<td>
							<?php echo form_input($inputs['posting_req']);?>
							<span class="gray"><?php echo $label['days'];?>
						</td>
					</tr>
				</tbody>
			</table><br />
			
			<?php echo text_output($label['header_email'], 'h2', 'page-subhead');?>
			<table class="table100 zebra">
				<tbody>
					<tr class="height_40">
						<td class="cell-label"><?php echo $label['sysemail'];?></td>
						<td class="cell-spacer"></td>
						<td>
							<?php echo form_radio($inputs['sys_email_on']) .' '. form_label($label['on'], 'sys_email_on');?>
							<?php echo form_radio($inputs['sys_email_off']) .' '. form_label($label['off'], 'sys_email_off');?>
						</td>
					</tr>
					<tr class="height_40">
						<td class="cell-label"><?php echo $label['emailsubject'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo form_input($inputs['email_subject']);?></td>
					</tr>
					<tr class="height_40">
						<td class="cell-label"><?php echo $label['emailname'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo form_input($inputs['email_name']);?></td>
					</tr>
					<tr class="height_40">
						<td class="cell-label"><?php echo $label['emailaddress'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo form_input($inputs['email_address']);?></td>
					</tr>
				</tbody>
			</table>
			
			<table class="table100">
				<tbody>
					<?php echo table_row_spacer(3, 15);?>
					<tr>
						<td class="cell-label"></td>
						<td class="cell-spacer"></td>
						<td align="right"><?php echo form_button($button_submit);?></td>
					</tr>
				</tbody>
			</table>
		<?php echo form_close();?>
	</div>
	
	<div id="three">
		<?php echo form_open('site/settings/2');?>
			<?php echo text_output($label['header_skins'], 'h2', 'page-subhead');?>
			<table class="table100 zebra">
				<tbody>
					<tr class="height_40">
						<td class="cell-label"><?php echo $label['skin_main'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo form_dropdown('skin_main', $themes['main'], $default['skin_main']);?></td>
					</tr>
					<tr class="height_40">
						<td class="cell-label"><?php echo $label['skin_admin'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo form_dropdown('skin_admin', $themes['admin'], $default['skin_admin']);?></td>
					</tr>
					<tr class="height_40">
						<td class="cell-label"><?php echo $label['skin_login'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo form_dropdown('skin_login', $themes['login'], $default['skin_login']);?></td>
					</tr>
					<tr class="height_40">
						<td class="cell-label"><?php echo $label['skin_wiki'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo form_dropdown('skin_wiki', $themes['wiki'], $default['skin_wiki']);?></td>
					</tr>
				</tbody>
			</table><br />
			
			<?php echo text_output($label['header_options'], 'h2', 'page-subhead');?>
			<table class="table100 zebra">
				<tbody>
					<tr class="height_40">
						<td class="cell-label"><?php echo $label['rank'];?></td>
						<td class="cell-spacer"></td>
						<td>
							<?php foreach ($ranks as $key => $value): ?>
								<?php echo form_radio($inputs['ranks'][$value['location']]);?>
								<?php echo form_label($ranks[$key]['image'], 'r_'. $ranks[$key]['id']);?><br />
							<?php endforeach; ?>
						</td>
					</tr>
					<tr class="height_40">
						<td class="cell-label"><?php echo $label['posts_num'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo form_input($inputs['list_posts_num']);?></td>
					</tr>
					<tr class="height_40">
						<td class="cell-label"><?php echo $label['logs_num'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo form_input($inputs['list_logs_num']);?></td>
					</tr>
					<tr class="height_40">
						<td class="cell-label"><?php echo $label['news_show'];?></td>
						<td class="cell-spacer"></td>
						<td>
							<?php echo form_radio($inputs['show_news_y']);?>
							<?php echo form_label($label['yes'], 'show_news_y');?>
							
							<?php echo form_radio($inputs['show_news_n']);?>
							<?php echo form_label($label['no'], 'show_news_n');?>
						</td>
					</tr>
					<tr class="height_40">
						<td class="cell-label"><?php echo $label['use_notes'];?></td>
						<td class="cell-spacer"></td>
						<td>
							<?php echo form_radio($inputs['use_mission_notes_y']);?>
							<?php echo form_label($label['yes'], 'use_mission_notes_y');?>
							
							<?php echo form_radio($inputs['use_mission_notes_n']);?>
							<?php echo form_label($label['no'], 'use_mission_notes_n');?>
						</td>
					</tr>
					<tr class="height_40">
						<td class="cell-label"><?php echo $label['sample_post'];?></td>
						<td class="cell-spacer"></td>
						<td>
							<?php echo form_radio($inputs['use_sample_post_y']);?>
							<?php echo form_label($label['yes'], 'use_sample_post_y');?>
							
							<?php echo form_radio($inputs['use_sample_post_n']);?>
							<?php echo form_label($label['no'], 'use_sample_post_n');?>
						</td>
					</tr>
					<tr class="height_40">
						<td class="cell-label">
							<?php echo $label['count_format'];?><br />
							<a href="#" rel="tooltip" class="fontTiny image" tooltip="<?php echo $label['tt_post_count'];?>"><?php echo img($images['help']);?></a>
						</td>
						<td class="cell-spacer"></td>
						<td>
							<?php echo form_radio($inputs['post_count_multi']);?>
							<?php echo form_label($label['count_multiple'], 'post_count_multi');?>
							
							<?php echo form_radio($inputs['post_count_single']);?>
							<?php echo form_label($label['count_single'], 'post_count_single');?>
						</td>
					</tr>
					<tr class="height_40">
						<td class="cell-label">
							<?php echo $label['manifest'];?>
						</td>
						<td class="cell-spacer"></td>
						<td><?php echo form_dropdown('manifest_defaults', $values['manifest'], $default['manifest']);?></td>
					</tr>
				</tbody>
			</table>
			
			<table class="table100">
				<tbody>
					<?php echo table_row_spacer(3, 15);?>
					<tr>
						<td class="cell-label"></td>
						<td class="cell-spacer"></td>
						<td align="right"><?php echo form_button($button_submit);?></td>
					</tr>
				</tbody>
			</table>
		<?php echo form_close();?>
	</div>
	
	<?php if (isset($user)): ?>
		<div id="four">
			<?php echo form_open('site/settings/3');?>
				<?php echo text_output($label['header_user'], 'h2', 'page-subhead');?>
				<table class="table100 zebra">
					<tbody>
					<?php foreach ($user as $u): ?>
						<tr class="height_40">
							<td class="cell-label"><?php echo $u['label'];?></td>
							<td class="cell-spacer"></td>
							<td><?php echo form_input($u['key'], $u['value']);?></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
				
				<table class="table100">
					<tbody>
						<?php echo table_row_spacer(3, 15);?>
						<tr>
							<td class="cell-label"></td>
							<td class="cell-spacer"></td>
							<td align="right"><?php echo form_button($button_submit);?></td>
						</tr>
					</tbody>
				</table>
			<?php echo form_close();?>
		</div>
	<?php endif; ?>
</div>