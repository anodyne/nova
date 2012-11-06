<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php $string = random_string('alnum', 8);?>

<script type="text/javascript" src="<?php echo base_url().MODFOLDER;?>/assets/js/jquery.ui.mouse.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().MODFOLDER;?>/assets/js/jquery.ui.draggable.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().MODFOLDER;?>/assets/js/jquery.ui.droppable.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$('#add').click(function(){
			$('#add-panel').slideDown();
			return false;
		});
		
		$('.draggable').draggable({
			grid: [5,5]
		});
		$('.droppable').droppable({
			hoverClass: 'ui-state-highlight',
			drop: function(event, ui){
				var send = {
					manifest: $(this).attr('mid'),
					dept: ui.draggable.attr('did'),
					'nova_csrf_token': $('input[name=nova_csrf_token]').val()
				}
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('ajax/save_dept_manifest/'.$string);?>",
					data: send,
					success: function(data){
						// can we align the items here?
					}
				});
			}
		});
		
		$('[rel=tooltip]').twipsy({
			animate: false,
			offset: 5
		});
		
		$("a[rel=facebox]").click(function() {
			var action = $(this).attr('myAction');
			var id = $(this).attr('myID');
			
			if (action == 'delete')
				var location = '<?php echo site_url('ajax/del_manifest');?>/' + id + '/<?php echo $string;?>';
			
			if (action == 'edit')
				var location = '<?php echo site_url('ajax/edit_manifest');?>/' + id + '/<?php echo $string;?>';
			
			$.facebox(function() {
				$.get(location, function(data) {
					$.facebox(data);
				});
			});
			
			return false;
		});
	});
</script>