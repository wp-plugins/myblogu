<?php
$blog_url = get_bloginfo('url', 'raw');

?>

<div class="mbu-dlg" id="mbu-approve-idea-dlg" style="width: 500px; z-index: 9999;">
<div class="mbu-dlg-title"><span onclick="mbu.closeDlg('mbu-approve-idea-dlg')" class="close-btn">x</span><p>Approve Idea</p></div>
<div class="mbu-dlg-body">

<input type="hidden" id="mbu-id-idea" name="mbu-id-idea" value="0"></input>

<div class="mbu-option">
	<label for="mbu-username">Comment</label>
	<textarea id="mbu-idea-comment" class="mbu-medium"></textarea>
</div>

<div class="mbu-option">
	<label for="mbu-username">Article Link</label>
	<input type="url" id="mbu-idea-link" class="mbu-idea-link" value=""></input>
</div>

<p class="dlg-buttons">
	<button onclick="mbu.onApproveIdea();" id="mbu-ok-button" class="mbu-dlg-button">OK</button>
	<button  onclick="mbu.closeDlg('mbu-approve-idea-dlg')" class="mbu-dlg-button">Cancel</button></p>
</div>

</div>
