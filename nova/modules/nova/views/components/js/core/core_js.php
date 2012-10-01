<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="<?php echo Uri::base(false);?>nova/modules/assets/js/jquery.lazy.js"></script>
<script type="text/javascript" src="<?php echo Uri::base(false);?>nova/modules/assets/js/bootstrap.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		
		$.lazy({
			src: "<?php echo Uri::base(false);?>nova/modules/assets/js/jquery.chosen.min.js",
			name: 'chosen',
			dependencies: {
				css: ['<?php echo Uri::base(false);?>nova/modules/assets/css/jquery.chosen.css']
			},
			cache: true
		});

		// initialize the chosen plugin if it's there
		$('.chzn').chosen();
		
		/**
		 * Bootstrap Tooltips
		 */
		$('.tooltip-right').tooltip({
			placement: 'right'
		});
		$('.tooltip-left').tooltip({
			placement: 'left'
		});
		$('.tooltip-top').tooltip({
			placement: 'top'
		});
		$('.tooltip-bottom').tooltip({
			placement: 'bottom'
		});

		/**
		 * Bootstrap Popovers
		 */
		$('.popover-right').tooltip({
			placement: 'right',
			html: true
		});
		$('.popover-left').tooltip({
			placement: 'left',
			html: true
		});
		$('.popover-top').tooltip({
			placement: 'top',
			html: true
		});
		$('.popover-bottom').tooltip({
			placement: 'bottom',
			html: true
		});
	});

	// rank dropdown
	$('#rankDrop').on('change', function(){
		
		$.ajax({
			type: "POST",
			url: "<?php echo Uri::create('ajax/info/rank_image');?>",
			data: {
				rank: $('#rankDrop option:selected').val(),
				location: 'default'
			},
			success: function(data){
				$('#rankImg').html('');
				$('#rankImg').append(data);
			}
		});
		
		return false;
	});

	// position dropdown
	$('#positionDrop').on('change', function(){
		
		$.ajax({
			type: "POST",
			url: "<?php echo Uri::create('ajax/info/position_desc');?>",
			data: { position: $('#positionDrop option:selected').val() },
			success: function(data){
				$('#positionDesc').html('');
				$('#positionDesc').append(data);
			}
		});
		
		return false;
	});

	// access role dropdown
	$('#roleDrop').on('change', function(){
		
		$.ajax({
			type: "POST",
			url: "<?php echo Uri::create('ajax/info/accessrole_desc');?>",
			data: { role: $('#roleDrop option:selected').val() },
			success: function(data){
				$('#roleDesc').html('');
				$('#roleDesc').append(data);
			}
		});
		
		return false;
	});
</script>