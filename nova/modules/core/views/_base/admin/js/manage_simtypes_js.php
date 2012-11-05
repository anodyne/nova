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
		
		$('#update').click(function(){
			var parent = $(this).parent().attr('class');
			var list = $('#list').sortable('serialize');
			var data = list + '&' + $.param({'nova_csrf_token': $('input[name=nova_csrf_token]').val()});
			
			$('#loading').ajaxStart(function(){
				$(this).show();
				$('#update').prop({ disabled: true });
			});
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('ajax/save_deck');?>",
				data: data,
				success: function(data){
					$('.' + parent + ' .flash_message').remove();
					$('.' + parent).prepend(data);
				}
			});
			
			$('#loading').ajaxStop(function(){
				$(this).hide();
				$('#update').prop({ disabled: false });
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
		
		$('#add').click(function(){
			var parent = $(this).parent().parent().attr('class');
			var value = $('#deck').val();
			
			$('#loading').ajaxStart(function(){
				$(this).show();
				$('#add').prop({ disabled: true });
			});
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('ajax/add_deck');?>",
				data: { deck: value, 'nova_csrf_token': $('input[name=nova_csrf_token]').val() },
				success: function(data){
					$('#list').append(data).fadeIn('slow');
				}
			});
			
			$('#loading').ajaxStop(function(){
				$(this).hide();
				$('#add').prop({ disabled: false });
			});
			
			return false;
		});
	});
</script>