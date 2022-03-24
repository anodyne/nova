<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<script type="text/javascript">
	$(document).ready(function(){
		$("#progress").progressbar({ value: 60 });
		$('#percent').text($('#progress').progressbar('option', 'value') + '%');
		
		$('input:first').focus();
		
		$('#next').click(function(){
			$('.lower').fadeOut('fast');
			$('#loaded').fadeOut('fast', function(){
				$('#loading').removeClass('hidden');
			});
		});
		
		$('#position').change(function(){
			var id = $('#position option:selected').val();
			
			$.ajax({
				beforeSend: function(){
					$('#loading_update').show();
				},
				type: "POST",
				url: "<?php echo site_url('ajax/info_show_position_desc');?>",
				data: { position: id, 'nova_csrf_token': $('input[name=nova_csrf_token]').val() },
				success: function(data){
					$('#position_desc').html('');
					$('#position_desc').append(data);
				},
				complete: function(){
					$('#loading_update').hide();
				}
			});
			
			return false;
		});
		
		$('#rank').change(function(){
			var id = $('#rank option:selected').val();
			var set = 'default';
			var send = {
				rank: id,
				location: set,
				'nova_csrf_token': $('input[name=nova_csrf_token]').val()
			};
			
			$.ajax({
				beforeSend: function(){
					$('#loading_update_rank').show();
				},
				type: "POST",
				url: "<?php echo site_url('ajax/info_show_rank_img');?>",
				data: send,
				success: function(data){
					$('#rank_img').html('');
					$('#rank_img').append(data);
				},
				complete: function(){
					$('#loading_update_rank').hide();
				}
			});
			
			return false;
		});
	});
</script>