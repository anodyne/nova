<script type="text/javascript" src="<?php echo url::base().MODFOLDER;?>/assets/js/jquery.ajaxq.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$("#progress").progressbar({ value: 75 });
		$('#percent').text($('#progress').progressbar('option', 'value') + '%');
		
		$('#next').click(function(){
			$('.lower').fadeOut('fast');
			$('#loaded').fadeOut('fast', function(){
				$('#loading').removeClass('hidden');
			});
		});
		
		$('#start').live('click', function(){
			var send;
			
			// get the password
			var password = $('input[name=password]').val();
			
			// new password
			$.ajaxq('queue', {
				beforeSend: function(){
					$('.loading-password').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo url::site('upgradeajax/upgrade_final_password');?>",
				data: { password: password },
				dataType: 'json',
				success: function(data){
					$('.loading-password').addClass('hidden');
					
					if (data.code == 1)
					{
						$('.success-password').removeClass('hidden');
					}
					else
					{
						$('.failure-password').removeClass('hidden');
						$('.failure-password img').attr('title', function(){
							return data.message
						});
					}
				}
			});
			
			// get the admins
			var roles = $('select[name=admins]').val();
			
			// roles
			$.ajaxq('queue', {
				beforeSend: function(){
					$('.loading-admins').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo url::site('upgradeajax/upgrade_final_roles');?>",
				data: { roles: roles },
				dataType: 'json',
				success: function(data){
					$('.loading-admins').addClass('hidden');
					
					if (data.code == 1)
					{
						$('.success-admins').removeClass('hidden');
					}
					else
					{
						$('.failure-admin').removeClass('hidden');
						$('.failure-admin img').attr('title', function(){
							return data.message
						});
					}
				}
			});
			
			$('#progress').ajaxStop(function(){
				$("#progress").progressbar({ value: 100 });
				$('#percent').text($('#progress').progressbar('option', 'value') + '%');
				
				// change the button and text
				$('.lower .control button').attr('id', 'next').html('<?php echo __("Your Site");?>');
				$('.lower .control-text').html('<?php echo __("Go to your upgraded Nova site now");?>');
			});
			
			return false;
		});
	});
</script>