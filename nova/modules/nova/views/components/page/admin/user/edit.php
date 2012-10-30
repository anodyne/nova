<div class="btn-toolbar">
	<?php if (Sentry::user()->hasAccess('user.read')): ?>
		<div class="btn-group">
			<a href="<?php echo Uri::create('admin/user/index');?>" class="btn icn16 tooltip-top" title="<?php echo lang('action.back to all users', 1);?>"><div class="icn icn-75" data-icon="<"></div></a>
		</div>
	<?php endif;?>

	<div class="btn-group">
		<a href="#" class="btn icn16 tooltip-top" title="<?php echo lang('action.request loa', 1);?>"><div class="icn icn-75" data-icon="!"></div></a>
	</div>
</div>

<div class="row">
	<div class="span9">
		<ul class="nav nav-pills">
			<li class="active"><a href="#userInfo" data-toggle="pill"><?php echo lang('info', 1);?></a></li>
			<li><a href="#userPrefs" data-toggle="pill"><?php echo lang('preferences', 1);?></a></li>

			<?php if (Sentry::user()->hasLevel('user.update', 2)): ?>
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
								<?php echo NovaForm::timezones('timezone', $prefs['timezone'], array('class' => 'span4'));?>
							</div>
						</div>

						<?php if (count(File::read_dir(APPPATH.'lang', 1, null)) > 1): ?>
							<div class="control-group">
								<label class="control-label"><?php echo lang('language', 1);?></label>
								<div class="controls">
									<?php echo NovaForm::languages('language', $prefs['language'], array('class' => 'span4'));?>
								</div>
							</div>
						<?php endif;?>
					</fieldset>

					<fieldset>
						<legend><?php echo lang('site preferences', 2);?></legend>

						<div class="row">
							<div class="span4">
								<div class="control-group">
									<label class="control-label"><?php echo lang('rank', 1);?></label>
									<div class="controls">
										<?php echo Form::select('rank', $prefs['rank'], $ranks, array('class' => 'span4', 'id' => 'rankSet'));?>
									</div>
								</div>
							</div>
							<div class="span4">
								<label class="control-label">&nbsp;</label>
								<div id="rankImage"><?php Request::forge('ajax/info/rank_preview/'.$prefs['rank'])->execute();?></div>
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

					<fieldset>
						<legend><?php echo lang('email_short and email_short notification preferences', 2);?></legend>

						<div class="control-group">
							<label class="control-label"><?php echo lang('email_short format', 2);?></label>
							<div class="controls">
								<?php echo Form::select('email_format', $prefs['email_format'], array('html' => 'HTML', 'text' => lang('text', 1)), array('class' => 'span2'));?>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label"><?php echo lang('comments', 1);?> <span class="icn icn-50 tooltip-right" data-icon="?" title="<?php echo lang('[[email.help.notify_comments|comment|mission_post|personal_log|announcement]]');?>"></span></label>
							<div class="controls">
								<label class="radio inline">
									<?php echo Form::radio('email_comments', 1, $prefs['email_comments']).' '.lang('yes', 1);?>
								</label>
								<label class="radio inline">
									<?php echo Form::radio('email_comments', 0, $prefs['email_comments']).' '.lang('no', 1);?>
								</label>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label"><?php echo lang('messages', 1);?> <span class="icn icn-50 tooltip-right" data-icon="?" title="<?php echo lang('[[email.help.notify_messages|message]]');?>"></span></label>
							<div class="controls">
								<label class="radio inline">
									<?php echo Form::radio('email_messages', 1, $prefs['email_messages']).' '.lang('yes', 1);?>
								</label>
								<label class="radio inline">
									<?php echo Form::radio('email_messages', 0, $prefs['email_messages']).' '.lang('no', 1);?>
								</label>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label"><?php echo lang('personal_logs', 2);?> <span class="icn icn-50 tooltip-right" data-icon="?" title="<?php echo lang('[[email.help.notify|personal_log]]');?>"></span></label>
							<div class="controls">
								<label class="radio inline">
									<?php echo Form::radio('email_logs', 1, $prefs['email_logs']).' '.lang('yes', 1);?>
								</label>
								<label class="radio inline">
									<?php echo Form::radio('email_logs', 0, $prefs['email_logs']).' '.lang('no', 1);?>
								</label>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label"><?php echo lang('announcements', 1);?> <span class="icn icn-50 tooltip-right" data-icon="?" title="<?php echo lang('[[email.help.notify|announcement]]');?>"></span></label>
							<div class="controls">
								<label class="radio inline">
									<?php echo Form::radio('email_announcements', 1, $prefs['email_announcements']).' '.lang('yes', 1);?>
								</label>
								<label class="radio inline">
									<?php echo Form::radio('email_announcements', 0, $prefs['email_announcements']).' '.lang('no', 1);?>
								</label>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label"><?php echo lang('mission_posts', 2);?> <span class="icn icn-50 tooltip-right" data-icon="?" title="<?php echo lang('[[email.help.notify|mission_post]]');?>"></span></label>
							<div class="controls">
								<label class="radio inline">
									<?php echo Form::radio('email_posts', 1, $prefs['email_posts']).' '.lang('yes', 1);?>
								</label>
								<label class="radio inline">
									<?php echo Form::radio('email_posts', 0, $prefs['email_posts']).' '.lang('no', 1);?>
								</label>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label"><?php echo lang('joint mission_posts action.saved', 2);?> <span class="icn icn-50 tooltip-right" data-icon="?" title="<?php echo lang('[[email.help.notify_posts_action|mission_post|action.updated]]');?>"></span></label>
							<div class="controls">
								<label class="radio inline">
									<?php echo Form::radio('email_posts_save', 1, $prefs['email_posts_save']).' '.lang('yes', 1);?>
								</label>
								<label class="radio inline">
									<?php echo Form::radio('email_posts_save', 0, $prefs['email_posts_save']).' '.lang('no', 1);?>
								</label>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label"><?php echo lang('joint mission_posts action.deleted', 2);?> <span class="icn icn-50 tooltip-right" data-icon="?" title="<?php echo lang('[[email.help.notify_posts_action|mission_post|action.deleted]]');?>"></span></label>
							<div class="controls">
								<label class="radio inline">
									<?php echo Form::radio('email_posts_delete', 1, $prefs['email_posts_delete']).' '.lang('yes', 1);?>
								</label>
								<label class="radio inline">
									<?php echo Form::radio('email_posts_delete', 0, $prefs['email_posts_delete']).' '.lang('no', 1);?>
								</label>
							</div>
						</div>
					</fieldset><br>

					<div class="controls">
						<button type="submit" class="btn btn-primary"><?php echo lang('action.submit', 1);?></button>
					</div>

					<?php echo Form::hidden('action', 'preferences');?>
					<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
				<?php echo Form::close();?>
			</div>

			<?php if (Sentry::user()->hasLevel('user.update', 2)): ?>
				<div id="userAdmin" class="pill-pane"></div>
			<?php endif;?>
		</div>
	</div>

	<div class="span3">
		<p><img alt="" src="http://placehold.it/260x260" class="img-circle"></p>

		<a href="#" class="btn btn-block"><?php echo lang('action.edit image', 2);?></a>
	</div>
</div>