<?php

        /*
         *  обработка входящих сообщений от сервера MBU
         */
add_action('init', 'mbu_preprocess');

function mbu_preprocess(){
    if(isset($_REQUEST['mbu_action'])) {
        
        if($_REQUEST['mbu_action'] == 'mbu_init')   
        {
                              // начальная инициализация, сразу после добавления сайта в MBU
            $init_options = json_decode(str_replace('\"', '"', base64_decode($_REQUEST['init_options'])), true);

            if(is_array($init_options) && isset($init_options['oauth_token']))
            {
                add_option('mbu_options', $init_options, '', 'yes');
                update_option('mbu_options', $init_options);

                header ( 'Content-type: application/json' );
                $ret = array('key' => base64_encode(md5($init_options['oauth_token'].$init_options['id_site'].$init_options['id_category'])));
                echo json_encode($ret);
                exit();
            }
        }
        else if($_REQUEST['mbu_action'] == 'set_token' && !empty($_REQUEST['token']) && !empty($_REQUEST['expire']))
        {
                                                    // сюда MBU присылает сгенерированный токен
                $mbu_options = get_option('mbu_options');
                header ( 'Content-type: application/json' );
                
                if(isset($mbu_options['auth_code']) && $mbu_options['auth_code'] == $_REQUEST['code'])
                {
                    $mbu_options['oauth_token'] = $_REQUEST['token'];
                    $mbu_options['expire'] = $_REQUEST['expire'];
                    update_option('mbu_options', $mbu_options);
                    $ret = array('key' => base64_encode(md5($mbu_options['oauth_token'].$mbu_options['auth_code'].$mbu_options['id_site'])));
                }
                else
                {
                    $ret = array('error' => 'Bad Code');
                }
                echo json_encode($ret);
                exit();
        }
        else if($_REQUEST['mbu_action'] == 'download_idea_att' && current_user_can(MBU_REQUIRED_CAPABILITY))
        {
                // прокси для загрузки вложений чрез API
            $download_att = isset($_REQUEST['download_att']) ? intval($_REQUEST['download_att']) : 0;
            $filename = isset($_REQUEST['download_filename']) ? sanitize_file_name($_REQUEST['download_filename']) : '';
            if(!empty($filename))
            {
                $pos = strrpos($filename, '.');
                $format = ($pos > 0) ? strtolower(substr($filename, $pos+1)) : 'jpeg';
    
                if($format == 'jpg') $format = 'jpeg';                
            }
            else
            {
                $format = 'jpeg';
            }
            if($download_att > 0)
            {
                $url = MBU_API_BASE_URL.'/idea-attachment?oauth_token='.  mbuGetOption('oauth_token').'&id_att='.$download_att;
//                die($filename);
                header("Content-type: application/$format");
                header("Content-Disposition: attachment; filename=$filename");
                
                echo file_get_contents($url);
                exit();
            }
            
        }
    }
}

        // Ajax handlers

function mbuEraseSettings(){
    delete_option('mbu_options');
    delete_option('mbu_user_info');
    delete_option('mbu_messages');
}

add_action('wp_ajax_mbuEraseSettings', 'mbuEraseSettings');


function mbuSaveAuthCode(){
    $auth_code = isset($_REQUEST['auth_code']) ? sanitize_text_field($_REQUEST['auth_code']) : '';
    
    if(!empty($auth_code))
    {
        $mbu_options = get_option('mbu_options');
                
        if(is_array($mbu_options))
        {
            $mbu_options['auth_code'] = $auth_code;
            update_option('mbu_options', $mbu_options);
        }        
    }
}

add_action('wp_ajax_mbuSaveAuthCode', 'mbuSaveAuthCode');


