<script type="text/javascript">
	$(document).ready(function(){
		$("#progress").progressbar({ value: 60 });
		$('#percent').text($('#progress').progressbar('option', 'value') + '%');
		
		$('#next').click(function(){
			$('#body').fadeOut('fast', function(){
				$('#loading').removeClass('hidden');
			});
		});
	});
</script>