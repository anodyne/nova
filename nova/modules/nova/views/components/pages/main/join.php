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

?><form method="post">
	<ul class="nav nav-pills">
		<li class="active"><a href="#user" data-toggle="pill"><?php echo lang('user info', 2);?></a></li>
		<li><a href="#character" data-toggle="pill"><?php echo lang('character info', 2);?></a></li>
	</ul>

	<div class="pill-content">
		<div id="user" class="pill-pane active">
			<div class="row">
				<div id="userInfo" class="span6">
					<div class="alert alert-info alert-block hide">
						<h4><?php echo lang('short.welcome_back', 2);?></h4>
						<p><?php echo lang('[[short.join_user_found|user|character|game_master]]');?></p>
					</div>

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
							<input type="text" name="user[password]" class="span4">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label"><?php echo lang('action.confirm password', 2);?></label>
						<div class="controls">
							<input type="text" name="user[confirm_password]" class="span4">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label"><?php echo lang('simming experience', 2);?></label>
						<div class="controls">
							<textarea name="app[experience]" rows="5" class="span5"></textarea>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label"><?php echo lang('short.hear_about_us.question', 2);?></label>
						<div class="controls">
							<select name="app[hear_about]" id="hearAbout" class="span5">
								<option value=""></option>
								<option value="<?php echo lang('short.hear_about_us.friend', 1);?>"><?php echo lang('short.hear_about_us.friend', 1);?></option>
								<option value="<?php echo lang('short.hear_about_us.member', 2);?>"><?php echo lang('short.hear_about_us.member', 2);?></option>
								<option value="<?php echo lang('short.hear_about_us.org', 1);?>"><?php echo lang('short.hear_about_us.org', 1);?></option>
								<option value="<?php echo lang('short.hear_about_us.ad', 1);?>"><?php echo lang('short.hear_about_us.ad', 1);?></option>
								<option value="<?php echo lang('short.hear_about_us.search', 2);?>"><?php echo lang('short.hear_about_us.search', 2);?></option>
								<option value="<?php echo lang('short.hear_about_us.other', 1);?>"><?php echo lang('short.hear_about_us.other', 1);?></option>
							</select>
						</div>
					</div>

					<div class="control-group hide">
						<label class="control-label"><?php echo lang('short.hear_about_us.detail', 2);?></label>
						<div class="controls">
							<input type="text" name="app[hear_about_detail]" class="span5">
						</div>
					</div>

					<input type="hidden" name="user[id]" value="0">
				</div>

				<div id="userForm" class="span6"><?php echo $user;?></div>
			</div>
		</div>

		<div id="character" class="pill-pane"><?php echo $character;?></div>
	</div>

	<div class="controls">
		<button class="btn btn-primary" name="submit"><?php echo lang('action.submit', 1);?></button>
	</div>
</form>