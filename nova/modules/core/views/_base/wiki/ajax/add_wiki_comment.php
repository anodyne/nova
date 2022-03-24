<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo form_open('wiki/view/page/'. $id .'/comment');?>
	<?php echo form_textarea($inputs['comment_text']);?>