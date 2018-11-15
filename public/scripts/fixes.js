$(document).ready(function () {
    // Contact Form
    if ($('body').hasClass('contact')) {

        /* Contact Page, prevent pasting into the email confirmation feild */
        $('body.contact #contact-email2').bind("paste",function (e) {
            e.preventDefault();
        })

        /* Scroll to contact confirmation message */
        if ($('#contact-submit-message').length) {
            scrollToElement('#contact-submit-message');
        }

        /* Scroll to contact confirmation message */
        if ($('.form-group.error span.message').length) {
            scrollToElement('.form-group.error span.message');
        }

        // On Contact Form Country Change, get States from API
        $('#contact-form-country').change(function () {
            $countryCode = $(this).val();
            if ($countryCode != null && $countryCode != "") {
                $.ajax({
                    method: "GET",
                    url: '/api/country/' + $countryCode + '/states',
                    dataType: "json",
                })
                .done(function ( data ) {
                    if (data.status == "success" && data.count > 0) {
                        $('#contact-form-state').find('option:gt(0)').remove().end();
                        $.each(data.states, function (key, state) {
                            $('#contact-form-state').append('<option value="' + state.sta_code + '">' + state.sta_name + '</option>');
                        });
                        $('#contact-form-state option:first').attr('selected', 'selected');
                        $('#contact-form-state').dropdown('set selected', $("#contact-form-state option:selected").val());
                        $('#contact-form-state').dropdown('set text', $("#contact-form-state option:selected").text());
                        $('div.form-group.state').show();
                    } else {
                        $('#contact-form-state').find('option:gt(0)').remove().end();
                        $('div.form-group.state').hide();
                    }
                });
            }
        });
    } // End Contact Form

    // Locations Page
    if ($('body').hasClass('locations')) {
        
        /* Locations page, redirect on country change */
        $('body.locations select#locations-country').change(function () {
            var countryPage = $(this).data('locationspage');
            var countrySlug = $(this).find(':selected').data('countryslug');
            if (countrySlug != "") {
                window.location = countryPage + "/" + countrySlug;
            }
        });

        /* Locations Page, scroll to results */
        if ($('#location-addresses').hasClass('scrollto')) {
            scrollToElement('#location-addresses');
        }
    }
    // End Locations Page
   
    /* show the share links once they're fully loaded */
    $('.share-list').delay(3000).fadeIn(1);

    if($('body').hasClass('store')) { // Start Store javascript
        /* Submit forms */
        $('a.submit-form').click(function(e){
            e.preventDefault();
            $(this).parents('form').submit();
        });
    }

});

/* Scroll to Element */
function scrollToElement(elem)
{
    $('body').animate({
        scrollTop: $(elem).offset().top
    }, 1000);
}

function cartAdditionAnimation(imgSource) {
    if (imgSource.attr('src').length > 0) {
        var imgClone = imgSource.clone();
        imgClone.offset({
            top: imgSource.offset().top,
            left: imgSource.offset().left
        })
        .css({
            'opacity': '0.5',
            'position': 'absolute',
            'height': imgSource.css('height'),
            'width': imgSource.css('width'),
            'z-index': '100000'
        })
        .appendTo($('body'))
        .animate({
            'top': $('div#cart-button').offset().top + 20,
            'left': $('div#cart-button').offset().left,
            'width': 40,
            'height': 40                    
        }, 1000, 'easeInExpo', function(){
            imgClone.animate({
                    'opacity': 0
                }, 100, function () {
                    $(this).detach()
                    $('div#cart-button').effect("shake", {
                        times: 2
                    }, 200);
                });
            });
    }
}