<script type="text/javascript">
	$(document).ready(function(){
		$("#tabs").tabs();
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$("a[rel^='prettyPhoto']").prettyPhoto({
			theme: 'dark_rounded'
		});
	});
</script>