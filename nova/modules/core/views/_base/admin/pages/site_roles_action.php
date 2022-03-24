<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<p><?php echo anchor('site/roles', $label['back'], array('class' => 'bold'));?></p>

<?php echo text_output($text);?><br />

<?php if (isset($pages)): ?>
	<?php echo form_open('site/roles/'. $action .'/'. $id);?>
		<p>
			<kbd><?php echo $label['name'];?></kbd>
			<?php echo form_input($inputs['name']);?>
		</p>
		<p>
			<kbd><?php echo $label['desc'];?></kbd>
			<?php echo form_textarea($inputs['desc']);?>
		</p>
		
		<?php echo text_output($label['pages'], 'h3', 'page-subhead');?>
		
		<?php foreach ($pages['group'] as $group): ?>
			<?php echo text_output($group['group'], 'h4');?>
			
			<?php $i = 0;?>
			<table class="table100 zebra">
				<tbody>
				<?php foreach ($group['pages'] as $page): ?>
					<?php if ($i % 3 == 0): ?>
						<tr>
					<?php endif;?>
							
							<td class="col_30pct">
								<div class="inline_img_left">
									<?php echo form_checkbox('page_'. $page['id'], $page['id'], $page['checked'], 'id="page_'. $page['id'] .'"');?>
								</div>
								<label for="page_<?php echo $page['id'];?>">
									<?php echo $page['name'];?><br />
									<span class="fontSmall gray">
										<?php echo $page['url'];?>
										<?php if (!empty($page['desc'])): ?>
											<a href="#" rel="tooltip" title="<?php echo $page['desc'];?>">[?]</a>
										<?php endif;?>
									</span>
								</label>
							</td>
							
							<?php if($i == (count($group['pages']) - 1)): ?>
								<?php while (($i + 1) % 3 != 0): ?>
									<td class="col_30pct">&nbsp;</td>
									<?php $i++;?>
								<?php endwhile; ?>
							<?php endif;?>
							
						<?php if (($i + 1) % 3 == 0): ?>
							</tr>
						<?php endif;?>
					<?php $i++;?>
				<?php endforeach;?>
				</tbody>
			</table>
		<?php endforeach;?>
		
		<br />
		<?php echo form_button($button_submit);?>
	<?php echo form_close();?>
<?php endif;?>