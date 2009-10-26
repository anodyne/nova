<script type="text/javascript">
	$(document).ready(function(){
		$("#progress").progressbar({ value: 85 });
		$('#percent').text($('#progress').progressbar('option', 'value') + '%');
		
		$('input:first').focus();
		
		$('#next').click(function(){
			$('#body').fadeOut('fast', function(){
				$('#loading').removeClass('hidden');
			});
		});
		
		$('#s_sim_name').blur(function(){
			var name = $('#s_sim_name').val();
			$('#s_email_subject').val('['+ name +']');
		});
	});
</script>