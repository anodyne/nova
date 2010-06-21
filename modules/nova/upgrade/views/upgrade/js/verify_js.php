<script type="text/javascript" charset="utf-8">
	$(document).ready(function(){
		$('#install').live('click', function(){
			$('#container .lower').fadeOut('fast');
			$('#loaded').fadeOut('fast', function(){
				$('#loading').removeClass('hidden');
			});
		});
	});
</script>