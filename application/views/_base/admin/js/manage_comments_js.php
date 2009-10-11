<script type="text/javascript">
	$(document).ready(function(){
		$('#tabs').tabs();
		$('#tabs').tabs('select', <?php echo $type;?>);
		
		$('.subtabs').tabs();
		$('.subtabs').tabs('select', <?php echo $section;?>);
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$("a[rel*=facebox]").click(function() {
			var type = $(this).attr('myType'); /* posts, logs, news */
			var page = $(this).attr('myPage'); /* page number (offset) */
			var status = $(this).attr('myStatus'); /* activated, pending */
			var id = $(this).attr('myID');
			var action = $(this).attr('myAction');
			
			if (action == 'delete')
				var location = '<?php echo site_url('ajax/del_comment');?>/' + type + '/' + status + '/' + page + '/' + id;
				
			if (action == 'edit')
				var location = '<?php echo site_url('ajax/edit_comment');?>/' + type + '/' + status + '/' + page + '/' + id;
				
			if (action == 'approve')
				var location = '<?php echo site_url('ajax/approve');?>/' + type + '/' + id;
				
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