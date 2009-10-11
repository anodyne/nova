<script type="text/javascript">
	$(document).ready(function(){
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$("a[rel*=facebox]").click(function(){
			var id = $(this).attr('myID');
			var action = $(this).attr('myAction');
			
			if (action == 'add')
				var location = '<?php echo site_url('ajax/add_user_setting');?>';
				
			if (action == 'edit')
				var location = '<?php echo site_url('ajax/edit_user_setting');?>/' + id;
				
			if (action == 'delete')
				var location = '<?php echo site_url('ajax/del_user_setting');?>/' + id;
			
			$.facebox(function(){
				$.get(location, function(data){
					$.facebox(data);
				});
			});
			
			return false;
		});
	});
</script>