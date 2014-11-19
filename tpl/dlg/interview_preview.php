<div class="mbu-dlg" id="mbu-interview-preview-dlg" style="width: 600px;">
<div class="mbu-dlg-title"><span onclick="mbu.closeDlg('mbu-interview-preview-dlg')" class="close-btn">x</span><p>Interview Preview</p></div>
<div class="mbu-dlg-body">

<input type="hidden" id="mbu-id-interview" name="mbu-id-interview" value="<?php echo $interview['id'] ?>"></input>

<h4 id="mbu-interview-title"><?php echo $interview['title'] ?></h4>

<div class="mbu-scrollbox" id="mbu-interview-text"><?php echo $interview['code'] ?></div>

<p class="dlg-buttons">
    <button  onclick="mbu.closeDlg('mbu-interview-preview-dlg')" class="mbu-dlg-button">Close</button>
<?php
    if(empty($interview['post_id']))
    {
	echo '<button  onclick="mbu.onInterviewCreatePost()" class="mbu-dlg-button mbu-blue-btn">Create Draft</button>';
    }
?>
</p>
</div>

</div>
