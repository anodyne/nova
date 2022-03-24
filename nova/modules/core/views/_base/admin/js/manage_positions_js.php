<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php $string = random_string('alnum', 8);?>

<style>
.popover .inner { width: 550px !important; }
</style>

<script type="text/javascript">
	$(document).ready(function(){
		$('div.zebra div:nth-child(odd)').addClass('alt');
		
		$('.slider_control > .slider').each(function() {
			var value = parseInt($(this).text());
			var id = parseInt($(this).attr('id'));
			
			$(this).empty();
			$(this).slider({
				range: 'min',
				value: value,
				min: 0,
				max: 50,
				slide: function(event, ui) {
					$('#' + parseInt(ui.handle.parentNode.id) + '_amount').html(ui.value);
					$('#' + parseInt(ui.handle.parentNode.id) + '_open').val(ui.value);
				}
			});
		});
		
		$("a[rel=facebox]").click(function() {
			var id = $(this).attr('myID');
			var location = '<?php echo site_url('ajax/add_position');?>/' + id + '/<?php echo $string;?>';
			
			$.facebox(function() {
				$.get(location, function(data) {
					$.facebox(data);
				});
			});
			
			return false;
		});
		
		$('[rel=twipsy]').twipsy({
			animate: false,
			offset: 2
		});
		
		$('[rel=popover]').popover({
			trigger: 'manual',
			animate: false,
			placement: 'left',
			offset: 5,
			html: true
		}).click(function(e){
			
			// prevent the default action
			e.preventDefault();
			
			// hide all existing popovers
			$('[rel=popover]').each(function(){
				$(this).popover('hide');
			});
			
			// show the popover
			$(this).popover('show');
		});
		
		$(document).on('click', '.close-popover', function(e){
			
			// prevent the default action
			e.preventDefault();
			
			// hide all existing popovers
			$('[rel=popover]').each(function(){
				$(this).popover('hide');
			});
		});
		
		$(document).on('click', '[name=additional]', function(){
			var id = $(this).attr('id');
			var send = {
				'id': id,
				'order': $('#' + id + '_order').val(),
				'desc': $('#' + id + '_desc').val(),
				'display': $('#' + id + '_display').val(),
				'dept': $('#' + id + '_dept').val(),
				'type': $('#' + id + '_type').val(),
				'nova_csrf_token': $('input[name=nova_csrf_token]').val()
			}
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('ajax/save_position');?>",
				data: send,
				success: function(data){
					// update the content
					$('.popover .content').html('<p class="green bold"><?php echo $position_update_text;?></p>');
					
					// hide all existing popovers
					setTimeout(function(){
						$('[rel=popover]').each(function(){
							$(this).popover('hide');
						});
					}, 3000);
				}
			});
			
			return false;
		});
	});
</script>