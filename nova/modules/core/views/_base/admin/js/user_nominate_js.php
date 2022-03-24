<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php $string = random_string('alnum', 8);?>

<script type="text/javascript" src="<?php echo base_url() . MODFOLDER;?>/assets/js/jquery.ajaxq.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#tabs').tabs();
		$('#tabs').tabs('select', <?php echo $tab;?>);
		
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
			
			$.ajaxq('queue', {
				beforeSend: function(){
					$('#loading').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo site_url('ajax/info_show_characters_by_award');?>",
				data: { award: id, 'nova_csrf_token': $('input[name=nova_csrf_token]').val() },
				success: function(data){
					$('.char-menu').html('');
					$('.char-menu').append(data);
				},
				complete: function(){
					$('#loading').addClass('hidden');
				}
			});
			
			return false;
		});
		
		$("a[rel*=facebox]").click(function() {
			var id = $(this).attr('myID');
			var action = $(this).attr('myAction');
			
			if (action == 'approve')
				var location = '<?php echo site_url('ajax/approve/award_nomination');?>/' + id + '/<?php echo $string;?>';
				
			if (action == 'reject')
				var location = '<?php echo site_url('ajax/reject/award_nomination');?>/' + id + '/<?php echo $string;?>';
				
			$.facebox(function() {
				$.get(location, function(data) {
					$.facebox(data);
				});
			});
			
			return false;
		});
	});
</script>