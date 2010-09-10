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
				<td class="fontMedium bold"><?php echo __('Users');?></td>
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
			<tr>
				<td class="fontMedium bold"><?php echo __('Characters, Bio Form &amp; Data');?></td>
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
			<tr>
				<td class="fontMedium bold"><?php echo __('Awards &amp; Received Award Records');?></td>
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
			<tr>
				<td class="fontMedium bold"><?php echo __('Missions &amp; Mission Groups');?></td>
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
			<tr>
				<td class="fontMedium bold"><?php echo __('Mission Posts &amp; Comments');?></td>
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
			<tr>
				<td class="fontMedium bold"><?php echo __('Personal Logs &amp; Comments');?></td>
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
			<tr>
				<td class="fontMedium bold"><?php echo __('News Items, Categories &amp; Comments');?></td>
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
			<tr>
				<td class="fontMedium bold"><?php echo __('Private Messages');?></td>
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
			<tr>
				<td class="fontMedium bold"><?php echo __('Tour Items, Tour Form &amp; Decks');?></td>
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
			<tr>
				<td class="fontMedium bold"><?php echo __('Specification Items &amp; Specifications Form');?></td>
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
			<tr>
				<td class="fontMedium bold"><?php echo __('Wiki Categories, Pages, Drafts &amp; Comments');?></td>
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
			<tr>
				<td class="fontMedium bold"><?php echo __('Settings &amp; Messages');?></td>
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
			<tr>
				<td class="fontMedium bold"><?php echo __('Application Records');?></td>
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
			<tr>
				<td class="fontMedium bold"><?php echo __('Uploads');?></td>
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
			<tr>
				<td class="fontMedium bold"><?php echo __('Docked Items &amp; Docking Form');?></td>
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