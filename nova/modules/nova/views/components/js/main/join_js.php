<script type="text/javascript">
	
	$(document).ready(function(){

		// show the first tab
		$('.nav-tabs a:first').tab('show');
	});
	
	// show the additional details field after where did you hear about us
	$('#hearAbout').on('change', function(){

		var selected = $('#hearAbout option:selected').val();

		if (selected == '<?php echo lang('short.hear_about_us.member', 2);?>' ||
				selected == '<?php echo lang('short.hear_about_us.org', 1);?>' ||
				selected == '<?php echo lang('short.hear_about_us.ad', 1);?>' ||
				selected == '<?php echo lang('short.hear_about_us.other', 1);?>')
		{
			$(this).closest('div.control-group').next().slideDown();
		}
		else
		{
			$(this).closest('div.control-group').next().slideUp();
		}
	});

	// check the email address entered to see if it exists
	$('#emailField').on('change', function(){

		$.ajax({
			type: 'POST',
			url: "<?php echo Uri::create('ajax/get/user');?>",
			data: { 'email': $(this).val() },
			dataType: 'json',
			success: function(data){
				
				if ( ! $.isEmptyObject(data))
				{
					// change the user exists field
					$('[name="user[exists]"]').val(data.id);

					// hide the user info
					$('#userInfo').hide();

					// hide the user form
					$('#userForm').hide();

					// show the alert block with instructions
					$('#welcomeBack').fadeIn();
				}
				else
				{
					// change the user exists field
					$('[name="user[exists]"]').val(0);

					// show the user info
					$('#userInfo').show();

					// show the user form
					$('#userForm').show();

					// hide the alert block with instructions
					$('#welcomeBack').fadeOut();
				}
			}
		});
	});

	// reset the user form
	$('#userFormReset').on('click', function(){

		$.ajax({
			type: 'POST',
			url: "<?php echo Uri::create('ajax/get/user_form');?>",
			data: {
				'user': 0,
				'skin': '<?php echo $skin;?>'
			},
			dataType: 'json',
			success: function(data){

				// reset the user form
				$('#userForm').empty().html(data);
			}
		});

		// clear the email field
		$('[name="user[email]"]').val('');

		// clear the name field
		$('[name="user[name]"]').val('');

		// clear the password field
		$('[name="user[password]"]').val('');

		// clear the confirm password field
		$('[name="user[confirm_password]"]').val('');

		// clear the simming experience field
		$('[name="app[experience]"]').val('');

		// clear the heard about us field
		$('[name="app[hear_about]"]').val('');

		// clear the heard about us detail field
		$('[name="app[hear_about_detail]"]').val('');

		// hide the alert block with instructions
		$('#welcomeBack').hide();

		// show the user info
		$('#userInfo').show();

		// show the user form
		$('#userForm').show();

		return false;
	});

	$('#positionDrop').on('change', function(){
		
		$.ajax({
			type: "POST",
			url: "<?php echo Uri::create('ajax/info/position_desc');?>",
			data: { position: $('#positionDrop option:selected').val() },
			success: function(data){
				$('#positionDesc').html('');
				$('#positionDesc').append(data);
			}
		});
		
		return false;
	});
</script>