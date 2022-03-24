<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<table class="table100 zebra">
	<tbody>
	<?php foreach ($drafts as $d): ?>
		<tr>
			<td>
				<?php if ($d['old_id'] === FALSE): ?>
					<?php echo $d['created'] .' '. $label['created'] .' '. anchor('wiki/view/draft/'. $d['draft'], text_output($d['title'], 'strong')) .' '. $label['on'] .' '. $d['created_date'];?>
				<?php else: ?>
					<?php echo $d['created'] .' '. $label['reverted'] .' '. $label['to'] .' '. anchor('wiki/view/draft/'. $d['old_id'], text_output($d['title'], 'strong')) .' '. $label['on'] .' '. $d['created_date'];?>
				<?php endif;?>
			</td>
			<td class="align_right col_150">
				<?php if (count($drafts) > 1 && $d['draft'] != $d['page_draft']): ?>
					<a href="#" rel="facebox" myAction="revert" myPage="<?php echo $d['page'];?>" myDraft="<?php echo $d['draft'];?>"><?php echo $label['revert'];?></a>
					&nbsp;
				<?php endif;?>
				
				<?php if ($d['draft'] != $d['page_draft']): ?>
					<a href="#" class="delete" rel="facebox" myAction="deleteDraft" myID="<?php echo $d['draft'];?>"><?php echo $label['delete'];?></a>
				<?php endif;?>
			</td>
		</tr>
	<?php endforeach;?>
	</tbody
</table>