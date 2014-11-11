<tr id="mbu-idea-<?php echo $idea['id']; ?>" class="mbu-idea-status-<?php echo $idea['status']; ?>">    
<td style="width: 25%;">
    <a name="mbu-idea-<?php echo $idea['id']; ?>">&nbsp;</a>
    <p class="mbu-username"><a href="<?php echo MBU_BASE_URL ?>/profile?id=<?php echo $idea['id_user']; ?>" target="_blank"><?php echo $idea['username']; ?></a></p>
    <img class="mbu-userpic" src="<?php echo $idea['userpic']; ?>" />
</td>

<td>
    <h5><?php echo sanitize_text_field($idea['title']); ?> (<span class="mbu-idea-status-name-<?php echo $idea['status'] ?>"><?php echo $idea['status_name'] ?></span>)</h5>
<?php 
    if(!empty($idea['link']))
    {
        echo '<p class="mbu-idea-link"><a href="'.$idea['link'].'" target="_blank">'.$idea['link'].'</a></p>';
    }
?>    
    <div class="mbu-idea-view" onclick="mbu.showIdea(<?php echo $idea['id']; ?>);">
        <?php echo $idea['author_comment_preview']; ?>
    </div>

<?php
    if(!empty($idea['attachments']))
    {
        echo '<div class="mbu-idea-attachments">';
        foreach($idea['attachments'] as $att)
        {
            $filename = str_replace(array('"', "'"), '', $att['filename']);
            echo '<img class="mbu-att-preview" src="'.$att['preview_url'].'" title="'.$att['filename'].'" onclick="mbu.mbuDownloadAtt('.$att['id'].', \''.sanitize_file_name($filename).'\')"></img>';
        }
        echo '</div>';
    }
?>

    <div class="mbu-context-menu">
<?php 
    if($idea['status'] == 0)
    {
        echo '<a href="" class="mbu-btn mbu-blue-btn" onclick="mbu.approveIdea('.$idea['id'].'); return false;">approve idea</a>';
        echo '<a href="" class="mbu-btn mbu-blue-btn" onclick="mbu.rejectIdea('.$idea['id'].'); return false;">reject idea</a>';
    }
    else if($idea['status'] == 1 && !empty($idea['blogger_comment']))
    {
        echo '<p><b>Approve Comment:</b> '.sanitize_text_field($idea['blogger_comment']).'</p>';
    }
?>
    </div>
</td>
</tr>
