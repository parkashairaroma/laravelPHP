
/*
* Administration 
*/
$(function () {

    $('body')
    .on('mouseenter', '.inline-tools', function (e) {

        closePopup('.admin-actions');

        var token = $(this).data('token');
        var id = $(this).data('id');

        var html =  '<div class="admin-actions">' +
                    ' <a class="edit-inline" data-token="' + token + '" data-id="' + id + '"><i class="fa fa-pencil"></i> Inline</a> ' +
                    ' <a class="edit-admin" data-token="' + token + '" data-id="' + id + '"><i class="fa fa-eye"></i> Admin</a> ' +
                    '</div>';

        $('body').append(html);

        var pos = cursorPos($(this), -45, 0);
		$('.admin-actions').css({top:pos.top, left:pos.left}).show();
    })
    .on('mouseleave', '.inline-tools', function () {
     	$('.admin-actions').delay(1000).fadeOut('slow', function() {
     		closePopup('.admin-actions');
     	});
    })
    .on('click', '.save', function () {

        var value = $(this).parents('.admin-editor').find('.editor').text();
        var token = $(this).data('token');
        var id = $(this).data('id');
        var data = {pgt_value: value};
        var response = api('put', '/admin/api/tokens/edit/'+id, data);

        if (response.status) {
            updateText(token, nl2br(value));
            closePopup('.admin-editor');
        }
    })
    .on('click', '.close', function () {
        if (! confirm('Are you sure?')) return false;
        closePopup('.admin-editor');
    })
    .on('click', '.edit-admin', function () {
        window.open('admin/pages','_blank');
    })
    .on('click', '.edit-inline', function () {
        if (! confirm('Are you sure? ')) return false;
        closePopup('.admin-editor');

        var id = $(this).data('id');
        var token = $(this).data('token');
        var text = api('get', '/admin/api/tokens/view/'+id);

        var html =  '<div class="admin-editor">' + 
                    '  <div class="buttons">' +
                    '    <i class="fa fa-save save" data-id="'+ id +'"  data-token="'+ token +'"></i>' + 
                    '    <i class="fa fa-times-circle close"></i>' +
                    '  </div>' +
                    '  <div class="token">' + token + '</div>' + 
                    '  <div class="label">Default</div>' + 
                    '  <div class="original">' + text[baseId] + '</div>' + 
                    '  <div class="label">Translated</div>' + 
                    '  <div class="editor" contenteditable="true">' + text[websiteId] + '</div>' +
                    '</div>'; 

        $('body').append(html);

        var pos = cursorPos($(this), +70, -10);
        $('.admin-editor').css({top:pos.top, left:pos.left}).show();
    });
});


/* updates the token on the page to the provided text */
function updateText(token, text) {
    $('body').find(".inline-tools[data-token='" + token + "']").html(text);
}

