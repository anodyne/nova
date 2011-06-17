<p>So how about a little update? So far, I've been able to create all of the Nova database tables, put the basic data into the tables and put all the data from the items you selected into the Nova tables. Now, I need to upgrade a bunch of that data to the Nova format.</p>

<hr>

<?php echo Form::open('setup/sms/step/3');?>
	<table class="table100 zebra">
		<thead>
			<tr>
				<th>Items to Upgrade</th>
				<th class="col-30">Status</th>
		</thead>
		<tbody>
			<tr>
				<td class="fontMedium bold">Update User Ranks &amp; Skin Defaults</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo html::image(MODFOLDER.'/app/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation-red.png', array('class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="loading hidden"><?php echo html::image(MODFOLDER.'/app/modules/setup/views/design/images/loading.gif');?></span>
				</td>
			</tr>
			<tr>
				<td class="fontMedium bold">Update Welcome Page</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo html::image(MODFOLDER.'/app/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation-red.png', array('class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="loading hidden"><?php echo html::image(MODFOLDER.'/app/modules/setup/views/design/images/loading.gif');?></span>
				</td>
			</tr>
			<tr>
				<td class="fontMedium bold">Install Additional Ranks &amp; Skins</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo html::image(MODFOLDER.'/app/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation-red.png', array('class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="warning hidden">
						<?php echo html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation.png', array('class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="loading hidden"><?php echo html::image(MODFOLDER.'/app/modules/setup/views/design/images/loading.gif');?></span>
				</td>
			</tr>
			<tr>
				<td class="fontMedium bold">Update News Items with New User IDs</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo html::image(MODFOLDER.'/app/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation-red.png', array('class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="loading hidden"><?php echo html::image(MODFOLDER.'/app/modules/setup/views/design/images/loading.gif');?></span>
				</td>
			</tr>
			<tr>
				<td class="fontMedium bold">Update Personal Logs with New User IDs</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo html::image(MODFOLDER.'/app/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation-red.png', array('class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="loading hidden"><?php echo html::image(MODFOLDER.'/app/modules/setup/views/design/images/loading.gif');?></span>
				</td>
			</tr>
			<tr>
				<td class="fontMedium bold">Update Mission Posts with New User IDs</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo html::image(MODFOLDER.'/app/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation-red.png', array('class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="loading hidden"><?php echo html::image(MODFOLDER.'/app/modules/setup/views/design/images/loading.gif');?></span>
				</td>
			</tr>
			<tr>
				<td class="fontMedium bold">Update Given Awards</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo html::image(MODFOLDER.'/app/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation-red.png', array('class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="warning hidden">
						<?php echo html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation.png', array('class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="loading hidden"><?php echo html::image(MODFOLDER.'/app/modules/setup/views/design/images/loading.gif');?></span>
				</td>
			</tr>
		</tbody>
	</table>