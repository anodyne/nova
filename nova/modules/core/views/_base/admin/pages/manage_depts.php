<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>

<p class="bold">
	<a href="#" rel="facebox" myaction="add" class="image"><?php echo img($images['add']) .' '. $label['add_dept'];?></a>
</p><br />

<?php if (isset($depts)): ?>
	<div id="tabs">
		<ul>
			<li><a href="#one"><span><?php echo $label['assigned'];?></span></a></li>
			<li><a href="#two"><span><?php echo $label['unassigned'];?></span></a></li>
		</ul>
		
		<div id="one">
			<?php foreach ($depts as $key => $value): ?>
				<?php if ($key > 0): ?>
					<?php echo text_output($manifests[$key], 'h2', 'page-subhead');?>
					
					<table class="table100 zebra">
						<tbody>
						<?php foreach ($value as $d): ?>
							<tr>
								<td class="col_15"></td>
								<td>
									<strong class="fontMedium"><?php echo $d->dept_name;?></strong><br />
									<span class="gray fontSmall"><?php echo $d->dept_desc;?></span>
								</td>
								<td class="col_30"></td>
								<td class="col_100 align_right">
									<a href="#" rel="facebox" myid="<?php echo $d->dept_id;?>" myaction="duplicate" class="image"><?php echo img($images['duplicate']);?></a>
									&nbsp;
									<a href="#" rel="facebox" myid="<?php echo $d->dept_id;?>" myaction="delete" class="image"><?php echo img($images['delete']);?></a>
									&nbsp;
									<a href="#" rel="facebox" myid="<?php echo $d->dept_id;?>" myaction="edit" class="image"><?php echo img($images['edit']);?></a>
								</td>
							</tr>
							<?php if (isset($subs[$d->dept_id])): ?>
								<?php foreach ($subs[$d->dept_id] as $k => $v): ?>
									<tr>
										<td class="col_15"></td>
										<td>
											<strong class="fontMedium"><?php echo $v['data']->dept_name;?></strong><br />
											<strong class="fontSmall gray"><?php echo $label['sub_of'].$v['parent']?></strong><br />
											<span class="gray fontSmall"><?php echo $v['data']->dept_desc;?></span>
										</td>
										<td class="col_30"></td>
										<td class="col_100 align_right">
											<a href="#" rel="facebox" myid="<?php echo $v['data']->dept_id;?>" myaction="duplicate" class="image"><?php echo img($images['duplicate']);?></a>
											&nbsp;
											<a href="#" rel="facebox" myid="<?php echo $v['data']->dept_id;?>" myaction="delete" class="image"><?php echo img($images['delete']);?></a>
											&nbsp;
											<a href="#" rel="facebox" myid="<?php echo $v['data']->dept_id;?>" myaction="edit" class="image"><?php echo img($images['edit']);?></a>
										</td>
									</tr>
								<?php endforeach;?>
							<?php endif;?>
						<?php endforeach;?>
						</tbody>
					</table>
				<?php endif;?>
			<?php endforeach;?>
		</div>
		
		<div id="two">
			<?php if (isset($depts[0])): ?>
				<?php foreach ($depts as $key => $value): ?>
					<?php if ($key == 0): ?>
						<?php echo text_output($manifests[$key], 'h2', 'page-subhead');?>
						
						<table class="table100 zebra">
							<tbody>
							<?php foreach ($value as $d): ?>
								<tr>
									<td class="col_15"></td>
									<td>
										<strong class="fontMedium"><?php echo $d->dept_name;?></strong><br />
										<span class="gray fontSmall"><?php echo $d->dept_desc;?></span>
									</td>
									<td class="col_30"></td>
									<td class="col_100 align_right">
										<a href="#" rel="facebox" myid="<?php echo $d->dept_id;?>" myaction="duplicate" class="image"><?php echo img($images['duplicate']);?></a>
										&nbsp;
										<a href="#" rel="facebox" myid="<?php echo $d->dept_id;?>" myaction="delete" class="image"><?php echo img($images['delete']);?></a>
										&nbsp;
										<a href="#" rel="facebox" myid="<?php echo $d->dept_id;?>" myaction="edit" class="image"><?php echo img($images['edit']);?></a>
									</td>
								</tr>
							<?php endforeach;?>
							</tbody>
						</table>
					<?php endif;?>
				<?php endforeach;?>
			<?php else: ?>
				<?php echo text_output($label['no_unassigned'], 'h3', 'orange');?>
			<?php endif;?>
		</div>
	</div>
<?php endif;?>