<div class="page-header">
	<h1>Site Settings</h1>
</div>

<div class="row">
	<div class="span12">
		<div class="alert-message block-message">
			<ul>
				<li>We should look at an Ajax call that saves the content when the user leaves a field</li>
			</ul>
		</div>
		
		<div class="tabbable">
			<ul class="tabs">
				<li class="active"><a href="#general" data-toggle="tab">General Info</a></li>
				<li><a href="#system" data-toggle="tab">System Settings</a></li>
				<li><a href="#appearance" data-toggle="tab">Appearance</a></li>
				<li><a href="#email" data-toggle="tab">Email</a></li>
				<li><a href="#skin" data-toggle="tab">Skin Options</a></li>
				<li><a href="#usercreated" data-toggle="tab">User-Created Settings</a></li>
			</ul>
			
			<div class="tab-content">
				<div id="general" class="tab-pane active">
					<ul>
						<li><span class="label warning">change</span> Sim name proper (USS Nimitz NXI-3)</li>
						<li><span class="label success">add</span> Sim name standard (USS Nimitz)</li>
						<li>Type of sim</li>
						<li><span class="label important">remove</span> Year</li>
					</ul>
				</div>
				
				<div id="system" class="tab-pane">
					<ul>
						<li>Maintenance Mode</li>
						<li>Use mission notes</li>
						<li>Use sample post on join page</li>
						<li><span class="label warning">change</span> Date format (using PHP data format characters)</li>
						<li>Daylight savings time</li>
						<li><span class="label warning">change</span> Timezone (using different PHP timezone strings)</li>
						<li>Posting requirement</li>
						<li><span class="label important">remove</span> Specifying the number of awards to show in the bios</li>
						<li><span class="label important">remove</span> Allowed number of playing characters</li>
						<li><span class="label important">remove</span> Allowed number of NPCs</li>
						<li><span class="label important">remove</span> Number of mission posts to show in the post listing</li>
						<li><span class="label important">remove</span> Number of personal logs to show in the log listing</li>
						<li><span class="label important">remove</span> Whether to show news or not</li>
						<li><span class="label important">remove</span> Whether to show posts or not</li>
						<li><span class="label important">remove</span> Whether to show logs or not</li>
						<li><span class="label important">remove</span> Whether to use post participants (this is now mandatory)</li>
						<li><span class="label success">add</span> Set log in attempts</li>
						<li><span class="label success">add</span> Set log in lock out time</li>
					</ul>
				</div>
				
				<div id="appearance" class="tab-pane">
					<ul class="pills">
						<li class="active"><a href="#app-gen" data-toggle="pill">General</a></li>
						<li><a href="#app-skinsranks" data-toggle="pill">Skins &amp; Ranks</a></li>
						<li><a href="#app-widgets" data-toggle="pill">Widgets</a></li>
					</ul>
					
					<div class="pill-content">
						<div id="app-gen" class="pill-pane active">
							<ul>
								<li>General appearance options</li>
							</ul>
						</div>
						
						<div id="app-skinsranks" class="pill-pane">
							<ul>
								<li>Change defaults for skins and ranks</li>
							</ul>
						</div>
						
						<div id="app-widgets" class="pill-pane">
							<ul>
								<li><span class="label success">add</span> Manage widgets</li>
							</ul>
						</div>
					</div>
				</div>
				
				<div id="email" class="tab-pane">
					<ul>
						<li>Turn email on/off</li>
						<li>Set default email address</li>
						<li>Set default email address name</li>
						<li><span class="label success">add</span> Set email address for off site post archive (Yahoo! groups, Google Groups, email address, etc.)</li>
						<li><span class="label success">add</span> Set email address for off site log archive (Yahoo! groups, Google Groups, email address, etc.)</li>
						<li><span class="label success">add</span> Set email address for off site news archive (Yahoo! groups, Google Groups, email address, etc.)</li>
					</ul>
				</div>
				
				<div id="skin" class="tab-pane">
					<ul class="pills">
						<li class="active"><a href="#skin-gen" data-toggle="pill">General</a></li>
						<li><a href="#skin-footer" data-toggle="pill">Footer</a></li>
						<li><a href="#skin-metadata" data-toggle="pill">Meta Data</a></li>
					</ul>
					
					<div class="pill-content">
						<div id="skin-gen" class="pill-pane active">
							<ul>
								<li><span class="label success">add</span> Specify custom header image?</li>
								<li><span class="label success">add</span> Specify custom header text?</li>
							</ul>
						</div>
						
						<div id="skin-footer" class="pill-pane">
							<ul>
								<li><span class="label success">add</span> Update additional footer content here</li>
							</ul>
						</div>
						
						<div id="skin-metadata" class="pill-pane">
							<ul>
								<li><span class="label success">add</span> Meta data</li>
							</ul>
						</div>
					</div>
				</div>
				
				<div id="usercreated" class="tab-pane">
					<p><button class="btn">Add Setting</button></p>
					
					<ul>
						<li>User-created content</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>