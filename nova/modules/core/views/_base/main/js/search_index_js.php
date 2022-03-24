<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<script type="text/javascript">
	$(document).ready(function(){
		$('select[name=type]').change(function(){
			if ($(this).val() == 'wiki')
			{
				$('select[name=component] option:eq(2)').remove();
			}
			else
			{
				if ($('select[name=component] option:eq(2)').length == 0)
				{
					$('select[name=component]').append('<option value="tags"><?php echo ucfirst(lang("labels_tags"));?></option>');
				}
			}
		});
	});
</script>