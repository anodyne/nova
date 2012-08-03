<div class="well well-small">
	<h2><?php echo $app->character->name(false);?> <small><?php echo $app->position->name;?></small></h2>

	<p>
		<strong><?php echo lang('[[short.arc.involved|users]]', 1);?>:</strong>
		<?php echo $reviewerString;?>
	</p>

	<hr>

	<div class="row">
		<div class="span10">
			<div class="control-group">
				<div class="controls">
					<textarea name="content" rows="5" class="span10" placeholder="Enter your comments on this application here"></textarea>
				</div>
			</div>
		</div>

		<div class="span1">
			<div class="btn-group btn-group-vertical btn-block">
				<button class="btn btn-small"><i class="icon-comment icon-50"></i></button>
				<button class="btn btn-small btn-success"><i class="icon-thumbs-up icon-white"></i></button>
				<button class="btn btn-small btn-danger"><i class="icon-thumbs-down icon-white"></i></button>
			</div>
		</div>
	</div>
</div>

<ul class="nav nav-pills">
	<li class="active"><a href="#reviewHistory" data-toggle="pill"><?php echo lang('review history', 2);?></a></li>
	<li><a href="#characterForm" data-toggle="pill"><?php echo lang('character bio', 2);?></a></li>
	
	<?php if (Sentry::user()->has_level('character.create', 2)): ?>
		<li><a href="#userForm" data-toggle="pill"><?php echo lang('user info', 2);?></a></li>
	<?php endif;?>
	
	<?php if ( ! empty($samplePost)): ?>
		<li><a href="#samplePost" data-toggle="pill"><?php echo lang('sample_post', 2);?></a></li>
	<?php endif;?>

	<?php if (Sentry::user()->has_level('character.create', 2)): ?>
		<li><a href="#admin" data-toggle="pill"><?php echo lang('admin', 1);?></a></li>
	<?php endif;?>
</ul>

<div class="pill-content">
	<div id="reviewHistory" class="pill-pane active">
		<?php if (count($responses) > 0): ?>
			<?php foreach ($responses as $res): ?>
				<?php if ($res->type == \Model_Application_Response::COMMENT): ?>
					<blockquote>
						<?php echo Markdown::parse($res->content);?>
						<small><?php echo $res->user->name;?></small>
					</blockquote>
				<?php elseif ($res->type == \Model_Application_Response::VOTE): ?>
					<?php if ($res->content == 'yes'): ?>
						<p class="alert alert-success"><?php echo lang('[[short.arc.voted|{{'.$res->user->name.'}}|yes]]');?></p>
					<?php else: ?>
						<p class="alert alert-danger"><?php echo lang('[[short.arc.voted|{{'.$res->user->name.'}}|no]]');?></p>
					<?php endif;?>
				<?php elseif ($res->type == \Model_Application_Response::RESPONSE): ?>
					<div class="alert alert-block alert-info">
						<h4 class="alert-heading"><?php echo lang('final response', 2);?></h4>
						<?php echo Markdown::parse($res->content);?>
					</div>
				<?php endif;?>
			<?php endforeach;?>
		<?php else: ?>
			<p class="alert"><?php echo lang('[[error.not_found|application review history]]');?></p>
		<?php endif;?>
	</div>

	<div id="characterForm" class="pill-pane"><?php echo $characterForm;?></div>

	<?php if (Sentry::user()->has_level('character.create', 2)): ?>
		<div id="userForm" class="pill-pane">
			<div class="row">
				<div class="span6">
					<div class="control-group">
						<label class="control-label"><?php echo lang('name', 1);?></label>
						<div class="controls">
							<p><?php echo $app->user->name;?></p>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label"><?php echo lang('email_address', 2);?></label>
						<div class="controls">
							<p><?php echo $app->user->email;?></p>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label"><?php echo lang('action.applied on', 2);?></label>
						<div class="controls">
							<p><?php echo Date::forge($app->created_at)->format('eu_named');?></p>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label"><?php echo lang('simming experience', 2);?></label>
						<div class="controls">
							<p><?php echo $app->experience;?></p>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label"><?php echo lang('short.hear_about_us.question', 2);?></label>
						<div class="controls">
							<p>
								<?php echo $app->hear_about;?>

								<?php if ( ! empty($app->hear_about_detail)): ?>
									<br>
									<span class="muted"><?php echo $app->hear_about_detail;?></span>
								<?php endif;?>
							</p>
						</div>
					</div>
				</div>

				<div class="span6"><?php echo $userForm;?></div>
			</div>
		</div>

		<div id="admin" class="pill-pane">
			<div class="row">
				<div class="span6">
					<h4><?php echo lang('final response', 2);?></h4>

					<form method="post">
						<div class="control-group">
							<label class="control-label"><?php echo lang('decision', 1);?></label>
							<div class="controls">
								<?php echo Form::select('decision', false, array('approve' => lang('action.approve', 1), 'reject' => lang('action.reject', 1)), array('class' => 'span2'));?>
							</div>
						</div>

						<div class="hide">
							<div class="control-group">
								<label class="control-label"><?php echo lang('decision', 1);?></label>
								<div class="controls">
									<?php echo Form::select('decision', false, array('approve' => lang('action.approve', 1), 'reject' => lang('action.reject', 1)), array('class' => 'span2'));?>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label"><?php echo lang('decision', 1);?></label>
								<div class="controls">
									<?php echo Form::select('decision', false, array('approve' => lang('action.approve', 1), 'reject' => lang('action.reject', 1)), array('class' => 'span2'));?>
								</div>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label"><?php echo lang('message', 1);?></label>
							<div class="controls">
								<textarea name="message" class="span6" rows="10"></textarea>
							</div>
						</div>

						<div class="controls">
							<?php echo Form::hidden('action', 'decision');?>

							<button type="submit" class="btn btn-primary"><?php echo lang('action.send response', 2);?></button>
						</div>
					</form>
				</div>

				<div class="span6">
					<h4><?php echo lang('[[short.arc.involved|users]]', 2);?></h4>
					
					<form method="post">
						<div class="control-group">
							<div class="controls">
								<?php echo NovaForm::users('reviewUsers[]', $reviewerArray, array('class' => 'span6 chzn', 'multiple' => 'multiple'));?>
								<p class="help-block"><?php echo lang('short.arc.admin.users');?></p>
							</div>
						</div>

						<div class="controls">
							<?php echo Form::hidden('action', 'users');?>

							<button type="submit" class="btn btn-primary"><?php echo lang('action.update', 1);?></button>
						</div>
					</form>
				</div>
			</div>
		</div>
	<?php endif;?>

	<?php if ( ! empty($samplePost)): ?>
		<div id="samplePost" class="pill-pane">
			<p><strong><?php echo $samplePost;?></strong></p>
			<?php echo Markdown::parse($app->sample_post);?>
		</div>
	<?php endif;?>
</div>