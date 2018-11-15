function addToolTip()
{
    $('.tip').tooltipster({
        theme: 'tooltip-theme',
        delay: 1,
        multiple: true
    });
}

function nl2br(str, is_xhtml)
{
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br ' + '/>' : '<br>'; // Adjust comment to avoid issue on phpjs.org display

    return (str + '')
    .replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}

function enableSaveButton(obj)
{
    var row = obj.parents('tr');
    row.find('.save').switchClass('btn-default', 'btn-success');
    row.find('.save').prop('disabled', false);
    
    if ($('#save-all').length) {
        $('#save-all').switchClass('btn-default', 'btn-success');
        $('#save-all').prop('disabled', false);
    }
}
function disableSaveButton(obj)
{
    var row = obj.parents('tr');
    row.find('.save').switchClass('btn-success', 'btn-default');
    row.find('.save').prop('disabled', true);
}

function saveAll(obj)
{
    obj.prop('disabled', true);
    msgBox('Saving...', false);

    setTimeout(function () {
        $('.save, .save-new').each(function () {
            if (! $(this).attr('disabled')) {
                $(this).trigger('click');
            }
        })
        .promise()
        .done(function () {
            $('#save-all').switchClass('btn-success', 'btn-default');
            $('#save-all').prop('disabled', true);
        });
    }, 100);
}


function openGalleryDialog(url, obj)
{

    var id = obj.attr('id');

    $('#gallery-dialog').data('id', id).dialog({
        open: function () {
            $(this).load(url);
        },
        width: 800,
        height: 600,
        title: 'Gallery',
        resizable: false
    });
}

function getRowData(obj, data)
{
    var row = obj.parents('tr');
    return row.data(data);
}

function api(type,url,data)
{
    var response;

    $.ajaxSetup({
        url: url,
        type: type,
        async: true
    });

    switch (type) {
        case 'get':
            var request = $.ajax();
        break;
        case 'put':
            var request = $.ajax({ data: data });
        break;
        case 'post':
            var request = $.ajax({ data: data });
        break;
        case 'delete':
            var request = $.ajax();
        break;
    }

    return request;
}


/* closes the element provided */
function closePopup(elem)
{
    if ($(elem).length) {
        $(elem).remove();
    }
}
function closeElement(elem)
{
    if ($(elem).length) {
        $(elem).remove();
    }
}

/* find the position of element where the cursor clicked or hover */
function cursorPos(obj, x, y)
{

    var left = Math.ceil(obj.offset().left) + y;
    var top = Math.ceil(obj.offset().top) + x;

    return { top: top, left: left };
}

/* popup msgbox */
function msgBox(message, status)
{
    var elem = '.popup-message';

    if ($(elem).length) {
        $(elem).remove();
    }

    switch (status) {
        case true:
            var html = '<div class="popup-message"><i class="fa fa-save btn-success"></i><p>' + message + '</p></div>';
        break;
        case false:
            var html = '<div class="popup-message" style="z-index: 10000000"><i class="fa fa-times btn-danger"></i><p>' + message + '</p></div>';
        break;
    }

    $('body').append(html);

    $(elem).show('fast').delay(3000).fadeOut('slow', function () {
        $(elem).remove()
    });
}


function getSelectionStartNode()
{
    if (window.getSelection) { // should work in webkit/ff
        var node = window.getSelection().anchorNode;
        var startNode = (node.nodeName == "#text" ? node.parentNode : node);
        return startNode;
    }
}