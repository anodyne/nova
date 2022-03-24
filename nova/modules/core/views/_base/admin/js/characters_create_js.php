<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#tabs').tabs();
		
		$('#position1').change(function(){
			var id = $('#position1 option:selected').val();
			
			$.ajax({
				beforeSend: function(){
					$('#loading_pos1').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo site_url('ajax/info_show_position_desc');?>",
				data: { position: id, 'nova_csrf_token': $('input[name=nova_csrf_token]').val() },
				success: function(data){
					$('#position1_desc').html('');
					$('#position1_desc').append(data);
				},
				complete: function(){
					$('#loading_pos1').addClass('hidden');
				}
			});
			
			return false;
		});
		
		$('#position2').change(function(){
			var id = $('#position2 option:selected').val();
			
			$.ajax({
				beforeSend: function(){
					$('#loading_pos2').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo site_url('ajax/info_show_position_desc');?>",
				data: { position: id, 'nova_csrf_token': $('input[name=nova_csrf_token]').val() },
				success: function(data){
					$('#position2_desc').html('');
					$('#position2_desc').append(data);
				},
				complete: function(){
					$('#loading_pos2').addClass('hidden');
				}
			});
			
			return false;
		});
		
		$('#rank').change(function(){
			var id = $('#rank option:selected').val();
			var send = {
				rank: id,
				location: '<?php echo $rankloc;?>',
				'nova_csrf_token': $('input[name=nova_csrf_token]').val()
			};
			
			$.ajax({
				beforeSend: function(){
					$('#loading_rank').show();
				},
				type: "POST",
				url: "<?php echo site_url('ajax/info_show_rank_img');?>",
				data: send,
				success: function(data){
					$('#rank_img').html('');
					$('#rank_img').append(data);
				},
				complete: function(){
					$('#loading_rank').hide();
				}
			});
			
			return false;
		});
	});
</script>