<?php

$text = sprintf(
	lang('global_upgrading'),
	' '. lang('labels_settings') .' '. AMP .' '. lang('labels_messages')
);

?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#progress").progressbar({ value: 28 });
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