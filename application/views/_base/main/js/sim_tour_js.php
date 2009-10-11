<script type="text/javascript">
	$(document).ready(function(){
		$('table.zebra tbody > tr:nth-child(odd)').addClass('alt');
		
		$('#gallery a').lightBox({
			imageLoading:	'<?php echo base_url() . APPFOLDER;?>/assets/js/images/lightbox-ico-loading.gif',
			imageBtnPrev:	'<?php echo base_url() . APPFOLDER;?>/assets/js/images/lightbox-btn-prev.gif',
			imageBtnNext:	'<?php echo base_url() . APPFOLDER;?>/assets/js/images/lightbox-btn-next.gif',
			imageBtnClose:	'<?php echo base_url() . APPFOLDER;?>/assets/js/images/lightbox-btn-close.gif',
		});
	});
</script>