<!-- BODY -->
<div id="body">
	<div class="wrapper">
		<div id="head">
			<div class="logo">
				<?php echo html::image(APPFOLDER.'/views/'.$skin.'/'.$sec.'/images/nova-small.png');?>
			</div>
			
			<?php echo $name;?>
		</div>
	
		<!-- PAGE CONTENT -->
		<div class="content">
			<?php echo $flash_message;?>
			<?php echo $content;?>
			
			<?php /*if (!$this->uri->segment(2) || $this->uri->segment(2) == 'index' || $this->uri->segment(2) == 'reset_password'): ?>
				<!-- FAUX FOOTER -->
				<div class="lower_content">
					<?php if ($this->uri->segment(2) && $this->uri->segment(2) != 'index'): ?>
						<strong><?php echo anchor('login/index', ucwords(lang('actions_login') .' '. lang('time_now')));?></strong>
						&nbsp; | &nbsp;
					<?php endif; ?>

					<?php if ($this->uri->segment(2) != 'reset_password'): ?>
						<strong><?php echo anchor('login/reset_password', ucwords(lang('actions_reset') .' '. lang('labels_password')));?></strong>
						&nbsp; | &nbsp;
					<?php endif; ?>

					<strong><?php echo anchor('main/index', ucfirst(lang('actions_back') .' '. lang('labels_to') .' '. lang('labels_site')));?></strong>
				</div>
			<?php endif;*/ ?>
		</div>
		
		<!-- FOOTER -->
		<div id="footer">
			Powered by <strong><?php echo Kohana::config('info.app_name');?></strong>
		</div>
	</div>
</div>