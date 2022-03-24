<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<script type="text/javascript">
	$(document).ready(function(){
		$("#progress").progressbar({ value: 80 });
		$('#percent').text($('#progress').progressbar('option', 'value') + '%');
		
		$('input:first').focus();
		
		$('#next').click(function(){
			$('.lower').fadeOut('fast');
			$('#loaded').fadeOut('fast', function(){
				$('#loading').removeClass('hidden');
			});
		});
		
		$('#s_sim_name').blur(function(){
			var name = $('#s_sim_name').val();
			$('#s_email_subject').val('['+ name +']');
		});
	});
</script>