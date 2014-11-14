<?php

        echo '<tr id="mbu-interview-'.$iv['id'].'" class="mbu-interview">';
	echo '<a name="iv-'.$iv['id'].'">&nbsp;</a>';
        echo '<td style="width: 40%;">';

        echo '<h5>'.sanitize_text_field($iv['title']);
	echo ' (<span class="mbu-interview-status mbu-interview-status-'.$iv['status'].'">'.$iv['status_name'].'</span>) '.(($iv['status'] == 1 && $iv['new_answers_count'] > 0) ? (' - <span class="mbu-new-answers-count">'.$iv['new_answers_count'].'</span> new answers') : '');
	echo '</h5>';

	echo '<div class="mbu-expire mbu-list-info"><b>Expire:</b> '.$iv['deadline'].(($iv['expired'] && $iv['status'] == 1) ? ' - <span style="color: red;">Expired!</span>' : '').'</div>';
	
        echo '<div class="mbu-interview-category mbu-list-info"><b>Category:</b> '.sanitize_text_field($iv['category']).'</div>';	
        echo '<div class="mbu-interview-tags mbu-list-info"><b>Tags:</b> '.sanitize_text_field($iv['tags']).'</div>';

	if(!empty($iv['hide_comment']))
	{
	    echo '<div class="mbu-hide-comment mbu-list-info"><b>Hide Comment:</b> '.sanitize_text_field($iv['hide_comment']).'</div>';
	}
        
	if($iv['status'] == 3 && !empty($iv['url']))
	{
	    echo '<div class="mbu-url mbu-list-info"><b>URL:</b> <a target="_blank" href="'.$iv['url'].'">'.$iv['url'].'</a></div>';
	}

        echo '<div class="mbu-context-menu">';
        if($iv['answers_count'] > 0)
        {
            echo '<a href="'.admin_url('admin.php?page=mbu_interviews&mbu_page=interview&id_interview='.$iv['id']).'" class="mbu-btn mbu-blue-btn">show answers</a>';
        }
	if($iv['status'] == 0 || $iv['status'] == 6 || $iv['status'] == 99)
	{
	    echo '<a href="'.admin_url('admin.php?page=mbu_interviews&mbu_page=edit_interview&id_interview='.$iv['id']).'" class="mbu-btn mbu-blue-btn">edit project</a>';
	}
	if($iv['status'] == 0 || $iv['status'] == 6)
	{
	    echo '<a href="javascript:mbu.delInterview('.$iv['id'].')" class="mbu-btn mbu-blue-btn">delete project</a>';
	}
	if($iv['status'] == 1 || $iv['status'] == 6)
	{
	    echo '<a href="javascript:mbu.toDraftInterview('.$iv['id'].')" class="mbu-btn mbu-blue-btn">move to draft</a>';
	}
	if($iv['status'] == 0)
	{
	    echo '<a href="javascript:mbu.publishInterview('.$iv['id'].')" class="mbu-btn mbu-blue-btn">publish project</a>';
	}
	if($iv['expired'] && $iv['status'] == 1)
	{
	    echo '<a href="javascript:mbu.changeInterviewDeadline('.$iv['id'].', \''.$iv['deadline'].'\')" class="mbu-btn mbu-blue-btn">expand deadline</a>';
	}
	if(!empty($iv['post_id']) && ($iv['status'] == 2 || $iv['status'] == 3))
	{
	    echo '<a href="'.admin_url('post.php?post='.$iv['post_id'].'&action=edit').'"  target="_blank" class="mbu-btn mbu-blue-btn">Edit Post</a>';
	}

        echo '</div>';        
        echo '</td>';

	echo '<td>';
        echo '<div class="mbu-interview-comment">'.sanitize_text_field($iv['comment']).'</div>';
	echo '</td>';
        echo '</tr>';

?>