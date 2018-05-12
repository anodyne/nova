<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php if (Auth::check_access('user/account', false) and $level >= 2): ?>
	<p><a href="<?php echo site_url('user/all');?>" class="fontMedium bold"><?php echo $label['back'];?></a></p>
<?php endif;?>

<p><?php echo anchor('user/options', img($images['display']) .' '. $label['display'], array('class' => 'bold image'));?></p>

<p><?php echo link_to_if($level == 2, 'user/characterlink/'. $inputs['id'], img($images['user']) .' '. $label['characters'], array('class' => 'bold image'));?></p>

<?php if ($my_user and !Auth::is_sysadmin($userid)):?>
	<p><?php echo anchor('user/delete', img($images['delete']) .' '. $label['delete'], array('class' => 'bold image'));?></p>
<?php else: ?>
	<?php echo text_output($label['admin_delete'], 'h4', 'red'); ?>
<?php endif;?>

<?php if ($level == 2 and ! $my_user):?>
	<p>
		<kbd><?php echo $label['reset_password'];?></kbd>
		<?php echo form_button($button['password_reset']);?>
	</p>
	<p>
		<kbd><?php echo $label['type'];?></kbd>
		<?php echo form_button($button['user_status']);?>
	</p>
<?php elseif ($level == 2 and $my_user): ?>
	<?php echo text_output($label['your_user'], 'h4', 'blue');?>
<?php endif;?>

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
			<p>
				<kbd><?php echo $label['name'];?></kbd>
				<?php echo form_input($inputs['name']);?>
			</p>
			<p>
				<kbd><?php echo $label['email'];?></kbd>
				<?php echo form_input($inputs['email']);?>
			</p>
			<p>
				<kbd><?php echo $label['password'];?></kbd>
				<?php echo form_password($inputs['password']);?>
			</p><br />

			<p>
				<kbd><?php echo $label['dob'];?></kbd>
				<?php echo form_input($inputs['dob']);?>
			</p>
			<p>
				<kbd><?php echo $label['language'];?></kbd>
				<?php echo form_dropdown('language', $values['language'], $inputs['language']);?>
			</p><br />

			<p>
				<kbd><?php echo $label['secquestion'];?></kbd>
				<?php echo form_dropdown('security_question', $values['questions'], $inputs['question']);?>
			</p>
			<p>
				<kbd><?php echo $label['secanswer'];?></kbd>
				<?php echo text_output($label['sectext'], 'span', 'fontSmall bold gray');?><br />
				<?php echo form_input($inputs['answer']);?>
			</p><br />

			<?php echo text_output($label['datetime'], 'h3', 'page-subhead');?>
			<div class="indent-left">
				<p>
					<kbd><?php echo $label['timezone'];?></kbd>
					<?php echo timezone_menu($inputs['timezone']);?>
				</p>
				<p>
					<kbd><?php echo $label['dst'];?></kbd>
					<?php echo form_radio($inputs['dst_y']) .' '. form_label($label['yes'], 'dst_y');?>
					<?php echo form_radio($inputs['dst_n']) .' '. form_label($label['no'], 'dst_n');?>
				</p>
			</div>
		</div>

		<div id="two">
			<p>
				<kbd><?php echo $label['im'];?></kbd>
				<?php echo text_output($label['im_inst'], 'span', 'fontSmall gray bold');?><br />
				<?php echo form_textarea($inputs['im']);?>
			</p>
			<p>
				<kbd><?php echo $label['location'];?></kbd>
				<?php echo form_input($inputs['location']);?>
			</p>
			<p>
				<kbd><?php echo $label['interests'];?></kbd>
				<?php echo form_textarea($inputs['interests']);?>
			</p>
			<p>
				<kbd><?php echo $label['bio'];?></kbd>
				<?php echo form_textarea($inputs['bio']);?>
			</p>
		</div>

		<div id="three">
			<?php foreach ($prefs as $p): ?>
				<p><?php echo form_checkbox($p['input']) .' '. form_label($p['label'], $p['input']['id']);?></p>
			<?php endforeach;?>
		</div>

		<?php if ($level == 2): ?>
			<div id="four">
				<?php echo text_output($label['usersettings'], 'h3', 'page-subhead');?>

				<div class="indent-left">
					<p>
						<kbd><?php echo $label['role'];?></kbd>
						<?php echo form_dropdown('access_role', $values['roles'], $inputs['role']);?>
					</p>
					<p>
						<kbd><?php echo $label['type'];?></kbd>
						<?php echo form_button($button['user_status']);?>
					</p>
					<p>
						<kbd><?php echo $label['status'];?></kbd>
						<?php echo form_dropdown('loa', $values['loa'], $inputs['loa']);?>
						<?php echo form_hidden('loa_old', $inputs['loa']);?>
					</p>
					<p>
						<kbd><?php echo $label['sysadmin'];?></kbd>
						<?php echo form_radio($inputs['admin_y']) .' '. form_label($label['yes'], 'admin_y');?>
						<?php echo form_radio($inputs['admin_n']) .' '. form_label($label['no'], 'admin_n');?>
					</p>
					<p>
						<kbd><?php echo $label['gm'];?></kbd>
						<?php echo form_radio($inputs['gm_y']) .' '. form_label($label['yes'], 'gm_y');?>
						<?php echo form_radio($inputs['gm_n']) .' '. form_label($label['no'], 'gm_n');?>
					</p>
					<p>
						<kbd><?php echo $label['webmaster'];?></kbd>
						<?php echo form_radio($inputs['webmaster_y']) .' '. form_label($label['yes'], 'webmaster_y');?>
						<?php echo form_radio($inputs['webmaster_n']) .' '. form_label($label['no'], 'webmaster_n');?>
					</p>
				</div>

				<?php echo text_output($label['moderate'], 'h3', 'page-subhead');?>

				<div class="indent-left">
					<p>
						<kbd><?php echo $label['mod_posts'];?></kbd>
						<?php echo form_radio($inputs['mod_posts_y']) .' '. form_label($label['yes'], 'mod_posts_y');?>
						<?php echo form_radio($inputs['mod_posts_n']) .' '. form_label($label['no'], 'mod_posts_n');?>
					</p>
					<p>
						<kbd><?php echo $label['mod_c_posts'];?></kbd>
						<?php echo form_radio($inputs['mod_pcomment_y']) .' '. form_label($label['yes'], 'mod_pcomment_y');?>
						<?php echo form_radio($inputs['mod_pcomment_n']) .' '. form_label($label['no'], 'mod_pcomment_n');?>
					</p>

					<p>
						<kbd><?php echo $label['mod_logs'];?></kbd>
						<?php echo form_radio($inputs['mod_logs_y']) .' '. form_label($label['yes'], 'mod_logs_y');?>
						<?php echo form_radio($inputs['mod_logs_n']) .' '. form_label($label['no'], 'mod_logs_n');?>
					</p>
					<p>
						<kbd><?php echo $label['mod_c_logs'];?></kbd>
						<?php echo form_radio($inputs['mod_lcomment_y']) .' '. form_label($label['yes'], 'mod_lcomment_y');?>
						<?php echo form_radio($inputs['mod_lcomment_n']) .' '. form_label($label['no'], 'mod_lcomment_n');?>
					</p>

					<p>
						<kbd><?php echo $label['mod_news'];?></kbd>
						<?php echo form_radio($inputs['mod_news_y']) .' '. form_label($label['yes'], 'mod_news_y');?>
						<?php echo form_radio($inputs['mod_news_n']) .' '. form_label($label['no'], 'mod_news_n');?>
					</p>
					<p>
						<kbd><?php echo $label['mod_c_news'];?></kbd>
						<?php echo form_radio($inputs['mod_ncomment_y']) .' '. form_label($label['yes'], 'mod_ncomment_y');?>
						<?php echo form_radio($inputs['mod_ncomment_n']) .' '. form_label($label['no'], 'mod_ncomment_n');?>
					</p>

					<p>
						<kbd><?php echo $label['mod_c_wiki'];?></kbd>
						<?php echo form_radio($inputs['mod_wcomment_y']) .' '. form_label($label['yes'], 'mod_wcomment_y');?>
								<?php echo form_radio($inputs['mod_wcomment_n']) .' '. form_label($label['no'], 'mod_wcomment_n');?>
					</p>
				</div>
			</div>
		<?php endif;?>

		<br /><br />
		<?php echo form_button($buttons['update']);?>
	</div>
<?php echo form_close();?>
