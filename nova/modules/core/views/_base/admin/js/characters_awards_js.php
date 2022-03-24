<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<script type="text/javascript" src="<?php echo base_url() . MODFOLDER;?>/assets/js/jquery.ajaxq.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#tabs').tabs();
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$('#awards').change(function(){
			var id = $('#awards option:selected').val();
			
			$.ajaxq('queue', {
				beforeSend: function(){
					$('#loading').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo site_url('ajax/info_show_award_desc');?>",
				data: { award: id, 'nova_csrf_token': $('input[name=nova_csrf_token]').val() },
				success: function(data){
					$('.award-desc').html('');
					$('.award-desc').append(data);
				},
				complete: function(){
					$('#loading').addClass('hidden');
				}
			});
			
			return false;
		});
		
		$('.remove').click(function(){
			var id = $(this).attr('myID');
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('ajax/del_character_award');?>",
				data: { award: id, 'nova_csrf_token': $('input[name=nova_csrf_token]').val() },
				success: function(){
					$('tr#' + id).fadeOut('normal', function(){
						$(this).remove();
						
						$('table.zebra tbody > tr').removeClass('alt');
						$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
					});
				}
			});
			
			return false;
		});
	});
</script>