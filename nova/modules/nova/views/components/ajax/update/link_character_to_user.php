<p>You can add characters to a user's account by entering the user name or email address and entering the name of the character. During creation, the user will be emailed to notify them of the new character associated with their account.</p>

<?php echo Form::open();?>
	<div class="control-group">
		<label class="control-label"><?php echo ucfirst(lang('user'));?></label>
		<div class="controls">
			<?php echo NovaForm::users('user', array(), array('class' => 'span5 chzn'));?>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo ucfirst(lang('character'));?></label>
		<div class="controls">
			<?php //echo NovaForm::characters('character', array(), array('class' => 'span5 chzn'));?>
		</div>
	</div>

	<div class="controls">
		<button type="submit" name="submit" class="btn"><?php echo ucfirst(lang('action.submit'));?></button>
	</div>

	<?php echo Form::hidden('action', 'link');?>
	<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
<?php echo Form::close();?>