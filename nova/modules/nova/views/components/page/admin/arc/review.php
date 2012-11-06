<div class="btn-group">
	<a href="<?php echo Uri::create('admin/application/index');?>" class="btn icn16 tooltip-top" title="<?php echo lang('action.back to index', 1);?>"><div class="icn icn-75" data-icon="<"></div></a>
</div>

<div class="row">
	<div class="span10">
		<div class="well well-small">
			<h2><?php echo $app->character->getName(false);?> <small><?php echo $app->position->name;?></small></h2>

			<p>
				<strong><?php echo lang('[[short.arc.involved|users]]', 1);?>:</strong>
				<?php echo $reviewerString;?>
			</p>

			<?php if ($app->status == Status::IN_PROGRESS): ?>
				<hr>

				<form method="post">
					<div class="control-group">
						<div class="controls">
							<textarea name="content" rows="5" class="span9" placeholder="<?php echo lang('[[short.arc.add_comment|comments|application]]');?>"></textarea>
						</div>
					</div>

					<div class="controls=">
						<button class="btn btn-small"><?php echo lang('action.submit', 1);?></button>
					</div>

					<?php echo Form::hidden('action', 'comment');?>
					<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
				</form>
			<?php endif;?>
		</div>
	</div>

	<div class="span2">
		<?php if ($app->status == Status::IN_PROGRESS): ?>
			<form method="post">
				<div class="btn-group btn-group-vertical btn-block">
					<button name="vote[yes]" class="btn btn-success icn16 tooltip-top" title="<?php echo lang('vote yes', 1);?>"><div class="icn" data-icon="."></div></a>
					<button name="vote[no]" class="btn btn-danger icn16 tooltip-top" title="<?php echo lang('vote no', 1);?>"><div class="icn" data-icon="/"></div></a>
				</div>

				<?php echo Form::hidden('action', 'vote');?>
				<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
			</form>
		<?php else: ?>
			<?php if ($app->status == Status::APPROVED): ?>
				<p class="alert alert-success">
			<?php elseif ($app->status == Status::REJECTED): ?>
				<p class="alert alert-danger">
			<?php endif;?>

			<strong><?php echo ucwords(Status::toString($app->status));?></strong></p>
		<?php endif;?>

		<?php if ($votes->mine): ?>
			<div class="control-group">
				<label class="control-label"><?php echo lang('your vote', 2);?></label>
				<p class="help-block"><?php echo ucfirst($votes->mine->content);?></p>
			</div>
		<?php endif;?>

		<?php if ($votes->yes > 0 or $votes->no > 0): ?>
			<hr>
		<?php endif;?>

		<?php if ($votes->yes > 0): ?>
			<div class="control-group success">
				<label class="control-label"><?php echo lang('yes', 1);?></label>
				<p class="help-block">
					<?php echo ceil(($votes->yes/$votes->all) * 100);?>%
					(<?php echo $votes->yes;?>
					<?php if ($votes->yes == 1): echo lang('vote'); else: echo lang('votes'); endif;?>)
				</p>
			</div>
		<?php endif;?>

		<?php if ($votes->no > 0): ?>
			<div class="control-group error">
				<label class="control-label"><?php echo lang('no', 1);?></label>
				<p class="help-block">
					<?php echo floor(($votes->no/$votes->all) * 100);?>%
					(<?php echo $votes->no;?>
					<?php if ($votes->no == 1): echo lang('vote'); else: echo lang('votes'); endif;?>)
				</p>
			</div>
		<?php endif;?>
	</div>
</div>

<ul class="nav nav-pills">
	<li class="active"><a href="#reviewHistory" data-toggle="pill"><?php echo lang('review history', 2);?></a></li>
	<li><a href="#characterForm" data-toggle="pill"><?php echo lang('character bio', 2);?></a></li>
	
	<?php if (Sentry::user()->hasLevel('character.create', 2)): ?>
		<li><a href="#userForm" data-toggle="pill"><?php echo lang('user info', 2);?></a></li>
	<?php endif;?>
	
	<?php if ( ! empty($samplePost)): ?>
		<li><a href="#samplePost" data-toggle="pill"><?php echo lang('sample_post', 2);?></a></li>
	<?php endif;?>

	<?php if (Sentry::user()->hasLevel('character.create', 2) and $app->status == Status::IN_PROGRESS): ?>
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
				<?php elseif ($res->type == \Model_Application_Response::EMAIL): ?>
					<div class="alert alert-block">
						<h4 class="alert-heading"><?php echo lang('action.email to applicant', 2);?></h4>
						<?php echo Markdown::parse($res->content);?>
					</div>
				<?php endif;?>
			<?php endforeach;?>
		<?php else: ?>
			<p class="alert"><?php echo lang('[[error.not_found|application review history]]');?></p>
		<?php endif;?>
	</div>

	<div id="characterForm" class="pill-pane"><?php echo $characterForm;?></div>

	<?php if (Sentry::user()->hasLevel('character.create', 2)): ?>
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
							<p><?php echo $applied_date;?></p>
						</div>
					</div>

					<?php echo $appForm;?>
				</div>

				<div class="span6"><?php echo $userForm;?></div>
			</div>
		</div>

		<?php if ($app->status == Status::IN_PROGRESS): ?>
			<div id="admin" class="pill-pane">
				<div class="tabbable tabs-left">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#adminUsers" data-toggle="tab"><?php echo lang('review participants', 2);?></a></li>
						<li><a href="#adminEmail" data-toggle="tab"><?php echo lang('action.email applicant', 2);?></a></li>
						<li><a href="#adminResponse" data-toggle="tab"><?php echo lang('final response', 2);?></a></li>
					</ul>

					<div class="tab-content">
						<div id="adminUsers" class="tab-pane active">
							<form method="post">
								<div class="control-group">
									<div class="controls">
										<?php echo NovaForm::users('reviewUsers[]', $reviewerArray, array('class' => 'span6 chzn', 'multiple' => 'multiple'));?>
										<p class="help-block"><?php echo lang('short.arc.admin.users');?></p>
									</div>
								</div>

								<div class="controls">
									<?php echo Form::hidden('action', 'users');?>
									<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>

									<button type="submit" class="btn btn-primary"><?php echo lang('action.update', 1);?></button>
								</div>
							</form>
						</div>

						<div id="adminEmail" class="tab-pane">
							<p><?php echo lang('short.arc.email');?></p>

							<form method="post">
								<div class="control-group">
									<label class="control-label"><?php echo lang('message', 1);?></label>
									<div class="controls">
										<textarea name="message" class="span8" rows="10"></textarea>
									</div>
								</div>

								<div class="controls">
									<?php echo Form::hidden('action', 'email');?>
									<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>

									<button type="submit" class="btn btn-primary"><?php echo lang('action.send', 2);?></button>
								</div>
							</form>
						</div>

						<div id="adminResponse" class="tab-pane">
							<form method="post">
								<div class="control-group">
									<label class="control-label"><?php echo lang('decision', 1);?></label>
									<div class="controls">
										<?php echo Form::select('decision', false, array('approve' => lang('action.approve', 1), 'reject' => lang('action.reject', 1)), array('class' => 'span2', 'id' => 'decisionDrop'));?>
									</div>
								</div>

								<div id="approveOptions">
									<?php echo NovaForm::position('position', $app->position->id, array(), 'open_playing');?>

									<?php echo NovaForm::rank('rank');?>

									<?php echo NovaForm::roles('role', Model_Access_Role::ACTIVE);?>
								</div>

								<div class="control-group">
									<label class="control-label"><?php echo lang('message', 1);?></label>
									<div class="controls">
										<textarea name="message" class="span8" rows="10"><?php echo Model_SiteContent::getContent("accept_message");?></textarea>
									</div>
								</div>

								<div class="controls">
									<?php echo Form::hidden('action', 'decision');?>
									<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>

									<button type="submit" class="btn btn-primary"><?php echo lang('action.send response', 2);?></button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		<?php endif;?>
	<?php endif;?>

	<?php if ( ! empty($samplePost)): ?>
		<div id="samplePost" class="pill-pane">
			<p><strong><?php echo $samplePost;?></strong></p>
			<?php echo Markdown::parse($app->sample_post);?>
		</div>
	<?php endif;?>
</div>