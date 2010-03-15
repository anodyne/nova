<?php

$text = sprintf(
	lang('global_upgrading'),
	' '. lang('global_characters') .' '. AMP .' '. lang('global_users')
);

?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#progress").progressbar({ value: 84 });
		$('#percent').text($('#progress').progressbar('option', 'value') + '%');
		
		$('#next').click(function(){
			$('.lower').fadeOut('fast');
			$('#loaded').fadeOut('fast', function(){
				$('#loading strong').html('<?php echo $text;?>');
				$('#loading').removeClass('hidden');
			});
		});
	});
</script>