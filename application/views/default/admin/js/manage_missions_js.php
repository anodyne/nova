<?php $string = random_string('alnum', 8);?>

<?php $image = base_url().Location::img('calendar-day.png', $this->skin, 'admin');?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url() . MODFOLDER;?>/assets/js/css/jquery.ui.datepicker.css" />

<style type="text/css">
	.ui-datepicker-trigger {
		display: block;
		float: left;
		margin: 0 -3px 0 0;
		padding: 3px 8px 4px 6px;
		
		background: #efefef;
		border: 1px solid #d5d5d5;
		border-right: 0;
		
		border-radius: 3px 0 0 3px;
		-moz-border-radius: 3px 0 0 3px;
		-webkit-border-top-left-radius: 3px;
		-webkit-border-top-right-radius: 3px;
	}
</style>

<script type="text/javascript" src="<?php echo base_url() . MODFOLDER;?>/assets/js/jquery.ui.datepicker.min.js"></script>

<script type="text/javascript">
	function jq(myid) { 
		return myid.replace(/(:|\.)/g,'\\$1');
	}
	
	$(document).ready(function(){
		var $tabs = $('#tabs').tabs();
		$tabs.tabs('select', <?php echo $tab;?>);
		
		$('.subtabs').tabs();
		
		var $date = $('.datepick').datepicker({
			numberOfMonths: 2,
			showButtonPanel: true,
			showOn: 'button',
			buttonImage: '<?php echo $image;?>',
			buttonImageOnly: true
		});
		$date.closest('body').find('#ui-datepicker-div').wrap('<span class="UITheme"></span>');
		$date.datepicker('option', {dateFormat: 'yy-mm-dd'});
		
		$('input[name=mission_start]').val('<?php echo $start;?>');
		$('input[name=mission_end]').val('<?php echo $end;?>');
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$("a[rel*=facebox]").click(function() {
			var action = $(this).attr('myAction');
			var id = $(this).attr('myID');
			var location = '<?php echo site_url('ajax/del_mission');?>/' + id + '/<?php echo $string;?>';
			
			$.facebox(function() {
				$.get(location, function(data) {
					$.facebox(data);
				});
			});
			
			return false;
		});
		
		$('#list-grid').sortable({
			forcePlaceholderSize: true,
			placeholder: 'ui-state-highlight'
		});
		$('#list-grid').disableSelection();
		
		$('.add').click(function(){
			var image = $(this).parent().parent().children().eq(0).html();
			
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('ajax/save_mission_image') .'/'. $id .'/'. $string;?>",
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
				url: "<?php echo site_url('ajax/save_mission_images') .'/'. $id .'/'. $string;?>",
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
				url: "<?php echo site_url('ajax/del_mission_image') .'/'. $id .'/'. $string;?>",
				data: { image: image, 'nova_csrf_token': $('input[name=nova_csrf_token]').val() },
				success: function(){
					$('#list-grid').children().eq(index).fadeOut('slow', function(){
						$(this).remove();
					});
				}
			});
			
			return false;
		});
	});
</script>