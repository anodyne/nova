<p class="fontMedium"><?php echo __("Nova gives you the ability to upgrade only the items you want from SMS. Using the list below, please select which items you want Nova to upgrade from the SMS format to the Nova format.");?></p>

<hr />

<?php echo form::open('upgrade/step/2');?>
	<table class="table100 zebra">
		<thead>
			<tr>
				<th colspan="2"><?php echo __('Items to Upgrade');?></th>
				<th class="col-100">Yes</th>
				<th class="col-100">No</th>
		</thead>
		<tbody>
			<tr>
				<td class="fontMedium bold"><?php echo __('Characters &amp; Users');?></td>
				<td class="col-30 align-center">
					<?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/tick-circle.png');?>
				</td>
				<td class="align-center"><?php echo form::radio('upgrade_characters_users', 1, TRUE);?></td>
				<td class="align-center"><?php echo form::radio('upgrade_characters_users', 0);?></td>
			</tr>
			<tr>
				<td class="fontMedium bold"><?php echo __('Awards');?></td>
				<td class="col-30 align-center">
					<?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/tick-circle.png');?>
				</td>
				<td class="align-center"><?php echo form::radio('upgrade_awards', 1, TRUE);?></td>
				<td class="align-center"><?php echo form::radio('upgrade_awards', 0);?></td>
			</tr>
			<tr>
				<td class="fontMedium bold"><?php echo __('System Settings');?></td>
				<td class="col-30 align-center">
					<?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/tick-circle.png');?>
				</td>
				<td class="align-center"><?php echo form::radio('upgrade_settings', 1, TRUE);?></td>
				<td class="align-center"><?php echo form::radio('upgrade_settings', 0);?></td>
			</tr>
			<tr>
				<td class="fontMedium bold"><?php echo __('Personal Logs');?></td>
				<td class="col-30 align-center">
					<?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/tick-circle.png');?>
				</td>
				<td class="align-center"><?php echo form::radio('upgrade_logs', 1, TRUE);?></td>
				<td class="align-center"><?php echo form::radio('upgrade_logs', 0);?></td>
			</tr>
			<tr>
				<td class="fontMedium bold"><?php echo __('News Items &amp; Categories');?></td>
				<td class="col-30 align-center">
					<?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/tick-circle.png');?>
				</td>
				<td class="align-center"><?php echo form::radio('upgrade_news', 1, TRUE);?></td>
				<td class="align-center"><?php echo form::radio('upgrade_news', 0);?></td>
			</tr>
			<tr>
				<td class="fontMedium bold"><?php echo __('Missions &amp; Mission Posts');?></td>
				<td class="col-30 align-center">
					<?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/tick-circle.png');?>
				</td>
				<td class="align-center"><?php echo form::radio('upgrade_missions', 1, TRUE);?></td>
				<td class="align-center"><?php echo form::radio('upgrade_missions', 0);?></td>
			</tr>
			<tr>
				<td class="fontMedium bold"><?php echo __('Specifications');?></td>
				<td class="col-30 align-center">
					<?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/tick-circle.png');?>
				</td>
				<td class="align-center"><?php echo form::radio('upgrade_specs', 1, TRUE);?></td>
				<td class="align-center"><?php echo form::radio('upgrade_specs', 0);?></td>
			</tr>
			<tr>
				<td class="fontMedium bold"><?php echo __('Tour Items');?></td>
				<td class="col-30 align-center">
					<?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/tick-circle.png');?>
				</td>
				<td class="align-center"><?php echo form::radio('upgrade_tour', 1, TRUE);?></td>
				<td class="align-center"><?php echo form::radio('upgrade_tour', 0);?></td>
			</tr>
		</tbody>
	</table><br />
	
	<h3><?php echo __('New Password');?></h3>
	
	<p class="fontMedium"><?php echo __("Because Nova uses a new method of securiing passwords, I need to reset all of the passwords in the system. Tell me what you want the password to be (and make sure you remember to tell all your users what it is). This password is case-sensitive and users will be prompted to change their password the first time they log in.");?></p>
	
	<p><?php echo form::input('password', 'default');?></p>
	
	<h3><?php echo __('Admin Rights');?></h3>
	
	<p class="fontMedium"><?php echo __("Nova uses a role-based system for determining permissions, but since it's incompatible with SMS, you'll need to tell me the email addresses of the people who should have system administrator privileges. It's best to keep this list as limited as possible right now. You'll be able to add or remove people from roles once Nova is installed.");?></p>
	
	<p><?php echo form::textarea('admins');?></p>