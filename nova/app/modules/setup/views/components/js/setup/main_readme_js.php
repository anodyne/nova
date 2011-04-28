<script type="text/javascript">
	$(document).ready(function(){
		$('.install-options').click(function(){
			var opt = $(this).attr('option');
			
			if ($('#content_' + opt).is(':visible'))
				$('#content_' + opt).addClass('hidden');
			else
				$('#content_' + opt).removeClass('hidden');
			
			return false;
		});
	});
</script>