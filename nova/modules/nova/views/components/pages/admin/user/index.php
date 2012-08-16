<div class="controls pull-right">
	<div class="input-prepend">
		<span class="add-on"><i class="icon-search icon-50"></i></span><input type="text" id="user-search" class="span4" placeholder="<?php echo lang('action.search for users', 1);?>">
	</div>
</div>

<div class="btn-toolbar">
	<div class="btn-group">
		<?php if (Sentry::user()->has_access('user.create')): ?>
			<a href="#" class="btn tooltip-top add-switch" rel="user" title="<?php echo lang('action.add user', 1);?>"><i class="icon-plus icon-75"></i></a>
		<?php endif;?>

		<?php if (Sentry::user()->has_level('user.update', 2)): ?>
			<a href="#" class="btn tooltip-top add-switch" rel="character" title="<?php echo lang('action.link character to user', 1);?>"><i class="icon-resize-small icon-75"></i></a>
		<?php endif;?>
	</div>
</div><br>

<?php if (Sentry::user()->has_access('user.create')): ?>
	<div id="add-user" class="hide well well-small">
		<a class="close" href="#" rel="user" class="add-cancel">&times;</a>
		
		<h3><?php echo lang('action.add user', 2);?></h3>
		
		<p><?php echo lang('[[short.users.add|user|name|email_address|password|characters]]');?></p>

		<?php echo Form::open();?>
			<div class="row">
				<div class="span4">
					<div class="control-group">
						<label class="control-label"><?php echo lang('name', 1);?></label>
						<div class="controls">
							<input type="text" name="name" value="" class="span4">
						</div>
					</div>
				</div>

				<div class="span7">
					<div class="control-group">
						<label class="control-label"><?php echo lang('email_address', 1);?></label>
						<div class="controls">
							<div class="input-append">
								<input type="email" name="email" value="" class="span4"><button type="submit" name="submit" class="btn"><?php echo lang('action.submit', 1);?></button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php echo Form::hidden('action', 'create');?>
			<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
		<?php echo Form::close();?>
	</div>
<?php endif;?>

<?php if (Sentry::user()->has_level('user.update', 2)): ?>
	<div id="add-character" class="hide well well-small">
		<a class="close" href="#">&times;</a>
		
		<h3>Add Character to User Account</h3>
		
		<p>You can add characters to a user's account by entering the user name or email address and entering the name of the character. During creation, the user will be emailed to notify them of the new character associated with their account.</p>

		<?php echo Form::open();?>
			<div class="control-group">
				<label class="control-label"><?php echo lang('user', 1);?></label>
				<div class="controls">
					<?php echo NovaForm::users('user', array(), array('class' => 'span5 chzn'));?>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label"><?php echo lang('character', 1);?></label>
				<div class="controls">
					<?php //echo NovaForm::characters('character', array(), array('class' => 'span5 chzn'));?>
				</div>
			</div>

			<div class="controls">
				<button type="submit" name="submit" class="btn"><?php echo lang('action.submit', 1);?></button>
			</div>

			<?php echo Form::hidden('action', 'link');?>
			<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
		<?php echo Form::close();?>
	</div>
<?php endif;?>

<div id="actives">
	<table class="table table-striped" id="users-active">
		<tbody>
		<?php foreach($active as $a): ?>
			<tr>
				<td>
					<span class="lead"><?php echo $a->name;?></span><br>
					<span class="muted"><?php echo $a->email;?></span>
				</td>
				<td class="span2">
					<div class="btn-toolbar pull-right">
						<?php if ((Sentry::user()->has_level('user.update', 1) and Sentry::user()->id == $a->id)
								or Sentry::user()->has_level('user.update', 2)): ?>
							<div class="btn-group">
								<a href="<?php echo Uri::create('admin/user/edit/'.$a->id);?>" class="btn btn-mini btn-icon tooltip-top" title="<?php echo lang('action.edit user', 1);?>"><i class="icon-pencil icon-50"></i></a>
							</div>
						<?php endif;?>

						<?php if (Sentry::user()->has_access('user.delete')): ?>
							<div class="btn-group">
								<a href="#" class="btn btn-mini btn-icon btn-danger tooltip-top user-action" title="<?php echo lang('action.delete user', 1);?>" data-action="delete" data-id="<?php echo $a->id;?>"><i class="icon-remove icon-white icon-50"></i></a>
							</div>
						<?php endif;?>
					</div>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
</div>

<div id="all" class="hide">
	<p><em><?php echo lang('[[short.users.done_searching|active|users]]');?></em></p>
	
	<div id="results" class="hide">
		<div id="results-name" class="hide">
			<h3><?php echo lang('results by name', 1);?></h3>
			<ul class="unstyled"></ul>
		</div>
		
		<div id="results-email" class="hide">
			<h3><?php echo lang('results by email_address', 2);?></h3>
			<ul class="unstyled"></ul>
		</div>
		
		<div id="results-characters" class="hide">
			<h3><?php echo lang('results by action.linked characters', 2);?></h3>
			<ul class="unstyled"></ul>
		</div>
	</div>
	
	<div id="no-results" class="hide">
		<p class="alert"><?php echo lang('[[error.not_found|results]]');?></p>
	</div>
</div>