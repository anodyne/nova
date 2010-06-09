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
				},
				type: "POST",
				url: "<?php echo url::site('ajax/install_table');?>",
				data: send,
				success: function(data){
					// hide the loader
					$('.loading-table').addClass('hidden');
					
					if (data == "1")
					{
						$('strong.success-table').removeClass('hidden');
					}
					else
					{
						$('strong.error-table').removeClass('hidden');
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
	});
</script>