<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Login Header
 *
 * @package		Nova
 * @category	Assets
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 */
?><script type="text/javascript" src="<?php echo base_url().MODFOLDER.'/assets/js/jquery.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url().MODFOLDER.'/assets/js/jquery.countdown.js';?>"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#countdown').countDown({
					startNumber: 5,
					startFontSize: '1em',
					endFontSize: '1em'
				});
			});
		</script>
		