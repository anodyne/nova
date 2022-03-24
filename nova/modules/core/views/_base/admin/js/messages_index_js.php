<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $string = random_string('alnum', 8);?>

<style>
.popover .inner { width: 550px !important; }
</style>

<script type="text/javascript">
	$(document).ready(function(){
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$('[rel=popover]').popover({
			animate: false,
			offset: 5,
			placement: 'right',
			html: true
		});
		
		$('#inbox_check_all').click(function(){
			$("input[type='checkbox']").attr('checked', $('#inbox_check_all').is(':checked'));
		});
		
		$('#mark_read').click(function(){
			$.ajax({
				type: "POST",
				data: { 'nova_csrf_token': $('input[name=nova_csrf_token]').val() },
				url: "<?php echo site_url('ajax/update_mark_messages_as_read');?>/" + $(this).data('user') + "/<?php echo $string;?>",
				success: function(data){
					window.location.reload(true);
				}
			});
			
			return false;
		});
		
		$('#loading').hide();
		$('#loaded').removeClass('hidden');
	});
</script>