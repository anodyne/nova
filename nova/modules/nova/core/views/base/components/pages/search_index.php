<h1 class="page-head"><?php echo $header;?></h1>

<p><?php echo __("Searching through Nova has never been simpler than it is right now. Instead of giving users tons of options they have to wade through, we've reduced search down to its most basic element: the search field. By default, Nova will search through :item for your search terms. Instead of just searching through one area, Nova will search through all the areas listed above the field. If you don't want all the areas searched, just click on the ones you don't want searched and Nova will ignore them. If you'd prefer to search for something besides :item, simply click on the icon in the field and select the new type of item you want to search for.", array(':item' => __('mission posts')));?></p>

<hr />

<div class="search-container">
	<div class="posts">
		<?php echo __(":search :posts", array(':search' => ucfirst(__("search")), ':posts' => __("mission posts")));?>:
		<span class="search-item p-title"><?php echo __("title");?></span>, <span class="search-item p-location"><?php echo __("location");?></span>, <span class="search-item p-timeline"><?php echo __("timeline");?></span>, <span class="search-item p-content"><?php echo __("content");?></span>, <span class="search-item p-tags"><?php echo __("tags");?></span>
	</div>
	
	<div class="logs hidden">
		<?php echo __(":search :logs", array(':search' => ucfirst(__("search")), ':logs' => __("personal logs")));?>:
		<span class="search-item l-title"><?php echo __("title");?></span>, <span class="search-item l-content"><?php echo __("content");?></span>, <span class="search-item l-tags"><?php echo __("tags");?></span>
	</div>
	
	<div class="news hidden">
		<?php echo __(":search :news", array(':search' => ucfirst(__("search")), ':news' => __("news items")));?>:
		<span class="search-item n-title"><?php echo __("title");?></span>, <span class="search-item n-content"><?php echo __("content");?></span>, <span class="search-item n-tags"><?php echo __("tags");?></span>
	</div>
	
	<div class="wiki hidden">
		<?php echo __(":search :wiki :pages", array(':search' => ucfirst(__("search")), ':wiki' => __("wiki"), ':pages' => __("pages")));?>:
		<span class="search-item w-title"><?php echo __("title");?></span>, <span class="search-item w-summary"><?php echo __("summary");?></span>, <span class="search-item w-changes"><?php echo __("changes");?></span>, <span class="search-item w-content"><?php echo __("content");?></span>
	</div>
</div>

<br />

<?php echo form::open('search/results');?>
	<div class="search-field">
		<span class="search-field-options options-posts"></span>
		<?php echo form::input('search', null, array('class' => 'search-field-input', 'placeholder' => __(":search :posts", array(':search' => ucfirst(__("search")), ':posts' => __("mission posts")))));?>
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
		<li><a href="#" class="opt-list-item" myItem="wiki"><span class="options-list-item options-wiki"></span><span><?php echo ucwords(__(':wiki :pages', array(':wiki' => ucfirst(__("wiki")), ':pages' => ucfirst(__("pages")))));?></span></a></li>
	</ul>
</div>