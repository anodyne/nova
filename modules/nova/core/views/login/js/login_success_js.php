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