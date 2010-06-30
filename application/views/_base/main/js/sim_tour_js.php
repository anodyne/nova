<script type="text/javascript">
	$(document).ready(function(){
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		$('table.zebra-even tbody > tr:nth-child(even)').addClass('alt');
		
		$('#gallery a').fancybox({
			overlayOpacity:		'0.5',
			titlePosition:		'over'
		});
	});
</script>