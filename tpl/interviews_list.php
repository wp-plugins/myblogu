<div class="wrap">
<?php
    echo mbuRunTpl('chunks/interviews/top_menu', array('active_page' => $mbu_page));

    if(empty($interviews))
    {
        mbuShowMessage('No active projects. You can <a href="'.admin_url('admin.php?page=mbu_interviews&mbu_page=new_interview').'">add</a>.');
        exit();
    }
    echo '<h2>'.$title.'</h2>';
    echo '<table class="mbu-table mbu-interviews-table">';

    foreach($interviews as $iv)
    {
	echo mbuRunTpl('chunks/interviews/interview_row', array('iv' => $iv));
    }

    echo '</table>';
?>

</div>

<?php
echo mbuRunTpl('dlg/change_deadline', array());
?>