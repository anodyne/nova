<?php

$specsarray = Database::instance()->list_columns('sms_specs', null, false);
$tourarray = Database::instance()->list_columns('sms_tour', null, false);

$keep = array('type', 'column_name', 'column_default', 'data_type', 'extra', 'key');

foreach ($specsarray as $key => $value)
{
	ksort($specsarray);
	
	foreach ($value as $k => $v)
	{
		if ( ! in_array($k, $keep))
		{
			unset($specsarray[$key][$k]);
		}
	}
}

foreach ($tourarray as $key => $value)
{
	ksort($tourarray);
	
	foreach ($value as $k => $v)
	{
		if ( ! in_array($k, $keep))
		{
			unset($tourarray[$key][$k]);
		}
	}
}

$specshash = md5(implode('', array_keys($specsarray)));
$tourhash = md5(implode('', array_keys($tourarray)));

?><script type="text/javascript" src="<?php echo Url::base().MODFOLDER;?>/assets/js/jquery.ajaxq.js"></script>
<script type="text/javascript" src="<?php echo Url::base().MODFOLDER;?>/assets/js/jquery.tipTip.js"></script>

<link rel="stylesheet" href="<?php echo Url::base().MODFOLDER;?>/assets/css/jquery.tipTip.css" />

<script type="text/javascript">
	$(document).ready(function(){
		var specshash = '<?php echo $specshash;?>';
		var tourhash = '<?php echo $tourhash;?>';
		
		$("#progress").progressbar({ value: 25 });
		$('#percent').text($('#progress').progressbar('option', 'value') + '%');
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$('#next').live('click', function(){
			$('.lower').fadeOut('fast');
			$('#loaded').fadeOut('fast', function(){
				$('#loading').removeClass('hidden');
			});
		});
		
		if (specshash != '5dbd1bfed7a4f67ecde6ad82e83ad0eb')
		{
			$('input[name=upgrade_specs]:nth(1)').attr("checked", true);
			$('input[name=upgrade_specs]').attr("disabled", "disabled");
		}
		
		if (tourhash != '95f4c7150d7629995765dba73a9f344b')
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
		
		$('#start').live('click', function(){
			var tipOpts = {
				defaultPosition: 'right',
				edgeOffset: 8
			}
			
			// characters and users
			if ($('input[name=upgrade_characters_users]:checked').val() == 1)
			{
				var send;
				
				$.ajaxq('queue', {
					beforeSend: function(){
						$('table tbody tr:eq(0) td:eq(1) .loading').removeClass('hidden');
					},
					type: "POST",
					url: "<?php echo Url::site('smsajax/upgrade_characters');?>",
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
						else if (data.code == 2)
						{
							$('table tbody tr:eq(0) td:eq(1) .warning').removeClass('hidden');
							$('table tbody tr:eq(0) td:eq(1) .warning img').attr('title', function(){
								return data.message
							});
							$('.tiptip').tipTip(tipOpts);
						}
					}
				});
			}
			
			// awards
			if ($('input[name=upgrade_awards]:checked').val() == 1)
			{
				var send;
				
				$.ajaxq('queue', {
					beforeSend: function(){
						$('table tbody tr:eq(1) td:eq(1) .loading').removeClass('hidden');
					},
					type: "POST",
					url: "<?php echo Url::site('smsajax/upgrade_awards');?>",
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
			}
			
			// settings and messages
			if ($('input[name=upgrade_settings]:checked').val() == 1)
			{
				var send;
				
				$.ajaxq('queue', {
					beforeSend: function(){
						$('table tbody tr:eq(2) td:eq(1) .loading').removeClass('hidden');
					},
					type: "POST",
					url: "<?php echo Url::site('smsajax/upgrade_settings');?>",
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
			}
			
			// personal logs
			if ($('input[name=upgrade_logs]:checked').val() == 1)
			{
				var send;
				
				$.ajaxq('queue', {
					beforeSend: function(){
						$('table tbody tr:eq(3) td:eq(1) .loading').removeClass('hidden');
					},
					type: "POST",
					url: "<?php echo Url::site('smsajax/upgrade_logs');?>",
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
						else if (data.code == 2)
						{
							$('table tbody tr:eq(3) td:eq(1) .warning').removeClass('hidden');
							$('table tbody tr:eq(3) td:eq(1) .warning img').attr('title', function(){
								return data.message
							});
							$('.tiptip').tipTip(tipOpts);
						}
					}
				});
			}
			
			// news categories and items
			if ($('input[name=upgrade_news]:checked').val() == 1)
			{
				var send;
				
				$.ajaxq('queue', {
					beforeSend: function(){
						$('table tbody tr:eq(4) td:eq(1) .loading').removeClass('hidden');
					},
					type: "POST",
					url: "<?php echo Url::site('smsajax/upgrade_news');?>",
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
						else if (data.code == 2)
						{
							$('table tbody tr:eq(4) td:eq(1) .warning').removeClass('hidden');
							$('table tbody tr:eq(4) td:eq(1) .warning img').attr('title', function(){
								return data.message
							});
							$('.tiptip').tipTip(tipOpts);
						}
					}
				});
			}
			
			// missions and mission posts
			if ($('input[name=upgrade_missions]:checked').val() == 1)
			{
				var send;
				
				$.ajaxq('queue', {
					beforeSend: function(){
						$('table tbody tr:eq(5) td:eq(1) .loading').removeClass('hidden');
					},
					type: "POST",
					url: "<?php echo Url::site('smsajax/upgrade_missions');?>",
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
						else if (data.code == 2)
						{
							$('table tbody tr:eq(5) td:eq(1) .warning').removeClass('hidden');
							$('table tbody tr:eq(5) td:eq(1) .warning img').attr('title', function(){
								return data.message
							});
							$('.tiptip').tipTip(tipOpts);
						}
					}
				});
			}
			
			// specs
			if ($('input[name=upgrade_specs]:checked').val() == 1)
			{
				var send;
				
				$.ajaxq('queue', {
					beforeSend: function(){
						$('table tbody tr:eq(6) td:eq(1) .loading').removeClass('hidden');
					},
					type: "POST",
					url: "<?php echo Url::site('smsajax/upgrade_specs');?>",
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
			}
			
			// tour items
			if ($('input[name=upgrade_tour]:checked').val() == 1)
			{
				var send;
				
				$.ajaxq('queue', {
					beforeSend: function(){
						$('table tbody tr:eq(7) td:eq(1) .loading').removeClass('hidden');
					},
					type: "POST",
					url: "<?php echo Url::site('smsajax/upgrade_tour');?>",
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
							$('.tiptip').tipTip(tipOpts);
						}
						else if (data.code == 2)
						{
							$('table tbody tr:eq(7) td:eq(1) .warning').removeClass('hidden');
							$('table tbody tr:eq(7) td:eq(1) .warning img').attr('title', function(){
								return data.message
							});
							$('.tiptip').tipTip(tipOpts);
						}
					}
				});
			}
			
			$('#progress').ajaxStop(function(){
				$("#progress").progressbar({ value: 50 });
				$('#percent').text($('#progress').progressbar('option', 'value') + '%');
				
				// change the button and text
				$('.lower .control button').attr('id', 'next').html('<?php echo __("Next Step");?>');
				$('.lower .control-text').html('<?php echo __("Move on to the next step of the upgrade process.");?>');
			});
			
			return false;
		});
	});
</script>