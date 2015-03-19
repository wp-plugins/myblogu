var mbu = {

    tags : '',
            
init : function(){
    jQuery('.mbu-answer-select-checkbox').on('click', function(){
        var p = {
            'id_answer' : jQuery(this).attr('data-id-answer'),
            'select' : jQuery('#'+this.id+':checked').length,
            'action' : 'select_answer',
        };

    mbu.api_proxy('interview', p, function(ret){
                                
                             });        
    });
    
    jQuery('.mbu-checkbox-pm').on('click', function(){
        if(jQuery('.mbu-checkbox-pm:checked').length > 0)
        {
            jQuery('.mbu-group-actions').fadeIn(500);
        }
        else
        {
            jQuery('.mbu-group-actions').fadeOut(500);
        }
    });
    
    jQuery.fn.prettyPhoto();
    
},

showMessage : function(pmsg)
{
mbu.clearWaitButtons();
mbu.closeMessage();

	if(pmsg != '')
	{
	var wnd = jQuery('<div class="mbu-popup rounded" style="z-index: 99999999;"><span onclick="mbu.closeMessage()" class="close-btn">x</span><p>'+pmsg+'</p></div>');
	
	width = 500;
	//var top = jQuery(window).scrollTop()+100;
	var top = 100;
	var container = jQuery('body');
			
	var left = jQuery(window).width() / 2 - width / 2;
	
	wnd.css('top', top + 'px');
	wnd.css('left', left + 'px');
//	wnd.corner("5px");

	container.prepend(wnd);
	//wnd.css('position', 'absolute');
	wnd.css('position', 'fixed');
	wnd.fadeIn(1000);
	}
},

closeMessage : function()
{
jQuery('.mbu-popup').fadeOut(1000);
},

inputDlg : function(title, onok, cont)
{
mbu.clearWaitButtons();
cont = cont || '';

var code = '<div class="mbu-dlg" id="mbu-input-dlg" data-mbu-inserted-dlg="1">';
code += '<div class="mbu-dlg-title"><span onclick="mbu.closeDlg(\'mbu-input-dlg\')" class="close-btn">x</span><p>'+title+'</p></div>';
code += '<div class="mbu-dlg-body">';
code += '<textarea id="mbu-dlg-input-txt">'+cont+'</textarea>';
code += '<p class="dlg-buttons"><input id="mbu-dlg-ok" type="button" value="OK" /><input type="button" onclick="mbu.closeDlg();" value="Cancel" /></p>';
code += '</div>';
code += '</div>';

var wnd = jQuery(code);
	
width = 500;
var top = 100;

var container = jQuery('body');
			
var left = jQuery(window).width() / 2 - width / 2;
	
wnd.css('top', top + 'px');
wnd.css('left', left + 'px');
//	wnd.corner("5px");

container.prepend(wnd);
//wnd.css('position', 'absolute');
wnd.css('position', 'fixed');
wnd.fadeIn(1000);

	if(typeof(onok) == 'function')
	{
	jQuery('.mbu-dlg #mbu-dlg-ok').click(
					function(){
					onok();
					mbu.closeDlg();				    
					});
	}
},

confirmDlg : function(title, onok, cont)
{
mbu.clearWaitButtons();
cont = cont || '';

var code = '<div class="mbu-dlg" id="mbu-confirm-dlg" style="z-index: 999999;" data-mbu-inserted-dlg="1">';
code += '<div class="mbu-dlg-title"><span onclick="mbu.closeDlg(\'mbu-confirm-dlg\')" class="close-btn">x</span><p>'+title+'</p></div>';
code += '<div class="mbu-dlg-body">';
code += '<div class="mbu-dlg-msg">'+cont+'</div>';
code += '<p class="dlg-buttons"><button id="mbu-dlg-ok">OK</button><button onclick="mbu.closeDlg(\'mbu-confirm-dlg\');">Cancel</button></p>';
code += '</div>';
code += '</div>';

var wnd = jQuery(code);
	
width = 500;
var top = 100;

var container = jQuery('body');
			
var left = jQuery(window).width() / 2 - width / 2;
	
wnd.css('top', top + 'px');
wnd.css('left', left + 'px');
//	wnd.corner("5px");

container.prepend(wnd);
//wnd.css('position', 'absolute');
wnd.css('position', 'fixed');
wnd.fadeIn(1000);

	if(typeof(onok) == 'function')
	{
	jQuery('.mbu-dlg #mbu-dlg-ok').click(
					function(){
					onok();
					mbu.closeDlg();				    
					});
	}
},

loginDlg : function(onok, username)
{
mbu.clearWaitButtons();

var code = '<div class="mbu-dlg" id="mbu-login-dlg" data-mbu-inserted-dlg="1">';
code += '<div class="mbu-dlg-title"><span onclick="mbu.closeDlg(\'mbu-login-dlg\')" class="close-btn">x</span><p>Login to MBU</p></div>';
code += '<div class="mbu-dlg-body">';

code += '<div class="mbu-option">';
code += '	<label for="mbu-username">Username</label>';

if(typeof(username) == 'string' && username != '')
    code += '	<input disabled="disabled" type="text" id="mbu-username" class="mbu-medium" value="'+username+'"></input>';
else
    code += '	<input type="text" id="mbu-username" class="mbu-medium"></input>';    
    
code += '</div>';

code += '<div class="mbu-option">';
code += '	<label for="mbu-username">Password</label>';
code += '	<input type="password" id="mbu-password" class="mbu-medium"></input>';
code += '</div>';

code += '<p class="dlg-buttons"><button id="mbu-dlg-ok" class="mbu-dlg-button" type="button">OK</button><button class="mbu-dlg-button" onclick="mbu.closeDlg(\'mbu-login-dlg\');" >Cancel</button></p>';
code += '</div>';
code += '</div>';

var wnd = jQuery(code);
	
width = 500;
var top = 100;

var container = jQuery('body');
			
var left = jQuery(window).width() / 2 - width / 2;
	
wnd.css('top', top + 'px');
wnd.css('left', left + 'px');
//	wnd.corner("5px");

container.prepend(wnd);
//wnd.css('position', 'absolute');
wnd.css('position', 'fixed');
wnd.fadeIn(1000);

	if(typeof(onok) == 'function')
	{
	jQuery('.mbu-dlg #mbu-dlg-ok').click(
					function(){
                                            mbu.setButtonWait(this);
                                            onok();
                                            mbu.closeDlg();				    
					});
	}
},

setButtonWait : function(btn)
{
    btn = jQuery(btn);
    btn.data('old_caption', btn.html()).attr('disabled', 'disabled').html('<img src="'+mbu_script_data.img_path+'/indicator.gif"></img>');
},

clearWaitButtons : function()
{
    jQuery('.mbu-dlg-button[disabled]').each(function(){
        jQuery(this).html(jQuery(this).data('old_caption')).removeAttr('disabled');
    });
},

dlg : function(id)
{
    mbu.clearWaitButtons();
    var wnd = jQuery('#'+id);	
    var top = 100;

    var left = jQuery(window).width() / 2 - wnd.width() / 2;
	
    if(top > 0) wnd.css('top', top + 'px');

    if(left > 0) wnd.css('left', left + 'px');
        //	wnd.corner("5px");

    wnd.fadeIn(1000);
},

newAccount : function()
{
    mbu.dlg('mbu-new-account-dlg');
},

onNewAccount : function()
{
    mbu.setButtonWait('#mbu-new-account-dlg #mbu-ok-button');
    var p = {};
    p.action = 'send_alert';
    var params = {
                    username : jQuery('#mbu-new-account-dlg #mbu-username').val(),
                    email : jQuery('#mbu-new-account-dlg #mbu-email').val(),
                    password  : jQuery('#mbu-new-account-dlg #mbu-password').val(),
                    password1 : jQuery('#mbu-new-account-dlg #mbu-password-1').val(),
                    blog_name : jQuery('#mbu-new-account-dlg #mbu-blog-name').val(),
                    blog_url  : jQuery('#mbu-new-account-dlg #mbu-blog-url').val(),
                    blog_tags  : jQuery('#mbu-new-account-dlg #mbu-blog-tags').val(),
                    id_category  : jQuery('#mbu-new-account-dlg #mbu-id-category').val(),
                    subscribe_category  : jQuery('#mbu-new-account-dlg #mbu-subscribe:checked').length,
                 };
         
    if(params['username'].replace(/(^\s+)|(\s+$)/g, "") == '')
    {
       mbu.showMessage("Username can't be empty!");
       return;
    }
    
    if(params['email'].replace(/(^\s+)|(\s+$)/g, "") == '')
    {
       mbu.showMessage("Email can't be empty!");
       return;
    }
    
    if(params['password'].replace(/(^\s+)|(\s+$)/g, "") == '')
    {
       mbu.showMessage("Password can't be empty!");
       return;
    }
    
    if(params['password1'].replace(/(^\s+)|(\s+$)/g, "") == '')
    {
       mbu.showMessage("Password can't be empty!");
       return;
    }
    
    if(params['password'] != params['password1'])
    {
       mbu.showMessage("Password not match!");
       return;
    }
    
    var url = mbu_script_data.mbu_url+'/api/useradd' +
		'?username=' + encodeURIComponent(params['username']) +
		'&email=' + encodeURIComponent(params['email']) +
		'&password=' + encodeURIComponent(params['password']) +
		'&blog_name=' + encodeURIComponent(params['blog_name'])+
		'&blog_url=' + encodeURIComponent(params['blog_url'])+
                '&blog_tags=' + encodeURIComponent(params['blog_tags'])+
                '&id_category=' + params['id_category']+
                '&subscribe_category='+params['subscribe_category']+
		'&callback=?';

    jQuery.getJSON(url, function(data){
        console.log(data);
        
        if(typeof(data.error) != 'undefined' && data.error.msg != '')
        {
            mbu.showMessage(data.error.msg);
        }
        else if(typeof(data.msg) != 'undefined' && data.msg != '')
        {
            mbu.showMessage(data.msg);
            mbu.closeDlg('mbu-new-account-dlg');
            setTimeout(function(){location.reload();}, 1000);
            
            mbu.ajax(mbu_script_data['ajaxurl'], 'action=mbuCreateTODO', function(){});
        }
    });
},

closeDlg : function(id)
{
    var wnd = jQuery('#'+id);
    wnd.fadeOut(1000);
    if(wnd.attr('data-mbu-inserted-dlg') == 1)
    {
        wnd.remove();
    }
},

eraseSettings : function()
{
    mbu.confirmDlg('Confirmation', function(){
        mbu.ajax(mbu_script_data['ajaxurl'], 'action=mbuEraseSettings', function(){location.reload()});
    },
    'Remove All Plugin Settings?')
},

updateToken : function(username){
    mbu.loginDlg(function(){
        var username = jQuery('#mbu-login-dlg #mbu-username').val();
        var password = jQuery('#mbu-login-dlg #mbu-password').val();
        
        if(username.replace(/(^\s+)|(\s+$)/g, "") == '')
        {
            mbu.showMessage("Username can't be empty!");
            return;
        }
    
        if(password.replace(/(^\s+)|(\s+$)/g, "") == '')
        {
            mbu.showMessage("Password can't be empty!");
            return;
        }

        var url = mbu_script_data.mbu_url+'/api/oauth' +
		'?username=' + username +
		'&password=' + password +
                '&action=authentication' +
                '&id_site=' + mbu_script_data.id_site + 
		'&callback=?';

        jQuery.getJSON(url, function(data){
        
            if(typeof(data.error) != 'undefined' && data.error.msg != '')
            {
                mbu.showMessage(data.error.msg);
            }
            else
            {
                                        // сохраняем код авторизации на серверной стороне

                mbu.ajax(mbu_script_data['ajaxurl'], 'action=mbuSaveAuthCode&auth_code=' + data.auth_code, 
                    function(){
                                        // теперь просим сгенерировать для нас токен
                                        
                            var url = mbu_script_data.mbu_url+'/api/oauth' +
                                '?action=get_token' +
                                '&auth_code=' + data.auth_code + 
                                '&callback=?';

                        jQuery.getJSON(url, function(data){
                            if(data.error)
                            {
                                mbu.showMessage(data.error.msg);
                            }
                            else
                            {
                                if(data.msg)
                                {
                                    mbu.showMessage(data.msg);
                                }
                                mbu.closeDlg('mbu-login-dlg');
                            }
                        });
                                        
                    });
            }
    });        
    }, username);
},

connectAccount : function(){
    mbu.loginDlg(function(){
        var username = jQuery('#mbu-login-dlg #mbu-username').val();
        var password = jQuery('#mbu-login-dlg #mbu-password').val();
        
        if(username.replace(/(^\s+)|(\s+$)/g, "") == '')
        {
            mbu.showMessage("Username can't be empty!");
            return;
        }
    
        if(password.replace(/(^\s+)|(\s+$)/g, "") == '')
        {
            mbu.showMessage("Password can't be empty!");
            return;
        }

        var url = mbu_script_data.mbu_url+'/api/oauth' +
		'?username=' + encodeURIComponent(username) +
		'&password=' + encodeURIComponent(password) +
                '&blog_name=' + encodeURIComponent(mbu_script_data.blog_title) +
                '&blog_url=' + encodeURIComponent(mbu_script_data.blog_url) +
                '&blog_tags=' + encodeURIComponent(mbu.tags) +
                '&action=connect_account' +
		'&callback=?';

        jQuery.getJSON(url, function(data){
        
            if(typeof(data.error) != 'undefined' && data.error.msg != '')
            {
                mbu.showMessage(data.error.msg);
            }
            else if(typeof(data.msg) != 'undefined' && data.msg != '')
            {
                mbu.showMessage(data.msg);
            //    mbu.closeDlg('mbu-new-account-dlg');
                setTimeout(function(){location.reload();}, 1000);
            }

        });        
    });
},

saveSettings : function()
{
    var id_category = jQuery('#mbu-id-category').val();
    var tags = jQuery('#mbu-tags').val();
    mbu.setButtonWait('#mbu-submit');
    mbu.ajax(mbu_script_data['ajaxurl'], 'action=mbuSaveSettings&tags='+encodeURIComponent(tags)+'&id_category='+id_category, 
        function(){});
    
},

ajax : function(url, data, success, method)
{
    method = method || "POST";
    //console.log(data);
	jQuery.ajax({
		type:  method,
		url:   url,
		cache: false,
		data:  data,
		success: function(ret){
                    if(typeof(ret) == 'string')
                    {
                        var param = eval('('+ret+')');
                    }
                    else
                    {
                        var param = ret;
                    }
                    if(typeof(param['msg']) != 'undefined' && param['msg'] != '')
                    {
                        mbu.showMessage(param['msg']);
                    }
			
                    if(typeof(param['err']) != 'undefined' && param['err'] != '')
                    {
                        mbu.showMessage(param['err']);
                    }
                    else
                    {
                        success(param);
                    }			
		},
		error: function (data, status, e)
		{
			mbu.showMessage(e);
		}
	});
},

api_proxy : function(api_method, params, success, method)
{
    method = method || "POST";
    console.log(params);
    var p = JSON.stringify(params);
    p = jQuery('<div />').text(p).html();
    mbu.ajax(mbu_script_data['ajaxurl'], 'api_method='+api_method+'&action=mbuApiProxy&params='+Base64.encode(p), success, method);
},

saveBrainstorm : function()
{   
    var f = function(){
            var p = {
            'id_request'    : jQuery('#mbu-brainstorm-id').val(),
            'title' : jQuery('#mbu-project-name').val(),
            'txt'   : jQuery('#mbu-txt').val(),
            'tags'   : jQuery('#mbu-project-tags').val(),
            'id_category' : jQuery('#mbu-project-cat').val(),
            'public' : jQuery('#mbu-public-project:checked').length,
            'pro' : jQuery('#mbu-pro-project:checked').length,
            'action' : 'save_request',
        };

        if(p.title.replace(/(^\s+)|(\s+$)/g, "") == '')
        {
            mbu.showMessage("Title can't be empty!");
            return;
        }
        if(p.txt.replace(/(^\s+)|(\s+$)/g, "") == '')
        {
            mbu.showMessage("Description can't be empty!");
            return;
        }

        mbu.setButtonWait(jQuery('#mbu-submit'));
        mbu.api_proxy('article-requests', p, function(ret){
                                            mbu.clearWaitButtons();
                                            mbu.closeDlg('mbu-confirm-dlg');
                                            setTimeout(function(){
                                                if(p['id_request'] > 0)
                                                {
                                                    location.reload();
                                                }
                                                else
                                                {
                                                    document.location = mbu_script_data.blog_admin_url+'/admin.php?page=mbu_brainstorms&mbu_page=active_brainstorms';
                                                }
                                            }, 1000);
                                        });
    };
    
    var status = jQuery('#mbu-brainstorm-status').val();
    if(status == 1)
    {
        mbu.confirmDlg('Saving', f, 'After saving, project will hide from public gallery, for moderation! Please confirm.');
    }
    else
    {
        f();
    }
},

deleteBrainstorm : function(id_request)
{
    mbu.confirmDlg('Please Confirm', function(){
        var p = {
            'id_request'    : id_request,
            'action' : 'delete_request',
        };

        mbu.setButtonWait(jQuery('#mbu-confirm-dlg #mbu-dlg-ok'));
        mbu.api_proxy('article-requests', p, function(ret){
                                            mbu.clearWaitButtons();
                                            setTimeout(function(){location.reload();}, 1000);
                                        });
        
    }, 'Delete this project?');
},

closeBrainstorm : function(id_request)
{
    mbu.confirmDlg('Please Confirm', function(){
        var p = {
            'id_request'    : id_request,
            'action' : 'close_request',
        };

        mbu.setButtonWait(jQuery('#mbu-confirm-dlg #mbu-dlg-ok'));
        mbu.api_proxy('article-requests', p, function(ret){
                                            mbu.clearWaitButtons();
                                            setTimeout(function(){location.reload();}, 1000);
                                        });
        
    }, 'Close this project?');
},

approveIdea : function(id_idea)
{
    jQuery('#mbu-approve-idea-dlg #mbu-id-idea').val(id_idea);
    jQuery('#mbu-approve-idea-dlg #mbu-idea-link').val('');
    jQuery('#mbu-approve-idea-dlg #mbu-idea-comment').val('');
    mbu.dlg('mbu-approve-idea-dlg');
},

onApproveIdea : function()
{
    var p = {
        'id_idea'    : jQuery('#mbu-approve-idea-dlg #mbu-id-idea').val(),
        'link' : jQuery('#mbu-approve-idea-dlg #mbu-idea-link').val(),
        'blogger_comment'   : jQuery('#mbu-approve-idea-dlg #mbu-idea-comment').val(),
        'action' : 'approve_idea',
    };

    mbu.setButtonWait(jQuery('#mbu-approve-idea-dlg #mbu-ok-button'));
    mbu.api_proxy('ideas', p, function(ret){
                                            mbu.clearWaitButtons();
                                                setTimeout(function(){
                                                        location.hash = '#mbu-idea-'+p['id_idea'];
                                                        location.reload();
                                                    }, 1000);
                                        });
    
},

rejectIdea : function(id_idea)
{
    jQuery('#mbu-reject-idea-dlg #mbu-id-idea').val(id_idea);
    jQuery('#mbu-reject-idea-dlg #mbu-idea-comment').val('');
    mbu.dlg('mbu-reject-idea-dlg');
},

onRejectIdea : function()
{
    var p = {
        'id_idea'    : jQuery('#mbu-reject-idea-dlg #mbu-id-idea').val(),
        'link' : jQuery('#mbu-reject-idea-dlg #mbu-idea-link').val(),
        'blogger_comment'   : jQuery('#mbu-reject-idea-dlg #mbu-idea-comment').val(),
        'action' : 'reject_idea',
    };

    mbu.setButtonWait(jQuery('#mbu-reject-idea-dlg #mbu-ok-button'));
    mbu.api_proxy('ideas', p, function(ret){
                                            mbu.clearWaitButtons();
                                                setTimeout(function(){
                                                        location.hash = '#mbu-idea-'+p['id_idea'];
                                                        location.reload();
                                                    }, 1000);
                                        });
    
},

showIdea : function(id_idea)
{
    mbu.ajax(mbu_script_data['ajaxurl'], 'action=mbuGetIdeaDlg&id_idea='+id_idea, function(ret){
        
        if(typeof(ret['html']) != 'undefined')
        {
            jQuery('#mbu-idea-dlg').replaceWith(ret['html']);
            mbu.dlg('mbu-idea-dlg');
        }
    });
},

mbuDownloadAtt : function(id_att, filename)
{
    jQuery.fileDownload(mbu_script_data['blog_url']+"?mbu_action=download_idea_att&download_filename="+filename+"&download_att="+id_att, {
        successCallback: function (url) {
            mbu.showMessage(url);
        },
        failCallback: function (html, url) {
 
            mbu.showMessage('Your file download just failed for this URL:' + url + '\r\n' +
                'Here was the resulting error HTML: \r\n' + html, 'danger'
                );
        }
    });
},

closeTODOItem : function(id_item)
{
    mbu.ajax(mbu_script_data['ajaxurl'], 'action=mbuDelTODOItem&id_item='+id_item, 
                function(){
                    jQuery('#mbu-todo-item-'+id_item).fadeOut(1000);
                });
},

readPm : function(id_pm)
{
    jQuery('#mbu-read-pm-dlg #mbu-id-pm').val(id_pm);
    jQuery('#mbu-read-pm-dlg #mbu-pm-title').text('');
    jQuery('#mbu-read-pm-dlg #mbu-pm-text').html('');
    jQuery('#mbu-read-pm-dlg .mbu-avatar').attr('src', mbu_script_data.img_path+'/indicator.gif');
    mbu.dlg('mbu-read-pm-dlg');
    
    var p = {
        'id_pm'    : id_pm,
        'action' : 'read_message',
    };

    mbu.api_proxy('pm', p, function(ret){
                                            jQuery('#mbu-read-pm-dlg #mbu-id-pm').val(ret.message['id']);
                                            jQuery('#mbu-read-pm-dlg #mbu-pm-title').text(ret.message['subject']);
                                            jQuery('#mbu-read-pm-dlg #mbu-pm-text').html(ret.message['body_parsed']);
                                            jQuery('#mbu-read-pm-dlg .mbu-avatar').attr('src', ret.message['sender_avatar']);
                                        });

},

delPm : function(id_pm)
{
    if(!id_pm)
    {
        id_pm = jQuery('#mbu-read-pm-dlg #mbu-id-pm').val();
    }

    mbu.confirmDlg('Please confirm', function(){
        var p = {
            'id_pm' : id_pm,
            'action' : 'del',
        };

        mbu.api_proxy('pm', p, function(ret){
                                mbu.closeDlg('mbu-read-pm-dlg');
                                mbu.closeDlg('mbu-confirm-dlg');
                                jQuery('#msg-'+id_pm).remove();
                             });
        
    }, 'Delete this message?');
},

markReadPm : function(id_pm)
{
    var p = {
        'id_pm' : id_pm,
        'action' : 'read_message',
    };

    mbu.api_proxy('pm', p, function(ret){
                                //jQuery('#msg-'+id_pm+' .mbu-pm-status').text('read');
                                jQuery('#msg-'+id_pm).remove();
                             });
        
},

delPmGrp : function()
{
    var sel_count = jQuery('.mbu-checkbox-pm:checked').length;
    if(sel_count > 0)
    {
        mbu.confirmDlg('Please confirm', function(){
            mbu.closeDlg('mbu-confirm-dlg');
            
            jQuery('.mbu-checkbox-pm:checked').each(function(){
                var id_pm = jQuery(this).attr('data-id-message');
                var p = {
                    'id_pm' : id_pm,
                    'action' : 'del',
                };

                mbu.api_proxy('pm', p, function(ret){
                                jQuery('#msg-'+id_pm).remove();
                             });
            });
        
        }, 'Delete '+sel_count+' messages?');
    }
},

markReadPmGrp : function()
{
    var sel_count = jQuery('.mbu-checkbox-pm:checked').length;
    if(sel_count > 0)
    {
        mbu.confirmDlg('Please confirm', function(){
            mbu.closeDlg('mbu-confirm-dlg');
            
            jQuery('.mbu-checkbox-pm:checked').each(function(){
                var id_pm = jQuery(this).attr('data-id-message');
                var p = {
                    'id_pm' : id_pm,
                    'action' : 'read_message',
                };

                mbu.api_proxy('pm', p, function(ret){
                                jQuery('#msg-'+id_pm).remove();
                             });
            });
        
        }, 'Process with '+sel_count+' messages?');        
    }
},

saveInterview : function(reload, callback)
{
    var p = {
        'id_interview' : jQuery('#mbu-id-interview').val(),
        'title' : jQuery('#mbu-project-name').val(),
        'deadline' : jQuery('#mbu-project-deadline').val(),
        'id_category' : jQuery('#mbu-project-cat').val(),
        'tags' : jQuery('#mbu-project-tags').val(),
        'comment' : jQuery('#mbu-comment').val(),
        'public' : jQuery('#mbu-public-project:checked').length,
        'action' : 'save_interview',
    };
    if(!p.title || p.title.replace(/(^\s+)|(\s+$)/g, "") == '')
    {
        mbu.showMessage("Title can't be empty!");
        return;
    }
    if(!p.comment || p.comment.replace(/(^\s+)|(\s+$)/g, "") == '')
    {
        mbu.showMessage("Comment can't be empty!");
        return;
    }
    if(!p.deadline || p.deadline.replace(/(^\s+)|(\s+$)/g, "") == '')
    {
        mbu.showMessage("Deadline can't be empty!");
        return;
    }

    mbu.setButtonWait(jQuery('#mbu-submit'));
    mbu.api_proxy('my-interviews', p, function(ret){
                            jQuery('#mbu-id-interview').val(ret['id_interview']);
                            mbu.clearWaitButtons();
                            if(typeof(callback) == 'function')
                            {
                                setTimeout(callback, 1000);
                            }
                            if(reload)
                            {
                                setTimeout(function(){
                                        document.location = mbu_script_data['blog_admin_url']+'admin.php?page=mbu_interviews&mbu_page=edit_interview&id_interview='+ret['id_interview'];
                                    }, 1000);
                            }
                         });
    
},

addInterviewQuestion : function()
{
    var id_interview = jQuery('#mbu-id-interview').val();
    var f = function(){
        
        var id_interview = jQuery('#mbu-id-interview').val();
        if(id_interview == 0)
        {
            return;
        }
        
        mbu.closeMessage();
        jQuery('#mbu-question-dlg #mbu-id-question').val('0');
        jQuery('#mbu-question-dlg #mbu-question').val('');
        jQuery('#mbu-question-dlg #mbu-min-words').val('50');
        mbu.dlg('mbu-question-dlg');
    };
    
    if(id_interview == 0)
    {
        mbu.saveInterview(false, f);
    }
    else
    {
        f();
    }    
},
        
onSaveQuestion : function()
{
    var p = {
        'id_interview' : jQuery('#mbu-id-interview').val(),
        'id_question' : jQuery('#mbu-question-dlg #mbu-id-question').val(),
        'question' : jQuery('#mbu-question-dlg #mbu-question').val(),
        'min_answer_words' : jQuery('#mbu-question-dlg #mbu-min-words').val(),
        'action' : 'save_question',
    };

    mbu.setButtonWait(jQuery('#mbu-question-dlg #mbu-ok-button'));
    mbu.api_proxy('my-interviews', p, function(ret){
                                mbu.closeDlg('mbu-question-dlg');
                                setTimeout(function(){
                                        if(mbu.getUrlVars()['id_interview'] > 0)
                                        {
                                            location.hash = '#questions';
                                            location.reload();
                                        }
                                        else
                                        {
                                            location.replace(mbu_script_data['blog_admin_url']+'admin.php?page=mbu_interviews&mbu_page=edit_interview&id_interview='+p['id_interview']+'#questions').reload();
                                        }
                                    }, 1000);
                             });
    
},

delQuestion : function(id_question)
{
    mbu.confirmDlg('Please Confirm', function(){
        var p = {
            'id_interview' : jQuery('#mbu-id-interview').val(),
            'id_question' : id_question,
            'question' : '',
            'action' : 'save_question',
        };

        //mbu.setButtonWait(jQuery('#mbu-question-dlg #mbu-ok-button'));
        mbu.api_proxy('my-interviews', p, function(ret){
                                mbu.closeDlg('mbu-confirm-dlg');
                                mbu.closeMessage();
                                jQuery('#mbu-question-'+id_question).remove();
                             });
        
    }, 'Delete this Question?');
},

editQuestion : function(id_question)
{
    var id_interview = jQuery('#mbu-id-interview').val()
    if(id_interview == 0)
    {
        return;
    }
        
    jQuery('#mbu-question-dlg #mbu-id-question').val(id_question);
    jQuery('#mbu-question-dlg #mbu-question').val(jQuery('#mbu-question-'+id_question+' .mbu-question-body').text());
    jQuery('#mbu-question-dlg #mbu-min-words').val(jQuery('#mbu-question-'+id_question+' .mbu-question-min-words').text());
    mbu.dlg('mbu-question-dlg');    
},

delInterview : function(id_interview)
{
    mbu.confirmDlg('Please confirm', function(){
        var p = {
            'id_interview' : id_interview,
            'action' : 'del_interview',
        };

        mbu.setButtonWait(jQuery('#mbu-confirm-dlg #mbu-dlg-ok'));
        mbu.api_proxy('my-interviews', p, function(ret){
                                mbu.clearWaitButtons();
                                setTimeout(function(){                                
                                    mbu.closeDlg('mbu-confirm-dlg');
                                    jQuery('#mbu-interview-'+id_interview).remove();
                                }, 1000);
                             });
        
    }, 'Delete this project?');    
},

publishInterview : function(id_interview)
{
    mbu.confirmDlg('Please confirm', function(){
        var p = {
            'id_interview' : id_interview,
            'action' : 'publish_interview',
        };

        mbu.setButtonWait(jQuery('#mbu-confirm-dlg #mbu-dlg-ok'));
        mbu.api_proxy('my-interviews', p, function(ret){
                                mbu.clearWaitButtons();
                                mbu.closeDlg('mbu-confirm-dlg');
                                //location.hash = '#iv-'+id_interview;
                                //location.reload();
                                setTimeout(function(){                                
                                    document.location = mbu_script_data.blog_admin_url+'/admin.php?page=mbu_interviews&mbu_page=active_interviews#iv-'+id_interview;
                                }, 1000);
                             });
        
    }, 'Move this project to public MBU gallery?');    
},

toDraftInterview : function(id_interview)
{
    mbu.confirmDlg('Please confirm', function(){
        var p = {
            'id_interview' : id_interview,
            'action' : 'to_draft',
        };

        mbu.setButtonWait(jQuery('#mbu-confirm-dlg #mbu-dlg-ok'));
        mbu.api_proxy('my-interviews', p, function(ret){
                                mbu.clearWaitButtons();
                                mbu.closeDlg('mbu-confirm-dlg');
                                setTimeout(function(){                                
                                    location.hash = '#iv-'+id_interview;
                                    location.reload();
                                }, 1000);
                             });
        
    }, 'Move this project to draft?');    
},

changeInterviewDeadline : function(id_interview, deadline)
{
    jQuery('#mbu-deadline-dlg #mbu-id-interview').val(id_interview);
    jQuery('#mbu-deadline-dlg #mbu-deadline').val(deadline);
    mbu.dlg('mbu-deadline-dlg');
},
        
onChangeInterviewDeadline : function()
{
    var p = {
        'id_interview' : jQuery('#mbu-deadline-dlg #mbu-id-interview').val(),
        'deadline' : jQuery('#mbu-deadline-dlg #mbu-deadline').val(),
        'action' : 'change_deadline',
    };

    mbu.setButtonWait(jQuery('#mbu-deadline-dlg #mbu-ok-button'));
    mbu.api_proxy('my-interviews', p, function(ret){
                            mbu.clearWaitButtons();
                            mbu.closeDlg('mbu-deadline-dlg');
                            setTimeout(function(){                            
                                location.hash = '#iv-'+p['id_interview'];
                                location.reload();
                            }, 1000);
                         });
},

closeInterview : function(id_interview)
{
    var answers_count = jQuery('.mbu-answer-select-checkbox:checked').length;
    
    if(answers_count > 0)
    {
        mbu.confirmDlg('Please Confirm', function(){
            var p = {
                'id_interview' : id_interview,
                'action' : 'close_interview',
            };

            mbu.setButtonWait(jQuery('#mbu-confirm-dlg #mbu-dlg-ok'));
            mbu.api_proxy('interview', p, function(ret){
                                setTimeout(function(){                                
                                    location.hash = '#actions';
                                    location.reload();
                                }, 1000);
                             });
        
        }, '<strong>You have selected '+answers_count+' replies to include into your final article.</strong> Close the interview to create a new draft article containing selected answers (Click OK and then select "Create a draft post" to import all answers into a new draft. You\'ll be able to edit and publish from there!)?');
    }
    else
    {
        mbu.showMessage('Please select some answers!');
    }
},

interviewGetCodeOptions : function(id_interview, callback)
{
    jQuery('#mbu-interview-code-options-dlg #mbu-id-interview').val(id_interview);
    jQuery('#mbu-interview-code-options-dlg #mbu-ok-button').unbind('click');
    jQuery('#mbu-interview-code-options-dlg #mbu-ok-button').on('click', function(){
                                    callback();
                                    mbu.closeDlg('mbu-interview-code-options-dlg');
                                });
    mbu.dlg('mbu-interview-code-options-dlg');
},
        
interviewPreviewCode : function(id_interview)
{
    mbu.interviewGetCodeOptions(id_interview, mbu.onInterviewPreviewCode);
},

onInterviewPreviewCode : function()
{
    var p = {
        'id_interview' : jQuery('#mbu-interview-code-options-dlg #mbu-id-interview').val(),
        'preview' : 1,
        'gen_content_table' : jQuery('#mbu-interview-code-options-dlg #gen-content-table:checked').length,
        'gen_author_info' : jQuery('#mbu-interview-code-options-dlg #gen-author-info:checked').length,
        'action' : 'get_code',
    };

    mbu.setButtonWait(jQuery('#mbu-interview-code-options-dlg #mbu-ok-button'));
    mbu.ajax(mbu_script_data['ajaxurl'], 'action=mbuGetInterviewPreviewDlg&gen_author_info='+p['gen_author_info']+'&gen_content_table='+p['gen_content_table']+'&id_interview='+p['id_interview'], 
        function(data){
            if(typeof(data.html) != 'undefined')
            {
                jQuery('#mbu-interview-preview-dlg').replaceWith(data.html);
                mbu.dlg('mbu-interview-preview-dlg');
            }
        });    
        
},

interviewCreatePost : function(id_interview)
{
    mbu.interviewGetCodeOptions(id_interview, mbu.onInterviewCreatePost);
},

onInterviewCreatePost : function()
{
    var id_interview = jQuery('#mbu-interview-code-options-dlg #mbu-id-interview').val();
    var gen_content_table = jQuery('#mbu-interview-code-options-dlg #gen-content-table:checked').length;
    var gen_author_info = jQuery('#mbu-interview-code-options-dlg #gen-author-info:checked').length;

    mbu.setButtonWait(jQuery('#mbu-interview-code-options-dlg #mbu-ok-button'));
    
    mbu.ajax(mbu_script_data['ajaxurl'], 'action=mbuPublishInterviewAjax&gen_author_info='+gen_author_info+'&gen_content_table='+gen_content_table+'&id_interview='+id_interview, 
        function(data){
            mbu.showMessage(data.msg);
        });    
},

showPageHelp : function(method)
{

    if(method == 'mbu_brainstorms')
    {
        jQuery.prettyPhoto.open('https://www.youtube.com/watch?v=QxcmAO1e4NQ', '', '');
    } 
    else if(method == 'new_brainstorm')
    {
        jQuery.prettyPhoto.open('https://www.youtube.com/watch?v=W7tIhnnllbU');
    }
    else if(method == 'mbu_interviews')
    {
        jQuery.prettyPhoto.open('https://www.youtube.com/watch?v=1YLGMyBFRuU');
    }
    else if(method == 'interview')
    {
        jQuery.prettyPhoto.open('https://www.youtube.com/watch?v=-nMTYqC8h-Y');
    }    
},

getUrlVars : function() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&^#]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
},

addBrainstormTODO : function(id_idea)
{
    jQuery('#mbu-todo-dlg #mbu-id-idea').val(id_idea);
    jQuery('#mbu-todo-dlg #mbu-todo-comment').val('');
    mbu.dlg('mbu-todo-dlg');    
},
        
saveBrainstormTODO : function()
{
    var p = {
        'id_idea'    : jQuery('#mbu-todo-dlg #mbu-id-idea').val(),
        'txt'        : jQuery('#mbu-todo-dlg #mbu-todo-comment').val(),
        'remind'     : jQuery('#mbu-todo-dlg #mbu-remind-date').val(),
        'action'     : 'add_todo_item',
    };

    mbu.setButtonWait('#mbu-todo-dlg #mbu-dlg-ok');
    mbu.api_proxy('ideas', p, function(ret){
                                            setTimeout(function(){
                                                        location.hash = '#mbu-idea-'+p['id_idea'];
                                                        location.reload();
                                                }, 1000);
                                        });    
},
        
delTODOItem : function(id_todo)
{
    mbu.confirmDlg('Confirmation', function(){
        var p = {
            'id_todo'    : id_todo,
            'action'     : 'del_todo_item',
        };

        mbu.setButtonWait('#mbu-dlg-ok');
        mbu.api_proxy('ideas', p, function(ret){
                                            setTimeout(function(){
                                                        jQuery('#todo-item-'+id_todo).remove();
                                                        //location.hash = '#mbu-idea-'+ret['id_idea'];
                                                        //location.reload();
                                                }, 1000);
                                        });            
    },
    'Remove TODO Item?')    
},

showTODOItem : function(id_todo)
{
    mbu.ajax(mbu_script_data['ajaxurl'], 'action=mbuGetTODOItemDlg&id_todo='+id_todo, function(ret){
        
        if(typeof(ret['html']) != 'undefined')
        {
            jQuery('#mbu-show-todo-idea-dlg').replaceWith(ret['html']);
            mbu.dlg('mbu-show-todo-idea-dlg');
        }
    });
},

widgetSaveIdea : function()
{
    var p = {
        'id_request'      : jQuery('#mbu_widget #mbu-project').val(),
        'title'           : jQuery('#mbu_widget #mbu-idea-title').val(),
        'author_comment'  : jQuery('#mbu_widget #mbu-idea-text').val(),
        'action'          : 'save_idea',
    };

    if(!p.id_request)
    {
        mbu.showMessage("Please select project!");
        return;
    }
    if(!p.title || p.title.replace(/(^\s+)|(\s+$)/g, "") == '')
    {
        mbu.showMessage("Title can't be empty!");
        return;
    }
    if(!p.author_comment || p.author_comment.replace(/(^\s+)|(\s+$)/g, "") == '')
    {
        mbu.showMessage("Idea text can't be empty!");
        return;
    }

    //mbu.setButtonWait('#mbu-send-idea-button');
    mbu.api_proxy('article-requests', p, function(ret){
                                            mbu.showMessage('Idea was sent successfully');
                                            setTimeout(function(){
                                                        //location.hash = '#mbu-idea-'+ret['id_idea'];
                                                        location.reload();
                                                }, 1000);
                                        });            
    
},

deleteIdea : function(id_idea)
{
    mbu.confirmDlg('Confirmation', function(){
        var p = {
            'id_idea'    : id_idea,
            'action'     : 'delete_idea',
        };

        mbu.setButtonWait('#mbu-confirm-dlg #mbu-dlg-ok')
        mbu.api_proxy('ideas', p, function(ret){
                                            mbu.showMessage(ret['msg'])
                                            jQuery('#mbu-idea-'+id_idea).remove();
                                            mbu.closeDlg('mbu-confirm-dlg');
                                        });            
    },
    'Remove Idea?')        
},

saveIdeaURL : function(id_idea)
{
    mbu.ajax(mbu_script_data['ajaxurl'], 'action=mbuGetIdeaURLDlg&id_idea='+id_idea, function(ret){
        
        if(typeof(ret['html']) != 'undefined')
        {
            jQuery('#mbu-idea-url-dlg').replaceWith(ret['html']);
            mbu.dlg('mbu-idea-url-dlg');
        }
    });    
},
        
onSaveIdeaURL : function()
{
    var p = {
        'id_idea'    : jQuery('#mbu-idea-url-dlg #mbu-id-idea').val(),
        'link'       : jQuery('#mbu-idea-url-dlg #mbu-idea-link').val(),
        'action'     : 'save_idea_link',
    };

    mbu.setButtonWait('#mbu-idea-url-dlg #mbu-dlg-ok')
    mbu.api_proxy('ideas', p, function(ret){
                                            mbu.showMessage(ret['msg'])
                                            mbu.closeDlg('mbu-idea-url-dlg');
                                            setTimeout(function(){
                                                        location.hash = '#mbu-idea-'+p['id_idea'];
                                                        location.reload();
                                                }, 1000);                                            
                                        });            
    
}

};

jQuery(document).ready(mbu.init);
