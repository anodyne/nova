<?php echo text_output($header, 'h1', 'page-head');?>

<p><?php echo anchor('user/options', img($images['display']) .' '. $label['display'], array('class' => 'fontMedium bold image'));?></p>

<p><?php echo link_to_if($level == 2, 'user/characterlink/'. $inputs['id'], img($images['user']) .' '. $label['characters'], array('class' => 'fontMedium bold image'));?></p>

<?php echo form_open('user/account/'. $inputs['id']);?>
	<div id="tabs">
		<ul>
			<li><a href="#one"><span><?php echo $label['basicinfo'];?></span></a></li>
			<li><a href="#two"><span><?php echo $label['mybio'];?></span></a></li>
			<li><a href="#three"><span><?php echo $label['myprefs'];?></span></a></li>
			
			<?php if ($level == 2): ?>
				<li><a href="#four"><span><?php echo $label['admin'];?></span></a></li>
			<?php endif;?>
		</ul>
		
		<div id="one">
			<br /><table class="table100">
				<tbody>
					<tr>
						<td class="cell-label"><?php echo $label['name'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo form_input($inputs['name']);?></td>
					</tr>
					<tr>
						<td class="cell-label"><?php echo $label['email'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo form_input($inputs['email']);?></td>
					</tr>
					<tr>
						<td class="cell-label"><?php echo $label['password'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo form_password($inputs['password']);?></td>
					</tr>
					
					<?php echo table_row_spacer(3, 15);?>
					
					<tr>
						<td class="cell-label"><?php echo $label['dob'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo form_input($inputs['dob']);?></td>
					</tr>
					
					<?php echo table_row_spacer(3, 15);?>
					
					<tr>
						<td class="cell-label"><?php echo $label['language'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo form_dropdown('language', $values['language'], $inputs['language']);?></td>
					</tr>
					
					<?php echo table_row_spacer(3, 15);?>
					
					<tr>
						<td class="cell-label"><?php echo $label['secquestion'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo form_dropdown('security_question', $values['questions'], $inputs['question']);?></td>
					</tr>
					<tr>
						<td class="cell-label"><?php echo $label['secanswer'];?></td>
						<td class="cell-spacer"></td>
						<td>
							<?php echo text_output($label['sectext'], 'span', 'fontSmall bold gray');?><br />
							<?php echo form_input($inputs['answer']);?>
						</td>
					</tr>
					
					<?php echo table_row_spacer(3, 15);?>
					
					<tr>
						<td colspan="3"><?php echo text_output($label['datetime'], 'h3', 'page-subhead');?></td>
					</tr>
					<tr>
						<td class="cell-label"><?php echo $label['timezone'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo timezone_menu($inputs['timezone']);?></td>
					</tr>
					<tr>
						<td class="cell-label"><?php echo $label['dst'];?></td>
						<td class="cell-spacer"></td>
						<td>
							<?php echo form_radio($inputs['dst_y']) .' '. form_label($label['yes'], 'dst_y');?>
							<?php echo form_radio($inputs['dst_n']) .' '. form_label($label['no'], 'dst_n');?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div id="two">
			<br /><table class="table100">
				<tbody>
					<tr>
						<td class="cell-label"><?php echo $label['im'];?></td>
						<td class="cell-spacer"></td>
						<td>
							<?php echo text_output($label['im_inst'], 'span', 'fontSmall gray bold');?><br />
							<?php echo form_textarea($inputs['im']);?>
						</td>
					</tr>
					
					<?php echo table_row_spacer(3, 15);?>
					
					<tr>
						<td class="cell-label"><?php echo $label['location'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo form_input($inputs['location']);?></td>
					</tr>
					
					<?php echo table_row_spacer(3, 15);?>
					
					<tr>
						<td class="cell-label"><?php echo $label['interests'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo form_textarea($inputs['interests']);?></td>
					</tr>
					
					<?php echo table_row_spacer(3, 15);?>
					
					<tr>
						<td class="cell-label"><?php echo $label['bio'];?></td>
						<td class="cell-spacer"></td>
						<td><?php echo form_textarea($inputs['bio']);?></td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div id="three">
			<?php foreach ($prefs as $p): ?>
				<p><?php echo form_checkbox($p['input']) .' '. form_label($p['label'], $p['input']['id']);?></p>
			<?php endforeach;?>
		</div>
		
		<?php if ($level == 2): ?>
			<div id="four">
				<table class="table100">
					<tbody>
						<tr>
							<td colspan="3"><?php echo text_output($label['playersettings'], 'h3', 'page-subhead');?></td>
						</tr>
						<tr>
							<td class="cell-label"><?php echo $label['role'];?></td>
							<td class="cell-spacer"></td>
							<td><?php echo form_dropdown('access_role', $values['roles'], $inputs['role']);?></td>
						</tr>
						<tr>
							<td class="cell-label"><?php echo $label['type'];?></td>
							<td class="cell-spacer"></td>
							<td>
								<?php echo form_dropdown('status', $values['status'], $inputs['status']);?>
								<?php echo form_hidden('status_old', $inputs['status']);?>
							</td>
						</tr>
						<tr>
							<td class="cell-label"><?php echo $label['status'];?></td>
							<td class="cell-spacer"></td>
							<td>
								<?php echo form_dropdown('loa', $values['loa'], $inputs['loa']);?>
								<?php echo form_hidden('loa_old', $inputs['loa']);?>
							</td>
						</tr>
						
						<?php echo table_row_spacer(3, 15);?>
					
						<tr>
							<td class="cell-label"><?php echo $label['sysadmin'];?></td>
							<td class="cell-spacer"></td>
							<td>
								<?php echo form_radio($inputs['admin_y']) .' '. form_label($label['yes'], 'admin_y');?>
								<?php echo form_radio($inputs['admin_n']) .' '. form_label($label['no'], 'admin_n');?>
							</td>
						</tr>
						
						<?php echo table_row_spacer(3, 5);?>
						
						<tr>
							<td class="cell-label"><?php echo $label['gm'];?></td>
							<td class="cell-spacer"></td>
							<td>
								<?php echo form_radio($inputs['gm_y']) .' '. form_label($label['yes'], 'gm_y');?>
								<?php echo form_radio($inputs['gm_n']) .' '. form_label($label['no'], 'gm_n');?>
							</td>
						</tr>
						
						<?php echo table_row_spacer(3, 5);?>
						
						<tr>
							<td class="cell-label"><?php echo $label['webmaster'];?></td>
							<td class="cell-spacer"></td>
							<td>
								<?php echo form_radio($inputs['webmaster_y']) .' '. form_label($label['yes'], 'webmaster_y');?>
								<?php echo form_radio($inputs['webmaster_n']) .' '. form_label($label['no'], 'webmaster_n');?>
							</td>
						</tr>
						
						<?php echo table_row_spacer(3, 15);?>
						
						<tr>
							<td colspan="3"><?php echo text_output($label['moderate'], 'h3', 'page-subhead');?></td>
						</tr>
						<tr>
							<td class="cell-label"><?php echo $label['mod_posts'];?></td>
							<td class="cell-spacer"></td>
							<td>
								<?php echo form_radio($inputs['mod_posts_y']) .' '. form_label($label['yes'], 'mod_posts_y');?>
								<?php echo form_radio($inputs['mod_posts_n']) .' '. form_label($label['no'], 'mod_posts_n');?>
							</td>
						</tr>
						<tr>
							<td class="cell-label"><?php echo $label['mod_c_posts'];?></td>
							<td class="cell-spacer"></td>
							<td>
								<?php echo form_radio($inputs['mod_pcomment_y']) .' '. form_label($label['yes'], 'mod_pcomment_y');?>
								<?php echo form_radio($inputs['mod_pcomment_n']) .' '. form_label($label['no'], 'mod_pcomment_n');?>
							</td>
						</tr>
						
						<?php echo table_row_spacer(3, 15);?>
						
						<tr>
							<td class="cell-label"><?php echo $label['mod_logs'];?></td>
							<td class="cell-spacer"></td>
							<td>
								<?php echo form_radio($inputs['mod_logs_y']) .' '. form_label($label['yes'], 'mod_logs_y');?>
								<?php echo form_radio($inputs['mod_logs_n']) .' '. form_label($label['no'], 'mod_logs_n');?>
							</td>
						</tr>
						<tr>
							<td class="cell-label"><?php echo $label['mod_c_logs'];?></td>
							<td class="cell-spacer"></td>
							<td>
								<?php echo form_radio($inputs['mod_lcomment_y']) .' '. form_label($label['yes'], 'mod_lcomment_y');?>
								<?php echo form_radio($inputs['mod_lcomment_n']) .' '. form_label($label['no'], 'mod_lcomment_n');?>
							</td>
						</tr>
						
						<?php echo table_row_spacer(3, 15);?>
						
						<tr>
							<td class="cell-label"><?php echo $label['mod_news'];?></td>
							<td class="cell-spacer"></td>
							<td>
								<?php echo form_radio($inputs['mod_news_y']) .' '. form_label($label['yes'], 'mod_news_y');?>
								<?php echo form_radio($inputs['mod_news_n']) .' '. form_label($label['no'], 'mod_news_n');?>
							</td>
						</tr>
						<tr>
							<td class="cell-label"><?php echo $label['mod_c_news'];?></td>
							<td class="cell-spacer"></td>
							<td>
								<?php echo form_radio($inputs['mod_ncomment_y']) .' '. form_label($label['yes'], 'mod_ncomment_y');?>
								<?php echo form_radio($inputs['mod_ncomment_n']) .' '. form_label($label['no'], 'mod_ncomment_n');?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		<?php endif;?>
		
		<br /><br />
		<?php echo form_button($buttons['update']);?>
	</div>
<?php echo form_close();?>