<script type="text/javascript">
	$(document).ready(function(){
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$('#table').live('click', function(){
			var table = $('input[name=table_name]').val();
			var send = {
				table: table
			};
			
			$.ajax({
				beforeSend: function(){
					// show the loader
					$('.loading-table').removeClass('hidden');
					$('.success-table').addClass('hidden');
					$('.error-table').addClass('hidden');
				},
				type: "POST",
				url: "<?php echo url::site('ajax/install_table');?>",
				data: send,
				success: function(data){
					// hide the loader
					$('.loading-table').addClass('hidden');
					
					if (data == "1")
					{
						$('.success-table').removeClass('hidden');
					}
					else
					{
						$('.error-table').removeClass('hidden');
					}
				}
			});
			
			return false;
		});
		
		$('select[name=field_type]').change(function(){
			var selected = $('select[name=field_type] option:selected').val();
			
			if (selected == 'VARCHAR')
			{
				$('input[name=field_constraint]')
					.val('100')
					.attr('disabled', '')
					.animate({
						width: '75px'
					}, 700);
				$('input[name=field_default]').val('').attr('disabled', '').focus();
			}
			else if (selected == 'TEXT' || selected == 'LONGTEXT')
			{
				$('input[name=field_constraint]')
					.val('')
					.attr('disabled', 'disabled')
					.animate({
						width: '275px'
					}, 700);
				$('input[name=field_default]').val('').attr('disabled', 'disabled');
			}
			else if (selected == 'INT')
			{
				$('input[name=field_constraint]')
					.val('5')
					.attr('disabled', '')
					.animate({
						width: '30px'
					}, 700);
				$('input[name=field_default]').val('0').attr('disabled', '').focus();
			}
			else if (selected == 'TINYINT')
			{
				$('input[name=field_constraint]')
					.val('1')
					.attr('disabled', '')
					.animate({
						width: '15px'
					}, 700);
				$('input[name=field_default]').val('0').attr('disabled', '').focus();
			}
			else if (selected == 'BIGINT')
			{
				$('input[name=field_constraint]')
					.val('20')
					.attr('disabled', '')
					.animate({
						width: '75px'
					}, 700);
				$('input[name=field_default]').val('0').attr('disabled', '').focus();
			}
			else if (selected == 'ENUM')
			{
				$('input[name=field_constraint]')
					.val('')
					.attr('disabled', '')
					.animate({
						width: '275px'
					}, 700)
					.focus();
				$('input[name=field_default]').val('').attr('disabled', '');
			}
		});
		
		$('#field').live('click', function(){
			var table = $('select[name=table_name] option:selected').val();
			var field_name = $('input[name=field_name]').val();
			var field_type = $('select[name=field_type] option:selected').val();
			var field_constraint = $('input[name=field_constraint]').val();
			var field_default = $('input[name=field_default]').val();
			var send = {
				table: table,
				name: field_name,
				type: field_type,
				constraint: field_constraint,
				def: field_default
			};
			
			$.ajax({
				beforeSend: function(){
					// show the loader
					$('.loading-field').removeClass('hidden');
					$('.success-field').addClass('hidden');
					$('.error-field').addClass('hidden');
				},
				type: "POST",
				url: "<?php echo url::site('ajax/install_field');?>",
				data: send,
				success: function(data){
					// hide the loader
					$('.loading-field').addClass('hidden');
					
					if (data == "1")
					{
						$('.success-field').removeClass('hidden');
					}
					else
					{
						$('.error-field').removeClass('hidden');
					}
				}
			});
			
			return false;
		});
		
		$('#query').live('click', function(){
			var query = $('textarea[name=query]').val();
			var send = {
				query: query
			};
			
			$.ajax({
				beforeSend: function(){
					// show the loader
					$('.loading-query').removeClass('hidden');
					$('.success-query').addClass('hidden');
					$('.error-query').addClass('hidden');
				},
				type: "POST",
				url: "<?php echo url::site('ajax/install_query');?>",
				data: send,
				success: function(data){
					// hide the loader
					$('.loading-query').addClass('hidden');
					
					if (data == "1")
					{
						$('.success-query').removeClass('hidden');
					}
					else
					{
						$('.error-query').removeClass('hidden');
					}
				}
			});
			
			return false;
		});
	});
</script>