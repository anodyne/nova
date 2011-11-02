<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#search-trigger').click(function(){
			var visible = $('#search-panel').is(':visible');
			
			if (visible)
				$('#search-panel').slideUp();
			else
				$('#search-panel').slideDown();
				
			return false;
		});
	});
</script>