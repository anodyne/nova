<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php $string = random_string('alnum', 8);?>

<script type="text/javascript">
	$(document).ready(function(){
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$('#tabs').tabs();
		
		$('a.addtoggle').click(function(){
			$('.addban').slideDown();
			return false;
		});
		
		$('input[name=ban_level]').change(function(){
			var selected = $('input[name=ban_level]:checked').val();
			
			if (selected == '1')
			{
				$('#ban_email').prop({ disabled: false }).val('');
			}
				
			if (selected == '2')
			{
				$('#ban_email').prop({ disabled: true }).val('');
				$('#ban_ip').focus();
			}
		});
		
		$("a[rel*=facebox]").click(function() {
			var id = $(this).attr('myID');
			var location = '<?php echo site_url('ajax/del_ban');?>/' + id + '/<?php echo $string;?>';
			
			$.facebox(function() {
				$.get(location, function(data) {
					$.facebox(data);
				});
			});
			
			return false;
		});
	});
</script>