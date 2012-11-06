<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

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
		
		$(document).on('click', '#update', function(){
			var parent = $(this).parent().attr('class');
			var list = $('#list').sortable('serialize');
			var data = list + '&' + $.param({'nova_csrf_token': $('input[name=nova_csrf_token]').val()});
			
			$.ajax({
				beforeSend: function(){
					$('#loading').show();
					$('#update').prop({ disabled: true });
				},
				type: "POST",
				url: "<?php echo site_url('ajax/save_deck');?>",
				data: data,
				success: function(data){
					$('.' + parent + ' .flash_message').remove();
					$('.' + parent).prepend(data);
				},
				complete: function(){
					$('#loading').hide();
					$('#update').prop({ disabled: false });
				}
			});
			
			return false;
		});
		
		$(document).on('click', '.remove', function(){
			var parent = $(this).parent().parent().parent().parent().attr('class');
			var id = $(this).attr('id');
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('ajax/del_deck');?>",
				data: { deck: id, 'nova_csrf_token': $('input[name=nova_csrf_token]').val() },
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
		
		$(document).on('click', '#add', function(){
			var parent = $(this).parent().parent().attr('class');
			var send = {
				deck: $('#deck').val(),
				item: $('select[name=item] option:selected').val(),
				'nova_csrf_token': $('input[name=nova_csrf_token]').val()
			};
			
			$.ajax({
				beforeSend: function(){
					$('#loading').show();
					$('#add').prop({disabled: true});
				},
				type: "POST",
				url: "<?php echo site_url('ajax/add_deck');?>",
				data: send,
				success: function(data){
					$('#list').append(data).fadeIn('slow');
					$('#update_button_div').show();
				},
				complete: function(){
					$('#loading').hide();
					$('#add').prop({disabled: false});
				}
			});
			
			return false;
		});
	});
</script>