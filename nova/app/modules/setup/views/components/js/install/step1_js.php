<script type="text/javascript">
	$(document).ready(function(){
		$("#progress").progressbar({ value: 50 });
		$('#percent').text($('#progress').progressbar('option', 'value') + '%');
		
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
					$('#loading_update').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo Url::site('ajax/info_show_position_desc');?>",
				data: { position: id },
				success: function(data){
					$('#position_desc').html('');
					$('#position_desc').append(data);
				},
				complete: function(){
					$('#loading_update').addClass('hidden');
				}
			});
			
			return false;
		});
		
		$('#rank').change(function(){
			var id = $('#rank option:selected').val();
			var set = 'default';
			var send = {
				rank: id,
				location: set
			};
			
			$.ajax({
				beforeSend: function(){
					$('#loading_update_rank').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo Url::site('ajax/info_show_rank_image');?>",
				data: send,
				success: function(data){
					$('#rank_img').html('');
					$('#rank_img').append(data);
				},
				complete: function(){
					$('#loading_update_rank').addClass('hidden');
				}
			});
			
			return false;
		});
	});
</script>