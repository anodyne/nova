<div class="btn-toolbar">
	<?php if (Sentry::user()->has_access('user.read')): ?>
		<div class="btn-group">
			<a href="<?php echo Uri::create('admin/user/index');?>" class="btn tooltip-top" title="<?php echo lang('action.back to all users', 1);?>"><i class="icon-chevron-left icon-75"></i></a>
		</div>
	<?php endif;?>

	<div class="btn-group">
		<a href="#" class="btn tooltip-top" title="<?php echo lang('action.request loa', 1);?>"><i class="icon-briefcase icon-75"></i></a>
	</div>
</div>

<div class="row">
	<div class="span9">
		<ul class="nav nav-pills">
			<li class="active"><a href="#userInfo" data-toggle="pill"><?php echo lang('info', 1);?></a></li>
			<li><a href="#userPrefs" data-toggle="pill"><?php echo lang('preferences', 1);?></a></li>

			<?php if (Sentry::user()->has_level('user.update', 2)): ?>
				<li><a href="#userAdmin" data-toggle="pill"><?php echo lang('admin', 1);?></a></li>
			<?php endif;?>
		</ul>

		<div class="pill-content">
			<div id="userInfo" class="pill-pane active">
				<?php echo Form::open(array('id' => 'userInfoForm'));?>
					<fieldset>
						<legend><?php echo lang('basic info', 2);?></legend>

						<div class="control-group">
							<label class="control-label"><?php echo lang('name', 1);?></label>
							<div class="controls">
								<input type="text" name="basic[name]" class="span4" value="<?php echo $user->name;?>">
							</div>
						</div>

						<div class="control-group">
							<label class="control-label"><?php echo lang('email_address', 2);?></label>
							<div class="controls">
								<input type="email" name="basic[email]" class="span4" value="<?php echo $user->email;?>">
							</div>
						</div>

						<div class="row">
							<div class="span4">
								<div class="control-group">
									<label class="control-label"><?php echo lang('password', 1);?></label>
									<div class="controls">
										<input type="password" name="basic[password]" class="span4">
									</div>
								</div>
							</div>

							<div class="span4">
								<div class="control-group">
									<label class="control-label"><?php echo lang('action.confirm password', 2);?></label>
									<div class="controls">
										<input type="password" name="basic[confirm_password]" class="span4">
									</div>
								</div>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<legend><?php echo lang('user bio', 2);?></legend>

						<?php echo $userForm;?>
					</fieldset>

					<div class="controls">
						<button type="submit" class="btn btn-primary"><?php echo lang('action.submit', 1);?></button>
					</div>

					<?php echo Form::hidden('action', 'basic');?>
					<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
				<?php echo Form::close();?>
			</div>

			<div id="userPrefs" class="pill-pane">
				<?php echo Form::open();?>
					<fieldset>
						<legend><?php echo lang('general preferences', 2);?></legend>

						<div class="control-group">
							<label class="control-label"><?php echo lang('timezone', 1);?></label>
							<div class="controls">
							</div>
						</div>

						<div class="control-group">
							<label class="control-label"><?php echo lang('language', 1);?></label>
							<div class="controls">
							</div>
						</div>
					</fieldset>

					<fieldset>
						<legend><?php echo lang('email_short preferences', 2);?></legend>

						<div class="control-group">
							<label class="control-label"><?php echo lang('email_short format', 2);?></label>
							<div class="controls">
								<?php echo Form::select('email_format', $prefs['email_format'], array('html' => 'HTML', 'text' => lang('text', 1)), array('class' => 'span2'));?>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<legend><?php echo lang('site preferences', 2);?></legend>

						<div class="control-group">
							<label class="control-label"><?php echo lang('rank', 1);?></label>
							<div class="controls">
							</div>
						</div>

						<div class="control-group">
							<label class="control-label"><?php echo lang('main skin', 2);?></label>
							<div class="controls">

							</div>
						</div>

						<div class="control-group">
							<label class="control-label"><?php echo lang('admin skin', 2);?></label>
							<div class="controls">
							</div>
						</div>
					</fieldset>

					<div class="controls">
						<button type="submit" class="btn btn-primary"><?php echo lang('action.submit', 1);?></button>
					</div>

					<?php echo Form::hidden('action', 'preferences');?>
					<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
				<?php echo Form::close();?>
			</div>

			<?php if (Sentry::user()->has_level('user.update', 2)): ?>
				<div id="userAdmin" class="pill-pane"></div>
			<?php endif;?>
		</div>
	</div>

	<div class="span3">
		<ul class="thumbnails">
			<li class="span3"><a href="#" class="thumbnail"><img alt="" src="http://placehold.it/260x180"></a></li>
		</ul>
	</div>
</div>