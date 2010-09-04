<script type="text/javascript" src="<?php echo url::base().MODFOLDER;?>/assets/js/jquery.ajaxq.js"></script>
<script type="text/javascript" src="<?php echo url::base().MODFOLDER;?>/assets/js/jquery.ui.position.min.js"></script>
<script type="text/javascript" src="<?php echo url::base().MODFOLDER;?>/assets/js/jquery.ui.tooltip.min.js"></script>

<link rel="stylesheet" href="<?php echo url::base().MODFOLDER;?>/assets/css/jquery.ui.tooltip.css" />

<script type="text/javascript">
	$(document).ready(function(){
		$("#progress").progressbar({ value: 50 });
		$('#percent').text($('#progress').progressbar('option', 'value') + '%');
		
		$('#next').click(function(){
			$('.lower').fadeOut('fast');
			$('#loaded').fadeOut('fast', function(){
				$('#loading').removeClass('hidden');
			});
		});
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
	});
	
	$('#start').live('click', function(){
		var send;
		
		// users
		$.ajaxq('queue', {
			beforeSend: function(){
				$('table tbody tr:eq(1) td:eq(1) .loading').removeClass('hidden');
			},
			type: "POST",
			url: "<?php echo url::site('updateajax/update_users');?>",
			data: send,
			dataType: 'json',
			success: function(data){
				$('table tbody tr:eq(0) td:eq(1) .loading').addClass('hidden');
				
				if (data.code == 1)
				{
					$('table tbody tr:eq(0) td:eq(1) .success').removeClass('hidden');
				}
				else if (data.code == 0)
				{
					$('table tbody tr:eq(0) td:eq(1) .failure').removeClass('hidden');
					$('table tbody tr:eq(0) td:eq(1) .failure img').attr('title', function(){
						return data.message
					});
				}
				else if (data.code == 2)
				{
					$('table tbody tr:eq(0) td:eq(1) .warning').removeClass('hidden');
					$('table tbody tr:eq(0) td:eq(1) .warning img').attr('title', function(){
						return data.message
					});
				}
			}
		});
		
		$('#progress').ajaxStop(function(){
			$("#progress").progressbar({ value: 75 });
			$('#percent').text($('#progress').progressbar('option', 'value') + '%');
			
			// change the button and text
			$('.lower .control button').attr('id', 'next').html('<?php echo __("Next Step");?>');
			$('.lower .control-text').html('<?php echo __("Move on to the final step of the upgrade process.");?>');
		});
		
		return false;
	});
</script>