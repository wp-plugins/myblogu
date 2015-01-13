<?php

/* Runs when plugin is activated */
register_activation_hook(__FILE__, 'mbu_install');

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'mbu_remove' );

	
		

/* call register settings function */
add_action( 'admin_init', 'register_mbu_settings' );
	
if ( is_admin() ){
	/* Call the html code and register the menus */
 		
	add_action('admin_menu', 'mbu_admin_menu');
	
    function mbu_admin_menu() {
	
        $user_info = mbuGetUserInfo();
        $num_new_ideas = (is_array($user_info) && isset($user_info['num_new_ideas'])) ? $user_info['num_new_ideas'] : 0;
        $num_new_ideas_msg = ($num_new_ideas > 0) ? '<span class="update-plugins"><span class="plugin-count">'.$num_new_ideas.'</span></span>' : '';
        $num_new_answers = (is_array($user_info) && isset($user_info['num_new_answers'])) ? $user_info['num_new_answers'] : 0;
        $num_new_answers_msg = ($num_new_answers > 0) ? '<span class="update-plugins"><span class="plugin-count">'.$num_new_answers.'</span></span>' : '';

        $todo = get_option('mbu_todo');
        $num_todo = (is_array($todo) && count($todo) > 0) ? count($todo) : 0;
        $num_todo_msg = ($num_todo > 0) ? '<span class="update-plugins"><span class="plugin-count">'.$num_todo.'</span></span>' : '';

        $main_msg = (($num_new_ideas + $num_new_answers + $num_todo) > 0) ? '<span class="update-plugins"><span class="plugin-count">'.($num_new_ideas + $num_new_answers + $num_todo).'</span></span>' : '';
        
	add_menu_page(MBU_DISPLAY_NAME, MBU_DISPLAY_NAME.' '.$main_msg, MBU_REQUIRED_CAPABILITY, 'mbu-main-menu', 'mbu_settings_page', MBU_IMGS.'/icon.png'); 
	add_submenu_page( 'mbu-main-menu',  MBU_DISPLAY_NAME, 'Settings '.$num_todo_msg, MBU_REQUIRED_CAPABILITY, 'mbu-main-menu', 'mbu_settings_page');        
        add_submenu_page( 'mbu-main-menu',  'Brainstorms', 'Brainstorms '.$num_new_ideas_msg, MBU_REQUIRED_CAPABILITY, 'mbu_brainstorms', 'mbu_brainstorms_page');
        add_submenu_page( 'mbu-main-menu',  'Interviews', 'Interviews '.$num_new_answers_msg, MBU_REQUIRED_CAPABILITY, 'mbu_interviews', 'mbu_interviews_page');
        add_submenu_page( 'mbu-main-menu',  'MBU Alerts', '', MBU_REQUIRED_CAPABILITY, 'mbu_pm', 'mbu_pm_page');


		/* Load UP CSS & Javascript files */

        $id_site = mbuGetOption('id_site');
        $mbu_script_data = array( 
                                'ajaxurl' => admin_url( 'admin-ajax.php' ), 
                                'mbu_url' => MBU_BASE_URL,
                                'img_path' => MBU_IMGS,
                                'blog_title' => mbuGetBlogTitle(),
                                'blog_url' => MBU_BLOG_URL,
                                'blog_admin_url' => admin_url(),
                                );
         if(!empty($id_site))
         {
            $mbu_script_data['id_site'] = $id_site;
         }
	 if (MBU_LOAD_JS) {
            wp_register_script('mbu_process', MBU_JS_URL, array('jquery') );
            wp_localize_script('mbu_process', 'mbu_script_data', $mbu_script_data);
            wp_enqueue_script('mbu_process');
                        
            wp_enqueue_script('json2');
            wp_enqueue_script('jquery');
            wp_enqueue_script('jquery-ui-datepicker');
            
            wp_register_script('file_download', MBU_PLUGIN_URL.'/js/jquery.fileDownload.js', array('jquery') );
            wp_enqueue_script('file_download');
            
            wp_register_script('pretty_photo', MBU_PLUGIN_URL.'/js/pretty_photo/js/jquery.prettyPhoto.js', array('jquery') );
            wp_enqueue_script('pretty_photo');            
            
            wp_register_script('mbu_ckeditor', MBU_PLUGIN_URL.'/js/ckrditor/ckeditor.js', array('jquery') );
            wp_enqueue_script('mbu_ckeditor');
            
            wp_register_script('base64', MBU_PLUGIN_URL.'/js/base64.js');
            wp_enqueue_script('base64');
	 }
		
	 if (MBU_LOAD_CSS) {
            wp_enqueue_style('mbu-style', MBU_CSS_URL);
            wp_enqueue_style('pretty-photo-style', MBU_PLUGIN_URL.'/js/pretty_photo/css/prettyPhoto.css');
            wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
            wp_enqueue_style('full-glyphicons', MBU_PLUGIN_URL.'/css/full-glyphicons/css/glyphicons.css');
	 }
    }
}

	
function mbu_install() {
/* Creates new database field */
	add_option("mbu_options", '', '', 'yes');
}

function mbu_remove() {
/* Deletes the database field */
	delete_option('mbu_options');
}

function register_mbu_settings() {

//register our settings
	register_setting( 'mbu_settings', 'mbu_options', 'mbu_options_validate' );
}

// Sanitize and validate input. Accepts an array, return a sanitized array.
function mbu_options_validate($input) {
   
    return $input;
}

        /*
         *  показывает сообщение
         */
function mbuShowMessage($message, $errormsg = false)
{
	if ($errormsg) {
		echo '<div id="message" class="error">';
	}
	else {
		echo '<div id="message" class="updated fade">';
	}

	echo "<p><i>MyBlogU:</i> <strong>$message</strong></p></div>";
}    

function mbuShowAdminMessages()
{
    if(defined('MBU_TEST_ENV'))
    {
        mbuShowMessage('Connected to TEST server', true);
    }
    if(mbuIsInitialized())
    {
        $expire = mbuGetOption('expire', 0);
        if($expire < time())
        {
            mbuShowMessage('Connection token has been expired, please update autorization <a href="'.get_admin_url().'admin.php?page=mbu-main-menu'.'">here</a>', true);
        }
        else
        {
            $user_info = mbuGetUserInfo();
            if(is_array($user_info) && $user_info['user']['status'] == 0)
            {
                mbuShowMessage(sprintf('Please check your mailbox %s to complete registration! Please check your spam box in case it\'s not there and add info@myblogu.com to your address book!', $user_info['user']['email']));
            }
        }
    }
    else
    {
        if(!isset($_REQUEST['page']) || $_REQUEST['page'] != 'mbu-main-menu')
        {
            //mbuShowMessage('Please <a href="'.get_admin_url().'admin.php?page=mbu-main-menu'.'">init</a> MBU connection', true);
            echo '<div class="mbu-init-msg">';
            echo 'You\'ve installed MyBlogU plugin for WordPress! Now you can <a class="mbu-btn mbu-blue-btn" href="'.get_admin_url().'admin.php?page=mbu-main-menu'.'">connect</a> to MyBlogU';
            echo '</div>';
        }
    }
}
add_action('admin_notices', 'mbuShowAdminMessages');

function mbuApiProxy(){
    
    if( ! current_user_can(MBU_REQUIRED_CAPABILITY)) {
        return;
    }
    //var_dump(base64_decode($_REQUEST['params'])); die();
    $params_str = base64_decode($_REQUEST['params']);
    if(empty($params_str))
    {
        echo json_encode(array('err' => 'Bad Proxy Request!'));
        die();
    }
    $params_str = html_entity_decode($params_str);
    
    $api_method = isset($_REQUEST['api_method']) ? trim(sanitize_text_field($_REQUEST['api_method'])) : '';
    $params = isset($_REQUEST['params']) ? json_decode($params_str, true) : array();
    $res = mbu_api(MBU_API_BASE_URL.'/'.$api_method, $params, true, $_SERVER['REQUEST_METHOD']);
    
    if(is_string($res))
    {
        $res = array('err' => $res);
    }
    
    $action = (isset($params) && isset($params['action'])) ? $params['action'] : '';
    if($api_method == 'ideas' && ($action == 'approve_idea' || $action == 'reject_idea'))
    {
        delete_option('mbu_user_info');
    }
    if($api_method == 'pm' && ($action == 'del' || $action == 'read_message'))
    {
        delete_option('mbu_messages');
    }
    
    header ( 'Content-type: application/json' );
    echo json_encode($res);
    exit();
}

add_action('wp_ajax_mbuApiProxy', 'mbuApiProxy');

add_action('wp_ajax_mbuSaveSettings', 'mbuSaveSettings');

function mbuSaveSettings(){
    header ( 'Content-type: application/json' );
    
    $id_category = isset($_REQUEST['id_category']) ? intval($_REQUEST['id_category']) : 0;
    $tags = isset($_REQUEST['tags']) ? trim(urldecode(str_replace("\'", "'", $_REQUEST['tags']))) : '';
    $mbu_options = get_option('mbu_options');
    if(is_array($mbu_options) && !empty($id_category))
    {
        $mbu_options['id_category'] = $id_category;
        $mbu_options['tags'] = $tags;
        update_option('mbu_options', $mbu_options);
        
        $res = mbu_api(MBU_API_BASE_URL.'/oauth', array('action' => 'save_settings', 'id_category' => $id_category, 'tags' => $tags), true);
        if(is_string($res))
        {
            echo json_encode(array('err' => $res));
            exit();            
        }
    }        
    
    echo json_encode(array('msg' => 'Save Successfully'));
    exit();
}

add_action('wp_ajax_mbuCreateTODO', 'mbuCreateTODO');

function mbuCreateTODO(){
    
    $todo = array(
        1 => 'Complete your MBU account for more benefits (<a href="http://myblogu.com/profile?section=identity&amp;id=57230" target="_blank">Add  social media accounts to build followers</a>, <a href="http://myblogu.com/profile?section=avatar&amp;id=57230" target="_blank">profile picture</a>, etc)',
        2 => '<a href="https://www.udemy.com/myblogu-content-marketing/" target="_blank"><strong>Take our free Udemy course</strong></a> to make the most of our platform (This won\'t take you long!)',
        3 => '<a href="http://myblogu.com/forum/" target="_blank">Say hi to us in the forums</a>',
        4 => '<a href="http://myblogu.com/article-requests" target="_blank">Browse our Brainstorm requests and help users</a>: Get inspired by helping others + Grow your MBU rank + Learn how to use our platform!',
    );
    add_option('mbu_todo', $todo, '', 'yes');
    update_option('mbu_todo', $todo);

    header ( 'Content-type: application/json' );
    echo json_encode(array());    
    exit();
}

add_action('wp_ajax_mbuDelTODOItem', 'mbuDelTODOItem');

function mbuDelTODOItem(){
    
    $id_item = (isset($_REQUEST['id_item'])) ? intval($_REQUEST['id_item']) : 0;
    $todo = get_option('mbu_todo');
    
    if(!empty($id_item) && !empty($todo) && isset($todo[$id_item]))
    {
        unset($todo[$id_item]);
        add_option('mbu_todo', $todo, '', 'yes');
        update_option('mbu_todo', $todo);
    }
    header ( 'Content-type: application/json' );
    echo json_encode(array());
    exit();
    
    exit();
}


function mbuPMAdminBar($wp_admin_bar){
    
    $messages = mbuGetMessages();
    $msg_count = (is_array($messages) && is_array($messages['messages'])) ? count($messages['messages']) : 0;
    
    if($msg_count > 0)
    {
        $args = array(
            'id' => 'mbu-top-bar-item-pm',
            'title' => '<span class="mbu-msg-count">'.$msg_count.'</span> MBU alerts',
            'href' => get_admin_url().'admin.php?page=mbu_pm',
            'meta' => array(
                'class' => 'mbu-top-bar-item',
            )
        );
        $wp_admin_bar->add_node($args);
    }
}

add_action('admin_bar_menu', 'mbuPMAdminBar', 150);

    // просмотр идеи
function mbuGetIdeaDlg(){
    
    header ( 'Content-type: application/json' );
    if( ! current_user_can(MBU_REQUIRED_CAPABILITY)) {
        return;
    }
    $res = array();
    $id_idea = isset($_REQUEST['id_idea']) ? intval($_REQUEST['id_idea']) : 0;
    if(empty($id_idea))
    {
        $res['err'] = 'Bad Request';
        echo json_encode($res);
        exit();        
    }
    
    $data = array('action' => 'get_ideas', 'statuses' => '0,1', 'id_idea' => $id_idea);
    $ret = mbu_api(MBU_API_BASE_URL.'/ideas', $data);
    if(is_string($ret))
    {
        $res['err'] = $ret;
        echo json_encode($res);
        exit();        
    }
    if(empty($ret['ideas']))
    {
        $res['err'] = 'Idea Not Found';
        echo json_encode($res);
        exit();                
    }
    $idea = $ret['ideas'][0];
    $data = array('action' => 'get_user', 'id_user' => $idea['id_user']);
    $ret = mbu_api(MBU_API_BASE_URL.'/profile', $data);
    $user = $ret['user'];
    
    $res['html'] = mbuRunTpl('dlg/idea', array('idea' => $idea, 'user' => $user));
    echo json_encode($res);
    exit();
}

add_action('wp_ajax_mbuGetIdeaDlg', 'mbuGetIdeaDlg');

    // изменение URL на котором опубликована идея

function mbuGetIdeaURLDlg(){
    
    header ( 'Content-type: application/json' );
    if( ! current_user_can(MBU_REQUIRED_CAPABILITY)) {
        return;
    }
    $res = array();
    $id_idea = isset($_REQUEST['id_idea']) ? intval($_REQUEST['id_idea']) : 0;
    if(empty($id_idea))
    {
        $res['err'] = 'Bad Request';
        echo json_encode($res);
        exit();        
    }
    
    $data = array('action' => 'get_ideas', 'statuses' => '1', 'id_idea' => $id_idea);
    $ret = mbu_api(MBU_API_BASE_URL.'/ideas', $data);
    if(is_string($ret))
    {
        $res['err'] = $ret;
        echo json_encode($res);
        exit();        
    }
    if(empty($ret['ideas']))
    {
        $res['err'] = 'Idea Not Found';
        echo json_encode($res);
        exit();                
    }
    $idea = $ret['ideas'][0];
    
    $res['html'] = mbuRunTpl('dlg/enter_idea_url', array('idea' => $idea));
    echo json_encode($res);
    exit();
}

add_action('wp_ajax_mbuGetIdeaURLDlg', 'mbuGetIdeaURLDlg');



function mbuGetTODOItemDlg(){
    
    header ( 'Content-type: application/json' );
    if( ! current_user_can(MBU_REQUIRED_CAPABILITY)) {
        return;
    }
    $res = array();
    $id_todo = isset($_REQUEST['id_todo']) ? intval($_REQUEST['id_todo']) : 0;
    if(empty($id_todo))
    {
        $res['err'] = 'Bad Request';
        echo json_encode($res);
        exit();        
    }
    
    $data = array('action' => 'get_todo_item', 'id_todo' => $id_todo);
    $ret = mbu_api(MBU_API_BASE_URL.'/ideas', $data);
    if(is_string($ret))
    {
        $res['err'] = $ret;
        echo json_encode($res);
        exit();        
    }
    if(empty($ret['todo_item']))
    {
        $res['err'] = 'Idea Not Found';
        echo json_encode($res);
        exit();                
    }
    
    $res['html'] = mbuRunTpl('dlg/show_idea_todo', array('todo' => $ret['todo_item']));
    echo json_encode($res);
    exit();
}

add_action('wp_ajax_mbuGetTODOItemDlg', 'mbuGetTODOItemDlg');

function mbuGetInterviewPreviewDlg(){

    header ( 'Content-type: application/json' );
    if( ! current_user_can(MBU_REQUIRED_CAPABILITY)) {
        return;
    }
    $res = array();
    $id_interview = isset($_REQUEST['id_interview']) ? intval($_REQUEST['id_interview']) : 0;
    if(empty($id_interview))
    {
        $res['err'] = 'Bad Request';
        echo json_encode($res);
        exit();        
    }
    
    $gen_content_table = isset($_REQUEST['gen_content_table']) ? intval($_REQUEST['gen_content_table']) : 0;
    $gen_author_info = isset($_REQUEST['gen_author_info']) ? intval($_REQUEST['gen_author_info']) : 0;
    
    $data = array('action' => 'get_code', 'gen_content_table' => $gen_content_table, 'gen_author_info' => $gen_author_info , 'id_interview' => $id_interview, 'preview' => 1);
    $ret = mbu_api(MBU_API_BASE_URL.'/interview', $data);
    if(is_string($ret))
    {
        $res['err'] = $ret;
        echo json_encode($res);
        exit();        
    }

    $post = mbuGetPostByInterview($id_interview);
    if(!empty($post))
    {
        $ret['post_id'] = $post->ID;
    }
    $res['html'] = mbuRunTpl('dlg/interview_preview', array('interview' => $ret));
    echo json_encode($res);
    exit();
}

add_action('wp_ajax_mbuGetInterviewPreviewDlg', 'mbuGetInterviewPreviewDlg');

/*
function mbuGetPmDlg(){
    
    header ( 'Content-type: application/json' );
    if( ! current_user_can(MBU_REQUIRED_CAPABILITY)) {
        return;
    }
    $res = array();
    $id_pm = isset($_REQUEST['id_pm']) ? intval($_REQUEST['id_pm']) : 0;
    if(empty($id_pm))
    {
        $res['err'] = 'Bad Request';
        echo json_encode($res);
        exit();        
    }
    
    $data = array('action' => 'read_message', 'id_pm' => $id_pm);
    $ret = mbu_api(MBU_API_BASE_URL.'/pm', $data);
    if(is_string($ret))
    {
        $res['err'] = $ret;
        echo json_encode($res);
        exit();        
    }
    if(empty($ret['message']))
    {
        $res['err'] = 'Message Not Found';
        echo json_encode($res);
        exit();                
    }
    $message = $ret['message'];
    
    $res['html'] = mbuRunTpl('dlg/read_pm', array('message' => $message));
    echo json_encode($res);
    exit();
}

add_action('wp_ajax_mbuGetIdeaDlg', 'mbuGetIdeaDlg');
*/

    /*
     *  создает пост на основе интервью
     */
function mbuPublishInterviewAjax(){

    global $user_ID;
    
    header ( 'Content-type: application/json' );
    if( ! current_user_can(MBU_REQUIRED_CAPABILITY)) {
        return;
    }

    $id_interview = isset($_REQUEST['id_interview']) ? intval($_REQUEST['id_interview']) : 0;

    if(empty($id_interview))
    {
        $res['err'] = 'Bad Request';
        echo json_encode($res);
        exit();        
    }
    
    $old_post = mbuGetPostByInterview($id_interview);
    if(is_object($old_post))
    {
	$message = sprintf("Post already exists <a target='_new' href='%s'>here</a>", admin_url('post.php?post='.$old_post->ID.'&action=edit'));
        $res['msg'] = $message;
        echo json_encode($res);
        exit();        
    }
    $gen_content_table = isset($_REQUEST['gen_content_table']) ? intval($_REQUEST['gen_content_table']) : 0;
    $gen_author_info   = isset($_REQUEST['gen_author_info']) ? intval($_REQUEST['gen_author_info']) : 0;
   
    $data = array(
                'action' => 'get_code', 
                'id_interview' => $id_interview, 
                'gen_content_table' => $gen_content_table, 
                'gen_author_info' => $gen_author_info,
                'preview' => 1,
                );
    $ret = mbu_api(MBU_API_BASE_URL.'/interview', $data);
    if(is_string($ret))
    {
        $res['err'] = $ret;
        echo json_encode($res);
        exit();                
    }
    if($ret['interview_status'] != 2)
    {
        $res['err'] = 'Bad Interview Status';
        echo json_encode($res);
        exit();                
    }
    
    $code = str_replace('&nbsp;', ' ', $ret['code']);
    //$code = str_replace("\xA0", ' ', html_entity_decode($code));
    $new_post = array(
            'post_title' => $ret['title'],
            'post_content' => $code,
            'post_status' => 'draft',
            'post_date' => date('Y-m-d H:i:s'),
            'post_author' => $user_ID,
            'post_type' => 'post',
            'post_category' => array(0),
            'filter' => true
    );
    
    $post_id = wp_insert_post($new_post);
		
    if (!empty($post_id))
    {
        add_post_meta($post_id, 'mbu_interview_id', $id_interview, true);
	$message = sprintf("Post Has Been Inserted Into Wordpress, <a target='_new' href='%s'>click here</a> to edit your post", admin_url('post.php?post='.$post_id.'&action=edit'));
        $res['msg'] = $message;
        echo json_encode($res);
        exit();                
        
    } else {
	// inserting post failed -- opps
        $res['err'] = "Inserting Post Into WordPress Failed";
        echo json_encode($res);
        exit();                
    }
}

add_action('wp_ajax_mbuPublishInterviewAjax', 'mbuPublishInterviewAjax');


    /* post status handling */
    
function mbu_draft_to_publish($post)
{
	// если пост создан на основе интервью, то при публикации нужно уведомить MBU
    $id_interview = get_post_meta($post->ID, 'mbu_interview_id', true);
  
    if(!empty($id_interview))
    {
        $data = array(
            'id_interview' => $id_interview,
            'url' => $post->guid,
            'action' => 'save_url',
        );
        $res = mbu_api(MBU_API_BASE_URL.'/interview', $data, true);
    }
}

add_action( 'draft_to_publish', 'mbu_draft_to_publish' );

function mbu_draft_to_future($post)
{
	// если пост создан на основе интервью, то при публикации нужно уведомить MBU
    $id_interview = get_post_meta($post->ID, 'mbu_interview_id', true);
    if(!empty($id_interview))
    {
	$date_info = explode(" ", $post->post_date);
	$shedule_date = $date_info[0];	
        if(!empty($shedule_date))
	{
            $data = array(
                'id_interview' => $id_interview,
                'url' => $post->guid,
                'scheduled' => $shedule_date,
                'action' => 'save_url',                
            );
        
            $res = mbu_api(MBU_API_BASE_URL.'/interview', $data, true);            
        }        
    }
}

add_action( 'draft_to_future', 'mbu_draft_to_future' );


    // регистрируем dashboard widgets
add_action( 'wp_dashboard_setup', 'mbu_add_dashboard_widgets' );

function mbu_add_dashboard_widgets()
{
    wp_add_dashboard_widget('mbu_widget', 'MyBlogU: Create My Own Idea for Brainstorming', 'mbu_draw_widget');
}

function mbu_draw_widget()
{
    if(!mbuIsInitialized())
    {
        return;
    }
    
    $data = array('statuses' => '1', 'action' => 'get_projects');
    $res = mbu_api(MBU_API_BASE_URL.'/article-requests', $data);
    if(is_string($res))
    {
        mbuShowMessage($res, true);
        return;        
    }
    
    if(!empty($res['requests']))
    {
        echo mbuRunTpl('chunks/requests/idea_widget', array(
                                            'requests' => $res['requests'],
                                        ));
    }
}

