<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<script type="text/javascript" src="<?php echo base_url().MODFOLDER;?>/assets/js/jquery.ajaxq.js"></script>
<script type="text/javascript" src="<?php echo base_url().MODFOLDER;?>/assets/js/bootstrap-twipsy.js"></script>
<link rel="stylesheet" href="<?php echo base_url().MODFOLDER;?>/assets/js/css/bootstrap-twipsy.css" />

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
		
		$(document).on('click', '#start', function(){
			var send = { 'nova_csrf_token': $('input[name=nova_csrf_token]').val() };
			
			var twipsyOptions = {
				placement: 'right',
				offset: 5,
				animate: false
			}
			
			// user defaults
			$.ajaxq('queue', {
				beforeSend: function(){
					$('table tbody tr:eq(0) td:eq(1) .loading').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo site_url('upgradeajax/upgrade_user_defaults');?>",
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
						$('.tiptip').twipsy(twipsyOptions);
					}
				}
			});
			
			// welcome page
			$.ajaxq('queue', {
				beforeSend: function(){
					$('table tbody tr:eq(1) td:eq(1) .loading').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo site_url('upgradeajax/upgrade_welcome');?>",
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
						$('.tiptip').twipsy(twipsyOptions);
					}
				}
			});
			
			// quick install
			$.ajaxq('queue', {
				beforeSend: function(){
					$('table tbody tr:eq(2) td:eq(1) .loading').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo site_url('upgradeajax/upgrade_quick_install');?>",
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
						$('.tiptip').twipsy(twipsyOptions);
					}
					else if (data.code == 2)
					{
						$('table tbody tr:eq(2) td:eq(1) .warning').removeClass('hidden');
						$('table tbody tr:eq(2) td:eq(1) .warning img').attr('title', function(){
							return data.message
						});
						$('.tiptip').twipsy(twipsyOptions);
					}
				}
			});
			
			// upgrade news items with new user ids
			$.ajaxq('queue', {
				beforeSend: function(){
					$('table tbody tr:eq(3) td:eq(1) .loading').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo site_url('upgradeajax/upgrade_user_news');?>",
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
						$('.tiptip').twipsy(twipsyOptions);
					}
				}
			});
			
			// upgrade personal logs with new user ids
			$.ajaxq('queue', {
				beforeSend: function(){
					$('table tbody tr:eq(4) td:eq(1) .loading').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo site_url('upgradeajax/upgrade_user_logs');?>",
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
						$('.tiptip').twipsy(twipsyOptions);
					}
				}
			});
			
			// upgrade mission posts with new user ids
			$.ajaxq('queue', {
				beforeSend: function(){
					$('table tbody tr:eq(5) td:eq(1) .loading').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo site_url('upgradeajax/upgrade_user_posts');?>",
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
						$('.tiptip').twipsy(twipsyOptions);
					}
				}
			});
			
			// upgrade awards with new user ids
			$.ajaxq('queue', {
				beforeSend: function(){
					$('table tbody tr:eq(6) td:eq(1) .loading').removeClass('hidden');
				},
				type: "POST",
				url: "<?php echo site_url('upgradeajax/upgrade_user_awards');?>",
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
						$('.tiptip').twipsy(twipsyOptions);
					}
					else if (data.code == 2)
					{
						$('table tbody tr:eq(6) td:eq(1) .warning').removeClass('hidden');
						$('table tbody tr:eq(6) td:eq(1) .warning img').attr('title', function(){
							return data.message
						});
						$('.tiptip').twipsy(twipsyOptions);
					}
				}
			});
			
			$('#progress').ajaxStop(function(){
				$("#progress").progressbar({ value: 75 });
				$('#percent').text($('#progress').progressbar('option', 'value') + '%');
				
				// change the button and text
				$('.lower .control button').attr('id', 'next').html('Next Step');
			});
			
			return false;
		});
	});
</script>