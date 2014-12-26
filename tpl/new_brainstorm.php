<div class="wrap">
<?php
    echo mbuRunTpl('chunks/requests/top_menu', array('active_page' => 'new_brainstorm'));

    echo '<h2>New Brainstorm Project</h2>';

    if(!empty($requests))
    {
       mbuShowMessage('First archive or delete <a href="'.admin_url('admin.php?page=mbu_brainstorms&mbu_page=active_brainstorms').'">existing projects</a>.', true);
       exit();
    }
?>

<p class="mbu-help">View <a href="javascript: mbu.showPageHelp('new_brainstorm');">this video</a> to get an idea of what kind of requests you can create here</p>

<form novalidate="novalidate" method="post">
<input id="mbu-brainstorm-id" type="hidden" value="<?php echo $brainstorm['id']; ?>" name="mbu-brainstorm-id"></input>
<input id="mbu-brainstorm-status" type="hidden" value="<?php echo $brainstorm['status']; ?>" name="mbu-brainstorm-status"></input>

<table class="form-table">
<tbody>
<tr>
<th scope="row">
<label for="blogname">Project Title</label>
</th>
<td>
    <input id="mbu-project-name" class="regular-text" type="text" value="<?php echo sanitize_text_field($brainstorm['title']); ?>" name="mbu-project-name"  autocomplete="off"></input>
</td>
</tr>

<tr>
<th scope="row">
<label for="blogname">Description</label>
</th>
<td>
    <textarea id="mbu-txt" class="large-text code" rows="4" name="mbu-txt" autocomplete="off"><?php echo sanitize_text_field($brainstorm['txt']); ?></textarea>
</td>
</tr>

<tr>
<th scope="row">
<label for="mbu-project-cat">Category</label>
</th>
<td>
    <select id="mbu-project-cat" class="regular-text" name="mbu-project-cat" autocomplete="off">
        <?php
        foreach($categories as $cat)
        {
            echo '<option value="'.$cat['id'].'" '.(($cat['id'] == $brainstorm['id_category']) ? ' selected="selected" ' : '').'>'.$cat['category'].'</option>';
        }
        ?>
    </select>
</td>
</tr>

<tr>
<th scope="row">
<label for="mbu-project-tags">Tags</label>
</th>
<td>
    <input id="mbu-project-tags" class="regular-text" type="text" value="<?php echo sanitize_text_field($brainstorm['tags']); ?>" name="mbu-project-tags" autocomplete="off"></input>
    <p class="description">Comma separated.</p>
</td>
</tr>


<tr class="option-site-visibility">
<th scope="row">Public project </th>
<td>
<fieldset>
<label for="mbu-public-project">
<input id="mbu-public-project" type="checkbox" value="0" name="mbu-public-project" <?php if($brainstorm['public'] == 1) echo ' checked="checked" '; ?> autocomplete="off"></input>
Non-logged-in users will be able to see your request and the associated site but will need to login to contribute
</label>
</fieldset>
</td>
</tr>

<?php
    if($user_info['user']['g_ispro'] == 1)
    {
?>
<tr class="option-site-visibility">
<th scope="row">Premium project </th>
<td>
<fieldset>
<label for="mbu-pro-project">
<input id="mbu-pro-project" type="checkbox" value="0" name="mbu-pro-project" <?php if($brainstorm['pro'] == 1) echo ' checked="checked" '; ?> autocomplete="off"></input>
You can create one promotional request per time. To open a new one, please archive your existing one
</label>
</fieldset>
</td>
</tr>
<?php
    }
?>

</tbody>
</table>
</form>

<p class="submit">
<button id="mbu-submit" class="button button-primary mbu-dlg-button" onclick="mbu.saveBrainstorm()" name="submit">Save Project</button>
<?php
    if($brainstorm['id'] > 0)
    {
        if($brainstorm['status'] == 1)
        {
            echo '<button id="mbu-close" class="button mbu-dlg-button" onclick="mbu.closeBrainstorm('.$brainstorm['id'].')" name="submit">Close Project</button>';
        }
        if($brainstorm['status'] == 0)
        {
            echo '<button id="mbu-delete" class="button mbu-dlg-button" onclick="mbu.deleteBrainstorm('.$brainstorm['id'].')" name="submit">Delete Project</button>';
        }        
    }
?>
</p>

</div>

<?php
echo mbuRunTpl('dlg/approve_idea');
echo mbuRunTpl('dlg/reject_idea');
?>