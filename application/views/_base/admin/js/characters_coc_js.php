<script type="text/javascript">
	$(document).ready(function(){
		$('#list').sortable({
			forcePlaceholderSize: true,
			placeholder: 'ui-state-highlight'
		});
		$('#list').disableSelection();
		
		$('#update').click(function(){
			var parent = $(this).parent().attr('class');
			var list = $('#list').sortable('serialize');
			
			$('#loading').ajaxStart(function(){
				$(this).show();
				$('#update').attr('disabled', 'disabled');
			});
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('ajax/save_coc');?>",
				data: list,
				success: function(data){
					$('.' + parent + ' .flash_message').remove();
					$('.' + parent).prepend(data);
				}
			});
			
			$('#loading').ajaxStop(function(){
				$(this).hide();
				$('#update').attr('disabled', '');
			});
			
			return false;
		});
		
		$('.remove').live("click", function(){
			var parent = $(this).parent().parent().parent().parent().attr('class');
			var id = $(this).attr('id');
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('ajax/del_coc');?>",
				data: { coc: id },
				success: function(data){
					$('.' + parent + ' .flash_message').remove();
					$('.' + parent).prepend(data);
				}
			});
			
			$('#coc_' + id).ajaxStop(function(){
				$(this).fadeOut('slow', function(){
					$(this).remove();
				});
			});
			
			return false;
		});
		
		$('#add').click(function(){
			var parent = $(this).parent().parent().attr('class');
			var id = $('#crew option:selected').val();
			var user = $('#crew option:selected').html();
			
			if (id > 0)
			{
				$('#loading').ajaxStart(function(){
					$(this).show();
					$('#add').attr('disabled', 'disabled');
				});
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('ajax/add_coc_entry');?>",
					data: { user: id },
					success: function(data){
						var content = '<li class="ui-state-default" id="coc_' + id;
						content += '"><div class="float_right"><a href="#" class="remove image" name="remove" id="' + id + '">x</a></div>' + user + '</li>';
						
						$('.' + parent + ' .flash_message').remove();
						$('.' + parent).prepend(data);
						$(content).hide().appendTo('#list').fadeIn('slow');
					}
				});
				
				$('#coc_' + id).ajaxStop(function(){
					$(this).fadeIn('slow');
				});
				
				$('#loading').ajaxStop(function(){
					$(this).hide();
					$('#add').attr('disabled', '');
				});
				
				$('#list').sortable('refresh');
			}
			
			return false;
		});
	});
</script>