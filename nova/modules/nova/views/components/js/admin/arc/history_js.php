<script type="text/javascript">
	$('.status-toggle').on('click', function(){

		var status = $(this).data('status');

		if (status == 'inprogress')
		{
			$('.status-<?php echo Status::IN_PROGRESS;?>').show();
			$('.status-<?php echo Status::APPROVED;?>').hide();
			$('.status-<?php echo Status::REJECTED;?>').hide();
		}

		if (status == 'approved')
		{
			$('.status-<?php echo Status::APPROVED;?>').show();
			$('.status-<?php echo Status::IN_PROGRESS;?>').hide();
			$('.status-<?php echo Status::REJECTED;?>').hide();
		}

		if (status == 'rejected')
		{
			$('.status-<?php echo Status::REJECTED;?>').show();
			$('.status-<?php echo Status::APPROVED;?>').hide();
			$('.status-<?php echo Status::IN_PROGRESS;?>').hide();
		}

		if (status == 'all')
		{
			$('.status-<?php echo Status::IN_PROGRESS;?>').show();
			$('.status-<?php echo Status::APPROVED;?>').show();
			$('.status-<?php echo Status::REJECTED;?>').show();
		}
	});
</script>