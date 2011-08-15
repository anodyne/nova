<script type="text/javascript" src="<?php echo Url::base().MODFOLDER;?>/modules/assets/js/jquery.ajaxq.js"></script>
<script type="text/javascript" src="<?php echo Url::base().MODFOLDER;?>/modules/assets/js/jquery.tipTip.js"></script>

<link rel="stylesheet" href="<?php echo Url::base().MODFOLDER;?>/modules/assets/css/jquery.tipTip.css" />

<script type="text/javascript">
	$(document).ready(function(){
		$('#next').click(function(){
			$('.lower').fadeOut('fast');
			$('#loaded').fadeOut('fast', function(){
				$('#loading').removeClass('hidden');
			});
		});
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$('#start').live('click', function(){
			var send;
			
			var tipOpts = {
				defaultPosition: 'right',
				edgeOffset: 8
			}
			
			// user defaults
			$.ajaxq('queue', {
				beforeSend: function(){
					$('table tbody tr:eq(0) td:eq(1) .loading').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo Url::site('setup/smsajax/upgrade_user_defaults');?>",
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
						$('.tiptip').tipTip(tipOpts);
					}
				}
			});
			
			// welcome page
			$.ajaxq('queue', {
				beforeSend: function(){
					$('table tbody tr:eq(1) td:eq(1) .loading').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo Url::site('setup/smsajax/upgrade_welcome');?>",
				data: send,
				dataType: 'json',
				success: function(data){
					$('table tbody tr:eq(1) td:eq(1) .loading').addClass('hidden');
					
					if (data.code == 1)
					{
						$('table tbody tr:eq(1) td:eq(1) .success').removeClass('hidden');
					}
					else if (data.code == 0)
					{
						$('table tbody tr:eq(1) td:eq(1) .failure').removeClass('hidden');
						$('table tbody tr:eq(1) td:eq(1) .failure img').attr('title', function(){
							return data.message
						});
						$('.tiptip').tipTip(tipOpts);
					}
				}
			});
			
			// quick install
			$.ajaxq('queue', {
				beforeSend: function(){
					$('table tbody tr:eq(2) td:eq(1) .loading').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo Url::site('setup/smsajax/upgrade_quick_install');?>",
				data: send,
				dataType: 'json',
				success: function(data){
					$('table tbody tr:eq(2) td:eq(1) .loading').addClass('hidden');
					
					if (data.code == 1)
					{
						$('table tbody tr:eq(2) td:eq(1) .success').removeClass('hidden');
					}
					else if (data.code == 0)
					{
						$('table tbody tr:eq(2) td:eq(1) .failure').removeClass('hidden');
						$('table tbody tr:eq(2) td:eq(1) .failure img').attr('title', function(){
							return data.message
						});
						$('.tiptip').tipTip(tipOpts);
					}
					else if (data.code == 2)
					{
						$('table tbody tr:eq(2) td:eq(1) .warning').removeClass('hidden');
						$('table tbody tr:eq(2) td:eq(1) .warning img').attr('title', function(){
							return data.message
						});
						$('.tiptip').tipTip(tipOpts);
					}
				}
			});
			
			// upgrade news items with new user ids
			$.ajaxq('queue', {
				beforeSend: function(){
					$('table tbody tr:eq(3) td:eq(1) .loading').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo Url::site('setup/smsajax/upgrade_user_news');?>",
				data: send,
				dataType: 'json',
				success: function(data){
					$('table tbody tr:eq(3) td:eq(1) .loading').addClass('hidden');
					
					if (data.code == 1)
					{
						$('table tbody tr:eq(3) td:eq(1) .success').removeClass('hidden');
					}
					else if (data.code == 0)
					{
						$('table tbody tr:eq(3) td:eq(1) .failure').removeClass('hidden');
						$('table tbody tr:eq(3) td:eq(1) .failure img').attr('title', function(){
							return data.message
						});
						$('.tiptip').tipTip(tipOpts);
					}
				}
			});
			
			// upgrade personal logs with new user ids
			$.ajaxq('queue', {
				beforeSend: function(){
					$('table tbody tr:eq(4) td:eq(1) .loading').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo Url::site('setup/smsajax/upgrade_user_logs');?>",
				data: send,
				dataType: 'json',
				success: function(data){
					$('table tbody tr:eq(4) td:eq(1) .loading').addClass('hidden');
					
					if (data.code == 1)
					{
						$('table tbody tr:eq(4) td:eq(1) .success').removeClass('hidden');
					}
					else if (data.code == 0)
					{
						$('table tbody tr:eq(4) td:eq(1) .failure').removeClass('hidden');
						$('table tbody tr:eq(4) td:eq(1) .failure img').attr('title', function(){
							return data.message
						});
						$('.tiptip').tipTip(tipOpts);
					}
				}
			});
			
			// upgrade mission posts with new user ids
			$.ajaxq('queue', {
				beforeSend: function(){
					$('table tbody tr:eq(5) td:eq(1) .loading').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo Url::site('setup/smsajax/upgrade_user_posts');?>",
				data: send,
				dataType: 'json',
				success: function(data){
					$('table tbody tr:eq(5) td:eq(1) .loading').addClass('hidden');
					
					if (data.code == 1)
					{
						$('table tbody tr:eq(5) td:eq(1) .success').removeClass('hidden');
					}
					else if (data.code == 0)
					{
						$('table tbody tr:eq(5) td:eq(1) .failure').removeClass('hidden');
						$('table tbody tr:eq(5) td:eq(1) .failure img').attr('title', function(){
							return data.message
						});
						$('.tiptip').tipTip(tipOpts);
					}
				}
			});
			
			// upgrade awards with new user ids
			$.ajaxq('queue', {
				beforeSend: function(){
					$('table tbody tr:eq(6) td:eq(1) .loading').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo Url::site('setup/smsajax/upgrade_user_awards');?>",
				data: send,
				dataType: 'json',
				success: function(data){
					$('table tbody tr:eq(6) td:eq(1) .loading').addClass('hidden');
					
					if (data.code == 1)
					{
						$('table tbody tr:eq(6) td:eq(1) .success').removeClass('hidden');
					}
					else if (data.code == 0)
					{
						$('table tbody tr:eq(6) td:eq(1) .failure').removeClass('hidden');
						$('table tbody tr:eq(6) td:eq(1) .failure img').attr('title', function(){
							return data.message
						});
						$('.tiptip').tipTip(tipOpts);
					}
					else if (data.code == 2)
					{
						$('table tbody tr:eq(6) td:eq(1) .warning').removeClass('hidden');
						$('table tbody tr:eq(6) td:eq(1) .warning img').attr('title', function(){
							return data.message
						});
						$('.tiptip').tipTip(tipOpts);
					}
				}
			});
			
			$('#progress').ajaxStop(function(){
				$('.lower .control button').attr('id', 'next').html('Next Step');
				$('.lower .control-text').html('Move on to the final step of the upgrade process.');
			});
			
			return false;
		});
	});
</script>