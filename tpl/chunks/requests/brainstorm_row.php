<?php
        echo '<tr id="mbu-request-'.$req['id'].'" class="mbu-request">';
        echo '<td style="width: 40%;">';
        echo '<h5>';
	if($req['pro'] == 1)
	{
	    echo '<img class="mbu-info-icon mbu-info-icon-pro" src="'.MBU_IMG_URL.'/empty-star.png" title="Premium Project"></img>';
	}
	echo $req['title'];
	echo ' (<span class="mbu-brainstorm-status mbu-brainstorm-status-'.$req['status'].'">'.$req['status_name'].'</span>)';
	echo '</h5>';

	echo '<div class="mbu-request-category mbu-list-info"><b>Category:</b> '.sanitize_text_field($req['category']).'</div>';
	echo '<div class="mbu-request-tags mbu-list-info"><b>Tags:</b> '.sanitize_text_field($req['tags']).'</div>';
	if(!empty($req['admin_comment']))
	{
	    echo '<div class="mbu-moderator-comment mbu-list-info"><b>Moderator Comment:</b> '.sanitize_text_field($req['admin_comment']).'</div>';
        }
        echo '<div class="mbu-context-menu">';
        if($req['ideas_count'] > 0)
        {
            echo '<a href="'.admin_url('admin.php?page=mbu_brainstorms&mbu_page=brainstorm&id_request='.$req['id']).'&new_ideas=1#mbu-ideas" class="mbu-btn mbu-blue-btn">show ideas</a>';
        }
	if($req['status'] == 0 || $req['status'] == 99)
	{
	    echo '<a href="javascript: mbu.deleteBrainstorm('.$req['id'].');" class="mbu-btn mbu-blue-btn">delete project</a>';
	}
	if($req['status'] != 2)
	{
	    echo '<a href="'.admin_url('admin.php?page=mbu_brainstorms&mbu_page=edit_brainstorm&id_request='.$req['id']).'" class="mbu-btn mbu-blue-btn">edit project</a>';
	}
	if($req['status'] == 1)
	{
	    echo '<a href="javascript: mbu.closeBrainstorm('.$req['id'].');" class="mbu-btn mbu-blue-btn">close project</a>';
	}
        echo '</div>';
        
        echo '</td>';

	echo '<td>';
        echo '<div class="mbu-request-txt">'.sanitize_text_field($req['txt']).'</div>';
	echo '</td>';

        echo '</tr>';
?>