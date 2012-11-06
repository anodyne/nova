<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>

<div class="fontSmall gray loader bold">
	&nbsp;
	
	<div id="loading" class="hidden">
		<?php echo img($loading);?><br />
		<?php echo $label['processing'];?>...
	</div>
	<br />
</div>

<div>
	<?php echo form_dropdown_characters('characters', '', 'id="crew"', 'user_npc', TRUE);?>
	&nbsp;
	<?php echo form_button($buttons['add']);?>
</div><br />

<hr /><br />

<div class="UITheme">
	<ul id="list">
		<?php if (isset($coc)): ?>
			<?php foreach ($coc as $key => $value): ?>
				<li class="ui-state-default" id="coc_<?php echo $key;?>">
					<div class="float_right"><a href="#" class="remove image" name="remove" id="<?php echo $key;?>">x</a></div>
					<?php echo $value;?>
				</li>
			<?php endforeach; ?>
		<?php endif; ?>
	</ul>
</div>

<div class="submit-div hidden">
	<br />
	<?php echo form_button($buttons['submit']);?>
</div>

<?php echo form_open().form_close();?>
