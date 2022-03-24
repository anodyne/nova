<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<p class="fontMedium"><?php echo $label['message'];?></p>

<hr />

<?php echo form_open('upgrade/step/2');?>
	<table class="table100 zebra fontMedium">
		<thead>
			<tr>
				<th colspan="2">Items to Upgrade</th>
				<th class="col-100">Yes</th>
				<th class="col-100">No</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="bold">Characters &amp; Users</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo img(MODFOLDER.'/core/views/_base/update/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo img(array('src' => MODFOLDER.'/core/views/_base/update/images/exclamation-red.png', 'class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="warning hidden">
						<?php echo img(array('src' => MODFOLDER.'/core/views/_base/update/images/exclamation.png', 'class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="loading hidden"><?php echo img(MODFOLDER.'/core/views/_base/update/images/loading-circle-large.gif');?></span>
				</td>
				<td class="align-center"><?php echo form_radio('upgrade_characters_users', 1, true);?></td>
				<td class="align-center"><?php echo form_radio('upgrade_characters_users', 0);?></td>
			</tr>
			<tr>
				<td class="bold">Awards</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo img(MODFOLDER.'/core/views/_base/update/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo img(array('src' => MODFOLDER.'/core/views/_base/update/images/exclamation-red.png', 'class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="loading hidden"><?php echo img(MODFOLDER.'/core/views/_base/update/images/loading-circle-large.gif');?></span>
				</td>
				<td class="align-center"><?php echo form_radio('upgrade_awards', 1, true);?></td>
				<td class="align-center"><?php echo form_radio('upgrade_awards', 0);?></td>
			</tr>
			<tr>
				<td class="bold">System Settings &amp; Messages</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo img(MODFOLDER.'/core/views/_base/update/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo img(array('src' => MODFOLDER.'/core/views/_base/update/images/exclamation-red.png', 'class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="warning hidden">
						<?php echo img(array('src' => MODFOLDER.'/core/views/_base/update/images/exclamation.png', 'class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="loading hidden"><?php echo img(MODFOLDER.'/core/views/_base/update/images/loading-circle-large.gif');?></span>
				</td>
				<td class="align-center"><?php echo form_radio('upgrade_settings', 1, true);?></td>
				<td class="align-center"><?php echo form_radio('upgrade_settings', 0);?></td>
			</tr>
			<tr>
				<td class="bold">Personal Logs</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo img(MODFOLDER.'/core/views/_base/update/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo img(array('src' => MODFOLDER.'/core/views/_base/update/images/exclamation-red.png', 'class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="warning hidden">
						<?php echo img(array('src' => MODFOLDER.'/core/views/_base/update/images/exclamation.png', 'class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="loading hidden"><?php echo img(MODFOLDER.'/core/views/_base/update/images/loading-circle-large.gif');?></span>
				</td>
				<td class="align-center"><?php echo form_radio('upgrade_logs', 1, true);?></td>
				<td class="align-center"><?php echo form_radio('upgrade_logs', 0);?></td>
			</tr>
			<tr>
				<td class="bold">News Items &amp; Categories</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo img(MODFOLDER.'/core/views/_base/update/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo img(array('src' => MODFOLDER.'/core/views/_base/update/images/exclamation-red.png', 'class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="warning hidden">
						<?php echo img(array('src' => MODFOLDER.'/core/views/_base/update/images/exclamation.png', 'class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="loading hidden"><?php echo img(MODFOLDER.'/core/views/_base/update/images/loading-circle-large.gif');?></span>
				</td>
				<td class="align-center"><?php echo form_radio('upgrade_news', 1, true);?></td>
				<td class="align-center"><?php echo form_radio('upgrade_news', 0);?></td>
			</tr>
			<tr>
				<td class="bold">Missions &amp; Mission Posts</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo img(MODFOLDER.'/core/views/_base/update/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo img(array('src' => MODFOLDER.'/core/views/_base/update/images/exclamation-red.png', 'class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="warning hidden">
						<?php echo img(array('src' => MODFOLDER.'/core/views/_base/update/images/exclamation.png', 'class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="loading hidden"><?php echo img(MODFOLDER.'/core/views/_base/update/images/loading-circle-large.gif');?></span>
				</td>
				<td class="align-center"><?php echo form_radio('upgrade_missions', 1, true);?></td>
				<td class="align-center"><?php echo form_radio('upgrade_missions', 0);?></td>
			</tr>
			<tr>
				<td class="bold">Database Entries</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo img(MODFOLDER.'/core/views/_base/update/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo img(array('src' => MODFOLDER.'/core/views/_base/update/images/exclamation-red.png', 'class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="warning hidden">
						<?php echo img(array('src' => MODFOLDER.'/core/views/_base/update/images/exclamation.png', 'class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="loading hidden"><?php echo img(MODFOLDER.'/core/views/_base/update/images/loading-circle-large.gif');?></span>
				</td>
				<td class="align-center"><?php echo form_radio('upgrade_database', 1, true);?></td>
				<td class="align-center"><?php echo form_radio('upgrade_database', 0);?></td>
			</tr>
			<tr>
				<td class="bold">Specifications</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo img(MODFOLDER.'/core/views/_base/update/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo img(array('src' => MODFOLDER.'/core/views/_base/update/images/exclamation-red.png', 'class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="warning hidden">
						<?php echo img(array('src' => MODFOLDER.'/core/views/_base/update/images/exclamation.png', 'class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="loading hidden"><?php echo img(MODFOLDER.'/core/views/_base/update/images/loading-circle-large.gif');?></span>
				</td>
				<td class="align-center"><?php echo form_radio('upgrade_specs', 1, true);?></td>
				<td class="align-center"><?php echo form_radio('upgrade_specs', 0);?></td>
			</tr>
			<tr>
				<td class="bold">Tour Items</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo img(MODFOLDER.'/core/views/_base/update/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo img(array('src' => MODFOLDER.'/core/views/_base/update/images/exclamation-red.png', 'class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="warning hidden">
						<?php echo img(array('src' => MODFOLDER.'/core/views/_base/update/images/exclamation.png', 'class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="loading hidden"><?php echo img(MODFOLDER.'/core/views/_base/update/images/loading-circle-large.gif');?></span>
				</td>
				<td class="align-center"><?php echo form_radio('upgrade_tour', 1, true);?></td>
				<td class="align-center"><?php echo form_radio('upgrade_tour', 0);?></td>
			</tr>
		</tbody>
	</table><br />