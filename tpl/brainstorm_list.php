<div class="wrap">
<?php
    echo mbuRunTpl('chunks/requests/top_menu', array('active_page' => 'active_brainstorms'));

    if(empty($requests))
    {
        mbuShowMessage('No active projects. You can <a href="'.admin_url('admin.php?page=mbu_brainstorms&mbu_page=new_brainstorm').'">add</a>.');
        exit();
    }
?>

<h2>Brainstorms</h2>

<?php
    echo '<table class="mbu-table mbu-requests-table">';

    foreach($requests as $req)
    {
	echo mbuRunTpl('chunks/requests/brainstorm_row', array('req' => $req));
    }

    echo '</table>';
?>

</div>
