<div class="wrap">
<?php
    echo mbuRunTpl('chunks/requests/top_menu', array('active_page' => 'brainstorm_archive'));

    if(empty($requests))
    {
        mbuShowMessage('Archieve Empty');
        exit();
    }
?>

<h2>Brainstorm Archive</h2>

<?php
    echo '<table class="mbu-table mbu-requests-table">';

    foreach($requests as $req)
    {
	echo mbuRunTpl('chunks/requests/brainstorm_row', array('req' => $req));
    }

    echo '</table>';
?>

</div>
