<?php $string = random_string('alnum', 8);?>

<script type="text/javascript">
	$(document).ready(function(){
		$("a[rel*=facebox]").click(function() {
			var id = $(this).attr('myID');
			var location = '<?php echo site_url('ajax/edit_deck');?>/' + id + '/<?php echo $string;?>';
			
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
			
			$.ajax({
				beforeSend: function(){
					$('#loading').show();
					$('#update').attr('disabled', 'disabled');
				},
				type: "POST",
				url: "<?php echo site_url('ajax/save_deck');?>",
				data: list,
				success: function(data){
					$('.' + parent + ' .flash_message').remove();
					$('.' + parent).prepend(data);
				},
				complete: function(){
					$('#loading').hide();
					$('#update').attr('disabled', '');
				}
			});
			
			return false;
		});
		
		$('.remove').live("click", function(){
			var parent = $(this).parent().parent().parent().parent().attr('class');
			var id = $(this).attr('id');
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('ajax/del_deck');?>",
				data: { deck: id },
				success: function(data){
					$('.' + parent + ' .flash_message').remove();
					$('.' + parent).prepend(data);
				}
			});
			
			$('#decks_' + id).ajaxStop(function(){
				$(this).fadeOut('slow', function(){
					$(this).remove();
				});
			});
			
			return false;
		});
		
		$('#add').click(function(){
			var parent = $(this).parent().parent().attr('class');
			var value = $('#deck').val();
			
			$.ajax({
				beforeSend: function(){
					$('#loading').show();
					$('#add').attr('disabled', 'disabled');
				},
				type: "POST",
				url: "<?php echo site_url('ajax/add_deck');?>",
				data: { deck: value },
				success: function(data){
					$('#list').append(data).fadeIn('slow');
				},
				complete: function(){
					$('#loading').hide();
					$('#add').attr('disabled', '');
				}
			});
			
			return false;
		});
	});
</script>