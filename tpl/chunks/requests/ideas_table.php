<a name='mbu-ideas'>&nbsp;</a>
<table class="mbu-table mbu-ideas-table">
<?php
    foreach($ideas as $idea)
    {
        echo mbuRunTpl('chunks/requests/idea', array('idea' => $idea));
    }
?>
</table>