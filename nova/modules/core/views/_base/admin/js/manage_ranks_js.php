<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php $string = random_string('alnum', 8);?>

<script type="text/javascript">
	$(document).ready(function(){
		$('div.zebra div:nth-child(odd)').addClass('alt');
		
		$('button.button-small').click(function(){
			var pid = $(this).attr('id');
			var action = $(this).attr('curAction');
			
			if (action == 'more')
			{
				$(this).attr('curAction', 'less');
				$('#tr_' + pid).slideDown();
				$(this).html('<span class="ui-icon ui-icon-triangle-1-n float_right"></span><span class="text"><?php echo ucwords($this->lang->line('labels_less'));?></span>&nbsp;');
			}
			else if (action == 'less')
			{
				$(this).attr('curAction', 'more');
				$('#tr_' + pid).slideUp();
				$(this).html('<span class="ui-icon ui-icon-triangle-1-s float_right"></span><span class="text"><?php echo ucwords($this->lang->line('labels_more'));?></span>&nbsp;');
			}
			
			return false;
		});
		
		$("a[rel*=facebox]").click(function() {
			var rankclass = $(this).attr('myClass');
			var set = $(this).attr('mySet');
			var location = '<?php echo site_url('ajax/add_rank');?>/' + set + '/' + rankclass + '/<?php echo $string;?>';
			
			$.facebox(function() {
				$.get(location, function(data) {
					$.facebox(data);
				});
			});
			
			return false;
		});
	});
</script>