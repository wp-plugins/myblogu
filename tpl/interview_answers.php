<div class="wrap">
<?php
    echo mbuRunTpl('chunks/interviews/top_menu', array('active_page' => $mbu_page));

    echo '<h2>'.$interview['title'].'  (<span class="mbu-interview-status mbu-interview-status-'.$interview['status'].'">'.$interview['status_name'].'</span>)</h2>';
?>

<form novalidate="novalidate" method="post">
<input type="hidden" id="mbu-id-interview" name="mbu-id-interview" value="<?php echo $interview['id']; ?>" autocomplete="off"></input>
</form>

<p>
<?php echo sanitize_text_field($interview['comment']); ?>
</p>

<p class="submit">
<a name="actions">&nbsp;</a>

<?php
    if($interview['status'] == 1)
    {
        echo '<button class="button button-primary mbu-dlg-button" onclick="mbu.closeInterview('.$interview['id'].')">Close Project</button>';
    }

    if($interview['status'] == 2 || $interview['status'] == 3)
    {
        echo '<button class="button button-primary mbu-dlg-button" onclick="mbu.interviewPreviewCode('.$interview['id'].')">Preview</button>';
    }
?>
</p>

<h3>Questions</h3>
<a name="questions">&nbsp;</a>

<?php
    if(!empty($questions))
    {
	echo '<table class="mbu-table mbu-questions-answers-table">';
        foreach($questions as $question)
        {
           echo '<tr id="mbu-question-'.$question['id'].'">';
	   echo '<td style="width: 35%;">';
	   echo '<p class="mbu-question-body">'.sanitize_text_field($question['question']).'</p>';
	   echo '</td>';
	   echo '<td>';
	   foreach($question['answers'] as $answer)
	   {
	       echo '<div class="mbu-question-answer" id="mbu-question-answer-'.$answer['id'].'">';
	       if($interview['status'] == 1)
               {
                   echo '<input type="checkbox" class="mbu-answer-select-checkbox" class="mbu-answer-select-checkbox" data-id-answer="'.$answer['id'].'" id="mbu-answer-select-checkbox-'.$answer['id'].'" '.(($answer['status'] == 1) ? 'checked="checked"': '').'></input>';
               }
	       echo '<img src="'.$answer['interviewee']['headshot_url'].'" style="height: 30px; width: auto;" />';
	       echo '<a class="mbu-answer-author" href="'.$answer['interviewee']['author_url'].'" target="_blank">'.$answer['interviewee']['author_name'].'</a> <i>('.$answer['interviewee']['author_title'].')</i>';

	       echo '<div class="mbu-answer-text">'.$answer['answer'].'</div>';
	       echo '</div>';
	   }
	   echo '</td>';
           echo '</tr>';
        }
	echo '</table>';
    }
?>

<script type="text/javascript">

    jQuery(document).ready(function(){
         jQuery('#mbu-project-deadline').datepicker({dateFormat:'yy-mm-dd'});
    });
</script>
</div>

<?php
echo mbuRunTpl('dlg/question');
echo mbuRunTpl('dlg/interview_code_options');
echo mbuRunTpl('dlg/interview_preview');
?>
