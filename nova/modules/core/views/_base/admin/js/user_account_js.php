<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php $string = random_string('alnum', 8);?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#tabs').tabs();
		
		$('#user-activate').click(function(){
			var id = $(this).attr('myid');
			var location = '<?php echo site_url("ajax/user_activate");?>/' + id + '/<?php echo $string;?>';
			
			$.facebox(function(){
				$.get(location, function(data){
					$.facebox(data);
				});
			});
			
			return false;
		});
		
		$('#user-deactivate').click(function(){
			var id = $(this).attr('myid');
			var location = '<?php echo site_url("ajax/user_deactivate");?>/' + id + '/<?php echo $string;?>';
			
			$.facebox(function(){
				$.get(location, function(data){
					$.facebox(data);
				});
			});
			
			return false;
		});
		
		$('#reset-password').click(function(){
			var id = $(this).attr('myid');
			var location = '<?php echo site_url("ajax/user_password_reset");?>/' + id + '/<?php echo $string;?>';
			
			$.facebox(function(){
				$.get(location, function(data){
					$.facebox(data);
				});
			});
			
			return false;
		});
	});
</script>