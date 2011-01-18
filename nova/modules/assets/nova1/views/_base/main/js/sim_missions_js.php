<script type="text/javascript">
	$(document).ready(function(){
		$("#tabs").tabs();
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$('#gallery a').colorbox({
			transition:	'elastic',
			speed:		400,
			rel:		'gallery'
		});
	});
</script>