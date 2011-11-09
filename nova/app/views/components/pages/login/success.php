<script type="text/javascript" src="<?php echo url::base().MODFOLDER.'/assets/js/jquery.countdown.js';?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#countdown').countDown({
			startNumber: 5,
			startFontSize: '1em',
			endFontSize: '1em'
		});
	});
</script>

<p><?php echo __("Log in successful. Redirecting to the :acp in <span id='countdown'></span>&nbsp;seconds...", array(':acp' => html::anchor('admin/index', ucwords(__("control panel")))));?></p>