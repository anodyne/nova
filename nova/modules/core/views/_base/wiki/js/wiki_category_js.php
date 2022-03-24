<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<script type="text/javascript" src="<?php echo base_url() . MODFOLDER .'/assets/js/jquery.quicksearch.js';?>"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('ul.cat_search li').quicksearch({
			position: 'append',
			attached: 'div.search_cat',
			labelText: '',
			inputText: '<?php echo ucwords(lang("actions_search") ." ". lang("global_wiki") ." ". lang("labels_pages"));?>',
			loaderText: '',
			stripeRowClass: ['alt', '']
		});
	});
</script>