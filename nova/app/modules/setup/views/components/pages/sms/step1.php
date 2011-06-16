<p>Nova gives you the ability to upgrade only the items you want from SMS. Using the list below, please select which items you want Nova to upgrade from the SMS format to the Nova format.</p>

<hr>

<?php echo Form::open('setup/sms/step/2');?>
	<table class="table100 zebra">
		<thead>
			<tr>
				<th colspan="2">Items to Upgrade</th>
				<th class="col-100">Yes</th>
				<th class="col-100">No</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="fontMedium bold">Characters &amp; Users</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation-red.png', array('class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="warning hidden">
						<?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/loading.gif');?>
					</span>
					<span class="loading hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/loading.gif');?></span>
				</td>
				<td class="align-center"><?php echo Form::radio('upgrade_characters_users', 1, true);?></td>
				<td class="align-center"><?php echo Form::radio('upgrade_characters_users', 0);?></td>
			</tr>
			<tr>
				<td class="fontMedium bold">Awards</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation-red.png', array('class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="loading hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/loading.gif');?></span>
				</td>
				<td class="align-center"><?php echo Form::radio('upgrade_awards', 1, true);?></td>
				<td class="align-center"><?php echo Form::radio('upgrade_awards', 0);?></td>
			</tr>
			<tr>
				<td class="fontMedium bold">System Settings &amp; Messages</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation-red.png', array('class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="warning hidden">
						<?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/loading.gif');?>
					</span>
					<span class="loading hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/loading.gif');?></span>
				</td>
				<td class="align-center"><?php echo Form::radio('upgrade_settings', 1, true);?></td>
				<td class="align-center"><?php echo Form::radio('upgrade_settings', 0);?></td>
			</tr>
			<tr>
				<td class="fontMedium bold">Personal Logs</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation-red.png', array('class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="warning hidden">
						<?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/loading.gif');?>
					</span>
					<span class="loading hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/loading.gif');?></span>
				</td>
				<td class="align-center"><?php echo Form::radio('upgrade_logs', 1, true);?></td>
				<td class="align-center"><?php echo Form::radio('upgrade_logs', 0);?></td>
			</tr>
			<tr>
				<td class="fontMedium bold">News Items &amp; Categories</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation-red.png', array('class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="warning hidden">
						<?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/loading.gif');?>
					</span>
					<span class="loading hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/loading.gif');?></span>
				</td>
				<td class="align-center"><?php echo Form::radio('upgrade_news', 1, true);?></td>
				<td class="align-center"><?php echo Form::radio('upgrade_news', 0);?></td>
			</tr>
			<tr>
				<td class="fontMedium bold">Missions &amp; Mission Posts</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation-red.png', array('class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="warning hidden">
						<?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/loading.gif');?>
					</span>
					<span class="loading hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/loading.gif');?></span>
				</td>
				<td class="align-center"><?php echo Form::radio('upgrade_missions', 1, true);?></td>
				<td class="align-center"><?php echo Form::radio('upgrade_missions', 0);?></td>
			</tr>
			<tr>
				<td class="fontMedium bold">Specifications</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation-red.png', array('class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="warning hidden">
						<?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/loading.gif');?>
					</span>
					<span class="loading hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/loading.gif');?></span>
				</td>
				<td class="align-center"><?php echo Form::radio('upgrade_specs', 1, true);?></td>
				<td class="align-center"><?php echo Form::radio('upgrade_specs', 0);?></td>
			</tr>
			<tr>
				<td class="fontMedium bold">Tour Items</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation-red.png', array('class' => 'tiptip', 'title' => ''));?>
					</span>
					<span class="warning hidden">
						<?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/loading.gif');?>
					</span>
					<span class="loading hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/loading.gif');?></span>
				</td>
				<td class="align-center"><?php echo Form::radio('upgrade_tour', 1, true);?></td>
				<td class="align-center"><?php echo Form::radio('upgrade_tour', 0);?></td>
			</tr>
		</tbody>
	</table>