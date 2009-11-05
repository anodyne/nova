<script type="text/javascript">
	$(document).ready(function(){
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$('a.addtoggle').click(function(){
			$('.addcat').slideDown('normal', function(){
				$('input:first').focus();
			});
			
			return false;
		});
		
		$("a[rel*=facebox]").click(function() {
			var action = $(this).attr('myAction');
			var id = $(this).attr('myID');
			
			if (action == 'delete')
			{
				var location = '<?php echo site_url('ajax/del_wiki_category');?>/' + id;
			}
			
			if (action == 'edit')
			{
				var location = '<?php echo site_url('ajax/edit_wiki_category');?>/' + id;
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