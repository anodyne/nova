<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php $string = random_string('alnum', 8);?>

<script type="text/javascript">
	$(document).ready(function(){
		$tabs = $('#tabs').tabs();
		$tabs.tabs('select', <?php echo $tab;?>);
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$("a[rel*=facebox]").click(function(){
			var action = $(this).attr('myAction');
			var location;
			
			if (action == 'comment')
			{
				var id = $(this).attr('myID');
				
				location = '<?php echo site_url('ajax/add_comment_wiki');?>/' + id + '/<?php echo $string;?>';
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