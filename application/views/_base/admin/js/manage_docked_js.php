<script type="text/javascript">
	$(document).ready(function(){
		var $tabs = $('#tabs').tabs();
		$tabs.tabs('select', <?php echo $tab;?>);
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$("a[rel*=facebox]").click(function() {
			var action = $(this).attr('myAction');
			var id = $(this).attr('myID');
			var location;
			
			if (action == 'delete')
				location = '<?php echo site_url('ajax/del_docked_item');?>/' + id;
			
			$.facebox(function() {
				$.get(location, function(data) {
					$.facebox(data);
				});
			});
			
			return false;
		});
	});
</script>