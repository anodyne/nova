<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php $string = random_string('alnum', 8);?>

<script type="text/javascript">
	$(document).ready(function(){
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$("a[rel*=facebox]").click(function(){
			var id = $(this).attr('myID');
			var action = $(this).attr('myAction');
			
			if (action == 'add')
				var location = '<?php echo site_url('ajax/add_spec_sec/'. $string);?>';
				
			if (action == 'edit')
				var location = '<?php echo site_url('ajax/edit_spec_sec');?>/' + id + '/<?php echo $string;?>';
				
			if (action == 'delete')
				var location = '<?php echo site_url('ajax/del_spec_sec');?>/' + id + '/<?php echo $string;?>';
			
			$.facebox(function(){
				$.get(location, function(data){
					$.facebox(data);
				});
			});
			
			return false;
		});
	});
</script>