<script type="text/javascript">
	$(document).ready(function(){
		$("#tabs").tabs();
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$('#gallery a').fancybox({
			overlayOpacity:		'0.5',
			titlePosition:		'over'
		});
	});
</script>