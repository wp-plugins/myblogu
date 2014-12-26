<div class="wrap">
<?php
    echo mbuRunTpl('chunks/requests/top_menu', array('active_page' => 'ideas'));

    echo '<h2>Ideas Database</h2>';
?>

<form novalidate="novalidate" method="get" action="">
<input type="hidden" value="mbu_brainstorms" name="page"></input>
<input type="hidden" value="ideas" name="mbu_page"></input>

<table class="form-table">
<tbody>

<tr>
<th scope="row">
<label for="mbu-project-cat">Category</label>
</th>
<td>
<?php
echo '<select id="mbu-project-cat" class="regular-text" autocomplete="off" name="id_category" style="width: 450px;">';
    foreach($categories as $category)
    {
        echo '<option value="'.$category['id'].'" '.(($category['id'] == $id_category) ? ' selected="selected"' : '').'>'.$category['category'].'</option>';
    }
echo '</select>';
?>
</td>
</tr>

<tr>
<th scope="row">
<label for="mbu-project-id">Project</label>
</th>
<td>
<?php
echo '<select id="mbu-project-id" class="regular-text" autocomplete="off" name="id_request" style="width: 450px;">';
    foreach($requests as $req)
    {
        echo '<option value="'.$req['id'].'" '.(($req['id'] == $id_request) ? ' selected="selected"' : '').'>'.$req['title'].'</option>';
    }
echo '</select>';
?>
</td>
</tr>

<tr>
<th scope="row">
<label for="mbu-txt">Text</label>
</th>
<td>
    <input id="txt" class="regular-text" type="text" name="txt" value="<?php echo sanitize_text_field($txt); ?>" name="mbu-txt" autocomplete="off" style="width: 450px;"></input>
</td>
</tr>



</tbody>
</table>

<p class="submit">
<button id="mbu-submit" class="button button-primary" name="submit">Search</button>
</p>

</form>

<?php 
    if(!empty($ideas))
    {
        echo mbuRunTpl('chunks/requests/ideas_table', array('ideas' => $ideas));
    }
    else
    {
        echo mbuShowMessage('Ideas Not Found!');
    }
?>
</div>

<?php
echo mbuRunTpl('dlg/approve_idea');
echo mbuRunTpl('dlg/reject_idea');
echo mbuRunTpl('dlg/idea');
echo mbuRunTpl('dlg/todo_item');
echo mbuRunTpl('dlg/show_idea_todo');
echo mbuRunTpl('dlg/enter_idea_url');
?>