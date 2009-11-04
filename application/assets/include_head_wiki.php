<?php
/*
|---------------------------------------------------------------
| INCLUDE - HEADER DATA
|---------------------------------------------------------------
|
| File: application/assets/include_head_wiki.php
| System Version: 1.0
|
| File that pulls in all the required CSS and JS files for the
| system to use.
|
*/

/* pull in the config file */
$this->load->config('thresher');

/* grab the type of parsing */
$parse = $this->config->item('parsetype');

?><style type="text/css">
			<?php if (!is_file(APPPATH .'views/'. $current_skin .'/admin/css/jquery.facebox.css')): ?>
				@import url("<?php echo base_url() . APPFOLDER .'/assets/js/css/jquery.facebox.css';?>");
			<?php else: ?>
				@import url("<?php echo base_url() . APPFOLDER .'/views/'. $current_skin .'/admin/css/jquery.facebox.css';?>");
			<?php endif;?>
			
			@import url("<?php echo base_url() . APPFOLDER .'/assets/js/css/ui.core.css';?>");
			
			<?php if (!is_file(APPPATH .'views/'. $current_skin .'/admin/css/ui.theme.css')): ?>
				@import url("<?php echo base_url() . APPFOLDER .'/assets/js/css/ui.theme.css';?>");
			<?php else: ?>
				@import url("<?php echo base_url() . APPFOLDER .'/views/'. $current_skin .'/admin/css/ui.theme.css';?>");
			<?php endif;?>
			
			@import url("<?php echo base_url() . APPFOLDER .'/assets/js/markitup/skins/simple/style.css';?>");
			@import url("<?php echo base_url() . APPFOLDER .'/assets/js/markitup/sets/'. $parse .'/style.css';?>");
		</style>
			
		<script type="text/javascript" src="<?php echo base_url() . APPFOLDER .'/assets/js/jquery.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url() . APPFOLDER .'/assets/js/jquery.lazy.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url() . APPFOLDER .'/assets/js/ui.core.min.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url() . APPFOLDER .'/assets/js/ui.tabs.min.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url() . APPFOLDER .'/assets/js/jquery.facebox.js';?>"></script>
		
		<script type="text/javascript" src="<?php echo base_url() . APPFOLDER .'/assets/js/markitup/jquery.markitup.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url() . APPFOLDER .'/assets/js/markitup/sets/'. $parse .'/set.js';?>"></script>

		
		<script type="text/javascript">
			$(document).ready(function(){
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
				
				$.facebox.settings.loadingImage = '<?php echo base_url() . APPFOLDER;?>/assets/js/images/facebox-loading.gif';
				
				$('.markitup').markItUp(mySettings);
			});
		</script>