<script type="text/javascript">
	$(document).ready(function(){
		$('input:first').focus();
		
		$('[type=password]').keypress(function(){
			if ($(this).val().length > 0)
			{
				if ($('.login-control-reset').is(':visible'))
				{
					$('.login-control-reset').fadeOut('fast', function(){
						$('.login-control-submit').fadeIn('fast');
					});
				}
			}
			else
			{
				if ($('.login-control-submit').is(':visible'))
				{
					$('.login-control-submit').fadeOut('fast', function(){
						$('.login-control-reset').fadeIn('fast');
					});
				}
			}
		});
	});
</script>

<br>

<?php echo Form::open('login/check');?>
	<p>
		<kbd><?php echo ucwords(__('email address'));?></kbd>
		<div class="login-control-container"><?php echo Form::input('email', null, $inputs['email']);?></div>
	</p>
	<p>
		<kbd><?php echo ucfirst(__('password'));?></kbd>
		<div class="login-control-container">
			<?php echo Form::password('password', null, $inputs['password']);?>
			
			<?php echo Form::button('submit', null, $inputs['button']);?>
			
			<a href="#" class="login-control-reset" title="<?php echo ucwords(___('reset password'));?>"></a>
		</div>
	</p>
	<p>
		<kbd>
			<label class="remember" for="remember"><strong><?php echo ucwords(__('remember me'));?></strong></label>
			<?php echo Form::checkbox('remember', 1, false, $inputs['remember']);?>
		</kbd>
	</p>
<?php echo Form::close();?>