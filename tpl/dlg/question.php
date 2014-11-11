<div class="mbu-dlg" id="mbu-question-dlg" style="width: 500px;">
<div class="mbu-dlg-title"><span onclick="mbu.closeDlg('mbu-question-dlg')" class="close-btn">x</span><p>Question</p></div>
<div class="mbu-dlg-body">

<input type="hidden" id="mbu-id-question" name="mbu-id-question" value="0"></input>

<div class="mbu-option">
	<label for="mbu-question">Question</label>
	<textarea id="mbu-question" class="mbu-medium"></textarea>
</div>

<div class="mbu-option">
	<label for="mbu-min-words">Min Answer Words</label>
	<input type="number" id="mbu-min-words" class="mbu-medium" value="50"></input>
</div>

<p class="dlg-buttons">
	<button onclick="mbu.onSaveQuestion();" id="mbu-ok-button" class="mbu-dlg-button">OK</button>
	<button  onclick="mbu.closeDlg('mbu-question-dlg')" class="mbu-dlg-button">Cancel</button></p>
</div>

</div>
