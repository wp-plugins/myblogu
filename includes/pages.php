<?php


function mbu_settings_page(){

   $categories = mbuGetCategories();
   if(!mbuIsInitialized())
   {
       $tags_arr = get_tags(array(
		       'orderby' => 'count',
		       'order' => 'DESC',
		       'fields' => 'names',
		       'number' => 4,
		       ));
       $tags = implode(',', $tags_arr);
   }
   else
   {
       $tags = mbuGetOption('tags', '');
   }
   
   $user_info = mbuGetUserInfo();
   echo mbuRunTpl('settings_page', array('categories' => $categories, 
                                          'user_info' => $user_info, 
                                          'tags' => $tags,
                                          'todo' => get_option('mbu_todo'),
                                          'expire' => mbuGetOption('expire', 0),
                                         ));
}


function mbu_brainstorms_page(){
        
//    var_dump($_SERVER);
    if( ! current_user_can(MBU_REQUIRED_CAPABILITY)) {
        showMessage("Sorry you are not authorized to access this page", true);
        return;
    }

    $mbu_page = !empty($_REQUEST['mbu_page']) ? sanitize_text_field($_REQUEST['mbu_page']) : 'active_brainstorms';

    if($mbu_page == 'active_brainstorms')
    {
        $data = array('statuses' => '0,1,99', 'action' => 'get_projects');
        $res = mbu_api(MBU_API_BASE_URL.'/article-requests', $data);
        if(is_string($res))
        {
            mbuShowMessage($res, true);
            return;        
        }
        
        echo mbuRunTpl('brainstorm_list', array(
                                        'requests' => $res['requests'],
                                        ));
        
    }
    else if($mbu_page == 'new_brainstorm')
    {
        $brainstorm = array(
            'id' => 0,
            'title' => '',
            'txt'   => '',
            'tags'  => mbuGetOption('tags', ''),
            'id_category' => mbuGetOption('id_category', 6),
        );
        
        $data = array('statuses' => '0,1', 'action' => 'get_projects');
        $res = mbu_api(MBU_API_BASE_URL.'/article-requests', $data);
        $requests = $res['requests'];
                
        $categories = mbuGetCategories();
        echo mbuRunTpl('new_brainstorm', array(
                                            'brainstorm' => $brainstorm,
                                            'categories' => $categories,
                                            'requests' => $requests,
                                            'user_info' => mbuGetUserInfo(),
                                        ));
    }    
    else if($mbu_page == 'edit_brainstorm')
    {
        $id_request = (isset($_REQUEST['id_request'])) ? intval($_REQUEST['id_request']) : 0;
        if(empty($id_request))
        {
            mbuShowMessage('Bad Request!', true);
            return;        
        }        
        $data = array('id_request' => $id_request, 'action' => 'get_projects');
    
        $res = mbu_api(MBU_API_BASE_URL.'/article-requests', $data);
        if(is_string($res))
        {
            mbuShowMessage($res, true);
            return;        
        }
    
        if(isset($res['requests']) && !empty($res['requests'][0]))
        {
            $brainstorm = $res['requests'][0];
        }
        else
        {
            mbuShowMessage('Project not found!', true);
            return;
        }

        if($brainstorm['status'] != 0 && $brainstorm['status'] != 99)
        {
            // получаем идеи
            $data = array('action' => 'get_ideas', 'statuses' => '0,1', 'id_request' => $id_request);
            $res = mbu_api(MBU_API_BASE_URL.'/ideas', $data);
            if(is_string($res))
            {
                mbuShowMessage($res, true);
                return;        
            }

            $brainstorm['ideas'] = $res['ideas'];
        }
    
        $categories = mbuGetCategories();
        echo mbuRunTpl('active_brainstorm', array(
                                        'brainstorm' => $brainstorm,
                                        'categories' => $categories,
                                        'user_info' => mbuGetUserInfo(),
                                        ));
    }
    else if($mbu_page == 'brainstorm_archive')
    {
        $data = array('statuses' => '2', 'action' => 'get_projects');
        $res = mbu_api(MBU_API_BASE_URL.'/article-requests', $data);
        if(is_string($res))
        {
            mbuShowMessage($res, true);
            return;
        }

        echo mbuRunTpl('brainstorm_archive', array(
                                        'requests' => $res['requests'],
                                        ));
        
     }
     else if($mbu_page == 'brainstorm')
     {        
        if(!empty($_REQUEST['id_request']))
        {
            $id_request = intval($_REQUEST['id_request']);
        }
        else
        {
            mbuShowMessage('Bad Request!', true);
            return;        
        }

        $data = array('id_request' => $id_request, 'action' => 'get_projects');
        $res = mbu_api(MBU_API_BASE_URL.'/article-requests', $data);
        if(is_string($res))
        {
            mbuShowMessage($res, true);
            return;        
        }
    
        if(isset($res['requests']) && !empty($res['requests'][0]))
        {
            $brainstorm = $res['requests'][0];
        }
        else
        {
            mbuShowMessage('Project Not Found', true);
            return;                    
        }
        
        $statuses = (empty($_REQUEST['new_ideas'])) ? '0,1' : '0,';
            // получаем идеи
        $data = array('action' => 'get_ideas', 'statuses' => $statuses);
        $res = mbu_api(MBU_API_BASE_URL.'/ideas', $data);
        if(is_string($res))
        {
            mbuShowMessage($res, true);
            return;        
        }

        $brainstorm['ideas'] = $res['ideas'];
        echo mbuRunTpl('brainstorm', array(
                                        'brainstorm' => $brainstorm,
                                        'new_ideas'  => ((!empty($_REQUEST['new_ideas'])) ? intval($_REQUEST['new_ideas']) : 0),
                                    ));        
    }
    else if($mbu_page == 'ideas')
    {
        $id_category = isset($_REQUEST['id_category']) ? intval($_REQUEST['id_category']) : 0;
        $id_request  = isset($_REQUEST['id_request']) ? intval($_REQUEST['id_request']) : 0;        
        $txt = isset($_REQUEST['txt']) ? str_replace(array('\\\'', '\"', '\'', '"'), '`', $_REQUEST['txt']) : '';
        
        $categories = mbuGetCategories();
        $categories[] = array('id' => 0, 'category' => 'All Categories');
        
        $res = mbu_api(MBU_API_BASE_URL.'/ideas', array('action' => 'get_ideas', 'id_category' => $id_category, 'txt' => $txt, 'statuses' => '0,1', 'id_request' => $id_request), true);
        if(is_string($res))
        {
            mbuShowMessage($res, true);
            return;
        }
        $ideas = $res['ideas'];

        $res = mbu_api(MBU_API_BASE_URL.'/article-requests', array('action' => 'get_projects', 'statuses' => '1,2'), true);
        if(is_string($res))
        {
            mbuShowMessage($res, true);
            return;
        }
        $requests = $res['requests'];
        $requests[] = array('id' => 0, 'title' => 'All Projects');
        
        echo mbuRunTpl('ideas_list', array(
                                        'mbu_page'   => $mbu_page,
                                        'txt' => $txt,
                                        'id_request' => $id_request,
                                        'id_category' => $id_category,
                                        'categories' => $categories,
                                        'ideas'      => $ideas,
                                        'requests'   => $requests,
                                        ));
    }    
}

function mbu_interviews_page(){
        
//    var_dump($_SERVER);
    if( ! current_user_can(MBU_REQUIRED_CAPABILITY)) {
        showMessage("Sorry you are not authorized to access this page", true);
        return;
    }

    $mbu_page = !empty($_REQUEST['mbu_page']) ? sanitize_text_field($_REQUEST['mbu_page']) : 'active_interviews';

    if($mbu_page == 'active_interviews')
    {
            // список интервью в статусах 			
            // 0 - 'Draft', 1 - 'Active', 6 - 'On Moderatin', 99 - 'Hidden'

        $data = array('statuses' => '0,1,6,99', 'action' => 'get_interviews');
        $res = mbu_api(MBU_API_BASE_URL.'/my-interviews', $data);
        if(is_string($res))
        {
            mbuShowMessage($res, true);
            return;        
        }

        $interviews = $res['interviews'];
        foreach($interviews as &$iv)
        {
            $post = mbuGetPostByInterview($iv['id']);
            if(is_object($post))
            {
                $iv['post_id'] = $post->ID;
            }
        }
        echo mbuRunTpl('interviews_list', array(
                                        'interviews' => $interviews,
                                        'title' => 'Active Interviews',
                                        'mbu_page' => $mbu_page,
                                        ));        
    }
    else if($mbu_page == 'archive')
    {
            // список интервью в статусах 			
            // 2 - 'Closed', 3 - 'Published'

        $data = array('statuses' => '2,3', 'action' => 'get_interviews');
        $res = mbu_api(MBU_API_BASE_URL.'/my-interviews', $data);
        if(is_string($res))
        {
            mbuShowMessage($res, true);
            return;        
        }
        $interviews = $res['interviews'];
        foreach($interviews as &$iv)
        {
            $post = mbuGetPostByInterview($iv['id']);
            if(is_object($post))
            {
                $iv['post_id'] = $post->ID;
            }
        }
        
        echo mbuRunTpl('interviews_list', array(
                                        'interviews' => $interviews,
                                        'title' => 'Interviews Archive',
                                        'mbu_page' => $mbu_page,
                                        ));        
        
    }
    else if($mbu_page == 'interview')
    {
        $id_interview = isset($_REQUEST['id_interview']) ? intval($_REQUEST['id_interview']) : 0;
        if(empty($id_interview))
        {
            mbuShowMessage('Bad Request!', true);
            return;
        }
        $res = mbu_api(MBU_API_BASE_URL.'/my-interviews', array('action' => 'get_interviews', 'id_interview' => $id_interview), true);
        if(is_string($res))
        {
            mbuShowMessage($res, true);
            return;
        }
        else if(empty($res['interviews']))
        {
            mbuShowMessage('Interview not found', true);
            return;            
        }
        $interview = $res['interviews'][0];
        $post = mbuGetPostByInterview($interview['id']);
        if(is_object($post))
        {
            $interview['post_id'] = $post->ID;
            
            if($interview['status'] == 2 && ($post->post_status == 'publish' || $post->post_status == 'future'))
            {
                $data = array(
                    'id_interview' => $id_interview,
                    'url' => $post->guid,
                    'action' => 'save_url',
                );
                if($post->post_status == 'future')
                {
                    $date_info = explode(" ", $post->post_date);
                    $shedule_date = $date_info[0];
                    $data['scheduled'] = $shedule_date;
                }
                $res = mbu_api(MBU_API_BASE_URL.'/interview', $data, true);
                if(is_array($res) && $res['new_status'] == 3)
                {
                    $interview['status'] = 3;
                    $interview['status_name'] = 'Published';
                    $interview['url'] = $post->guid;
                }
            }
        }
        
        $res = mbu_api(MBU_API_BASE_URL.'/interview', array('action' => 'get_questions_answers', 'id_interview' => $id_interview), true);
        if(is_string($res))
        {
            mbuShowMessage($res, true);
            return;
        }
        else if(empty($res['questions']))
        {
            mbuShowMessage('Questions not found', true);
            return;            
        }
        
        $questions = $res['questions'];
        echo mbuRunTpl('interview_answers', array(
                                        'mbu_page' => $mbu_page,
                                        'interview' => $interview,
                                        'questions' => $questions,
                                        'post' => $post,
                                        ));        
    }
    else if($mbu_page == 'new_interview')
    {
        $categories = mbuGetCategories();
        $interview = array(
            'id' => 0,
            'status' => 0,
            'id_category' => mbuGetOption('id_category', 6),
            'title' => '',
            'comment' => '',
            'deadline' => '',
            'tags' => mbuGetOption('tags', ''),
            'public' => '',
        );
        echo mbuRunTpl('edit_interview', array(
                                        'mbu_page' => $mbu_page,
                                        'categories' => $categories,
                                        'interview' => $interview,
                                        ));                
    }
    else if($mbu_page == 'edit_interview')
    {
        $id_interview = isset($_REQUEST['id_interview']) ? intval($_REQUEST['id_interview']) : 0;
        if(empty($id_interview))
        {
            mbuShowMessage('Bad Request!', true);
            return;
        }
        $categories = mbuGetCategories();
        $res = mbu_api(MBU_API_BASE_URL.'/my-interviews', array('action' => 'get_interviews', 'id_interview' => $id_interview), true);
        if(is_string($res))
        {
            mbuShowMessage($res, true);
            return;
        }
        else if(empty($res['interviews']))
        {
            mbuShowMessage('Interview not found', true);
            return;            
        }

        $interview = $res['interviews'][0];
        $interview['deadline'] = trim(preg_replace('/\d\d:\d\d:\d\d/', '', $interview['deadline']));
        
        echo mbuRunTpl('edit_interview', array(
                                        'mbu_page' => $mbu_page,
                                        'categories' => $categories,
                                        'interview' => $interview,
                                        ));
    }
}

function mbu_pm_page(){

   if( ! current_user_can(MBU_REQUIRED_CAPABILITY)) {
        showMessage("Sorry you are not authorized to access this page", true);
        return;
   }    
   $user_info = mbuGetUserInfo();
   
   $mbu_page = !empty($_REQUEST['mbu_page']) ? sanitize_text_field($_REQUEST['mbu_page']) : 'new_pm';
    
   if($mbu_page == 'new_pm')
   {   
       $msgs      = mbuGetMessages();
   }
   else if($mbu_page == 'all_pm')
   {   
       $msgs = mbu_api(MBU_API_BASE_URL.'/pm', array('action' => 'get_incoming', 'statuses' => 'sent,delivered,read', 'autocreated' => 1));
   }   
   echo mbuRunTpl('pm_page', array(
                                    'user_info' => $user_info, 
                                    'msgs' => $msgs,
                                    'mbu_page' => $mbu_page,
                                  ));
}

