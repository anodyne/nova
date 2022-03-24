<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php $string = random_string('alnum', 8);?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#tabs').tabs();
		$('#tabs').tabs('select', <?php echo $tab;?>);
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$("a[rel*=facebox]").click(function() {
			var action = $(this).attr('myaction');
			var did = $(this).attr('myid');
			
			if (action == 'add')
				var location = '<?php echo site_url('ajax/add_dept/'. $string);?>';
			if (action == 'delete')
				var location = '<?php echo site_url('ajax/del_dept');?>/' + did + '/<?php echo $string;?>';
			if (action == 'duplicate')
				var location = '<?php echo site_url('ajax/duplicate_dept');?>/' + did + '/<?php echo $string;?>';
			if (action == 'edit')
				var location = '<?php echo site_url('ajax/edit_dept');?>/' + did + '/<?php echo $string;?>';
			
			$.facebox(function() {
				$.get(location, function(data) {
					$.facebox(data);
				});
			});
			
			return false;
		});
	});
</script>