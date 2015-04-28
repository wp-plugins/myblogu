<script type="text/javascript">
    mbu.tags = '<?php echo str_replace(array("\'", '"', "'"), "\'", $tags); ?>';
</script>

<div class="wrap">
	
<h2><?php echo MBU_DISPLAY_NAME ?> Settings</h2>

<?php 
    if(!mbuIsInitialized())
    {                       // форма начальной инициализации плагина
?>
    <div>
    <div style="width:40%;" class="postbox-container" >

    <div class="mbu-settings-pane">
       <h2>Create New MBU Account.</h2>
       <p>And Associate this Blog with It</p>
       <div class="forminput">
       <input type="button" onclick="mbu.newAccount();" value="Click Here To Create New MBU User"></input>
       <span class="mbu_login_valid"></span>
       </div>
    <div class="clear"></div>
    </div>

    </div>
    </div>

    <div>
        
    <div style="width:40%; margin-left: 50px;" class="postbox-container" >

    <div class="mbu-settings-pane">
       <h2>Connect to MBU.</h2>
       <p>Connect to existing MBU account</p>
       <div class="forminput">
       <input type="button" onclick="mbu.connectAccount();" value="Click Here To Login on MBU"></input>
       <span class="mbu_login_valid"></span>
       </div>
    <div class="clear"></div>
    </div>

    </div>
    </div>

<?php
    }
    else{
    
    $id_category = mbuGetOption('id_category', 6);
    
			// настройки плагина
?>


    <form novalidate="novalidate" method="post">
    <input id="mbu-brainstorm-id" type="hidden" value="<?php echo $brainstorm['id']; ?>" name="mbu-brainstorm-id"></input>
    <input id="mbu-brainstorm-status" type="hidden" value="<?php echo $brainstorm['status']; ?>" name="mbu-brainstorm-status"></input>

    <table class="form-table mbu-settings-table">
    <tbody>

    <tr>
    <th scope="row">
    <label for="blogname">Blog Category</label>
    </th>
    <td>
        <select id="mbu-id-category" class="regular-text" type="text" name="mbu-id-category"  autocomplete="off">
<?php
        foreach($categories as $cat)
        {
            echo '<option value="'.$cat['id'].'" '.(($id_category == $cat['id']) ? ' selected="selected" ' : '').'>'.$cat['category'].'</option>';
        }
?>
	</select>
    </td>
    </tr>

    <tr>
    <th scope="row">
    <label for="blogname">Blog Tags</label>
    </th>
    <td>
        <input id="mbu-tags" class="regular-text" type="text" name="mbu-tags"  autocomplete="off" value="<?php echo sanitize_text_field($tags); ?>"></input>
        <p class="description">Comma separated</p>
    </td>
    </tr>
    
    <tr>
    <th scope="row">
    <label for="blogname">You can view and edit your MBU account here:</label>
    </th>
    <td>
        <strong><a target="_blank" href="<?php echo MBU_BASE_URL; ?>/profile?id=<?php echo $user_info['user']['id']; ?>"><?php echo $user_info['user']['username']; ?></a></strong>
    </td>
    </tr>
        
    </table>
    
    <p class="submit">
        <button id="mbu-submit" class="button button-primary mbu-dlg-button" onclick="mbu.saveSettings(); return false;">Save Settings</button>
    </p>
    </form>


<?php 
        if(!empty($todo))
        {
?>
<div style="width: 40%;">
    <div class="postbox-container mbu-box" id="mbu-todo">
        <div class="meta-box-sortables" id="side-sortables"><div class="postbox " id="metabox_like">
        <div title="Click to toggle" onclick="jQuery('#mbu-todo-body').toggle(500)" class="handlediv"><br></div><h3 class="hndle"><span>Here's your MBU to-do list</span></h3>
        <div class="inside" id="mbu-todo-body">
        <ul>
<?php
            foreach($todo as $id_item => $item)
            {
                echo '<li id="mbu-todo-item-'.$id_item.'" class="mbu-todo-item">';
                echo '<button class="mbu-close" title="Close" onclick="mbu.closeTODOItem('.$id_item.');" type="button" aria-hidden="true">×</button> ';
                echo $item;
                echo '</li>';
            }
?>            
        </ul>
        </div>
        </div>
        </div>
    </div>
</div>
<?php
        }
?>


<div style="width: 100%; clear: both; margin: 15px;">
    <button class="mbu-btn mbu-gray-btn" onclick="jQuery('#mbu-advanced-options').toggle(500)">Advanced options</button>
</div>

<div style="width: 60%; <?php if($expire > time()) echo 'display: none;'; ?>" id="mbu-advanced-options">
    <div>
    <div class="postbox-container" >

    <div class="mbu-settings-pane">
       <h2>Create New API Token.</h2>
       <p></p>
       <div class="formlabel">
       <h3></h3>
       </div>
       <div class="forminput">
           <input type="button" onclick="mbu.updateToken('<?php echo $user_info['user']['username']; ?>');" value="Click Here Generate New MBU Auth Token"></input>
       <span class="mbu_login_valid"></span>
       </div>
    <div class="clear"></div>
    </div>

    </div>
    </div>

    <div>
    <div class="postbox-container" >

    <div class="mbu-settings-pane">
       <h2>Erase MBU settings.</h2>
       <p></p>
       <div class="formlabel">
       <h3></h3>
       </div>
       <div class="forminput">
       <input type="button" onclick="mbu.eraseSettings();" value="Click Here To Erase MBU Settings"></input>
       <span class="mbu_login_valid"></span>
       </div>
    <div class="clear"></div>
    </div>

    </div>
    </div>
    
</div>


<?php
    }
?>


<div style="width: 100%; clear: both; margin-top: 10px;" class="updated fade mbu-alert"><p>
      MyBlogU is the free blogging community that lets you
      crowd source your content idea and even content creation: Ask
      MyBlogU users to brainstorm a great idea and even provide blurbs
      (=partially write your content for you) and create better content
      easier (=better writing productivity!) Action items:<br>
      <ul>
        <li>Please take our quick <a href="https://www.udemy.com/myblogu-content-marketing/" target="_blank">Udemy
            course</a> (won't take you much time) or view our video
          tutorials on our <a href="https://www.youtube.com/user/MyBlogu" target="_blank">Youtube channel</a></li>
        <li>Feel free to create your own <a href="<?php echo admin_url('admin.php?page=mbu_brainstorms'); ?>" target="_blank">Brainstorm
            project</a> to see how it works!<br>
        </li>
      </ul>
</p>
</div>


</div>
<?php

echo mbuRunTpl('dlg/new_account', array('categories' => $categories, 'tags' => $tags));
?>