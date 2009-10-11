<script type="text/javascript">
	$(document).ready(function(){
		$("a[rel*=facebox]").click(function() {
			var num = $(this).attr('myID');
			
			$.facebox(function() {
				$.get('<?php echo site_url();?>/ajax/add_comment_news/'+ num, function(data) {
					$.facebox(data);
				});
			});
			return false;
		});
	});
</script>