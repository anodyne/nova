<script type="text/javascript">
	$(document).ready(function(){
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$('a.toggle').click(function() {
			var id = $(this).attr('myID');
			var div = "#" + id;
			$(div).slideToggle('fast');
			
			return false;
		});
	});
</script>