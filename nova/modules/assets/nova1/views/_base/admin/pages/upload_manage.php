<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>

<p class="bold fontMedium"><?php echo anchor('upload/index', $label['upload']);?></p><br />

<div id="tabs">
	<ul>
		<?php if ($access['bio'] === true): ?>
			<li><a href="#one"><span><?php echo $label['bioimages'];?></span></a></li>
		<?php endif;?>
		
		<?php if ($access['awards'] === true): ?>
			<li><a href="#two"><span><?php echo $label['awardimages'];?></span></a></li>
		<?php endif;?>
		
		<?php if ($access['missions'] === true): ?>
			<li><a href="#three"><span><?php echo $label['missionimages'];?></span></a></li>
		<?php endif;?>
		
		<?php if ($access['tour'] === true): ?>
			<li><a href="#four"><span><?php echo $label['tourimages'];?></span></a></li>
		<?php endif;?>
	</ul>
	
	<?php if ($access['bio'] === true): ?>
		<div id="one">
			<?php echo form_open('upload/manage/bio');?>
			<?php if (isset($directory['bio'])): ?>
				<table class="table100 zebra">
					<thead>
						<th class="col_150"><?php echo $label['preview'];?></th>
						<th><?php echo $label['filename'];?></th>
						<th class="col_75"><?php echo $label['delete'];?></th>
					</thead>
					<tbody>
					<?php foreach ($directory['bio'] as $i): ?>
						<tr>
							<td><?php echo img($i['image']);?></td>
							<td>
								<strong><?php echo $i['filename'];?></strong><br />
								<span class="fontSmall gray">
									<?php echo $label['uploadedby'] .' '. $i['user'];?>
									<?php echo $label['on'] .' '. $i['date'];?>
								</span>
							</td>
							<td class="align_center"><?php echo form_checkbox($i['check']);?></td>
						</tr>
					<?php endforeach;?>
					</tbody>
				</table><br />
				
				<div class="align_right"><?php echo form_button($button['submit']);?></div>
			<?php else: ?>
				<?php echo text_output($label['nobio'], 'h3', 'orange');?>
			<?php endif;?>
			<?php echo form_close();?>
		</div>
	<?php endif;?>
		
	<?php if ($access['awards'] === true): ?>
		<div id="two">
			<?php echo form_open('upload/manage/awards');?>
			<?php if (isset($directory['award'])): ?>
				<table class="table100 zebra">
					<thead>
						<th class="col_150"><?php echo $label['preview'];?></th>
						<th><?php echo $label['filename'];?></th>
						<th class="col_75"><?php echo $label['delete'];?></th>
					</thead>
					<tbody>
					<?php foreach ($directory['award'] as $i): ?>
						<tr>
							<td><?php echo img($i['image']);?></td>
							<td>
								<strong><?php echo $i['filename'];?></strong><br />
								<span class="fontSmall gray">
									<?php echo $label['uploadedby'] .' '. $i['user'];?>
									<?php echo $label['on'] .' '. $i['date'];?>
								</span>
							</td>
							<td class="align_center"><?php echo form_checkbox($i['check']);?></td>
						</tr>
					<?php endforeach;?>
					</tbody>
				</table><br />
				
				<div class="align_right"><?php echo form_button($button['submit']);?></div>
			<?php else: ?>
				<?php echo text_output($label['noaward'], 'h3', 'orange');?>
			<?php endif;?>
			<?php echo form_close();?>
		</div>
	<?php endif;?>
	
	<?php if ($access['missions'] === true): ?>
		<div id="three">
			<?php echo form_open('upload/manage/missions');?>
			<?php if (isset($directory['mission'])): ?>
				<table class="table100 zebra">
					<thead>
						<th class="col_150"><?php echo $label['preview'];?></th>
						<th><?php echo $label['filename'];?></th>
						<th class="col_75"><?php echo $label['delete'];?></th>
					</thead>
					<tbody>
					<?php foreach ($directory['mission'] as $i): ?>
						<tr>
							<td><?php echo img($i['image']);?></td>
							<td>
								<strong><?php echo $i['filename'];?></strong><br />
								<span class="fontSmall gray">
									<?php echo $label['uploadedby'] .' '. $i['user'];?>
									<?php echo $label['on'] .' '. $i['date'];?>
								</span>
							</td>
							<td class="align_center"><?php echo form_checkbox($i['check']);?></td>
						</tr>
					<?php endforeach;?>
					</tbody>
				</table><br />

				<div class="align_right"><?php echo form_button($button['submit']);?></div>
			<?php else: ?>
				<?php echo text_output($label['nomission'], 'h3', 'orange');?>
			<?php endif;?>
			<?php echo form_close();?>
		</div>
	<?php endif;?>
	
	<?php if ($access['tour'] === true): ?>
		<div id="four">
			<?php echo form_open('upload/manage/tour');?>
			<?php if (isset($directory['tour'])): ?>
				<table class="table100 zebra">
					<thead>
						<th class="col_150"><?php echo $label['preview'];?></th>
						<th><?php echo $label['filename'];?></th>
						<th class="col_75"><?php echo $label['delete'];?></th>
					</thead>
					<tbody>
					<?php foreach ($directory['tour'] as $i): ?>
						<tr>
							<td><?php echo img($i['image']);?></td>
							<td>
								<strong><?php echo $i['filename'];?></strong><br />
								<span class="fontSmall gray">
									<?php echo $label['uploadedby'] .' '. $i['user'];?>
									<?php echo $label['on'] .' '. $i['date'];?>
								</span>
							</td>
							<td class="align_center"><?php echo form_checkbox($i['check']);?></td>
						</tr>
					<?php endforeach;?>
					</tbody>
				</table><br />

				<div class="align_right"><?php echo form_button($button['submit']);?></div>
			<?php else: ?>
				<?php echo text_output($label['notour'], 'h3', 'orange');?>
			<?php endif;?>
			<?php echo form_close();?>
		</div>
	<?php endif;?>
</div>