<?php echo text_output($header, 'h1', 'page-head');?>

<br />
<table class="table100 zebra">
	<thead>
		<tr>
			<th><?php echo $label['lastmonth'];?></th>
			<th></th>
			<th><?php echo $label['thismonth'];?></th>
		</tr>
	</thead>
	
	<tbody>
		<tr>
			<td class="align_center"><?php echo $players['previous'];?></td>
			<td class="align_center bold"><?php echo $label['players'];?></td>
			<td class="align_center"><?php echo $players['current'];?></td>
		</tr>
		<tr>
			<td class="align_center"><?php echo $characters['previous'];?></td>
			<td class="align_center bold"><?php echo $label['playing_chars'];?></td>
			<td class="align_center"><?php echo $characters['current'];?></td>
		</tr>
		<tr>
			<td class="align_center"><?php echo $npcs['previous'];?></td>
			<td class="align_center bold"><?php echo $label['npcs'];?></td>
			<td class="align_center"><?php echo $npcs['current'];?></td>
		</tr>
		
		<?php echo table_row_spacer(3, 30);?>
		
		<tr>
			<td class="align_center"><?php echo $posts['previous'];?></td>
			<td class="align_center bold"><?php echo $label['posts'];?></td>
			<td class="align_center"><?php echo $posts['current'];?></td>
		</tr>
		<tr>
			<td class="align_center"><?php echo $logs['previous'];?></td>
			<td class="align_center bold"><?php echo $label['logs'];?></td>
			<td class="align_center"><?php echo $logs['current'];?></td>
		</tr>
		<tr>
			<td class="align_center"><?php echo $post_totals['previous'];?></td>
			<td class="align_center bold"><?php echo $label['totals'];?></td>
			<td class="align_center"><?php echo $post_totals['current'];?></td>
		</tr>
		
		<?php echo table_row_spacer(3, 30);?>
		
		<tr>
			<td class="align_center"><?php echo $avg_posts['previous'];?></td>
			<td class="align_center bold">
				<?php echo $label['avgposts'];?><span class="fontSmall">&dagger;</span>
			</td>
			<td class="align_center"><?php echo $avg_posts['current'];?></td>
		</tr>
		<tr>
			<td class="align_center"><?php echo $avg_logs['previous'];?></td>
			<td class="align_center bold">
				<?php echo $label['avglogs'];?><span class="fontSmall">&dagger;</span>
			</td>
			<td class="align_center"><?php echo $avg_logs['current'];?></td>
		</tr>
		<tr>
			<td class="align_center"><?php echo $avg_totals['previous'];?></td>
			<td class="align_center bold">
				<?php echo $label['avgentries'];?><span class="fontSmall">&dagger;</span>
			</td>
			<td class="align_center"><?php echo $avg_totals['current'];?></td>
		</tr>
		
		<?php echo table_row_spacer(3, 30);?>
		
		<tr>
			<td class="align_center"><?php echo NDASH;?></td>
			<td class="align_center bold">
				<?php echo $label['paceposts'];?><span class="fontSmall">&Dagger;</span>
			</td>
			<td class="align_center"><?php echo $pace['posts'];?></td>
		</tr>
		<tr>
			<td class="align_center"><?php echo NDASH;?></td>
			<td class="align_center bold">
				<?php echo $label['pacelogs'];?><span class="fontSmall">&Dagger;</span>
			</td>
			<td class="align_center"><?php echo $pace['logs'];?></td>
		</tr>
		<tr>
			<td class="align_center"><?php echo NDASH;?></td>
			<td class="align_center bold">
				<?php echo $label['pacetotal'];?><span class="fontSmall">&Dagger;</span>
			</td>
			<td class="align_center"><?php echo $pace['total'];?></td>
		</tr>
	</tbody>
</table>

<p>&nbsp;</p>

<?php echo text_output($label['statsavg'], 'p', 'fontSmall gray italic');?>

<?php echo text_output($label['statspace'], 'p', 'fontSmall gray italic');?>