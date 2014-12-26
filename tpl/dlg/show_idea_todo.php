<div class="mbu-dlg" id="mbu-show-todo-idea-dlg" style="width: 500px; z-index: 8888;">

<?php
    if(!empty($todo))
    {
?>
<div class="mbu-dlg-title"><span onclick="mbu.closeDlg('mbu-show-todo-idea-dlg')" class="close-btn">x</span><p>Todo Item</p></div>
<div class="mbu-dlg-body">

<?php
        if($todo_item['status']==0)
        {
?>
<div class="mbu-option">
	<label>Remind Date:</label>
	<span style="color: red;"><?php echo $todo['remind']; ?></span>
</div>

<?php
        }
        else
        {
?>
<div class="mbu-option">
	<label>Remind sent:</label>
	<span style="color: red;"><?php echo $todo['sent']; ?></span>
</div>
<?php
        }
?>

    <div class="mbu-scrollbox">
	<?php echo sanitize_text_field($todo['txt']); ?>
    </div>


<p class="dlg-buttons">
    <button  onclick="mbu.closeDlg('mbu-show-todo-idea-dlg')" class="mbu-dlg-button">Close</button>
</p>
</div>
<?php
    }
?>

</div>
