<?php $string = random_string('alnum', 8);?>

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
		
		$('button.button-small').click(function(){
			var pid = $(this).attr('id');
			var action = $(this).attr('curAction');
			
			if (action == 'more')
			{
				$(this).attr('curAction', 'less');
				$('#tr_' + pid).slideDown();
				$(this).html('<span class="text"><?php echo ucwords($this->lang->line('labels_less'));?></span>');
			}
			else if (action == 'less')
			{
				$(this).attr('curAction', 'more');
				$('#tr_' + pid).slideUp();
				$(this).html('<span class="text"><?php echo ucwords($this->lang->line('labels_more'));?></span>');
			}
			
			return false;
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
	});
</script>