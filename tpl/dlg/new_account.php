<?php

$blog_title = mbuGetBlogTitle();
$blog_url = get_bloginfo('url', 'raw');

if(empty($blog_title))
{
    $blog_title = $blog_url;
}

?>

<div class="mbu-dlg" id="mbu-new-account-dlg" style="width: 500px;">
<div class="mbu-dlg-title"><span onclick="mbu.closeDlg('mbu-new-account-dlg')" class="close-btn">x</span><p>New Account</p></div>
<div class="mbu-dlg-body">

<div class="mbu-option">
	<label for="mbu-username">Username</label>
	<input type="text" id="mbu-username" class="mbu-medium"></input>
</div>

<div class="mbu-option">
	<label for="mbu-username">Email</label>
	<input type="email" id="mbu-email" class="mbu-medium"></input>
</div>

<div class="mbu-option">
	<label for="mbu-username">Password</label>
	<input type="password" id="mbu-password" class="mbu-medium"></input>
</div>

<div class="mbu-option">
	<label for="mbu-username">Password Again</label>
	<input type="password" id="mbu-password-1" class="mbu-medium"></input>
</div>

<div class="mbu-option">
	<label for="mbu-username">Blog Tags</label>
	<input type="text" id="mbu-blog-tags" class="mbu-medium" value="<?php echo $tags; ?>"></input>
</div>

<div class="mbu-option">
	<label for="mbu-username">Blog URL</label>
	<input type="url" disabled="disabled" id="mbu-blog-url" class="mbu-medium" value="<?php echo $blog_url; ?>"></input>
</div>

<div class="mbu-option">
	<label for="mbu-username">Blog Name</label>
	<input type="text" disabled="disabled" id="mbu-blog-name" class="mbu-medium" value="<?php echo $blog_title; ?>"></input>
</div>

<?php

    if(is_array($categories))
    {
        echo '<div class="mbu-option">';
        echo '	<label for="mbu-id-category">Blog Category</label>';
        echo '	<select id="mbu-id-category" class="mbu-medium" autocomplete="off">';
        foreach ($categories as $cat)
        {
            echo '<option value="'.$cat['id'].'" '.(($cat['id'] == 6) ? 'selected="selected"' : '').'>'.$cat['short_name'].'</option>';
        }
        echo '  </select>';
        echo '</div>';
    }
?>

<div class="mbu-option">
	<label for="mbu-subscrube">Subscribe to this category</label>
	<input type="checkbox" id="mbu-subscribe" autocomplete="off"></input>
</div>

<p class="dlg-buttons">
	<button onclick="mbu.onNewAccount();" id="mbu-ok-button" class="mbu-dlg-button">OK</button>
	<button  onclick="mbu.closeDlg('mbu-new-account-dlg')" class="mbu-dlg-button">Cancel</button></p>
</div>

</div>
