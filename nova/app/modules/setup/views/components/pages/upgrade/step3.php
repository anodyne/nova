<p>So how about a little update? So far, I've been able to create all of the Nova database tables, put the basic data into the tables and migrate the majority of your data to the new format. Now, let's do a little cleanup and head in to the home stretch.</p>

<hr>

<?php echo Form::open('setup/upgrade/step/4');?>
	<table class="table100 zebra">
		<thead>
			<tr>
				<th>Items to Upgrade</th>
				<th class="col-30">Status</th>
		</thead>
		<tbody>
			<tr>
				<td>
					<strong class="fontMedium">Update User Defaults</strong>
					<strong class="fontSmall errors hidden error"><br><span class="errors-content"></span></strong>
				</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation-red.png');?></span>
					<span class="warning hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation.png');?></span>
					<span class="loading hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/loading.gif');?></span>
				</td>
			</tr>
			<tr>
				<td>
					<strong class="fontMedium">Create New Post Author Structure</strong>
					<strong class="fontSmall errors hidden error"><br><span class="errors-content"></span></strong>
				</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation-red.png');?></span>
					<span class="warning hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation.png');?></span>
					<span class="loading hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/loading.gif');?></span>
				</td>
			</tr>
			<tr>
				<td>
					<strong class="fontMedium">Setup System Administrators</strong>
					<strong class="fontSmall errors hidden error"><br><span class="errors-content"></span></strong>
				</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation-red.png');?></span>
					<span class="warning hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation.png');?></span>
					<span class="loading hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/loading.gif');?></span>
				</td>
			</tr>
			<tr>
				<td>
					<strong class="fontMedium">Reorganize the Database Schema</strong>
					<strong class="fontSmall errors hidden error"><br><span class="errors-content"></span></strong>
				</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation-red.png');?></span>
					<span class="warning hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation.png');?></span>
					<span class="loading hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/loading.gif');?></span>
				</td>
			</tr>
			<tr>
				<td>
					<strong class="fontMedium">Cache Site Content</strong>
					<strong class="fontSmall errors hidden error"><br><span class="errors-content"></span></strong>
				</td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation-red.png');?></span>
					<span class="warning hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation.png');?></span>
					<span class="loading hidden"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/loading.gif');?></span>
				</td>
			</tr>
		</tbody>
	</table>