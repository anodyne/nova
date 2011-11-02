<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div id="loader" class="align_center">
	<?php echo img($images['loading']);?><br />
	<?php echo text_output($label['loading'], 'span', 'fontSmall bold gray');?>
</div>

<div id="loaded" class="hidden">
	<?php echo text_output($header, 'h1', 'page-head');?>
	
	<p class="bold">
		<?php echo anchor('characters/create', img($images['add']) .' '. $label['create'], array('class' => 'image'));?>
	</p>
	
	<div id="tabs">
		<ul>
			<li><a href="#one"><span><?php echo $label['active'];?></span></a></li>
			<li><a href="#two"><span><?php echo $label['inactive'];?></span></a></li>
			<li><a href="#three"><span><?php echo $label['pending'];?></span></a></li>
		</ul>
		
		<div id="one">
			<?php if ($count['active'] > 0): ?>
				<?php foreach ($characters as $c): ?>
					<?php if (isset($c['chars']['active'])): ?>
						<?php if (isset($c['dept'])): ?>
							<?php echo text_output($c['dept'], 'h3', 'page-subhead');?>
						<?php endif;?>
						<table class="table100 zebra">
							<tbody>
							<?php foreach ($c['chars']['active'] as $i): ?>
								<tr>
									<td>
										<strong><?php echo $i['name'];?></strong><br />
										
										<?php if (empty($i['uid'])): ?>
											<?php echo text_output($label['nouser'], 'span', 'fontSmall bold red');?><br />
										<?php endif;?>
										
										<?php echo text_output($i['position_1'], 'span', 'fontSmall gray');?>
									</td>
									<td class="col_150 align_right">
										<?php if (!empty($i['uid']) && $levelcheck['account'] == 2): ?>
											<?php echo anchor('user/account/'. $i['uid'], img($images['account']), array('class' => 'image'));?>
											&nbsp;
										<?php endif;?>
										
										<?php echo anchor('personnel/character/'. $i['id'], img($images['view']), array('class' => 'image'));?>
										
										<?php if ($levelcheck['bio'] == 3): ?>
											&nbsp;
											<?php echo anchor('user/characterlink', img($images['assign']), array('class' => 'image'));?>
											&nbsp;
											<a href="#" rel="facebox" myID="<?php echo $i['id'];?>" myAction="delete" class="image">
												<?php echo img($images['delete']);?>
											</a>
											&nbsp;
											<?php echo anchor('characters/bio/'. $i['id'], img($images['edit']), array('class' => 'image'));?>
										<?php endif;?>
									</td>
								</tr>
							<?php endforeach;?>
							</tbody>
						</table>
					<?php endif;?>
				<?php endforeach;?>
			<?php else: ?>
				<?php echo text_output($label['noactive'], 'h3', 'orange');?>
			<?php endif;?>
		</div>
		
		<div id="two">
			<?php if ($count['inactive'] > 0): ?>
				<?php foreach ($characters as $c): ?>
					<?php if (isset($c['chars']['inactive'])): ?>
						<?php if (isset($c['dept'])): ?>
							<?php echo text_output($c['dept'], 'h3', 'page-subhead');?>
						<?php endif;?>
						<table class="table100 zebra">
							<tbody>
							<?php foreach ($c['chars']['inactive'] as $i): ?>
								<tr>
									<td>
										<strong><?php echo $i['name'];?></strong><br />
										<span class="fontSmall gray"><?php echo $i['position_1'];?></span>
									</td>
									<td class="col_75 align_right">
										<?php echo anchor('personnel/character/'. $i['id'], img($images['view']), array('class' => 'image'));?>
										
										<?php if ($levelcheck['bio'] == 3): ?>
											&nbsp;
											<a href="#" rel="facebox" myID="<?php echo $i['id'];?>" myAction="delete" class="image">
												<?php echo img($images['delete']);?>
											</a>
											&nbsp;
											<?php echo anchor('characters/bio/'. $i['id'], img($images['edit']), array('class' => 'image'));?>
										<?php endif;?>
									</td>
								</tr>
							<?php endforeach;?>
							</tbody>
						</table>
					<?php endif;?>
				<?php endforeach;?>
			<?php else: ?>
				<?php echo text_output($label['noinactive'], 'h3', 'orange');?>
			<?php endif;?>
		</div>
		
		<div id="three">
			<?php if ($count['pending'] > 0): ?>
				<?php foreach ($characters as $c): ?>
					<?php if (isset($c['chars']['pending'])): ?>
						<?php if (isset($c['dept'])): ?>
							<?php echo text_output($c['dept'], 'h3', 'page-subhead');?>
						<?php endif;?>
						<table class="table100 zebra">
							<tbody>
							<?php foreach ($c['chars']['pending'] as $i): ?>
								<tr>
									<td>
										<?php if ($i['pstatus'] == 'pending'): ?>
											<?php echo img($images['new']);?>
										<?php endif;?>
										<strong><?php echo $i['name'];?></strong><br />
										
										<?php if (empty($i['uid'])): ?>
											<?php echo text_output($label['nouser'], 'span', 'fontSmall bold red');?><br />
										<?php endif;?>
										
										<span class="fontSmall gray"><?php echo $i['position_1'];?></span>
									</td>
									<td>
										<?php if ($i['pstatus'] == 'pending'): ?>
											<?php echo text_output($label['newuser'], 'span', 'green fontSmall bold');?>
											<br />
										<?php endif;?>
										<?php echo text_output($i['email'], 'span', 'fontSmall bold gray');?>
									</td>
									<td class="col_75 align_center">
										<?php echo anchor('personnel/character/'. $i['id'], img($images['view']), array('class' => 'image'));?>
										&nbsp;
										<a href="#" rel="facebox" myID="<?php echo $i['id'];?>" myAction="delete" class="image">
											<?php echo img($images['delete']);?>
										</a>
										&nbsp;
										<?php echo anchor('characters/bio/'. $i['id'], img($images['edit']), array('class' => 'image'));?>
									</td>
									<td class="col_5"></td>
									<td class="col_75 align_right">
										<a href="#" rel="facebox" myID="<?php echo $i['id'];?>" myAction="reject" class="image">
											<?php echo img($images['reject']);?>
										</a>
										&nbsp;
										<a href="#" rel="facebox" myID="<?php echo $i['id'];?>" myAction="approve" class="image">
											<?php echo img($images['approve']);?>
										</a>
									</td>
								</tr>
							<?php endforeach;?>
							</tbody>
						</table>
					<?php endif;?>
				<?php endforeach;?>
			<?php else: ?>
				<?php echo text_output($label['nopending'], 'h3', 'orange');?>
			<?php endif;?>
		</div>
	</div>
</div>