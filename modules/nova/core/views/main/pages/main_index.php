<h1 class="page-head"><?php echo $header;?></h1>

<p><?php echo $message;?></p><br />

<div id="nova-panel">
	<div class="nova-panel-nav">
		<div class="nova-panel-nav-links">
			<ul>
				<li><a href="#one"><span>Sim News</span></a></li>
				<li><a href="#two"><span>Mission Info</span></a></li>
				<li><a href="#three"><span>Recent Activity</span></a></li>
			</ul>
		</div>
		<h1 class="page-subhead">Sim News</h1>
	</div>
	<div class="nova-panel-content">
		<div class="nova-panel-content-one">
			<?php echo View::factory('_common/widgets/sim_news')->render();?>
		</div>
		
		<div class="nova-panel-content-two">
			<?php echo View::factory('_common/widgets/mission_info')->render();?>
		</div>
		
		<div class="nova-panel-content-three">
			
		</div>
	</div>
</div>