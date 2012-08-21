<p><?php echo lang('[[short.users.add|user|name|email_address|password|characters]]');?></p>

<?php echo Form::open();?>
	<div class="control-group">
		<label class="control-label"><?php echo lang('name', 1);?></label>
		<div class="controls">
			<input type="text" name="name" value="" class="span4">
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo lang('email_address', 1);?></label>
		<div class="controls">
			<input type="email" name="email" value="" class="span4">
		</div>
	</div>

	<div class="form-actions">
		<button class="btn btn-primary"><?php echo lang('action.submit', 1);?></button>
	</div>

	<?php echo Form::hidden('action', 'create');?>
	<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
<?php echo Form::close();?>