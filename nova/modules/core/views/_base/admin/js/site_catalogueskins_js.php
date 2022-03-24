<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php $string = random_string('alnum', 8);?>

<script type="text/javascript">
	$(document).ready(function(){
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$("a[rel*=facebox]").click(function() {
			var action = $(this).attr('myAction');
			var section = $(this).attr('mySec');
			var id = $(this).attr('myID');
			
			if (section == 'skin')
			{
				if (action == 'delete')
				{
					var location = '<?php echo site_url('ajax/del_catalogue/skins/');?>/' + id + '/<?php echo $string;?>';
				}
				
				if (action == 'edit')
				{
					var location = '<?php echo site_url('ajax/edit_catalogue/skins/');?>/' + id + '/<?php echo $string;?>';
				}
				
				if (action == 'add')
				{
					var location = '<?php echo site_url('ajax/add_catalogue/skins/'. $string);?>';
				}
			}
			else if (section == 'section')
			{
				if (action == 'delete')
				{
					var location = '<?php echo site_url('ajax/del_catalogue/skinsecs/');?>/' + id + '/<?php echo $string;?>';
				}
				
				if (action == 'edit')
				{
					var location = '<?php echo site_url('ajax/edit_catalogue/skinsecs/');?>/' + id + '/<?php echo $string;?>';
				}
				
				if (action == 'add')
				{
					var location = '<?php echo site_url('ajax/add_catalogue/skinsecs/'. $string);?>';
				}
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