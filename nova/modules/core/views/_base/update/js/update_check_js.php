<script type="text/javascript">
	$(document).ready(function(){
		$('input:first').focus();
		
		$('#next').click(function(){
			$('.lower').fadeOut('fast');
			$('#loaded').fadeOut('fast', function(){
				$('#loading').removeClass('hidden');
			});
		});
	});
</script>