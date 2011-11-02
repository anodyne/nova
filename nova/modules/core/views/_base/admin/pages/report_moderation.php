<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?><br />

<?php if (isset($users)): ?>
	<table class="table100 zebra">
		<thead>
			<tr>
				<th class="align_middle"><?php echo $label['name'];?></th>
				<th class="fontTiny align_middle"><?php echo $label['posts'];?></th>
				<th class="fontTiny align_middle"><?php echo text_output($label['comments_p'], '');?></th>
				<th class="fontTiny align_middle"><?php echo $label['logs'];?></th>
				<th class="fontTiny align_middle"><?php echo text_output($label['comments_l'], '');?></th>
				<th class="fontTiny align_middle"><?php echo $label['news'];?></th>
				<th class="fontTiny align_middle"><?php echo text_output($label['comments_n'], '');?></th>
				<th class="fontTiny align_middle"><?php echo text_output($label['comments_w'], '');?></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($users as $u): ?>
			<tr>
				<td class="col_50pct">
					<strong><?php echo $u['name'];?></strong><br />
					<span class="fontTiny gray">
						<?php echo anchor('personnel/user/'. $u['id'], $label['bio_user']);?>
						|
						<?php echo anchor('personnel/character/'. $u['charid'], $label['bio_char']);?>
					</span>
				</td>
				<td class="align_center"><?php echo img($images[$u['posts']]);?></td>
				<td class="align_center"><?php echo img($images[$u['comments_p']]);?></td>
				<td class="align_center"><?php echo img($images[$u['logs']]);?></td>
				<td class="align_center"><?php echo img($images[$u['comments_l']]);?></td>
				<td class="align_center"><?php echo img($images[$u['news']]);?></td>
				<td class="align_center"><?php echo img($images[$u['comments_n']]);?></td>
				<td class="align_center"><?php echo img($images[$u['comments_w']]);?></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php endif;?>