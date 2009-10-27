<script type="text/javascript">
	$(document).ready(function(){
		$('input:first').focus();
		
		$('#next').click(function(){
			$('#body').fadeOut('fast', function(){
				$('#loading').removeClass('hidden');
			});
		});
	});
</script>