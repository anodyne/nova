<?php $string = random_string('alnum', 8);?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#tabs').tabs();
		$('.subtabs').tabs();
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$('a[rel=tooltip]').each(function(){
			$(this).qtip({
				content: $(this).attr('tooltip'),
				position: {
					my: 'bottom left',
					at: 'top right'
				},
				style: { 
					classes: 'ui-tooltip-shadow ui-tooltip-dark ui-tooltip-rounded'
				}
			});
		});
		
		$("a[rel=facebox]").click(function() {
			var action = $(this).attr('myAction');
			var id = $(this).attr('myID');
			
			if (action == 'unlock')
				var location = '<?php echo site_url('ajax/info_release_post_lock');?>/' + id + '/<?php echo $string;?>';
			
			$.facebox(function() {
				$.get(location, function(data) {
					$.facebox(data);
				});
			});
			
			return false;
		});
	});
</script>