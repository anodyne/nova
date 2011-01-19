<script type="text/javascript">
	$(document).ready(function(){
		$('input[name=installType]').change(function(){
			var value = $('input[name=installType]:checked').val();
			
			if (value == 'nova1')
				$('input[name=prefix]').val('nova2_');
			else
				$('input[name=prefix]').val('nova_');
				
			return false;
		});
	});
</script>