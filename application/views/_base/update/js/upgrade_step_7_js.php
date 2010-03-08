<script type="text/javascript">
	$(document).ready(function(){
		$("#progress").progressbar({ value: 49 });
		$('#percent').text($('#progress').progressbar('option', 'value') + '%');
		
		$('#next').click(function(){
			$('.lower').fadeOut('fast');
			$('#loaded').fadeOut('fast', function(){
				$('#loading').removeClass('hidden');
			});
		});
	});
</script>