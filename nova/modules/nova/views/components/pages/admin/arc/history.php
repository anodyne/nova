<div class="btn-group">
	<a href="<?php echo Uri::create('admin/application/index');?>" class="btn tooltip-top" title="<?php echo lang('action.back to index', 1);?>"><i class="icon-chevron-left icon-75"></i></a>
</div>
<br>

<?php if (isset($applications)): ?>
	<ul class="nav nav-tabs">
		<li><a href="#appInProgress" data-toggle="tab">In Progress</a></li>
		<li><a href="#appApproved" data-toggle="tab">Approved</a></li>
		<li><a href="#appRejected" data-toggle="tab">Rejected</a></li>
	</ul>

	<div class="tab-content">
		<div id="appInProgress" class="tab-pane">
			<?php if (isset($applications[\Model_Application::IN_PROGRESS])): ?>
				something
			<?php else: ?>
				<p class="alert"><?php echo lang('[[error.not_found|applications]]');?></p>
			<?php endif;?>
		</div>

		<div id="appApproved" class="tab-pane">
			<?php if (isset($applications[\Model_Application::APPROVED])): ?>
				something
			<?php else: ?>
				<p class="alert"><?php echo lang('[[error.not_found|applications]]');?></p>
			<?php endif;?>
		</div>

		<div id="appRejected" class="tab-pane">
			<?php if (isset($applications[\Model_Application::REJECTED])): ?>
				<table class="table table-striped">
					<tbody>
					<?php foreach ($applications[\Model_Application::REJECTED] as $a): ?>
						<tr>
							<td class="span2">
								<div class="btn-toolbar">
									<div class="btn-group">
										<a href="#" class="btn btn-small btn-danger tooltip-top" title="Ban user"><i class="icon-ban-circle icon-white"></i></a>
									</div>
								</div>
							</td>
						</tr>
					<?php endforeach;?>
					</tbody>
				</table>
			<?php else: ?>
				<p class="alert"><?php echo lang('[[error.not_found|applications]]');?></p>
			<?php endif;?>
		</div>
	</div>
<?php else: ?>
	<p class="alert"><?php echo lang('[[error.not_found|applications]]');?></p>
<?php endif;?>