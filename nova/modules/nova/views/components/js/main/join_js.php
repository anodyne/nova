<script type="text/javascript">
	
	$(document).ready(function(){

		// show the first tab
		$('.nav-tabs a:first').tab('show');
	});
	
	// show the additional details field after where did you hear about us
	$(document).on('change', '#hearAbout', function(){

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
	$(document).on('change', '#emailField', function(){

		$.ajax({
			type: 'POST',
			url: "<?php echo Uri::create('ajax/get/user');?>",
			data: { 'email': $(this).val() },
			dataType: 'json',
			success: function(data){
				
				if ( ! $.isEmptyObject(data))
				{
					// push the user's name into the name field and make it read only
					$('[name="user[name]"]').val(data.name);

					// change the user exists field
					$('[name="user[exists]"]').val(data.id);

					// hide the password field
					$('[name="user[password]"]').closest('div.control-group').fadeOut();

					// hide the confirm password field
					$('[name="user[confirm_password]"]').closest('div.control-group').fadeOut();

					// show the alert block with instructions
					$('#welcomeBack').fadeIn();

					// go get the updated user form now
					$.ajax({
						type: 'POST',
						url: "<?php echo Uri::create('ajax/get/user_form');?>",
						data: { 'skin': '<?php echo $skin;?>', 'user': data.id },
						dataType: 'html',
						success: function(form){
							$('#userForm').empty().html(form);
						}
					});
				}
				else
				{
					// clear any user name from the field and make sure it's editable
					$('[name="user[name]"]').val('');

					// change the user exists field
					$('[name="user[id]"]').val('0');

					// show the password field
					$('[name="user[password]"]').closest('div.control-group').fadeIn();

					// show the confirm password field
					$('[name="user[confirm_password]"]').closest('div.control-group').fadeIn();

					// hide the alert block with instructions
					$('#welcomeBack').fadeOut();

					// reset the user form now
					$.ajax({
						type: 'POST',
						url: "<?php echo Uri::create('ajax/get/user_form');?>",
						data: { 'skin': '<?php echo $skin;?>', 'user': 0 },
						dataType: 'html',
						success: function(form){
							$('#userForm').empty().html(form);
						}
					});
				}
			}
		});
	});
</script>