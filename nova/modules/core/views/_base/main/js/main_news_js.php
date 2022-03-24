<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<script type="text/javascript">
	$(document).ready(function() {
		$('a.show').click(function() {
			var id = $(this).attr('myID');
			var header = $(this).attr('myTitle');
			
			$('.news').hide();
			$('h1.page-head').html(header);
			$('.' + id).show();
			
			return false;
		});
		
		$('a.all').click(function(){
			var header = $(this).attr('myTitle');
			
			$('h1.page-head').html(header);
			$('.news').show();
			
			return false;
		});
		
		$('#loader').hide(); /* hide the loader */
		$('#news').removeClass('hidden'); /* show the news */
	});
</script>