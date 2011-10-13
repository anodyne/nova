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
		
		$('.close-popover').live('click', function(e){
			
			// prevent the default action
			e.preventDefault();
			
			// hide all existing popovers
			$('[rel=popover]').each(function(){
				$(this).popover('hide');
			});
		});
	});
</script>