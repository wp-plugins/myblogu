<?php

function mbuSaveBrainstorm(){
    $brainstorm = isset($_REQUEST['brainstorm']) ? json_decode($_REQUEST['brainstorm'], true) : null;
    

}

add_action('wp_ajax_mbuSaveBrainstorm', 'mbuSaveBrainstorm');
