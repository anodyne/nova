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
					<span class="success hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/tick-circle.png');?></span>
					<span class="failure hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/exclamation-red.png');?></span>
					<span class="loading hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/loading-circle-large.gif');?></span>
				</td>
				<td class="align-center"><?php echo form::radio('upgrade_characters_users', 1, TRUE);?></td>
				<td class="align-center"><?php echo form::radio('upgrade_characters_users', 0);?></td>
			</tr>
			<tr>
				<td class="fontMedium bold"><?php echo __('Awards');?></td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/exclamation-red.png', array('class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="loading hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/loading-circle-large.gif');?></span>
				</td>
				<td class="align-center"><?php echo form::radio('upgrade_awards', 1, TRUE);?></td>
				<td class="align-center"><?php echo form::radio('upgrade_awards', 0);?></td>
			</tr>
			<tr>
				<td class="fontMedium bold"><?php echo __('System Settings &amp; Messages');?></td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/exclamation-red.png', array('class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="warning hidden">
						<?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/exclamation.png', array('class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="loading hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/loading-circle-large.gif');?></span>
				</td>
				<td class="align-center"><?php echo form::radio('upgrade_settings', 1, TRUE);?></td>
				<td class="align-center"><?php echo form::radio('upgrade_settings', 0);?></td>
			</tr>
			<tr>
				<td class="fontMedium bold"><?php echo __('Personal Logs');?></td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/tick-circle.png');?></span>
					<span class="failure hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/exclamation-red.png');?></span>
					<span class="loading hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/loading-circle-large.gif');?></span>
				</td>
				<td class="align-center"><?php echo form::radio('upgrade_logs', 1, TRUE);?></td>
				<td class="align-center"><?php echo form::radio('upgrade_logs', 0);?></td>
			</tr>
			<tr>
				<td class="fontMedium bold"><?php echo __('News Items &amp; Categories');?></td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/tick-circle.png');?></span>
					<span class="failure hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/exclamation-red.png');?></span>
					<span class="loading hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/loading-circle-large.gif');?></span>
				</td>
				<td class="align-center"><?php echo form::radio('upgrade_news', 1, TRUE);?></td>
				<td class="align-center"><?php echo form::radio('upgrade_news', 0);?></td>
			</tr>
			<tr>
				<td class="fontMedium bold"><?php echo __('Missions &amp; Mission Posts');?></td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/tick-circle.png');?></span>
					<span class="failure hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/exclamation-red.png');?></span>
					<span class="loading hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/loading-circle-large.gif');?></span>
				</td>
				<td class="align-center"><?php echo form::radio('upgrade_missions', 1, TRUE);?></td>
				<td class="align-center"><?php echo form::radio('upgrade_missions', 0);?></td>
			</tr>
			<tr>
				<td class="fontMedium bold"><?php echo __('Specifications');?></td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/tick-circle.png');?></span>
					<span class="failure hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/exclamation-red.png');?></span>
					<span class="loading hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/loading-circle-large.gif');?></span>
				</td>
				<td class="align-center"><?php echo form::radio('upgrade_specs', 1, TRUE);?></td>
				<td class="align-center"><?php echo form::radio('upgrade_specs', 0);?></td>
			</tr>
			<tr>
				<td class="fontMedium bold"><?php echo __('Tour Items');?></td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/tick-circle.png');?></span>
					<span class="failure hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/exclamation-red.png');?></span>
					<span class="loading hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/loading-circle-large.gif');?></span>
				</td>
				<td class="align-center"><?php echo form::radio('upgrade_tour', 1, TRUE);?></td>
				<td class="align-center"><?php echo form::radio('upgrade_tour', 0);?></td>
			</tr>
		</tbody>
	</table>