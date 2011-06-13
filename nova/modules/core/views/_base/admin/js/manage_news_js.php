<?php $string = random_string('alnum', 8);?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#tabs').tabs();
		$('#tabs').tabs('select', <?php echo $tab;?>);
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$('#content-textarea').elastic();
		
		$("a[rel*=facebox]").click(function() {
			var page = $(this).attr('myPage');
			var status = $(this).attr('myStatus');
			var id = $(this).attr('myID');
			var action = $(this).attr('myAction');
			var location;
			
			if (action == 'approve')
				location = '<?php echo site_url('ajax/approve');?>/news/' + id + '/<?php echo $string;?>';
				
			if (action == 'delete')
				location = '<?php echo site_url('ajax/del_news');?>/' + status + '/' + page + '/' + id + '/<?php echo $string;?>';
			
			$.facebox(function() {
				$.get(location, function(data) {
					$.facebox(data);
				});
			});
			
			return false;
		});
	});
</script>