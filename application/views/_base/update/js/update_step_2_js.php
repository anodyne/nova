<script type="text/javascript">
	$(document).ready(function(){
		$("#progress").progressbar({ value: 100 });
		$('#percent').text($('#progress').progressbar('option', 'value') + '%');
	});
</script>