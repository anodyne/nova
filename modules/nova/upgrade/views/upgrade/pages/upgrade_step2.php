<p class="fontMedium"><?php echo __("step2.text");?></p>

<hr />

<?php echo form::open('upgrade/step/3');?>
	<table class="table100 zebra">
		<thead>
			<tr>
				<th><?php echo __('Items to Upgrade');?></th>
				<th class="col-30">Status</th>
		</thead>
		<tbody>
			<tr>
				<td class="fontMedium bold"><?php echo __('Update User Ranks &amp; Skin Defaults');?></td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/tick-circle.png');?></span>
					<span class="failure hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/exclamation-red.png');?></span>
					<span class="loading hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/loading-circle-large.gif');?></span>
				</td>
			</tr>
			<tr>
				<td class="fontMedium bold"><?php echo __('Update Welcome Page');?></td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/exclamation-red.png', array('title' => ''));?>
					</span>
					<span class="loading hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/loading-circle-large.gif');?></span>
				</td>
			</tr>
			<tr>
				<td class="fontMedium bold"><?php echo __('Install Additional Ranks &amp; Skins');?></td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/tick-circle.png');?></span>
					<span class="failure hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/exclamation-red.png');?></span>
					<span class="loading hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/loading-circle-large.gif');?></span>
				</td>
			</tr>
			<tr>
				<td class="fontMedium bold"><?php echo __('Update News Items with New User IDs');?></td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/tick-circle.png');?></span>
					<span class="failure hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/exclamation-red.png');?></span>
					<span class="loading hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/loading-circle-large.gif');?></span>
				</td>
			</tr>
			<tr>
				<td class="fontMedium bold"><?php echo __('Update Personal Logs with New User IDs');?></td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/tick-circle.png');?></span>
					<span class="failure hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/exclamation-red.png');?></span>
					<span class="loading hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/loading-circle-large.gif');?></span>
				</td>
			</tr>
			<tr>
				<td class="fontMedium bold"><?php echo __('Update Mission Posts with New User IDs');?></td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/tick-circle.png');?></span>
					<span class="failure hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/exclamation-red.png');?></span>
					<span class="loading hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/loading-circle-large.gif');?></span>
				</td>
			</tr>
			<tr>
				<td class="fontMedium bold"><?php echo __('Update Given Awards');?></td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/tick-circle.png');?></span>
					<span class="failure hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/exclamation-red.png');?></span>
					<span class="loading hidden"><?php echo html::image(MODFOLDER.'/nova/upgrade/views/upgrade/images/loading-circle-large.gif');?></span>
				</td>
			</tr>
		</tbody>
	</table>