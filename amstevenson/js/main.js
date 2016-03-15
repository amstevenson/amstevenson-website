
(function($) {

	"use strict";

	skel.breakpoints({
		xlarge:	'(max-width: 1680px)',
		large:	'(max-width: 1280px)',
		medium:	'(max-width: 980px)',
		small:	'(max-width: 736px)',
		xsmall:	'(max-width: 480px)'
	});

	$(function() {

		var	$window = $(window),
			$body = $('body'),
			$header = $('#header'),
			$banner = $('#banner');

		// Disable animations/transitions until the page has loaded.
			$body.addClass('is-loading');

			$window.on('load', function() {
				window.setTimeout(function() {
					$body.removeClass('is-loading');
				}, 100);
			});

		// Fix: Placeholder polyfill.
			$('form').placeholder();

		// Prioritize "important" elements on medium.
			skel.on('+medium -medium', function() {
				$.prioritize(
					'.important\\28 medium\\29',
					skel.breakpoint('medium').active
				);
			});

		// Header.
			if (skel.vars.IEVersion < 9)
				$header.removeClass('alt');

			if ($banner.length > 0
			&&	$header.hasClass('alt')) {

				$window.on('resize', function() { $window.trigger('scroll'); });

				$banner.scrollex({
					bottom:		$header.outerHeight(),
					terminate:	function() { $header.removeClass('alt'); },
					enter:		function() { $header.addClass('alt'); },
					leave:		function() { $header.removeClass('alt'); }
				});

			}

		// Menu.
			var $menu = $('#menu');

			$menu._locked = false;

			$menu._lock = function() {

				if ($menu._locked)
					return false;

				$menu._locked = true;

				window.setTimeout(function() {
					$menu._locked = false;
				}, 350);

				return true;

			};

			$menu._show = function() {

				if ($menu._lock())
					$body.addClass('is-menu-visible');

			};

			$menu._hide = function() {

				if ($menu._lock())
					$body.removeClass('is-menu-visible');

			};

			$menu._toggle = function() {

				if ($menu._lock())
					$body.toggleClass('is-menu-visible');

			};

			$menu
				.appendTo($body)
				.on('click', function(event) {

					event.stopPropagation();

					// Hide.
						$menu._hide();

				})
				.find('.inner')
					.on('click', '.close', function(event) {

						event.preventDefault();
						event.stopPropagation();
						event.stopImmediatePropagation();

						// Hide.
							$menu._hide();

					})
					.on('click', function(event) {
						event.stopPropagation();
					})
					.on('click', 'a', function(event) {

						var href = $(this).attr('href');

						event.preventDefault();
						event.stopPropagation();

						// Hide.
							$menu._hide();

						// Redirect.
							window.setTimeout(function() {
								window.location.href = href;
							}, 350);

					});

			$body
				.on('click', 'a[href="#menu"]', function(event) {

					event.stopPropagation();
					event.preventDefault();

					// Toggle.
						$menu._toggle();

				})
				.on('keydown', function(event) {

					// Hide on escape.
						if (event.keyCode == 27)
							$menu._hide();

				});


        // Shortcuts to elements on pages
            $(document).on('click','.special', function(event) {

                var check = $(this).attr('id');

                // Elements on page that result in a short animation.
                if(check == 'aboutme' || check == 'services' || check == 'documentationLink'
                || check == 'cmdsLink' || check == 'addComLink' || check == 'delComLink' || check == 'editComLink' || check == 'editComRepeatLink' || check == 'startTriviaLink' || check == 'stopTriviaLink' || check == 'setQuestionPoolLink' || check == 'currencyLink' || check == 'giveCurrencyLink' || check == 'miscLink') {

                    event.preventDefault();

                    var target = "#" + this.getAttribute('data-target');

                    $('html, body').animate({
                        scrollTop: $(target).offset().top
                    }, 1500);
                }
            });


	});

    function validEmail(email) { // see:
        var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        return re.test(email);
    }

    // get all data in form and return object
    function getFormData(formName) {
        var elements = document.getElementById(formName).elements; // all form elements
        var fields = Object.keys(elements).filter(function(k){
            return k.length > 1 && elements[k].name && elements[k].name.length > 0 ;
        });
        var data = {};
        fields.forEach(function(k){
            data[k] = elements[k].value;
        });
        console.log(data);
        return data;
    }

    function handleFormSubmitMessage(event) {  // handles form submit withtout any jquery
        event.preventDefault();           // we are submitting via xhr below
        var data = getFormData("contact-form");         // get the values submitted in the form
        if( !validEmail(data.email) ) {   // if email is not valid show error
            document.getElementById('email-invalid').style.display = 'block';
            return false;
        } else {
            var url = event.target.action;  //
            var xhr = new XMLHttpRequest();
            xhr.open('POST', url);
            // xhr.withCredentials = true;
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                console.log( xhr.status, xhr.statusText )
                console.log(xhr.responseText);
                document.getElementById('contact-form').style.display = 'none';
                document.getElementById('start_message_header').style.display ='none';
                document.getElementById('start_message_text').style.display ='none';
                document.getElementById('return_message').style.display = 'block';
                return;
            };
            // url encode form data for sending as post data
            var encoded = Object.keys(data).map(function(k) {
                return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
            }).join('&')
                xhr.send(encoded);
        }
    }

    function handleFormSubmitProjectSearch(event)
    {
        // POSSIBLE DELETE IN THE FUTURE
        //event.preventDefault();
        //var data = getFormData("project-form");


    }

    function loaded() {

        // This is where we deal with what happens after a form is submitted.
        console.log('contact form submission handler loaded successfully');

        // Contact: bind to the submit event of our form
        var contactForm = document.getElementById('contact-form');
        contactForm.addEventListener("submit", handleFormSubmitMessage, false);

        // Project search
        var projectForm = document.getElementById('project-form');
        projectForm.addEventListener("submit", handleFormSubmitProjectSearch, false);
    }
    // After the page has loaded, assign the form event listeners
    document.addEventListener('DOMContentLoaded', loaded, false);

})(jQuery);
