<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<p class="bold"><?php echo anchor('wiki/managepages', $label['back']);?></p>

<?php echo form_open('wiki/page/'. $id .'/edit');?>
	<?php echo text_output($label['title'], 'p', 'fontMedium bold');?>
	<?php echo form_input($inputs['title']);?>
	
	<br /><br />
	
	<?php echo text_output($label['summary'], 'p', 'fontMedium bold');?>
	<?php echo form_textarea($inputs['summary']);?>
	
	<br /><br />
	
	<?php echo form_textarea($inputs['content']);?>
	
	<br /><br />
	
	<?php if ($type == 'standard'): ?>
		<?php echo text_output($label['categories'], 'p', 'fontMedium bold');?>
		
		<div id="category-panel">
			<?php if (Auth::check_access('wiki/categories', false)): ?>
				<div class="category-panel-header">
					<input type="text" id="category-panel-name" placeholder="<?php echo $label['addcategory'];?>" value="" />
					<button id="category-panel-create"><span></span></button>
				</div>
			<?php endif;?>
			
			<div class="category-panel-content">
				<div id="category-panel-content-tags">
					<?php if (isset($cats)): ?>
						<?php foreach ($cats as $c): ?>
							<?php $catclass = (is_array($inputs['categories']) and in_array($c['id'], $inputs['categories'])) ? ' tag-active' : '';?>
							<nobr><span class="tag<?php echo $catclass;?>" id="<?php echo $c['id'];?>"><?php echo $c['name'];?></span></nobr>
						<?php endforeach;?>
						<input type="hidden" name="categories" value=",<?php echo $inputs['category_string'];?>," />
					<?php endif;?>
				</div>
				
				<div id="category-panel-content-message">
					<?php if ( ! isset($cats)): ?>
						<h3><?php echo $label['pleaseadd'];?></h3>
						<h4><?php echo $label['pleaseadd_supp'];?></h4>
					<?php endif;?>
				</div>
			</div>
		</div>
	<?php endif;?>
	
	<?php echo text_output($label['changes'], 'p', 'fontMedium bold');?>
	<?php echo form_textarea($inputs['changes']);?>
	
	<br /><br />
	
	<?php if ($type == 'standard'): ?>
		<?php echo text_output($label['comments'], 'p', 'fontMedium bold');?>
		<?php echo form_radio($inputs['comments_open']) .' '. form_label($label['open'], 'comments_open');?>
		<?php echo form_radio($inputs['comments_closed']) .' '. form_label($label['closed'], 'comments_closed');?>
		
		<br /><br />
	<?php endif;?>
	
	<?php echo form_button($buttons['update']);?>
<?php echo form_close();?>