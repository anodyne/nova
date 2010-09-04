<p class="fontMedium"><?php echo __("step2.text");?></p>

<hr />

<?php echo form::open('update/nova1/2');?>
	<table class="table100 zebra">
		<thead>
			<tr>
				<th><?php echo __('Items to Update');?></th>
				<th class="col-30">Status</th>
		</thead>
		<tbody>
			<tr>
				<td class="fontMedium bold"><?php echo __('Update Users');?></td>
				<td class="col-30 align-center">
					<span class="success hidden"><?php echo html::image(MODFOLDER.'/nova/update/views/update/images/tick-circle.png');?></span>
					<span class="failure hidden">
						<?php echo html::image(MODFOLDER.'/nova/update/views/update/images/exclamation-red.png', array('title' => ''));?>
					</span>
					<span class="warning hidden">
						<?php echo html::image(MODFOLDER.'/nova/update/views/update/images/exclamation.png', array('title' => ''));?>
					</span>
					<span class="loading hidden"><?php echo html::image(MODFOLDER.'/nova/update/views/update/images/loading-circle-large.gif');?></span>
				</td>
			</tr>
		</tbody>
	</table>