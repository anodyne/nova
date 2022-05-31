<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}?>

<?php echo text_output($header, 'h1', 'page-head');?>

<div id="tabs">
	<ul>
		<li><a href="#one"><span>Monthly Stats</span></a></li>
		<li><a href="#two"><span>Sim Totals</span></a></li>
	</ul>

	<div id="one">
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
					<td class="align_center"><?php echo $users['previous'];?></td>
					<td class="align_center bold"><?php echo $label['users'];?></td>
					<td class="align_center"><?php echo $users['current'];?></td>
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
					<td class="align_center"><?php echo $posts['total']['previous'];?></td>
					<td class="align_center bold"><?php echo $label['posts'];?></td>
					<td class="align_center"><?php echo $posts['total']['current'];?></td>
				</tr>
				<tr>
					<td class="align_center"><?php echo $posts['words']['previous'];?></td>
					<td class="align_center bold"><?php echo $label['postsWords'];?></td>
					<td class="align_center"><?php echo $posts['words']['current'];?></td>
				</tr>
				<tr>
					<td class="align_center"><?php echo $posts['average']['previous'];?></td>
					<td class="align_center bold">
						<?php echo $label['postsAverage'];?><span class="fontSmall">&dagger;</span>
					</td>
					<td class="align_center"><?php echo $posts['average']['current'];?></td>
				</tr>
				<tr>
					<td class="align_center"><?php echo $posts['wordsAverage']['previous'];?></td>
					<td class="align_center bold">
						<?php echo $label['postsWordsAverage'];?><span class="fontSmall">&dagger;</span>
					</td>
					<td class="align_center"><?php echo $posts['wordsAverage']['current'];?></td>
				</tr>
				<tr>
					<td class="align_center"><?php echo NDASH;?></td>
					<td class="align_center bold">
						<?php echo $label['postsPace'];?><span class="fontSmall">&Dagger;</span>
					</td>
					<td class="align_center"><?php echo $posts['pace'];?></td>
				</tr>
				<tr>
					<td class="align_center"><?php echo NDASH;?></td>
					<td class="align_center bold">
						<?php echo $label['postsWordsPace'];?><span class="fontSmall">&Dagger;</span>
					</td>
					<td class="align_center"><?php echo $posts['wordsPace'];?></td>
				</tr>

				<?php echo table_row_spacer(3, 30);?>

				<tr>
					<td class="align_center"><?php echo $logs['total']['previous'];?></td>
					<td class="align_center bold"><?php echo $label['logs'];?></td>
					<td class="align_center"><?php echo $logs['total']['current'];?></td>
				</tr>
				<tr>
					<td class="align_center"><?php echo $logs['words']['previous'];?></td>
					<td class="align_center bold"><?php echo $label['logsWords'];?></td>
					<td class="align_center"><?php echo $logs['words']['current'];?></td>
				</tr>
				<tr>
					<td class="align_center"><?php echo $logs['average']['previous'];?></td>
					<td class="align_center bold">
						<?php echo $label['logsAverage'];?><span class="fontSmall">&dagger;</span>
					</td>
					<td class="align_center"><?php echo $logs['average']['current'];?></td>
				</tr>
				<tr>
					<td class="align_center"><?php echo $logs['wordsAverage']['previous'];?></td>
					<td class="align_center bold">
						<?php echo $label['logsWordsAverage'];?><span class="fontSmall">&dagger;</span>
					</td>
					<td class="align_center"><?php echo $logs['wordsAverage']['current'];?></td>
				</tr>
				<tr>
					<td class="align_center"><?php echo NDASH;?></td>
					<td class="align_center bold">
						<?php echo $label['logsPace'];?><span class="fontSmall">&Dagger;</span>
					</td>
					<td class="align_center"><?php echo $logs['pace'];?></td>
				</tr>
				<tr>
					<td class="align_center"><?php echo NDASH;?></td>
					<td class="align_center bold">
						<?php echo $label['logsWordsPace'];?><span class="fontSmall">&Dagger;</span>
					</td>
					<td class="align_center"><?php echo $logs['wordsPace'];?></td>
				</tr>

				<?php echo table_row_spacer(3, 30);?>

				<tr>
					<td class="align_center"><?php echo $entries['total']['previous'];?></td>
					<td class="align_center bold"><?php echo $label['entries'];?></td>
					<td class="align_center"><?php echo $entries['total']['current'];?></td>
				</tr>
				<tr>
					<td class="align_center"><?php echo $entries['words']['previous'];?></td>
					<td class="align_center bold"><?php echo $label['entriesWords'];?></td>
					<td class="align_center"><?php echo $entries['words']['current'];?></td>
				</tr>
				<tr>
					<td class="align_center"><?php echo $entries['average']['previous'];?></td>
					<td class="align_center bold">
						<?php echo $label['entriesAverage'];?><span class="fontSmall">&dagger;</span>
					</td>
					<td class="align_center"><?php echo $entries['average']['current'];?></td>
				</tr>
				<tr>
					<td class="align_center"><?php echo $entries['wordsAverage']['previous'];?></td>
					<td class="align_center bold">
						<?php echo $label['entriesWordsAverage'];?><span class="fontSmall">&dagger;</span>
					</td>
					<td class="align_center"><?php echo $entries['wordsAverage']['current'];?></td>
				</tr>
				<tr>
					<td class="align_center"><?php echo NDASH;?></td>
					<td class="align_center bold">
						<?php echo $label['entriesPace'];?><span class="fontSmall">&Dagger;</span>
					</td>
					<td class="align_center"><?php echo $entries['pace'];?></td>
				</tr>
				<tr>
					<td class="align_center"><?php echo NDASH;?></td>
					<td class="align_center bold">
						<?php echo $label['entriesWordsPace'];?><span class="fontSmall">&Dagger;</span>
					</td>
					<td class="align_center"><?php echo $entries['wordsPace'];?></td>
				</tr>
			</tbody>
		</table>

		<p>&nbsp;</p>

		<?php echo text_output($label['statsavg'], 'p', 'fontSmall gray italic');?>

		<?php echo text_output($label['statspace'], 'p', 'fontSmall gray italic');?>
	</div>

	<div id="two">
		<h2 class="page-subhead"><?php echo $label['start_date'];?></h2>

		<p><?php echo $start;?></p>

		<h2 class="page-subhead"><?php echo $label['users'];?></h2>

		<p><strong><?php echo $label['all_users'];?>:</strong> <?php echo number_format($users['all']);?></p>
		<p><strong><?php echo $label['active_users'];?>:</strong> <?php echo number_format($users['current']);?></p>

		<h2 class="page-subhead"><?php echo $label['characters'];?></h2>

		<p><strong><?php echo $label['all_characters'];?>:</strong> <?php echo number_format($characters['all']);?></p>
		<p><strong><?php echo $label['active_characters'];?>:</strong> <?php echo number_format($characters['current']);?></p>
		<p><strong><?php echo $label['all_npcs'];?>:</strong> <?php echo number_format($npcs['all']);?></p>

		<h2 class="page-subhead"><?php echo $label['posting'];?></h2>

		<p><strong><?php echo $label['total_posts'];?>:</strong> <?php echo number_format($posts['total']['all']);?></p>
		<p><strong><?php echo $label['total_posts'];?>:</strong> <?php echo number_format($posts['total']['all']);?></p>

		<p><strong><?php echo $label['total_logs'];?>:</strong> <?php echo number_format($logs['total']['all']);?></p>
		<p><strong><?php echo $label['total_logs'];?>:</strong> <?php echo number_format($logs['total']['all']);?></p>

		<p><strong><?php echo $label['total_posting'];?>:</strong> <?php echo number_format($entries['total']['all']);?></p>
		<p><strong><?php echo $label['total_posting'];?>:</strong> <?php echo number_format($entries['total']['all']);?></p>
	</div>
</div>