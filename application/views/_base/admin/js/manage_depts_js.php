<script type="text/javascript">
	$(document).ready(function(){
		$('div.zebra div:nth-child(odd)').addClass('alt');
		
		$('button.button-small').click(function(){
			var did = $(this).attr('id');
			var location = '<?php echo site_url('ajax/del_dept');?>/' + did;
				
			$.facebox(function() {
				$.get(location, function(data) {
					$.facebox(data);
				});
			});
			
			return false;
		});
		
		$("a[rel*=facebox]").click(function() {
			var location = '<?php echo site_url('ajax/add_dept');?>';
			
			$.facebox(function() {
				$.get(location, function(data) {
					$.facebox(data);
				});
			});
			
			return false;
		});
	});
</script>