<script type="text/javascript">
	$(document).ready(function(){
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$("a[rel*=facebox]").click(function() {
			var action = $(this).attr('myAction');
			var id = $(this).attr('myID');
			
			if (action == 'delete')
			{
				var location = '<?php echo site_url('ajax/del_catalogue/ranks/');?>/' + id;
			}
			
			if (action == 'edit')
			{
				var location = '<?php echo site_url('ajax/edit_catalogue/ranks/');?>/' + id;
			}
			
			if (action == 'add')
			{
				var location = '<?php echo site_url('ajax/add_catalogue/ranks/');?>';
			}
			
			$.facebox(function() {
				$.get(location, function(data) {
					$.facebox(data);
				});
			});
			
			return false;
		});
	});
</script>