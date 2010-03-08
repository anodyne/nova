<?php $string = random_string('alnum', 8);?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#tabs').tabs();
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$('.imagepick').click(function(){
			var image = $(this).attr('myfile');
			
			if ($('#images').val() == '')
				var pre = '';
			else
				var pre = ', ';
				
			$('#images').append(pre + image);
			
			return false;
		});
		
		$("a[rel*=facebox]").click(function() {
			var action = $(this).attr('myAction');
			var id = $(this).attr('myID');
			var location = '<?php echo site_url('ajax/del_tour_item');?>/' + id + '/<?php echo $string;?>';
			
			$.facebox(function() {
				$.get(location, function(data) {
					$.facebox(data);
				});
			});
			
			return false;
		});
	});
</script>