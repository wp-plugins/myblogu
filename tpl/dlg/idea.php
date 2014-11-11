<div class="mbu-dlg" id="mbu-idea-dlg" style="width: 500px; z-index: 8888;">
<div class="mbu-dlg-title"><span onclick="mbu.closeDlg('mbu-idea-dlg')" class="close-btn">x</span><p>Idea</p></div>
<div class="mbu-dlg-body">

<input type="hidden" id="mbu-id-idea" name="mbu-id-idea" value="<?php echo $idea['id']; ?>"></input>

<img src="<?php echo $idea['userpic'] ?>" class="mbu-avatar" />

<?php

echo '<a target="_blank" href="'.MBU_BASE_URL.'/profile?id='.$idea['id_user'].'">'.((!empty($user['realname'])) ? $user['realname'] : $user['username']).'</a>';

    if(!empty($user['tw_username']))
    {
        echo '<a class="has-tip" title="'.$user['tw_username'].'" target="_blank" href="http://twitter.com/'.$user['tw_username'].'"><img src="'.MBU_IMGS.'/twitter3.png" class="mbu-social-icon" /></a>';
    }

    if(!empty($user['fb_id']))
    {
        echo '<a class="has-tip" title="'.$user['fb_username'].'" target="_blank" href="http://facebook.com/'.$user['fb_id'].'"><img src="'.MBU_IMGS.'/facebook3.png" class="mbu-social-icon" /></a>';
    }

    if(!empty($user['gplus_id']))
    {
        echo '<a class="has-tip" title="'.$user['gplus_username'].'" target="_blank" href="http://plus.google.com/'.$user['gplus_id'].'"><img src="'.MBU_IMGS.'/google+3.png" class="mbu-social-icon" /></a>';
    }

    if(!empty($user['sites']))
    {
	echo '<p class="mbu-sites-list">';
        foreach($user['sites'] as $site)
        {
            echo '<span><a href="'.$site['url'].'" target="_blank">'.$site['name'].'</a></span>';
	}
	echo '</p>';
    }
?>

<div class="mbu-scrollbox" id="mbu-idea-preview">
    <h3 id="mbu-pm-title"><?php echo sanitize_text_field($idea['title']); ?></h3>
    <?php echo $idea['author_comment'] ?>
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

<p class="dlg-buttons">
    <button  onclick="mbu.closeDlg('mbu-idea-dlg')" class="mbu-dlg-button">Close</button>
<?php
    if($idea['status'] == 0)
    {
        echo '<button  onclick="mbu.approveIdea('.$idea['id'].')" class="mbu-dlg-button mbu-blue-btn">Approve</button>';
        echo '<button  onclick="mbu.rejectIdea('.$idea['id'].')" class="mbu-dlg-button">Reject</button>';
    }
?>
</p>
</div>

</div>
