<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Wiki Header
 *
 * @package		Nova
 * @category	Assets
 * @author		Anodyne Productions
 * @copyright	2022 Anodyne Productions
 */

define('HEAD_NEXT_GEN', true);

// pull in the config file
$this->load->config('thresher');

// grab the type of parsing
$parse = $this->config->item('parsetype');

$modFolder = base_url().MODFOLDER.'/';

$faceboxcss = (! is_file(APPPATH.'views/'.$current_skin.'/wiki/css/jquery.facebox.css'))
    ? base_url().MODFOLDER.'/assets/js/css/jquery.facebox.css'
    : base_url().APPFOLDER.'/views/'.$current_skin.'/wiki/css/jquery.facebox.css';

$uiTheme = (! is_file(APPPATH .'views/'.$current_skin.'/wiki/css/jquery.ui.theme.css'))
    ? base_url().MODFOLDER.'/assets/js/css/jquery.ui.theme.css'
    : base_url().APPFOLDER.'/views/'.$current_skin.'/wiki/css/jquery.ui.theme.css';

?><style type="text/css">
			@import url("<?php echo $modFolder.'assets/js/css/jquery.ui.core.css';?>");
			@import url('<?php echo $faceboxcss;?>');
			@import url('<?php echo $uiTheme;?>');
			@import url("<?php echo $modFolder.'assets/js/markitup/skins/simple/style.css';?>");
			@import url("<?php echo $modFolder.'assets/js/markitup/sets/'. $parse .'/style.css';?>");
		</style>

		<script type="text/javascript" src="//code.jquery.com/jquery-1.8.3.min.js"></script>
		<script type="text/javascript" src="<?php echo $modFolder.'assets/js/jquery.lazy.js';?>"></script>
		<script type="text/javascript" src="<?php echo $modFolder.'assets/js/jquery.ui.core.min.js';?>"></script>
		<script type="text/javascript" src="<?php echo $modFolder.'assets/js/jquery.ui.widget.min.js';?>"></script>
		<script type="text/javascript" src="<?php echo $modFolder.'assets/js/jquery.facebox.js';?>"></script>
		<script type="text/javascript" src="<?php echo $modFolder.'assets/js/markitup/jquery.markitup.js';?>"></script>
		<script type="text/javascript" src="<?php echo $modFolder.'assets/js/markitup/sets/'.$parse.'/set.js';?>"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$.lazy({
					src: '<?php echo $modFolder;?>assets/js/jquery.ui.tabs.min.js',
					name: 'tabs',
					cache: true
				});

				$.lazy({
					src: '<?php echo $modFolder;?>assets/js/bootstrap-twipsy.js',
					name: 'twipsy',
					dependencies: {
						css: ['<?php echo $modFolder;?>assets/js/css/bootstrap.css']
					},
					cache: true
				});

				$.lazy({
					src: '<?php echo $modFolder;?>assets/js/bootstrap-popover.js',
					name: 'popover',
					dependencies: {
						js: ['<?php echo $modFolder;?>assets/js/bootstrap-twipsy.js'],
						css: ['<?php echo $modFolder;?>assets/js/css/bootstrap.css']
					},
					cache: true
				});

				$.facebox.settings.loadingImage = '<?php echo $modFolder;?>assets/js/images/facebox-loading.gif';

				$('.markitup').markItUp(mySettings);
			});
		</script>
