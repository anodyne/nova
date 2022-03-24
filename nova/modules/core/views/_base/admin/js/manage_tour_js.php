<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php $string = random_string('alnum', 8);?>

<script type="text/javascript">
	function jq(myid) { 
		return myid.replace(/(:|\.)/g,'\\$1');
	}
	
	$(document).ready(function(){
		$('#tabs').tabs();
		
		$('.subtabs').tabs();
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		$('table.zebra-even tbody > tr:nth-child(even)').addClass('alt');
		
		$('#list-grid').sortable({
			forcePlaceholderSize: true,
			placeholder: 'ui-state-highlight'
		});
		$('#list-grid').disableSelection();
		
		$('.add').click(function(){
			var image = $(this).parent().parent().children().eq(0).html();
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('ajax/save_tour_image') .'/'. $id .'/'. $string;?>",
				data: { image: image, 'nova_csrf_token': $('input[name=nova_csrf_token]').val() },
				success: function(data){
					var content = '<li id="img_' + jq(image) +'"><a href="#" class="image upload-close" remove="' + jq(image) + '">x</a>' + data + '</li>';
					$(content).hide().appendTo('#list-grid').fadeIn();
				}
			});
			
			return false;
		});
		
		$(document).on('click', '#update', function(){
			var list = $('#list-grid').sortable('serialize');
			var data = list + '&' + $.param({'nova_csrf_token': $('input[name=nova_csrf_token]').val()});
			
			$.ajax({
				beforeSend: function(){
					$('#loading_upload_update').show();
				},
				type: "POST",
				url: "<?php echo site_url('ajax/save_tour_images') .'/'. $id .'/'. $string;?>",
				data: data,
				complete: function(){
					$('#loading_upload_update').hide();
				}
			});
			
			return false;
		});
		
		$(document).on('click', '.upload-close', function(){
			var image = $(this).attr('remove');
			var index = $(this).parent().index();
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('ajax/del_tour_image') .'/'. $id .'/'. $string;?>",
				data: { image: image, 'nova_csrf_token': $('input[name=nova_csrf_token]').val() },
				success: function(){
					$('#list-grid').children().eq(index).fadeOut('slow', function(){
						$(this).remove();
					});
				}
			});
			
			return false;
		});
		
		$("a[rel=facebox]").click(function() {
			var action = $(this).attr('myAction');
			var id = $(this).attr('myID');
			var location = '<?php echo site_url('ajax/del_tour_item');?>/' + id + '/<?php echo $string;?>';
			
			$.facebox(function() {
				$.get(location, function(data) {
					$.facebox(data);
				});
			});
			
			return false;
		});
		
		$('[rel=tooltip]').twipsy({
			animate: false,
			offset: 5,
			placement: 'right'
		});
	});
</script>