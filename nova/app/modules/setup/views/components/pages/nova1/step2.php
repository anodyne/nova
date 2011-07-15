<p>Nova gives you the ability to upgrade only the items you want. Using the list below, please select which items you want Nova to upgrade.</p>

<hr>

<?php echo Form::open('setup/nova1/step/3');?>
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
				<td>
					<strong class="fontMedium">Characters &amp; Users</strong>
					<strong class="fontSmall errors hidden error"><br><span class="errors-content"></span></strong>
				</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation-red.png');?></span>
					<span class="warning hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation.png');?></span>
					<span class="loading hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/loading.gif');?></span>
				</td>
				<td class="align-center"><?php echo Form::radio('upgrade_characters_users', 1, true);?></td>
				<td class="align-center"><?php echo Form::radio('upgrade_characters_users', 0);?></td>
			</tr>
			<tr>
				<td>
					<strong class="fontMedium">Awards</strong>
					<strong class="fontSmall errors hidden error"><br><span class="errors-content"></span></strong>
				</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation-red.png');?></span>
					<span class="warning hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation.png');?></span>
					<span class="loading hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/loading.gif');?></span>
				</td>
				<td class="align-center"><?php echo Form::radio('upgrade_awards', 1, true);?></td>
				<td class="align-center"><?php echo Form::radio('upgrade_awards', 0);?></td>
			</tr>
			<tr>
				<td>
					<strong class="fontMedium">System Settings, Messages &amp; Bans</strong>
					<strong class="fontSmall errors hidden error"><br><span class="errors-content"></span></strong>
				</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation-red.png');?></span>
					<span class="warning hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation.png');?></span>
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
				<td class="fontMedium bold">News</td>
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
				<td class="fontMedium bold">Missions &amp; Posts</td>
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
			<tr>
				<td class="fontMedium bold">Docking Items (if applicable)</td>
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
				<td class="align-center"><?php echo Form::radio('upgrade_docking', 1, true);?></td>
				<td class="align-center"><?php echo Form::radio('upgrade_docking', 0);?></td>
			</tr>
			<tr>
				<td class="fontMedium bold">Wiki Pages</td>
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
				<td class="align-center"><?php echo Form::radio('upgrade_wiki', 1, true);?></td>
				<td class="align-center"><?php echo Form::radio('upgrade_wiki', 0);?></td>
			</tr>
			<tr>
				<td class="fontMedium bold">Uploads</td>
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
				<td class="align-center"><?php echo Form::radio('upgrade_uploads', 1, true);?></td>
				<td class="align-center"><?php echo Form::radio('upgrade_uploads', 0);?></td>
			</tr>
		</tbody>
	</table>