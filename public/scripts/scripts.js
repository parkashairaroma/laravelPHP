
/* Check to see if element is wholly visible in viewport */
function isScrolledIntoView(elem) {
    var docViewTop = $(window).scrollTop();
    var docViewBottom = docViewTop + $(window).height();

    var elemTop = $(elem).offset().top;
    var elemBottom = elemTop + $(elem).height();

    return ((docViewTop < elemTop) && (docViewBottom > elemBottom));
}

$(document).ready(function() {
	
	/* DROPDOWN NAVIGATION */
	
	/* Primary Navigation */
	var primary_menu = $('#nav-primary');
	var primary_menu_button = $('#menu-button');
	primary_menu_button.click(function() {
		showDropdown(primary_menu, true);
		return false;
	});
	
	/* Secondary Navigation */
	var secondary_menu = $('#nav-secondary');
	var secondary_menu_button = $('#dropdown-nav-button');
	secondary_menu_button.click(function() {
		showDropdown(secondary_menu, false);
		return false;
	});
	
	/* Account navigation */
	var account_menu = $('#nav-account');
	var account_menu_button = $('#cart-button a');
	account_menu_button.click(function() {
		showDropdown(account_menu, false);
		return false;
	});
	
	/* Show Dropdown Function */
	function showDropdown(dropdown, body_class) {
		// Remove other visible dropdowns
		$('.navigation').not(dropdown).removeClass('dropdown-visible');
		// Remove dropdown when clicking outside
		$('html').click(function() {
			dropdown.removeClass('dropdown-visible');
		});
		// Allow events inside dropdown
		dropdown.click(function(event) {
		    event.stopPropagation();
		});
		// Show/hide dropdown
		dropdown.toggleClass('dropdown-visible');
		// If body class property is set to true, add class to html. Used for full height main menu
		if (body_class) {
			$('body').toggleClass('nav-expanded');
		} else {
			$('html').removeClass('nav-expanded');
		}
	}
	
	/* Carousel */
	$('.carousel').slick({
		arrows: false,
		dots: true,
		draggable: true,
		autoplay: true,
		autoplaySpeed: 5000,
		speed: 1000,
		pauseOnHover: false
	});
	$('.carousel .preload').removeClass('preload');
	
	/* Select Dropdowns */
	$('select').dropdown();
	
	/* Swatch Picker */
	var swatch_img = $('#swatch-images').find('.swatch-image');
	// Hide all swatches by default
	swatch_img.hide();
	// Find radio buttons related to swatches
	var swatch_radio = $('.swatches').find('input');
	// Find checked radio button
	var swatch_checked = $('.swatches').find('input:checked');
	// On change, pick selected swatch
	swatch_radio.change(function() {
		swatchPicker($(this), swatch_img);
	});
	function swatchPicker(radio, swatch_img) {
		// Hide all swatches by default
		swatch_img.hide();
		// Display selected swatch image
		if (radio.is(':checked')) {
			var selected_tab = radio.data('tab');
			$('#' + selected_tab).show();
		}
	}
	
	swatchPicker(swatch_checked, swatch_img);
	
	// On scroll, check if diffuser graph has come into view
    if ($('body').hasClass('why-air-aroma')) {

        // Check once, if not, after a scroll
        if (isScrolledIntoView('#diffusion-graph')) {
            $('#diffusion-graph .plot-line').width('100%');
        } else {
            $(window).scroll(function () {
                if (isScrolledIntoView('#diffusion-graph')) {
                    $('#diffusion-graph .plot-line').width('100%');
                }
            });
        }
    }
    
    // On scroll, check if stress graph has come into view
    if ($('body').hasClass('arobalance')) {
	    // Check once, if not, after a scroll
	    if (isScrolledIntoView('#stress-graph')) {
	        $('#stress-graph .plot-bar-a').addClass('grow');
	    } else {
	        $(window).scroll(function () {
	            if (isScrolledIntoView('#stress-graph')) {
	                $('#stress-graph .plot-bar').addClass('grow');
	            }
	        });
	    }
	}

	
});