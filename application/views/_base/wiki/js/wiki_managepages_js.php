<script type="text/javascript">
	$(document).ready(function(){
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$("a[rel*=facebox]").click(function() {
			var id = $(this).attr('myID');
			var location = '<?php echo site_url('ajax/del_wiki_page');?>/' + id;
			
			$.facebox(function() {
				$.get(location, function(data) {
					$.facebox(data);
				});
			});
			
			return false;
		});
	});
</script>