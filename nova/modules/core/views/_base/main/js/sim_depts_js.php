<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<script type="text/javascript">
	$(document).ready(function(){
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$('a.toggle').click(function(){
			var id = $(this).attr('myID');
			var div = '#' + id;
			
			if ($(div).is(':visible'))
			{
				$(div).slideUp('fast');
				$(this).html('<?php echo ucwords(lang("actions_show")." ".lang("global_positions"));?>');
			}
			else
			{
				$(div).slideDown('fast');
				$(this).html('<?php echo ucwords(lang("actions_hide")." ".lang("global_positions"));?>');
			}
			
			return false;
		});
	});
</script>