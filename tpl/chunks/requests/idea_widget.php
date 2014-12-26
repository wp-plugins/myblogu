<form id="quick-press" class="initial-form hide-if-no-js">

    <div class="input-text-wrap mbu-input-wrap">
    <select id="mbu-project" autocomplete="off" name="mbu-project">
<?php
	foreach($requests as $req)
	{
	    echo '<option value="'.$req['id'].'">'.$req['title'].'</option>';
	}
?>
    </select>
    </div>

    <div class="input-text-wrap mbu-input-wrap">
    <input id="mbu-idea-title" placeholder="Title" type="text" autocomplete="off" name="mbu-idea-title"></input>
    </div>

    <div class="textarea-wrap mbu-input-wrap">
    <textarea id="mbu-idea-text" placeholder="Idea Text" class="mceEditor" autocomplete="off" cols="15" rows="3" name="content"></textarea>
    </div>

    <p class="submit">
    <input id="mbu-send-idea-button" class="button button-primary" type="button" onclick="mbu.widgetSaveIdea()" value="Send Idea">
    <br class="clear">
    </p>
</form>