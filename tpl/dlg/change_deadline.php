<div class="mbu-dlg" id="mbu-deadline-dlg" style="width: 500px;">
<div class="mbu-dlg-title"><span onclick="mbu.closeDlg('mbu-deadline-dlg')" class="close-btn">x</span><p>Change Interview Deadline</p></div>
<div class="mbu-dlg-body">

<input type="hidden" id="mbu-id-interview" name="mbu-id-interview" value="0"></input>

<div class="mbu-option">
	<label for="mbu-deadline">Deadline</label>
	<input type="text" id="mbu-deadline" class="mbu-medium" value=""></input>
</div>

<p class="dlg-buttons">
	<button onclick="mbu.onChangeInterviewDeadline();" id="mbu-ok-button" class="mbu-dlg-button">OK</button>
	<button  onclick="mbu.closeDlg('mbu-deadline-dlg')" class="mbu-dlg-button">Cancel</button></p>
</div>

</div>

<script type="text/javascript">

    jQuery(document).ready(function(){
         jQuery('#mbu-deadline-dlg #mbu-deadline').datepicker({dateFormat:'yy-mm-dd'});
    });
</script>
