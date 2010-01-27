<?php echo text_output($header, 'h1', 'page-head');?>

<p class="fontMedium bold"><?php echo anchor('wiki/managepages', $label['back']);?></p>

<?php echo form_open('wiki/page/0/create');?>
	<?php echo text_output($label['title'], 'p', 'fontMedium bold');?>
	<?php echo form_input($inputs['title']);?>
	
	<br /><br />
	
	<?php echo text_output($label['summary'], 'p', 'fontMedium bold');?>
	<?php echo form_textarea($inputs['summary']);?>
	
	<br /><br />
	
	<?php echo form_textarea($inputs['content']);?>
	
	<br /><br />
	
	<?php echo text_output($label['categories'], 'p', 'fontMedium bold');?>
	
	<?php if (isset($cats)): ?>
		<?php $i = 0;?>
		<table class="table100 zebra">
			<tbody>
			<?php foreach ($cats as $c): ?>
				<?php if ($i % 4 == 0): ?>
					<tr>
				<?php endif;?>
						
						<td width="25%">
							<div class="inline_img_left">
								<?php echo form_checkbox('cat_'. $c['id'], $c['id'], FALSE, 'id="cat_'. $c['id'] .'"');?>
							</div>
							<label for="cat_<?php echo $c['id'];?>">
								<?php echo $c['name'];?>
								<span class="fontSmall gray">
									<?php if (!empty($c['desc'])): ?>
										<a href="#" rel="tooltip" tooltip="<?php echo $c['desc'];?>">[?]</a>
									<?php endif;?>
								</span>
							</label>
						</td>
						
						<?php if($i == (count($cats) - 1)): ?>
							<?php while (($i + 1) % 4 != 0): ?>
								<td width="25%">&nbsp;</td>
								<?php $i++;?>
							<?php endwhile; ?>
						<?php endif;?>
						
					<?php if (($i + 1) % 4 == 0): ?>
						</tr>
					<?php endif;?>
				<?php $i++;?>
			<?php endforeach;?>
			</tbody>
		</table>
	<?php endif;?>
	
	<br /><br />
	
	<?php echo text_output($label['comments'], 'p', 'fontMedium bold');?>
	<?php echo form_radio($inputs['comments_open']) .' '. form_label($label['open'], 'comments_open');?>
	<?php echo form_radio($inputs['comments_closed']) .' '. form_label($label['closed'], 'comments_closed');?>
	
	<br /><br />
	
	<?php echo form_button($buttons['add']);?>
<?php echo form_close();?>