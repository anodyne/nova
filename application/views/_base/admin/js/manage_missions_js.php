<link rel="stylesheet" type="text/css" href="<?php echo base_url() . APPFOLDER;?>/assets/js/css/ui.datepicker.css" />

<script type="text/javascript" src="<?php echo base_url() . APPFOLDER;?>/assets/js/jquery.ui.datepicker.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		var $tabs = $('#tabs').tabs();
		$tabs.tabs('select', <?php echo $tab;?>);
		
		var $date = $('.datepick').datepicker({
			numberOfMonths: 2,
			showButtonPanel: true
		});
		$date.closest('body').find('#ui-datepicker-div').wrap('<span class="UITheme"></span>');
		$date.datepicker('option', {dateFormat: 'yy-mm-dd'});
		
		$('input[name=mission_start]').val('<?php echo $start;?>');
		$('input[name=mission_end]').val('<?php echo $end;?>');
		
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$('.imagepick').click(function(){
			var image = $(this).attr('myfile');
			
			if ($('#images').val() == '')
				var pre = '';
			else
				var pre = ', ';
				
			$('#images').append(pre + image);
			
			return false;
		});
		
		$("a[rel*=facebox]").click(function() {
			var action = $(this).attr('myAction');
			var id = $(this).attr('myID');
			var location = '<?php echo site_url('ajax/del_mission');?>/' + id;
			
			$.facebox(function() {
				$.get(location, function(data) {
					$.facebox(data);
				});
			});
			
			return false;
		});
	});
</script>