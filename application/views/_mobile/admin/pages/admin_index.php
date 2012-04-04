<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php if ($notifycount > 0): ?>
	<?php $pending_totals = $notification['pending_users'] + $notification['pending_posts'] + $notification['pending_logs'] + $notification['pending_news'] + $notification['pending_comments'] + $notification['pending_awards'] + $notification['pending_docked'];?>
	
	<div data-role="collapsible" data-content-theme="c" data-theme="e" data-collapsed="false">
		<h3><?php echo $label['mynotify'];?></h3>
		
		<ul data-role="listview" data-theme="c" data-inset="true">
			<?php if ($notification['saved_posts'] > 0): ?>
				<li><?php echo anchor('write/index', $label['s_posts']);?><span class="ui-li-count"><?php echo $notification['saved_posts'];?></span></li>
			<?php endif;?>
			
			<?php if ($notification['saved_logs'] > 0): ?>
				<li><?php echo anchor('write/index', $label['s_logs']);?><span class="ui-li-count"><?php echo $notification['saved_logs'];?></span></li>
			<?php endif;?>
			
			<?php if ($notification['saved_news'] > 0): ?>
				<li><?php echo anchor('write/index', $label['s_news']);?><span class="ui-li-count"><?php echo $notification['saved_news'];?></span></li>
			<?php endif;?>
			
			<?php if ($notification['unread_pms'] > 0): ?>
				<li><?php echo anchor('messages/index', $label['pm']);?><span class="ui-li-count"><?php echo $notification['unread_pms'];?></span></li>
			<?php endif;?>
			
			<?php if ($pending_totals > 0): ?>
				<li data-role="list-divider" role="heading"><?php echo $label['m_pending_items'];?></li>
			<?php endif;?>
			
			<?php if ($notification['pending_users'] > 0): ?>
				<li><?php echo anchor('characters/index/pending', $label['p_users']);?><span class="ui-li-count"><?php echo $notification['pending_users'];?></span></li>
			<?php endif;?>
			
			<?php if ($notification['pending_posts'] > 0): ?>
				<li><?php echo anchor('manage/posts/pending', $label['p_posts']);?><span class="ui-li-count"><?php echo $notification['pending_posts'];?></span></li>
			<?php endif;?>
			
			<?php if ($notification['pending_logs'] > 0): ?>
				<li><?php echo anchor('manage/logs/pending', $label['p_logs']);?><span class="ui-li-count"><?php echo $notification['pending_logs'];?></span></li>
			<?php endif;?>
			
			<?php if ($notification['pending_news'] > 0): ?>
				<li><?php echo anchor('manage/news/pending', $label['p_news']);?><span class="ui-li-count"><?php echo $notification['pending_news'];?></span></li>
			<?php endif;?>
			
			<?php if ($notification['pending_comments'] > 0): ?>
				<li><?php echo anchor('manage/comments', $label['p_comments']);?><span class="ui-li-count"><?php echo $notification['pending_comments'];?></span></li>
			<?php endif;?>
			
			<?php if ($notification['pending_awards'] > 0): ?>
				<li><?php echo anchor('user/nominate/queue', $label['p_awards']);?><span class="ui-li-count"><?php echo $notification['pending_awards'];?></span></li>
			<?php endif;?>
			
			<?php if ($notification['pending_docked'] > 0): ?>
				<li><?php echo anchor('manage/docked/pending', $label['p_docked']);?><span class="ui-li-count"><?php echo $notification['pending_docked'];?></span></li>
			<?php endif;?>
		</ul>
	</div>
<?php endif;?>

<?php $total = $notification['saved_posts'] + $notification['saved_logs'] + $notification['saved_news'];?>

<ul data-role="listview" data-theme="c" data-inset="true">
	<li data-role="list-divider" role="heading"><?php echo $label['m_wcp'];?></li>
		<li><a href="<?php echo site_url('write/index');?>"><?php echo $label['m_saved'];?></a><span class="ui-li-count"><?php echo $total;?></span></li>
		<li><a href="<?php echo site_url('write/missionpost');?>"><?php echo $label['m_write_post'];?></a></li>
		<li><a href="<?php echo site_url('write/personallog');?>"><?php echo $label['m_write_log'];?></a></li>
		<li><a href="<?php echo site_url('write/newsitem');?>"><?php echo $label['m_write_news'];?></a></li>
	<li data-role="list-divider" role="heading"><?php echo $label['m_pms'];?></li>
		<li><a href="<?php echo site_url('messages/index');?>"><?php echo $label['m_inbox'];?></a><span class="ui-li-count"><?php echo $notification['unread_pms'];?></span></li>
		<li><a href="<?php echo site_url('messages/sent');?>"><?php echo $label['m_sent'];?></a></li>
		<li><a href="<?php echo site_url('messages/write');?>"><?php echo $label['m_write'];?></a></li>
	<li data-role="list-divider" role="heading"><?php echo $label['m_useropts'];?></li>
		<li><a href="<?php echo site_url('user/status');?>"><?php echo $label['m_loa'];?></a></li>
</ul>