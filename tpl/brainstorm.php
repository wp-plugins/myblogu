<div class="wrap">
<?php
    echo mbuRunTpl('chunks/requests/top_menu', array());

    echo '<h2>'.sanitize_text_field($brainstorm['title']).'</h2>';
?>

<form novalidate="novalidate" method="post">
<input id="mbu-brainstorm-id" type="hidden" value="<?php echo $brainstorm['id']; ?>" name="mbu-brainstorm-id"></input>
<input id="mbu-brainstorm-status" type="hidden" value="<?php echo $brainstorm['status']; ?>" name="mbu-brainstorm-status"></input>

<table class="form-table">
<tbody>

<tr>
<th scope="row">
<label for="blogname">Description</label>
</th>
<td>
    <textarea disabled="disabled" id="mbu-txt" class="large-text code" rows="4" name="mbu-txt" autocomplete="off"><?php echo sanitize_text_field($brainstorm['txt']); ?></textarea>
</td>
</tr>

<!--

<tr>
<th scope="row">
<label for="mbu-project-cat">Category</label>
</th>
<td>
    <strong><?php echo $brainstorm['category']; ?></strong>
</td>
</tr>

<tr>
<th scope="row">
<label for="mbu-project-tags">Tags</label>
</th>
<td>
    <input id="mbu-project-tags" disabled="disabled" class="regular-text" type="text" value="<?php echo sanitize_text_field($brainstorm['tags']); ?>" name="mbu-project-tags" autocomplete="off"></input>
</td>
</tr>


<tr class="option-site-visibility">
<th scope="row">Public project </th>
<td>
<fieldset>
<label for="blog_public">
<input disabled="disabled" id="mbu-public-project" type="checkbox" value="0" name="mbu-public-project" <?php if($brainstorm['public'] == 1) echo ' checked="checked" '; ?> autocomplete="off"></input>
Non-logged-in users will be able to see your request and the associated site but will need to login to contribute
</label>
</fieldset>
</td>
</tr>

-->

</tbody>
</table>
</form>


<div class="mbu-menu">
   <a href="<?php echo admin_url('admin.php?page=mbu_brainstorms&mbu_page=brainstorm&id_request='.$brainstorm['id'].'&new_ideas=1#mbu-ideas'); ?>" class="mbu-btn <?php echo (($new_ideas == 1) ? 'mbu-blue-btn' : 'mbu-orange-btn'); ?>">New Ideas</a>
   <a href="<?php echo admin_url('admin.php?page=mbu_brainstorms&mbu_page=brainstorm&id_request='.$brainstorm['id'].'&new_ideas=0#mbu-ideas'); ?>" class="mbu-btn <?php echo (($new_ideas == 0) ? 'mbu-blue-btn' : 'mbu-orange-btn'); ?>">All Ideas</a>
</div>

<?php 
    if(!empty($brainstorm['ideas']))
    {
        echo mbuRunTpl('chunks/requests/ideas_table', array('ideas' => $brainstorm['ideas']));
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