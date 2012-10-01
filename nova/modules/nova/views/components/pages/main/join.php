<?php

if ( ! function_exists('joinData'))
{
	function joinData($field)
	{
		if (Sentry::check())
		{
			return Sentry::user()->{$field};
		}

		return false;
	}
}

?><form method="post" id="joinForm">
	<div class="btn-group pull-right hidden-phone">
		<a href="#" class="btn btn-small icn16 joinNavButton tooltip-top" data-direction="prev" title="<?php echo lang('previous step', 1);?>"><div class="icn icn-50" data-icon="<"></div></a>
		<a href="#" class="btn btn-small icn16 joinNavButton tooltip-top" data-direction="next" title="<?php echo lang('next step', 1);?>"><div class="icn icn-50" data-icon=">"></div></a>
	</div>

	<ul id="joinTabs" class="nav nav-pills">
		<li class="active"><a href="#user" data-toggle="pill"><?php echo lang('user info', 2);?></a></li>
		<li><a href="#characterInfo" data-toggle="pill"><?php echo lang('character info', 2);?></a></li>
		<li><a href="#characterForm" data-toggle="pill"><?php echo lang('character bio', 2);?></a></li>
		
		<?php if ( ! empty($samplePostContent)): ?>
			<li><a href="#samplePost" data-toggle="pill"><?php echo lang('sample_post', 2);?></a></li>
		<?php endif;?>
	</ul>

	<div class="pill-content">
		<div id="user" class="pill-pane active">
			<div class="alert alert-info alert-block">
				<h4><?php echo lang('short.please_note', 2);?></h4>
				<p><?php echo lang('[[short.join.user_info|user|name|email_address|sim]]', 1);?></p>
			</div>

			<div class="alert alert-info alert-block hide" id="welcomeBack">
				<h4><?php echo lang('short.join.welcome_back', 2);?></h4>
				<p><?php echo lang('[[short.join.user_found|user|character|game_master]]');?></p>
				<p><?php echo lang('[[short.join.user_form_reset|user]]');?></p>
			</div>

			<div class="row">
				<div id="userInfo" class="span6">
					<div class="control-group">
						<label class="control-label"><?php echo lang('email_address', 2);?></label>
						<div class="controls">
							<input type="email" name="user[email]" id="emailField" class="span4" value="<?php echo joinData('email');?>">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label"><?php echo lang('name', 1);?></label>
						<div class="controls">
							<input type="text" name="user[name]" class="span4" value="<?php echo joinData('name');?>">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label"><?php echo lang('password', 1);?></label>
						<div class="controls">
							<input type="password" name="user[password]" class="span4">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label"><?php echo lang('action.confirm password', 2);?></label>
						<div class="controls">
							<input type="password" name="user[confirm_password]" class="span4">
						</div>
					</div>

					<?php echo $appForm;?>
				</div>

				<div id="userForm" class="span6"><?php echo $user;?></div>
			</div>
		</div>

		<div id="characterInfo" class="pill-pane">
			<div class="row">
				<div class="span6">
					<div class="control-group">
						<label class="control-label"><?php echo lang('first name', 2);?></label>
						<div class="controls">
							<input type="text" name="character[first_name]" class="span4">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label"><?php echo lang('middle name', 2);?></label>
						<div class="controls">
							<input type="text" name="character[middle_name]" class="span4">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label"><?php echo lang('last name', 2);?></label>
						<div class="controls">
							<input type="text" name="character[last_name]" class="span4">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label"><?php echo lang('suffix', 1);?></label>
						<div class="controls">
							<input type="text" name="character[suffix]" class="span2">
						</div>
					</div>

					<?php echo NovaForm::position('position', array(), array(), 'open');?>
				</div>

				<div class="span6 muted"><?php echo $characterJoinHelp;?></div>
			</div>
		</div>

		<div id="characterForm" class="pill-pane"><?php echo $character;?></div>

		<?php if ( ! empty($samplePostContent)): ?>
			<div id="samplePost" class="pill-pane">
				<div class="control-group">
					<label class="control-label"><?php echo Markdown::parse($samplePostContent);?></label>
					<div class="controls">
						<textarea name="sample_post" rows="15" class="span12"></textarea>
					</div>
				</div>
			</div>
		<?php endif;?>
	</div>

	<div class="controls">
		<div class="btn-toolbar">
			<div class="btn-group">
				<button class="btn btn-primary" name="submit"><?php echo lang('action.submit', 1);?></button>
			</div>

			<div class="btn-group">
				<a href="#" class="btn btn-small icn16 joinNavButton tooltip-top" data-direction="prev" title="<?php echo lang('previous step', 1);?>"><div class="icn icn-50" data-icon="<"></div></a>
				<a href="#" class="btn btn-small icn16 joinNavButton tooltip-top" data-direction="next" title="<?php echo lang('next step', 1);?>"><div class="icn icn-50" data-icon=">"></div></a>
			</div>
		</div>
	</div>

	<input type="hidden" name="user[id]" value="0">
	<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
</form>