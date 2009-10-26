<script type="text/javascript">
	$(document).ready(function(){
		$("#progress").progressbar({ value: 17 });
		$('#percent').text($('#progress').progressbar('option', 'value') + '%');
		
		$('#test').click(function(){
			$.ajax({
				beforeSend: function(){
					$('#loading_update_rank').show();
				},
				type: "POST",
				url: "<?php echo site_url('ajax/try_database');?>",
				data: list,
				success: function(data){
					$('.' + parent + ' .flash_message').remove();
					$('.' + parent).prepend(data);
				},
				complete: function(){
					$('#loading_update_rank').hide();
				}
			});
			
			return false;
		});
		
		$('#next').click(function(){
			$('#body').fadeOut('fast', function(){
				$('#loading').removeClass('hidden');
			});
		});
	});
</script>