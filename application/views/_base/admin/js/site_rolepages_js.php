<script type="text/javascript">
	$(document).ready(function(){
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$("a[rel*=facebox]").click(function() {
			var action = $(this).attr('myAction');
			var id = $(this).attr('myID');
			
			if (action == 'delete')
				var location = '<?php echo site_url('ajax/del_role_page');?>/' + id;
			
			if (action == 'edit')
				var location = '<?php echo site_url('ajax/edit_role_page');?>/' + id;
			
			if (action == 'add')
				var location = '<?php echo site_url('ajax/add_role_page');?>';
			
			$.facebox(function() {
				$.get(location, function(data) {
					$.facebox(data);
				});
			});
			
			return false;
		});
		
		$('a[rel=tooltip]').each(function(){
			$(this).qtip({
				content: $(this).attr('tooltip'),
				style: { 
					border: {
						width: 1,
						radius: 4,
					},
					name: 'dark',
					fontSize: '90%'
				}
			});
		});
	});
</script>