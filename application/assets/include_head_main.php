<?php
/*
|---------------------------------------------------------------
| INCLUDE - HEADER DATA
|---------------------------------------------------------------
|
| File: application/assets/include_head_main.php
| System Version: 1.0
|
| File that pulls in all the required CSS and JS files for the
| system to use.
|
*/

?><style type="text/css">
			<?php if (!is_file(APPPATH .'views/'. $current_skin .'/main/css/jquery.lightbox.css')): ?>
				<?php $lightbox_css = base_url() . APPFOLDER .'/assets/js/css/jquery.lightbox.css';?>
			<?php else: ?>
				<?php $lightbox_css = base_url() . APPFOLDER .'/views/'. $current_skin .'/main/css/jquery.lightbox.css';?>
			<?php endif;?>
			
			<?php if (!is_file(APPPATH .'views/'. $current_skin .'/main/css/jquery.facebox.css')): ?>
				@import url("<?php echo base_url() . APPFOLDER .'/assets/js/css/jquery.facebox.css';?>");
			<?php else: ?>
				@import url("<?php echo base_url() . APPFOLDER .'/views/'. $current_skin .'/main/css/jquery.facebox.css';?>");
			<?php endif;?>
			
			@import url("<?php echo base_url() . APPFOLDER .'/assets/js/css/ui.core.css';?>");
			
			<?php if (!is_file(APPPATH .'views/'. $current_skin .'/main/css/ui.theme.css')): ?>
				@import url("<?php echo base_url() . APPFOLDER .'/assets/js/css/ui.theme.css';?>");
			<?php else: ?>
				@import url("<?php echo base_url() . APPFOLDER .'/views/'. $current_skin .'/main/css/ui.theme.css';?>");
			<?php endif;?>
		</style>
		
		<script type="text/javascript" src="<?php echo base_url() . APPFOLDER .'/assets/js/jquery.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url() . APPFOLDER .'/assets/js/jquery.lazy.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url() . APPFOLDER .'/assets/js/ui.core.min.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url() . APPFOLDER .'/assets/js/ui.tabs.min.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url() . APPFOLDER .'/assets/js/reflect.js';?>"></script>
		<script type="text/javascript" src="<?php echo base_url() . APPFOLDER .'/assets/js/jquery.facebox.js';?>"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
				$.lazy({					
					src: '<?php echo base_url() . APPFOLDER .'/assets/js/jquery.lightbox.js';?>',
					name: 'lightBox',
					dependencies: {
						css: ['<?php echo $lightbox_css;?>']
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
				
				$.facebox.settings.loadingImage = '<?php echo base_url() . APPFOLDER;?>/assets/js/images/facebox-loading.gif';
			});
		</script>