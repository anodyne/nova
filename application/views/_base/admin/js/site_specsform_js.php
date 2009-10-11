<script type="text/javascript">
	$(document).ready(function(){
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$("a[rel*=facebox]").click(function() {
			var id = $(this).attr('myID');
			var action = $(this).attr('myAction');
			var field = $(this).attr('myField');
			
			if (action == 'add')
				var location = '<?php echo site_url('ajax/add_spec_field');?>';
			
			if (action == 'delete')
				var location = '<?php echo site_url('ajax/del_spec_field');?>/' + id;
				
			if (action == 'edit_val')
				var location = '<?php echo site_url('ajax/edit_spec_field_value');?>/' + id + '/' + field;
			
			$.facebox(function() {
				$.get(location, function(data) {
					$.facebox(data);
				});
			});
			
			return false;
		});
		
		$('#list').sortable({
			forcePlaceholderSize: true,
			placeholder: 'ui-state-highlight'
		});
		$('#list').disableSelection();
		
		$('#update').click(function(){
			var parent = $(this).parent().attr('class');
			var list = $('#list').sortable('serialize');
			
			$('#loading_update').ajaxStart(function(){
				$(this).show();
				$('#update').attr('disabled', 'disabled');
			});
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('ajax/save_spec_field_value');?>",
				data: list,
				success: function(data){
					$('.' + parent + ' .flash_message').remove();
					$('.' + parent).prepend(data);
				}
			});
			
			$('#loading_update').ajaxStop(function(){
				$(this).hide();
				$('#update').attr('disabled', '');
			});
			
			return false;
		});
		
		$('.remove').click(function(){
			var parent = $(this).parent().parent().parent().parent().attr('class');
			var id = $(this).attr('id');
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('ajax/del_spec_field_value');?>",
				data: { field: id },
				success: function(data){
					$('.' + parent + ' .flash_message').remove();
					$('.' + parent).prepend(data);
				}
			});
			
			$('#value_' + id).ajaxStop(function(){
				$(this).fadeOut('slow', function(){
					$(this).remove();
				});
			});
			
			return false;
		});
		
		$('#add').click(function(){
			var parent = $(this).parent().parent().attr('class');
			var value = $('#value').val();
			var content = $('#content').val();
			var field = $('#add').val();
			
			$('#loading_add').ajaxStart(function(){
				$(this).show();
				$('#add').attr('disabled', 'disabled');
			});
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('ajax/add_spec_field_value');?>",
				data: { value: value, content: content, field: field },
				success: function(data){
					$('#list').append(data);
				}
			});
			
			$('#loading_add').ajaxStop(function(){
				$(this).hide();
				$('#add').attr('disabled', '');
			});
			
			return false;
		});
	});
</script>