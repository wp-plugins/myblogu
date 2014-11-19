<div class="wrap">

<?php
    echo mbuRunTpl('chunks/pm/top_menu', array('active_page' => $mbu_page));
?>

<h2>MBU Alerts</h2>
<?php

    if(empty($msgs['messages']))
    {
        mbuShowMessage('No active alerts');
    }
    else
    {
	echo '<table class="wp-list-table widefat fixed mbu-main-table mbu-alerts">';
	echo '<thead>';
	echo '<tr>';
	    echo '<th id="cb" class="manage-column column-cb" style="width: 5%;" scope="col">';
	    echo '&nbsp;';
	    echo '</th>';
        
	    echo '<th id="cb" class="manage-column column-cb" style="width: 20%;" scope="col">';
	    echo 'Sender';
	    echo '</th>';

	    echo '<th id="cb" class="manage-column column-cb" style="width: 50%;" scope="col">';
	    echo 'Alert';
	    echo '</th>';

	    echo '<th id="cb" class="manage-column column-cb" scope="col">';
	    echo 'Date';
	    echo '</th>';

	echo '</tr>';
	echo '</thead>';
	echo '<tbody id="the-list">';

	foreach($msgs['messages'] as $message)
	{
	    echo '<tr id="msg-'.$message['id'].'" class="">';
	    echo '<td>';
            echo '<input type="checkbox" class="mbu-checkbox-pm" id="mbu-checkbox-pm-'.$message['id'].'" data-id-message="'.$message['id'].'" autocomplete="off" />';
	    echo '</td>';
            
	    echo '<td>';
	    echo '<p><a target="_blank" href="'.MBU_BASE_URL.'/profile?id='.$message['sender_id'].'">'.$message['sender_name'].'</a></p>';
            echo '<img class="mbu-avatar" src="'.$message['sender_avatar'].'"></img>';
	    echo '</td>';
                        
	    echo '<td>';
	    echo '<a target="_blank" href="'.MBU_BASE_URL.'/pm?id_caller='.$message['sender_id'].'">'.$message['subject'].'</a> (<span class="mbu-pm-status">'.$message['status'].'</span>)';
            echo '<div class="row-actions mbu-actions" style="margin-top: 15px;">';	    
            echo '<span><a title="Read" href="javascript:mbu.readPm('.$message['id'].')">Read</a></span>';
            echo '<span><a title="View on MBU" href="'.MBU_BASE_URL.'/pm?id_caller='.$message['sender_id'].'" target="_blank">View on MBU</a></span>';

	    if($message['status'] == 'read')
	    {
   	        echo '<span><a title="Delete" href="javascript:mbu.delPm('.$message['id'].')">Delete</a></span>';
	    }

            if($message['status'] == 'sent' || $message['status'] == 'delivered')
            {
                echo '<span><a title="Mark as read" href="javascript:mbu.markReadPm('.$message['id'].')">Mark as Read</a></span>';
            }
	    echo '</div>';
	    echo '</td>';
                        
	    echo '<td>';
	    echo date('Y-m-d H:i', $message['lastedited_at']);
	    echo '</td>';
            
	    echo '</tr>';
	}

	echo '</tbody>';
	echo '</table>';
    }

    echo '<div class="mbu-group-actions" style="display: none;">';
    echo '<p class="submit">With Selected: ';
    echo '<button class="button button-primary mbu-dlg-button" onclick="mbu.delPmGrp(); return false;">Delete</button>';
    if($mbu_page == 'new_pm')
    {
            echo '<button class="button button-primary mbu-dlg-button" onclick="mbu.markReadPmGrp(); return false;">Mark As Read</button>';
    }
    echo '</p>';
    echo '</div>';

echo '</div>';

echo mbuRunTpl('dlg/read_pm', array());
?>