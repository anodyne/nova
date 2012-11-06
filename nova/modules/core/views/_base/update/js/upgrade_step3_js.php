<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<script type="text/javascript" src="<?php echo base_url().MODFOLDER;?>/assets/js/jquery.ajaxq.js"></script>
<script type="text/javascript" src="<?php echo base_url().MODFOLDER;?>/assets/js/bootstrap-twipsy.js"></script>
<link rel="stylesheet" href="<?php echo base_url().MODFOLDER;?>/assets/js/css/bootstrap.css" />

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
		
		$(document).on('click', '#start', function(){
			var send;
			
			var twipsyOptions = {
				placement: 'right',
				offset: 5,
				animate: false
			}
			
			// get the password
			var password = $('input[name=password]').val();
			
			// new password
			$.ajaxq('queue', {
				beforeSend: function(){
					$('.loading-password').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo site_url('upgradeajax/upgrade_final_password');?>",
				data: { password: password, 'nova_csrf_token': $('input[name=nova_csrf_token]').val() },
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
						$('.tiptip').twipsy(twipsyOptions);
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
				url: "<?php echo site_url('upgradeajax/upgrade_final_roles');?>",
				data: { roles: roles, 'nova_csrf_token': $('input[name=nova_csrf_token]').val() },
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
						$('.tiptip').twipsy(twipsyOptions);
					}
				}
			});
			
			$('#progress').ajaxStop(function(){
				$("#progress").progressbar({ value: 100 });
				$('#percent').text($('#progress').progressbar('option', 'value') + '%');
				
				// change the button and text
				$('.lower .control button').attr('id', 'next').html('Your Site');
			});
			
			return false;
		});
	});
</script>