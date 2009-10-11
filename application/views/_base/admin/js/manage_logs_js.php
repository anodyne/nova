<script type="text/javascript">
	$(document).ready(function(){
		$('#tabs').tabs();
		$('#tabs').tabs('select', <?php echo $tab;?>);
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$("a[rel*=facebox]").click(function() {
			var page = $(this).attr('myPage');
			var status = $(this).attr('myStatus');
			var id = $(this).attr('myID');
			var action = $(this).attr('myAction');
			var location;
			
			if (action == 'approve')
				location = '<?php echo site_url('ajax/approve');?>/logs/' + id;
				
			if (action == 'delete')
				location = '<?php echo site_url('ajax/del_log');?>/' + status + '/' + page + '/' + id;
			
			$.facebox(function() {
				$.get(location, function(data) {
					$.facebox(data);
				});
			});
			
			return false;
		});
	});
</script>