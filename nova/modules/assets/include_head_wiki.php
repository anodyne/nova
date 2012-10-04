<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Wiki Header
 *
 * @package		Nova
 * @category	Assets
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 */

// pull in the config file
$this->load->config('thresher');

// grab the type of parsing
$parse = $this->config->item('parsetype');

$faceboxcss = ( ! is_file(APPPATH.'views/'.$current_skin.'/wiki/css/jquery.facebox.css'))
	? base_url().MODFOLDER.'/assets/js/css/jquery.facebox.css'
	: base_url().APPFOLDER.'/views/'.$current_skin.'/wiki/css/jquery.facebox.css';
	
$uiTheme = ( ! is_file(APPPATH .'views/'.$current_skin.'/wiki/css/jquery.ui.theme.css'))
	? base_url().MODFOLDER.'/assets/js/css/jquery.ui.theme.css'
	: base_url().APPFOLDER.'/views/'.$current_skin.'/wiki/css/jquery.ui.theme.css';

?><style type="text/css">
			@import url("<?php echo base_url().MODFOLDER.'/assets/js/css/jquery.ui.core.css';?>");
			@import url('<?php echo $faceboxcss;?>');
			@import url('<?php echo $uiTheme;?>');
			@import url("<?php echo base_url().MODFOLDER.'/assets/js/markitup/skins/simple/style.css';?>");
			@import url("<?php echo base_url().MODFOLDER.'/assets/js/markitup/sets/'. $parse .'/style.css';?>");
			
			ul, ol { margin: 1em; padding: .5em; }
			ul li, ol li { margin: 2px; }
			ul { list-style: disc; }
			ol { list-style: decimal; }
			
			.panel-handle ul, .panel-handle ol, .panel-body ul { margin: 0; padding: 0; list-style: none; }
			.panel-handle ul li, .panel-handle ol li { margin: 0; }
		</style>
			
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url().MODFOLDER.'/assets/js/jquery.lazy.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url().MODFOLDER.'/assets/js/jquery.ui.core.min.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url().MODFOLDER.'/assets/js/jquery.ui.widget.min.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url().MODFOLDER.'/assets/js/jquery.facebox.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url().MODFOLDER.'/assets/js/markitup/jquery.markitup.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url().MODFOLDER.'/assets/js/markitup/sets/'.$parse.'/set.js';?>"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$.lazy({
					src: '<?php echo base_url().MODFOLDER;?>/assets/js/jquery.ui.tabs.min.js',
					name: 'tabs',
					cache: true
				});
				
				$.lazy({
					src: '<?php echo base_url() . MODFOLDER;?>/assets/js/bootstrap-twipsy.js',
					name: 'twipsy',
					dependencies: {
						css: ['<?php echo base_url() . MODFOLDER;?>/assets/js/css/bootstrap.css']
					},
					cache: true
				});
				
				$.lazy({
					src: '<?php echo base_url() . MODFOLDER;?>/assets/js/bootstrap-popover.js',
					name: 'popover',
					dependencies: {
						js: ['<?php echo base_url() . MODFOLDER;?>/assets/js/bootstrap-twipsy.js'],
						css: ['<?php echo base_url() . MODFOLDER;?>/assets/js/css/bootstrap.css']
					},
					cache: true
				});
				
				$('a#userpanel').toggle(function(){
					$('div.panel-body').slideDown('normal', function(){
						$('.panel-trigger div.ui-icon').removeClass('ui-icon-triangle-1-s');
						$('.panel-trigger div.ui-icon').addClass('ui-icon-triangle-1-n');
					});
					return false;
				}, function(){
					$('div.panel-body').slideUp('normal', function(){
						$('.panel-trigger div.ui-icon').removeClass('ui-icon-triangle-1-n');
						$('.panel-trigger div.ui-icon').addClass('ui-icon-triangle-1-s');
					});
					return false;
				});
				
				$.facebox.settings.loadingImage = '<?php echo base_url().MODFOLDER;?>/assets/js/images/facebox-loading.gif';
				
				$('.markitup').markItUp(mySettings);
			});
		</script>
		