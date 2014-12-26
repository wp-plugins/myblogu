<div class="mbu-dlg" id="mbu-todo-dlg" style="width: 500px;">
<div class="mbu-dlg-title"><span onclick="mbu.closeDlg('mbu-todo-dlg')" class="close-btn">x</span><p>Add TODO</p></div>
<div class="mbu-dlg-body">

<input type="hidden" id="mbu-id-idea" name="mbu-id-idea" value="0"></input>

<div class="mbu-option">
	<label for="mbu-deadline">Remind Date</label>
	<input type="text" id="mbu-remind-date" class="mbu-medium" value=""></input>
</div>

<div class="mbu-option">
	<label for="mbu-username">Comment</label>
	<textarea id="mbu-todo-comment" class="mbu-medium"></textarea>
</div>

<p class="dlg-buttons">
	<button onclick="mbu.saveBrainstormTODO();" id="mbu-ok-button" class="mbu-dlg-button">OK</button>
	<button  onclick="mbu.closeDlg('mbu-todo-dlg')" class="mbu-dlg-button">Cancel</button></p>
</div>

</div>

<script type="text/javascript">

    jQuery(document).ready(function(){

         jQuery('#mbu-todo-dlg #mbu-remind-date').datepicker({
				dateFormat : 'yy-mm-dd',
				beforeShowDay : function(date){
					var d = new Date();
					return [(date > d)];
				    }
				});

    });

</script>
