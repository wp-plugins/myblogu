<div class="wrap">
<?php
    echo mbuRunTpl('chunks/interviews/top_menu', array('active_page' => $mbu_page));

    if(empty($interview['id']))
    {
        echo '<h2>New Interview Project</h2>';
    }
    else
    {
        echo '<h2>Edit Interview Project  (<span class="mbu-interview-status mbu-interview-status-'.$interview['status'].'">'.$interview['status_name'].'</span>)</h2>';
    }

    if(!empty($interview['id']) && $interview['status'] == 0)
    {
       mbuShowMessage('The request is saved as a draft. Please add questions and click "Publish" to send to MyBlogU', true);
    }
?>

<form novalidate="novalidate" method="post">

<input type="hidden" id="mbu-id-interview" name="mbu-id-interview" value="<?php echo $interview['id']; ?>" autocomplete="off"></input>
<table class="form-table">
<tbody>
<tr>
<th scope="row">
<label for="blogname">Project Title</label>
</th>
<td>
    <input id="mbu-project-name" class="regular-text" type="text" value="<?php echo sanitize_text_field($interview['title']); ?>" name="mbu-project-name"  autocomplete="off"></input>
</td>
</tr>

<tr>
<th scope="row">
<label for="blogname">Project Deadline</label>
</th>
<td>
    <input id="mbu-project-deadline" class="regular-text" type="text" value="<?php echo sanitize_text_field($interview['deadline']); ?>" name="mbu-project-deadline" autocomplete="off"></input>
</td>
</tr>


<tr>
<th scope="row">
<label for="blogname">Description</label>
</th>
<td>
    <textarea id="mbu-comment" class="large-text code" rows="4" name="mbu-comment" autocomplete="off"><?php echo sanitize_text_field($interview['comment']); ?></textarea>
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
            echo '<option value="'.$cat['id'].'" '.(($cat['id'] == $interview['id_category']) ? ' selected="selected" ' : '').'>'.$cat['category'].'</option>';
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
    <input id="mbu-project-tags" class="regular-text" type="text" value="<?php echo sanitize_text_field($interview['tags']); ?>" name="mbu-project-tags" autocomplete="off"></input>
    <p class="description">Comma separated.</p>
</td>
</tr>


<tr class="option-site-visibility">
<th scope="row">Public project </th>
<td>
<fieldset>
<label for="blog_public">
<input id="mbu-public-project" type="checkbox" value="0" name="mbu-public-project" <?php if($interview['public'] == 1) echo ' checked="checked" '; ?> autocomplete="off"></input>
Non-logged-in users will be able to see your request and the associated site but will need to login to contribute
</label>
</fieldset>
</td>
</tr>

</tbody>
</table>
</form>



<!-- <h3>Questions</h3> -->
<a name="questions">&nbsp;</a>

<p class="submit">
<button id="mbu-add-question" class="button button-primary mbu-dlg-button" onclick="mbu.addInterviewQuestion()" name="submit">Add Question</button>
</p>

<?php
    if(!empty($interview['questions']))
    {
	echo '<table class="mbu-table mbu-questions-table">';
        foreach($interview['questions'] as $question)
        {
           echo '<tr id="mbu-question-'.$question['id'].'">';
	   echo '<td style="width: 10%;">';
	   echo '<button class="mbu-close" title="Delete Question" onclick="mbu.delQuestion('.$question['id'].');" type="button" aria-hidden="true">×</button>';
	   echo '</td>';
	   echo '<td>';
	   echo '<p class="mbu-question-body">'.sanitize_text_field($question['question']).'</p>';
	   echo '<div class="row-actions mbu-actions" style="margin-top: 15px;"><span><a href="javascript:mbu.editQuestion('.$question['id'].')" title="Edit">Edit</a></span></div>';
	   echo '</td>';
	   echo '<td style="width: 10%;"><p class="mbu-question-min-words">'.$question['min_answer_words'].'</p></td>';
           echo '</tr>';
        }
	echo '</table>';
    }
    else
    {
	echo '<div class="updated fade"><p>Add at least one question (or more) before publishing the interview request</p></div>';
    }
?>





<p class="submit">
<button id="mbu-submit" class="button button-primary mbu-dlg-button" onclick="mbu.saveInterview(true)" name="submit">Save Project</button>
<?php
    if($interview['id'] > 0 && $interview['status'] == 0)
    {
        echo '<button id="mbu-submit-publish" class="button button-primary mbu-dlg-button" onclick="mbu.publishInterview('.$interview['id'].')" name="submit">Publish Project</button>';
    }
    if($interview['id'] > 0 && $interview['status'] == 1)
    {
        echo '<a id="mbu-submit-publish" target="_blank" href="'.MBU_BASE_URL.'/interview?id_interview='.$interview['id'].'" class="button button-primary mbu-dlg-button" name="submit">Partially Publications</a>';
    }
?>
</p>

<script type="text/javascript">

    jQuery(document).ready(function(){
         jQuery('#mbu-project-deadline').datepicker({
				dateFormat : 'yy-mm-dd',
				beforeShowDay : function(date){
					var d = new Date();
					return [(date > d)];
				    }
				});
    });
</script>
</div>

<?php
echo mbuRunTpl('dlg/question');
?>