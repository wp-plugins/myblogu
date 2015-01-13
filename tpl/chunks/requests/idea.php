<tr id="mbu-idea-<?php echo $idea['id']; ?>" class="mbu-idea-status-<?php echo $idea['status']; ?>">    
<td style="width: 25%;">
    <a name="mbu-idea-<?php echo $idea['id']; ?>">&nbsp;</a>
    <p class="mbu-username"><a href="<?php echo MBU_BASE_URL ?>/profile?id=<?php echo $idea['id_user']; ?>" target="_blank"><?php echo $idea['username']; ?></a></p>
    <img class="mbu-userpic" src="<?php echo $idea['userpic']; ?>" />
</td>

<td>
    <h5>
    <?php
	if($idea['id_user'] == $idea['id_user_blogger'])
	{
	    echo '<img class="mbu-info-icon mbu-info-icon-self" src="'.MBU_IMG_URL.'/self.png" title="My Own Idea"></img>';
	}
    ?>
	
    <?php echo sanitize_text_field($idea['title']); ?> (<span class="mbu-idea-status-name-<?php echo $idea['status'] ?> mbu-idea-status-name"><?php echo $idea['status_name'] ?></span>)
    </h5>

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

    if($idea['status']==1)
    {
        if(!empty($idea['todo']))
        {
            foreach ($idea['todo'] as $todo_item)
            {
	        echo '<div class="mbu-idea-todo-item '.(($todo_item['status']==1) ? 'todo-item-remind-sent' : '').'" id="todo-item-'.$todo_item['id'].'">';

		echo '<button class="mbu-close" type="button" onclick="mbu.delTODOItem('.$todo_item['id'].');" aria-hidden="true">×</button> ';
		echo '<span class="glyphicon glyphicon-search wp-links" onclick="mbu.showTODOItem('.$todo_item['id'].');"></span>';
		echo '<a href="" onclick="mbu.showTODOItem('.$todo_item['id'].'); return false;">'.$todo_item['short_txt'].'</a>';

                if($todo_item['status'] == 0)
                {
                    echo '<div>';
                    echo '<label class="offer-label">Remind Date:</label>';
                    echo '<span style="color: red;"> '.$todo_item['remind'].'</span>';
                    echo '</div>';
                }
                else
                {
                    echo '<div>';
                    echo '<label class="offer-label">Reminder sent on:</label>';
                    echo '<span style="color: green;"> '.$todo_item['sent'].'</span>';
                    echo '</div>';
                }
                echo '</div>';
            }
        }
        echo '<p><a href="" onclick="mbu.addBrainstormTODO('.$idea['id'].'); return false;"><span class="icon-g-circle-plus" ></span> Add TODO</a></p>';
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
    if($idea['id_user'] == $idea['id_user_blogger'])
    {
        echo '<a href="" id="mbu-del-idea-btn" class="mbu-btn mbu-orange-btn" onclick="mbu.deleteIdea('.$idea['id'].'); return false;">delete</a>';
    }
    if($idea['status'] == 1)
    {
        echo '<a href="" class="mbu-btn mbu-blue-btn" onclick="mbu.saveIdeaURL('.$idea['id'].'); return false;">'.((empty($idea['link'])) ? 'save URL' : 'change URL').'</a>';
    }
?>
    </div>
</td>
</tr>
