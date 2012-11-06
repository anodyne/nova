<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$specsarray = $this->sys->list_table_columns('sms_specs');
$tourarray = $this->sys->list_table_columns('sms_tour');

$specshash = md5(implode('', array_keys($specsarray))); // 59617c2da17b75be955ec6deff433f6e
$tourhash = md5(implode('', array_keys($tourarray))); // 781e5e245d69b566979b86e28d23f2c7

?><script type="text/javascript" src="<?php echo base_url().MODFOLDER;?>/assets/js/jquery.ajaxq.js"></script>
<script type="text/javascript" src="<?php echo base_url().MODFOLDER;?>/assets/js/bootstrap-twipsy.js"></script>
<link rel="stylesheet" href="<?php echo base_url().MODFOLDER;?>/assets/js/css/bootstrap.css" />

<script type="text/javascript">
	$(document).ready(function(){
		var specshash = '<?php echo $specshash;?>';
		var tourhash = '<?php echo $tourhash;?>';
		
		$("#progress").progressbar({ value: 25 });
		$('#percent').text($('#progress').progressbar('option', 'value') + '%');
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$(document).on('click', '#next', function(){
			$('.lower').fadeOut('fast');
			$('#loaded').fadeOut('fast', function(){
				$('#loading').removeClass('hidden');
			});
		});
		
		if (specshash != '59617c2da17b75be955ec6deff433f6e')
		{
			$('input[name=upgrade_specs]:nth(1)').attr("checked", true);
			$('input[name=upgrade_specs]').attr("disabled", "disabled");
		}
		
		if (tourhash != '781e5e245d69b566979b86e28d23f2c7')
		{
			$('input[name=upgrade_tour]:nth(1)').attr("checked", true);
			$('input[name=upgrade_tour]').attr("disabled", "disabled");
		}
		
		$('input[name=upgrade_characters_users]').change(function(){
			var checked = $('input[name=upgrade_characters_users]:checked').val();
			
			if (checked == 0)
			{
				$('input[name=upgrade_logs]:nth(1)').attr("checked", true);
				$('input[name=upgrade_logs]').attr("disabled", "disabled");
				
				$('input[name=upgrade_news]:nth(1)').attr("checked", true);
				$('input[name=upgrade_news]').attr("disabled", "disabled");
				
				$('input[name=upgrade_missions]:nth(1)').attr("checked", true);
				$('input[name=upgrade_missions]').attr("disabled", "disabled");
			}
			
			if (checked == 1)
			{
				$('input[name=upgrade_logs]:nth(0)').attr("checked", true);
				$('input[name=upgrade_logs]').attr("disabled", "");
				
				$('input[name=upgrade_news]:nth(0)').attr("checked", true);
				$('input[name=upgrade_news]').attr("disabled", "");
				
				$('input[name=upgrade_missions]:nth(0)').attr("checked", true);
				$('input[name=upgrade_missions]').attr("disabled", "");
			}
		});
		
		$(document).on('click', '#start', function(){
			var twipsyOptions = {
				animate: false,
				placement: 'right',
				offset: 2
			}
			
			// characters and users
			if ($('input[name=upgrade_characters_users]:checked').val() == 1)
			{
				var send = { 'nova_csrf_token': $('input[name=nova_csrf_token]').val() };
				
				$.ajaxq('queue', {
					beforeSend: function(){
						$('table tbody tr:eq(0) td:eq(1) .loading').removeClass('hidden');
					},
					type: "POST",
					url: "<?php echo site_url('upgradeajax/upgrade_characters');?>",
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
						else if (data.code == 2)
						{
							$('table tbody tr:eq(0) td:eq(1) .warning').removeClass('hidden');
							$('table tbody tr:eq(0) td:eq(1) .warning img').attr('title', function(){
								return data.message
							});
							$('.tiptip').twipsy(twipsyOptions);
						}
					}
				});
			}
			
			// awards
			if ($('input[name=upgrade_awards]:checked').val() == 1)
			{
				var send = { 'nova_csrf_token': $('input[name=nova_csrf_token]').val() };
				
				$.ajaxq('queue', {
					beforeSend: function(){
						$('table tbody tr:eq(1) td:eq(1) .loading').removeClass('hidden');
					},
					type: "POST",
					url: "<?php echo site_url('upgradeajax/upgrade_awards');?>",
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
			}
			
			// settings and messages
			if ($('input[name=upgrade_settings]:checked').val() == 1)
			{
				var send = { 'nova_csrf_token': $('input[name=nova_csrf_token]').val() };
				
				$.ajaxq('queue', {
					beforeSend: function(){
						$('table tbody tr:eq(2) td:eq(1) .loading').removeClass('hidden');
					},
					type: "POST",
					url: "<?php echo site_url('upgradeajax/upgrade_settings');?>",
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
			}
			
			// personal logs
			if ($('input[name=upgrade_logs]:checked').val() == 1)
			{
				var send = { 'nova_csrf_token': $('input[name=nova_csrf_token]').val() };
				
				$.ajaxq('queue', {
					beforeSend: function(){
						$('table tbody tr:eq(3) td:eq(1) .loading').removeClass('hidden');
					},
					type: "POST",
					url: "<?php echo site_url('upgradeajax/upgrade_logs');?>",
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
						else if (data.code == 2)
						{
							$('table tbody tr:eq(3) td:eq(1) .warning').removeClass('hidden');
							$('table tbody tr:eq(3) td:eq(1) .warning img').attr('title', function(){
								return data.message
							});
							$('.tiptip').twipsy(twipsyOptions);
						}
					}
				});
			}
			
			// news categories and items
			if ($('input[name=upgrade_news]:checked').val() == 1)
			{
				var send = { 'nova_csrf_token': $('input[name=nova_csrf_token]').val() };
				
				$.ajaxq('queue', {
					beforeSend: function(){
						$('table tbody tr:eq(4) td:eq(1) .loading').removeClass('hidden');
					},
					type: "POST",
					url: "<?php echo site_url('upgradeajax/upgrade_news');?>",
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
						else if (data.code == 2)
						{
							$('table tbody tr:eq(4) td:eq(1) .warning').removeClass('hidden');
							$('table tbody tr:eq(4) td:eq(1) .warning img').attr('title', function(){
								return data.message
							});
							$('.tiptip').twipsy(twipsyOptions);
						}
					}
				});
			}
			
			// missions and mission posts
			if ($('input[name=upgrade_missions]:checked').val() == 1)
			{
				var send = { 'nova_csrf_token': $('input[name=nova_csrf_token]').val() };
				
				$.ajaxq('queue', {
					beforeSend: function(){
						$('table tbody tr:eq(5) td:eq(1) .loading').removeClass('hidden');
					},
					type: "POST",
					url: "<?php echo site_url('upgradeajax/upgrade_missions');?>",
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
						else if (data.code == 2)
						{
							$('table tbody tr:eq(5) td:eq(1) .warning').removeClass('hidden');
							$('table tbody tr:eq(5) td:eq(1) .warning img').attr('title', function(){
								return data.message
							});
							$('.tiptip').twipsy(twipsyOptions);
						}
					}
				});
			}
			
			// database entries
			if ($('input[name=upgrade_database]:checked').val() == 1)
			{
				var send = { 'nova_csrf_token': $('input[name=nova_csrf_token]').val() };
				
				$.ajaxq('queue', {
					beforeSend: function(){
						$('table tbody tr:eq(6) td:eq(1) .loading').removeClass('hidden');
					},
					type: "POST",
					url: "<?php echo site_url('upgradeajax/upgrade_database');?>",
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
			}
			
			// specs
			if ($('input[name=upgrade_specs]:checked').val() == 1)
			{
				var send = { 'nova_csrf_token': $('input[name=nova_csrf_token]').val() };
				
				$.ajaxq('queue', {
					beforeSend: function(){
						$('table tbody tr:eq(7) td:eq(1) .loading').removeClass('hidden');
					},
					type: "POST",
					url: "<?php echo site_url('upgradeajax/upgrade_specs');?>",
					data: send,
					dataType: 'json',
					success: function(data){
						$('table tbody tr:eq(7) td:eq(1) .loading').addClass('hidden');
						
						if (data.code == 1)
						{
							$('table tbody tr:eq(7) td:eq(1) .success').removeClass('hidden');
						}
						else if (data.code == 0)
						{
							$('table tbody tr:eq(7) td:eq(1) .failure').removeClass('hidden');
							$('table tbody tr:eq(7) td:eq(1) .failure img').attr('title', function(){
								return data.message
							});
							$('.tiptip').twipsy(twipsyOptions);
						}
						else if (data.code == 2)
						{
							$('table tbody tr:eq(7) td:eq(1) .warning').removeClass('hidden');
							$('table tbody tr:eq(7) td:eq(1) .warning img').attr('title', function(){
								return data.message
							});
							$('.tiptip').twipsy(twipsyOptions);
						}
					}
				});
			}
			
			// tour items
			if ($('input[name=upgrade_tour]:checked').val() == 1)
			{
				var send = { 'nova_csrf_token': $('input[name=nova_csrf_token]').val() };
				
				$.ajaxq('queue', {
					beforeSend: function(){
						$('table tbody tr:eq(8) td:eq(1) .loading').removeClass('hidden');
					},
					type: "POST",
					url: "<?php echo site_url('upgradeajax/upgrade_tour');?>",
					data: send,
					dataType: 'json',
					success: function(data){
						$('table tbody tr:eq(8) td:eq(1) .loading').addClass('hidden');
						
						if (data.code == 1)
						{
							$('table tbody tr:eq(8) td:eq(1) .success').removeClass('hidden');
						}
						else if (data.code == 0)
						{
							$('table tbody tr:eq(8) td:eq(1) .failure').removeClass('hidden');
							$('table tbody tr:eq(8) td:eq(1) .failure img').attr('title', function(){
								return data.message
							});
							$('.tiptip').twipsy(twipsyOptions);
						}
						else if (data.code == 2)
						{
							$('table tbody tr:eq(8) td:eq(1) .warning').removeClass('hidden');
							$('table tbody tr:eq(8) td:eq(1) .warning img').attr('title', function(){
								return data.message
							});
							$('.tiptip').twipsy(twipsyOptions);
						}
					}
				});
			}
			
			$('#progress').ajaxStop(function(){
				$("#progress").progressbar({ value: 50 });
				$('#percent').text($('#progress').progressbar('option', 'value') + '%');
				
				// change the button and text
				$('.lower .control button').attr('id', 'next').html('Next Step');
			});
			
			return false;
		});
	});
</script>