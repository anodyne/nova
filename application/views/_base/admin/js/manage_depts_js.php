<?php $string = random_string('alnum', 8);?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#tabs').tabs();
		$('#tabs').tabs('select', <?php echo $tab;?>);
		
		$('div.zebra div:nth-child(odd)').addClass('alt');
		
		$('button.button-small').click(function(){
			var action = $(this).attr('action');
			var did = $(this).attr('id');
			
			if (action == 'delete')
				var location = '<?php echo site_url('ajax/del_dept');?>/' + did + '/<?php echo $string;?>';
			if (action == 'duplicate')
				var location = '<?php echo site_url('ajax/duplicate_dept');?>/' + did + '/<?php echo $string;?>';
				
			$.facebox(function() {
				$.get(location, function(data) {
					$.facebox(data);
				});
			});
			
			return false;
		});
		
		$("a[rel*=facebox]").click(function() {
			var location = '<?php echo site_url('ajax/add_dept/'. $string);?>';
			
			$.facebox(function() {
				$.get(location, function(data) {
					$.facebox(data);
				});
			});
			
			return false;
		});
	});
</script>