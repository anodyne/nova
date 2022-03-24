<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php $string = random_string('alnum', 8);?>

<script type="text/javascript">
	$(document).ready(function(){
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$("a[rel*=facebox]").click(function() {
			var id = $(this).attr('myID');
			var action = $(this).attr('myAction');
			var location;
			
			if (action == 'add')
				location = "<?php echo site_url('ajax/add_mission_group');?>/" + "<?php echo $string;?>";
			if (action == 'delete')
				location = "<?php echo site_url('ajax/del_mission_group');?>/" + id + "/<?php echo $string;?>";
			if (action == 'edit')
				location = "<?php echo site_url('ajax/edit_mission_group');?>/" + id + "/<?php echo $string;?>";
			
			$.facebox(function() {
				$.get(location, function(data) {
					$.facebox(data);
				});
			});
			
			return false;
		});
	});
</script>