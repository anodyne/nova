<script type="text/javascript">
	$(document).ready(function(){
		$('#tabs').tabs();
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$('#accordion').accordion({ header: 'h2' });
		$('#accordion a').css('border-bottom', 'none');
		
		$('#loader').hide();
		$('#loaded').removeClass('hidden');
	});
</script>