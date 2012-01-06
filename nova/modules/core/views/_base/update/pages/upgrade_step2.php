<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<p class="fontMedium"><?php echo $message;?></p>

<hr />

<?php echo form_open('upgrade/step/3');?>
	<table class="table100 zebra fontMedium">
		<thead>
			<tr>
				<th>Items to Upgrade</th>
				<th class="col-30">Status</th>
		</thead>
		<tbody>
			<tr>
				<td class="bold">Update User Ranks &amp; Skin Defaults</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo img(MODFOLDER.'/core/views/_base/update/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo img(array('src' => MODFOLDER.'/core/views/_base/update/images/exclamation-red.png', 'class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="loading hidden"><?php echo img(MODFOLDER.'/core/views/_base/update/images/loading-circle-large.gif');?></span>
				</td>
			</tr>
			<tr>
				<td class="bold">Update Welcome Page</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo img(MODFOLDER.'/core/views/_base/update/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo img(array('src' => MODFOLDER.'/core/views/_base/update/images/exclamation-red.png', 'class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="loading hidden"><?php echo img(MODFOLDER.'/core/views/_base/update/images/loading-circle-large.gif');?></span>
				</td>
			</tr>
			<tr>
				<td class="bold">Install Additional Ranks &amp; Skins</td>
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
			</tr>
			<tr>
				<td class="bold">Update News Items with New User IDs</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo img(MODFOLDER.'/core/views/_base/update/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo img(array('src' => MODFOLDER.'/core/views/_base/update/images/exclamation-red.png', 'class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="loading hidden"><?php echo img(MODFOLDER.'/core/views/_base/update/images/loading-circle-large.gif');?></span>
				</td>
			</tr>
			<tr>
				<td class="bold">Update Personal Logs with New User IDs</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo img(MODFOLDER.'/core/views/_base/update/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo img(array('src' => MODFOLDER.'/core/views/_base/update/images/exclamation-red.png', 'class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="loading hidden"><?php echo img(MODFOLDER.'/core/views/_base/update/images/loading-circle-large.gif');?></span>
				</td>
			</tr>
			<tr>
				<td class="bold">Update Mission Posts with New User IDs</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo img(MODFOLDER.'/core/views/_base/update/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo img(array('src' => MODFOLDER.'/core/views/_base/update/images/exclamation-red.png', 'class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="loading hidden"><?php echo img(MODFOLDER.'/core/views/_base/update/images/loading-circle-large.gif');?></span>
				</td>
			</tr>
			<tr>
				<td class="bold">Update Given Awards</td>
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
			</tr>
		</tbody>
	</table>