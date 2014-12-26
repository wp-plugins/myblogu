<?php

    if(empty($idea))
    {
        $idea = array(
		'id' => 0, 
		'url' => get_bloginfo('url', 'raw'),
		'author_comment' => '', 
		);
    }
?>

<div class="mbu-dlg" id="mbu-idea-url-dlg" style="width: 500px; z-index: 9999;">
<div class="mbu-dlg-title"><span onclick="mbu.closeDlg('mbu-idea-url-dlg')" class="close-btn">x</span><p>Enter Idea Link</p></div>
<div class="mbu-dlg-body">

<input type="hidden" id="mbu-id-idea" name="mbu-id-idea" value="<?php echo $idea['id'] ?>"></input>

<div class="mbu-option">
	<label for="mbu-username">Title</label>
	<input id="mbu-idea-title" disabled="disabled" class="mbu-medium" type="text" value="<?php echo sanitize_text_field($idea['title']) ?>"></input>
</div>

<div class="mbu-option">
	<label for="mbu-username">Article Link</label>
	<input type="url" id="mbu-idea-link" class="mbu-medium" value="<?php echo $idea['link'] ?>"></input>
</div>

<p class="dlg-buttons">
	<button onclick="mbu.onSaveIdeaURL();" id="mbu-ok-button" class="mbu-dlg-button">OK</button>
	<button  onclick="mbu.closeDlg('mbu-idea-url-dlg')" class="mbu-dlg-button">Cancel</button></p>
</div>

</div>
