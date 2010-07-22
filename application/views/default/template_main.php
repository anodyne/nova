<noscript>
	<div class="system_warning"></div>
</noscript>

<?php if (Auth::is_logged_in()): ?>
	<!-- USER PANEL -->
	<div id="panel">
		<div class="panel-body">
			<div class="wrapper">
				<table class="table100">
					<tbody>
						<tr>
							<td class="panel_1 align_top"><?php echo $panel_1;?></td>
							<td class="panel_spacer"></td>
							<td class="panel_2 align_top"><?php echo $panel_2;?></td>
							<td class="panel_spacer"></td>
							<td class="panel_3 align_top"><?php echo $panel_3;?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="panel-handle UITheme">
			<div class="wrapper">
				<?php echo $panel_workflow;?>
			</div>
		</div>
	</div>
<?php endif; ?>

<!-- HEAD -->
<div id="head">
	<div class="head_top"></div>
	<div class="wrapper">
		<div class="head_content">
			<?php echo html::image('application/views/'.$skin.'/'.$sec.'/images/head-logo.png');?>
		</div>
	</div>
</div>

<!-- MENU -->
<div id="menu">
	<div class="wrapper">
		<div class="nav-main">
			<?php echo $nav_main;?>
		</div>
	</div>
</div>

<!-- BODY -->
<div id="body">
	<div class="wrapper">
		<!-- SUB NAVIGATION -->
		<div class="nav-sub">
			<h1><?php echo Jelly::query('setting')->key('sim_name')->limit(1)->select()->value;?></h1>
			<hr />
			<?php echo $nav_sub;?>
		</div>
		
		<!-- PAGE CONTENT -->
		<div class="content">
			<?php echo $flash_message;?>
			<?php echo $content;?>
			<?php echo $ajax;?>
			
			<div style="clear:both;">&nbsp;</div>
			
			<!-- FOOTER -->
			<div id="footer">
				Powered by <strong>Nova</strong> from <a href="http://www.anodyne-productions.com" target="_blank">Anodyne Productions</a> | 
				<?php echo html::anchor('main/credits', 'Site Credits');?>
			</div>
		</div>
	</div>
</div>