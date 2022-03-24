<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* set the location variable */
$location = FALSE;

$string = random_string('alnum', 8);

// if they need to reset their password, show them the right facebox
if ($password_reset == 1)
{
	$location = site_url('ajax/change_password/'. $this->session->userdata('userid') .'/'. $string);
}

?><script type="text/javascript">
	$(document).ready(function(){
		<?php if ($location !== FALSE): ?>
			$.facebox(function() {
				$.get('<?php echo $location;?>', function(data) {
					$.facebox(data);
				});
			});
		<?php endif; ?>
	
		$('#tabs').tabs();
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$('.<?php echo $panel;?>').removeClass('hidden');
		$('#<?php echo $panel;?>').addClass('active');
		
		$('#panelmenu a').click(function(){
			var panel = $(this).attr('id');
			$('#panelmenu > li > a').removeClass('active');
			$(this).addClass('active');
			
			$('.panel div:visible').fadeOut('fast', function(){
				$('.' + panel).fadeIn();
			});
			
			return false;
		});
		
		$('.ignore').click(function(){
			var myVersion = $(this).attr('myVersion');
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('ajax/save_ignore_update_version');?>",
				data: { version: myVersion, 'nova_csrf_token': $('input[name=nova_csrf_token]').val() },
				success: function(data){
					$('#update').fadeOut('normal', function(){
						$('#update').remove();
					});
					$('.update').fadeOut('normal');
					$('.stats').removeClass('hidden');
					$('#stats').addClass('active');
				}
			});
			
			return false;
		});
		
		$('#loading').hide();
		$('#loaded').removeClass('hidden'); 
	});
</script>