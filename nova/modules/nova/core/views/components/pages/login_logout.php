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

<h1 class="page-head"><?php echo $header;?></h1>

<p><?php echo __("You have successfully logged out. You can :login or proceed to the :main. You will be redirected in <span id='countdown'></span> seconds.", array(':login' => html::anchor('login/index', __("log in again")), ':main' => html::anchor('main/index', __("main site"))));?></p>