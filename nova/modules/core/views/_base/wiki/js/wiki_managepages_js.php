<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php $string = random_string('alnum', 8);?>

<script type="text/javascript" src="<?php echo base_url().MODFOLDER.'/assets/js/jquery.quicksearch.js';?>"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('click', '[rel=facebox]', function(){
			var id = $(this).attr('myID');
			var action = $(this).attr('myAction');
			
			if (action == 'deletePage')
				var location = '<?php echo site_url('ajax/del_wiki_page');?>/' + id + '/<?php echo $string;?>';
			if (action == 'deleteDraft')
				var location = '<?php echo site_url('ajax/del_wiki_draft');?>/' + id + '/<?php echo $string;?>';
			if (action == 'cleanup')
				var location = '<?php echo site_url('ajax/wiki_draft_cleanup');?>/<?php echo $string;?>';
			if (action == 'revert')
			{
				var page = $(this).attr('myPage');
				var draft = $(this).attr('myDraft');
				var location = '<?php echo site_url('ajax/revert_wiki_page');?>/' + page + '/' + draft + '/<?php echo $string;?>';
			}
			
			$.facebox(function() {
				$.get(location, function(data) {
					$.facebox(data);
				});
			});
			
			return false;
		});
		
		$('#search_pages > div').quicksearch({
			position: 'append',
			attached: 'div.search_pages',
			labelText: '',
			inputText: '<?php echo ucwords(lang("actions_search") ." ". lang("global_wiki") ." ". lang("labels_pages"));?>',
			loaderText: ''
		});
		
		$('#toggle-filters').click(function(){
			var visibility = $('.subnav-options-list').is(':visible');
			
			if (visibility == true)
				$('.subnav-options-list').hide();
			else
				$('.subnav-options-list').show();
				
			return false;
		});
		
		$('a[rel=toggle]').click(function(){
			var type = $(this).attr('id');
			
			// show everything to start with
			$('.standard').show();
			$('.system').show();
			$('.restricted').show();
			
			// don't do anything if we're showing everything
			if (type != 'show_all')
			{
				// figure out which css class we need to be targeting
				if (type == 'show_sys')
					var cl = 'system';
				if (type == 'show_std')
					var cl = 'standard';
				if (type == 'show_res')
					var cl = 'restricted';
				
				// loop through the items and hide the ones we don't need
				$('#search_pages').children().each(function(){
					if ( ! $(this).hasClass(cl))
					{
						$(this).hide();
					}
				});
			}
			
			// make sure the list of options is hidden after we select something
			$('.subnav-options-list').hide();
			
			return false;
		});
		
		$('a[rel=page-control]').click(function(){
			var item = $(this).attr('myID');
			var sec = $(this).attr('myAction');
			
			if (sec == 'info')
			{
				if ( ! $('#page-' + item + ' .page-supplemental .page-info').is(':visible'))
				{
					$('#page-' + item + ' .page-supplemental').children().addClass('hidden');
					$('#page-' + item + ' .page-supplemental .page-info').removeClass('hidden');
					$(this).parent().parent().children().removeClass('control-active');
					$(this).parent().addClass('control-active');
				}
			}
			else if (sec == 'history')
			{
				if ( ! $('#page-' + item + ' .page-supplemental .page-history').is(':visible'))
				{
					$('#page-' + item + ' .page-supplemental').children().addClass('hidden');
					$('#page-' + item + ' .page-supplemental .page-history').removeClass('hidden');
					$(this).parent().parent().children().removeClass('control-active');
					$(this).parent().addClass('control-active');
					
					$.ajax({
						type: "POST",
						data: { 'nova_csrf_token': $('input[name=nova_csrf_token]').val() },
						url: "<?php echo site_url('ajax/wiki_get_page_drafts');?>/" + item + "/<?php echo $string;?>",
						success: function(data){
							$('#page-' + item + ' .page-supplemental .page-history .loaded').html(data);
						},
						complete: function(){
							$('#page-' + item + ' .page-supplemental .page-history .loading').hide();
							$('#page-' + item + ' .page-supplemental .page-history .loaded').show();
						}
					});
				}
			}
			else if (sec == 'access')
			{
				if ( ! $('#page-' + item + ' .page-supplemental .page-restrictions').is(':visible'))
				{
					$('#page-' + item + ' .page-supplemental').children().addClass('hidden');
					$('#page-' + item + ' .page-supplemental .page-restrictions').removeClass('hidden');
					$(this).parent().parent().children().removeClass('control-active');
					$(this).parent().addClass('control-active');
					
					$.ajax({
						type: "POST",
						data: { 'nova_csrf_token': $('input[name=nova_csrf_token]').val() },
						url: "<?php echo site_url('ajax/wiki_get_page_restrictions');?>/" + item + "/<?php echo $string;?>",
						success: function(data){
							$('#page-' + item + ' .page-supplemental .page-restrictions .loaded').html(data);
						},
						complete: function(){
							$('#page-' + item + ' .page-supplemental .page-restrictions .loading').hide();
							$('#page-' + item + ' .page-supplemental .page-restrictions .loaded').show();
						}
					});
				}
			}
			
			return false;
		});
		
		$(document).on('click', '#submit', function(){
			var item = $(this).attr('rel');
			var roles = [];
			
			$('#page-' + item + ' .page-supplemental .page-restrictions .loaded table tbody tr td').children().each(function(i){
				if ($(this).is(':checked'))
					roles.push($(this).val());
			});
			
			$.ajax({
				beforeSend: function(){
					$('#page-' + item + ' .page-supplemental .page-restrictions .loaded #submit-success').hide();
					$('#page-' + item + ' .page-supplemental .page-restrictions .loaded #submit-failure').hide();
					$('#page-' + item + ' .page-supplemental .page-restrictions .loaded #submit-loading').show();
				},
				type: "POST",
				url: "<?php echo site_url('ajax/wiki_set_page_restrictions').'/'.$string;?>",
				data: { page: item, roles: roles, 'nova_csrf_token': $('input[name=nova_csrf_token]').val() },
				success: function(data){
					$('#page-' + item + ' .page-supplemental .page-restrictions .loaded #submit-loading').hide();
					
					if (data == '1')
						$('#page-' + item + ' .page-supplemental .page-restrictions .loaded #submit-success').show();
					else
						$('#page-' + item + ' .page-supplemental .page-restrictions .loaded #submit-failure').show();
				}
			});
			
			return false;
		});
		
		$('[rel=popover]').popover({
			animate: false,
			live: true,
			offset: 2
		});
	});
</script>