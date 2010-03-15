<?php

$text = sprintf(
	lang('global_upgrading'),
	' '. lang('global_personallogs')
);

?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#progress").progressbar({ value: 56 });
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