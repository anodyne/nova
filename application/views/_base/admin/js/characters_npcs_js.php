<script type="text/javascript">
	$(document).ready(function(){
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$("a[rel*=facebox]").click(function() {
			var id = $(this).attr('myID');
			var action = $(this).attr('myAction');
			var location = '<?php echo site_url('ajax/del_character');?>/' + id;
				
			$.facebox(function() {
				$.get(location, function(data) {
					$.facebox(data);
				});
			});
			
			return false;
		});
		
		$('#loader').hide();
		$('#loaded').removeClass('hidden');
	});
</script>