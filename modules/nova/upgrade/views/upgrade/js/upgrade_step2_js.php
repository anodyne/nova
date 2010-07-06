<script type="text/javascript" src="<?php echo url::base().MODFOLDER;?>/assets/js/jquery.ajaxq.js"></script>

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
		
		$('#start').live('click', function(){
			var send;
			
			// user defaults
			$.ajaxq('queue', {
				beforeSend: function(){
					$('table tbody tr:eq(0) td:eq(1) .loading').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo url::site('upgradeajax/upgrade_user_defaults');?>",
				data: send,
				success: function(data){
					$('table tbody tr:eq(0) td:eq(1) .loading').addClass('hidden');
					
					if (data == "1")
						$('table tbody tr:eq(0) td:eq(1) .success').removeClass('hidden');
					else
						$('table tbody tr:eq(0) td:eq(1) .failure').removeClass('hidden');
				}
			});
			
			// welcome page
			$.ajaxq('queue', {
				beforeSend: function(){
					$('table tbody tr:eq(1) td:eq(1) .loading').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo url::site('upgradeajax/upgrade_welcome');?>",
				data: send,
				success: function(data){
					$('table tbody tr:eq(1) td:eq(1) .loading').addClass('hidden');
					
					if (data == "1")
						$('table tbody tr:eq(1) td:eq(1) .success').removeClass('hidden');
					else
						$('table tbody tr:eq(1) td:eq(1) .failure').removeClass('hidden');
				}
			});
			
			// quick install
			$.ajaxq('queue', {
				beforeSend: function(){
					$('table tbody tr:eq(2) td:eq(1) .loading').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo url::site('upgradeajax/upgrade_quick_install');?>",
				data: send,
				success: function(data){
					$('table tbody tr:eq(2) td:eq(1) .loading').addClass('hidden');
					
					if (data == "1")
						$('table tbody tr:eq(2) td:eq(1) .success').removeClass('hidden');
					else
						$('table tbody tr:eq(2) td:eq(1) .failure').removeClass('hidden');
				}
			});
			
			// upgrade news items with new user ids
			$.ajaxq('queue', {
				beforeSend: function(){
					$('table tbody tr:eq(3) td:eq(1) .loading').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo url::site('upgradeajax/upgrade_user_news');?>",
				data: send,
				success: function(data){
					$('table tbody tr:eq(3) td:eq(1) .loading').addClass('hidden');
					
					if (data == "1")
						$('table tbody tr:eq(3) td:eq(1) .success').removeClass('hidden');
					else
						$('table tbody tr:eq(3) td:eq(1) .failure').removeClass('hidden');
				}
			});
			
			// upgrade personal logs with new user ids
			$.ajaxq('queue', {
				beforeSend: function(){
					$('table tbody tr:eq(4) td:eq(1) .loading').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo url::site('upgradeajax/upgrade_user_logs');?>",
				data: send,
				success: function(data){
					$('table tbody tr:eq(4) td:eq(1) .loading').addClass('hidden');
					
					if (data == "1")
						$('table tbody tr:eq(4) td:eq(1) .success').removeClass('hidden');
					else
						$('table tbody tr:eq(4) td:eq(1) .failure').removeClass('hidden');
				}
			});
			
			// upgrade mission posts with new user ids
			$.ajaxq('queue', {
				beforeSend: function(){
					$('table tbody tr:eq(5) td:eq(1) .loading').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo url::site('upgradeajax/upgrade_user_posts');?>",
				data: send,
				success: function(data){
					$('table tbody tr:eq(5) td:eq(1) .loading').addClass('hidden');
					
					if (data == "1")
						$('table tbody tr:eq(5) td:eq(1) .success').removeClass('hidden');
					else
						$('table tbody tr:eq(5) td:eq(1) .failure').removeClass('hidden');
				}
			});
			
			// upgrade awards with new user ids
			$.ajaxq('queue', {
				beforeSend: function(){
					$('table tbody tr:eq(6) td:eq(1) .loading').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo url::site('upgradeajax/upgrade_user_awards');?>",
				data: send,
				success: function(data){
					$('table tbody tr:eq(6) td:eq(1) .loading').addClass('hidden');
					
					if (data == "1")
						$('table tbody tr:eq(6) td:eq(1) .success').removeClass('hidden');
					else
						$('table tbody tr:eq(6) td:eq(1) .failure').removeClass('hidden');
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
	});
</script>