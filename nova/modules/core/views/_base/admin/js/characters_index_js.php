<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php $string = random_string('alnum', 8);?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#tabs').tabs();
		$('#tabs').tabs('select', <?php echo $tab;?>);
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$("a[rel*=facebox]").click(function() {
			var id = $(this).attr('myID');
			var action = $(this).attr('myAction');
			
			if (action == 'delete')
				var location = '<?php echo site_url('ajax/del_character');?>/' + id + '/<?php echo $string;?>';
			
			if (action == 'approve')
				var location = '<?php echo site_url('ajax/approve/character');?>/' + id + '/<?php echo $string;?>';
				
			if (action == 'reject')
				var location = '<?php echo site_url('ajax/reject/character');?>/' + id + '/<?php echo $string;?>';
				
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