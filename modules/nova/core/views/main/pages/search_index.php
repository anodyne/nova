<h1 class="page-head">Search</h1>

<p><?php echo __('search.text', array(':posts' => __('mission posts')));?></p>

<hr />

<div class="search-container">
	<div class="posts">
		Searching mission posts: <span class="search-item p-title">title</span>, <span class="search-item p-location">location</span>, <span class="search-item p-timeline">timeline</span>, <span class="search-item p-content">content</span>, <span class="search-item p-tags">tags</span>
	</div>
	
	<div class="logs hidden">
		Searching personal logs: <span class="search-item l-title">title</span>, <span class="search-item l-content">content</span>, <span class="search-item l-tags">tags</span>
	</div>
	
	<div class="news hidden">
		Searching news items: <span class="search-item n-title">title</span>, <span class="search-item n-content">content</span>, <span class="search-item n-tags">tags</span>
	</div>
	
	<div class="wiki hidden">
		Searching wiki pages: <span class="search-item w-title">title</span>, <span class="search-item w-summary">summary</span>, <span class="search-item w-changes">changes</span>, <span class="search-item w-content">content</span>
	</div>
</div>

<br />

<?php echo form::open('search/results');?>
	<div class="search-field">
		<span class="search-field-options options-posts"></span>
		<?php echo form::input('search', null, array('class' => 'search-field-input', 'placeholder' => __("Search Mission Posts")));?>
	</div>
	
	<?php echo form::hidden('type', 'posts');?>
	<?php echo form::hidden('criteria', '');?>
	<br />
	
	<p><?php echo form::button('submit', ucfirst(__('search')), array('class' => 'btn-main'));?></p>
<?php echo form::close();?>

<div class="search-field-options-list hidden">
	<ul>
		<li><a href="#" class="opt-list-item" myItem="posts"><span class="options-list-item options-posts"></span><span><?php echo ucwords(__('mission posts'));?></span></a></li>
		<li><a href="#" class="opt-list-item" myItem="logs"><span class="options-list-item options-logs"></span><span><?php echo ucwords(__('personal logs'));?></span></a></li>
		<li><a href="#" class="opt-list-item" myItem="news"><span class="options-list-item options-news"></span><span><?php echo ucwords(__('news items'));?></span></a></li>
		<li><a href="#" class="opt-list-item" myItem="wiki"><span class="options-list-item options-wiki"></span><span><?php echo ucwords(__('wiki pages'));?></span></a></li>
	</ul>
</div>