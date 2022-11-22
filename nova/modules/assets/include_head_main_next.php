<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Main Header
 *
 * @package		Nova
 * @category	Assets
 * @author		Anodyne Productions
 * @copyright	2022 Anodyne Productions
 */

$modFolder = base_url().MODFOLDER.'/';

$faceboxcss = (! is_file(APPPATH.'views/'.$current_skin.'/main/css/jquery.facebox.css'))
    ? base_url().MODFOLDER.'/assets/js/css/jquery.facebox.css'
    : base_url().APPFOLDER.'/views/'.$current_skin.'/main/css/jquery.facebox.css';

$uiTheme = (! is_file(APPPATH .'views/'.$current_skin.'/main/css/jquery.ui.theme.css'))
    ? base_url().MODFOLDER.'/assets/js/css/jquery.ui.theme.css'
    : base_url().APPFOLDER.'/views/'.$current_skin.'/main/css/jquery.ui.theme.css';

?><style type="text/css">
			@import url("<?php echo $modFolder.'assets/js/css/jquery.ui.core.css';?>");
			@import url('<?php echo $faceboxcss;?>');
			@import url('<?php echo $uiTheme;?>');
		</style>

		<script type="text/javascript" src="//code.jquery.com/jquery-1.8.3.min.js"></script>
		<script type="text/javascript" src="<?php echo $modFolder.'assets/js/jquery.lazy.js';?>"></script>
		<script type="text/javascript" src="<?php echo $modFolder.'assets/js/jquery.ui.core.min.js';?>"></script>
		<script type="text/javascript" src="<?php echo $modFolder.'assets/js/jquery.ui.widget.min.js';?>"></script>
		<script type="text/javascript" src="<?php echo $modFolder.'assets/js/reflection.js';?>"></script>
		<script type="text/javascript" src="<?php echo $modFolder.'assets/js/jquery.facebox.js';?>"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$.lazy({
					src: '<?php echo $modFolder;?>assets/js/jquery.ui.tabs.min.js',
					name: 'tabs',
					cache: true
				});

				$.lazy({
					src: '<?php echo $modFolder;?>assets/js/jquery.prettyPhoto.js',
					name: 'prettyPhoto',
					dependencies: {
						css: ['<?php echo $modFolder;?>assets/js/css/jquery.prettyPhoto.css']
					},
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

				$.facebox.settings.loadingImage = '<?php echo $modFolder;?>assets/js/images/facebox-loading.gif';

				$('.reflect').reflect({ opacity: '0.3' });
			});
		</script>
