<?php echo text_output($header, 'h1', 'page-head');?>

<?php if (isset($specs)): ?>
	<ul class="square margin1 padding1 fontMedium">
	<?php foreach ($specs as $k => $s): ?>
		<li><?php echo anchor('manage/decks/'.$k, $s);?></li>
	<?php endforeach;?>
	</ul>
<?php else: ?>
	<?php echo text_output($text);?>
	
	<p class="bold"><?php echo anchor('manage/decks', $label['back']);?></p>
	
	<div class="fontSmall gray loader bold">
		&nbsp;
		
		<div id="loading" class="hidden">
			<?php echo img($loading);?><br />
			<?php echo $label['processing'];?>
		</div>
		<br />
	</div>
	
	<div>
		<?php echo form_input($inputs['deck']);?>
		&nbsp;
		<?php echo form_dropdown('item', $values['specs'], $this->uri->segment(3));?>
		&nbsp;
		<?php echo form_button($buttons['add']);?>
	</div><br />
	
	<hr /><br />

	<?php if (isset($decks)): ?>
		<ul id="list" class="UITheme">
			<?php foreach ($decks as $key => $value): ?>
				<li class="ui-state-default" id="decks_<?php echo $key;?>">
					<div class="float_right"><a href="#" class="remove image" name="remove" id="<?php echo $key;?>">x</a></div>
					<a href="#" rel="facebox" class="image" myID="<?php echo $key;?>"><?php echo $value;?></a>
				</li>
			<?php endforeach; ?>
		</ul>
		
		<br />
		<?php echo form_button($buttons['submit']);?>
	<?php endif;?>
<?php endif;?>