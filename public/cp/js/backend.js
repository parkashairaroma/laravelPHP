


/*
* ordering
*/
function sortTable(url) {
	$('tbody').sortable({
	    helper: fixWidthHelper,
	    axis: 'y',
	    stop: function (e, ui) {
	    	
	    	//ui.item.find('td').css('background', '#fff');

	        var data = $(this).sortable('serialize');

			api('put', url, data);
		}
	});
}

/* 
* fixed width helpder for sortTable() 
*/
function fixWidthHelper(e, ui) {
    ui.children().each(function() {
        $(this).width($(this).width());
    });
    return ui;
}


function statusChange(obj, status) 
{
	switch (status) {
		case 1:
			obj.data('status', 0);
			obj.find('span').html('Enabled');
			obj.find('i').removeClass('fa-times text-danger').addClass('fa-check text-success');
		break;
		case 0:
			obj.data('status', 1);
			obj.find('span').html('Disabled');
			obj.find('i').removeClass('fa-check text-success').addClass('fa-times text-danger');
		break;
	}
}

function makeid()
{
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < 5; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}