jQuery(document).ready(function($) {

    // remove the disabled attribute from input or select fields
    $(document).on('click', 'span.input-wrapper', function() {
        var inputField = $(this).find('input, select');
        if (inputField.length) {
            // confirm the user wants to edit
            if (!confirm('Are you sure you want to edit this field?')) {
                return false;
            }
            // remove the disabled attribute
            inputField.removeClass('disabled');
        }
    });

    // toggle the visibility of the add venue form
    $(document).on('click', '#toggle_add_venue', function(e) {
        e.preventDefault();
        // toggle the visibility of the add venue form
        $('#add_venue_wrapper').toggleClass('show-form');
        // focus on the first input field in the form
        $('#add_venue_form input#new_venue_name').focus();
    });

    // handle the change event for the session local venue select
    $(document).on('change', 'select#session_local_venue', function() {
        const $session_venue = $('input#session_venue');
        const $session_outside_venue = $('select#session_outside_venue');
        var selectedVenue = $(this).val();
        // set the selected venue value to the hidden input
        $session_venue.val(selectedVenue);
        // reset the outside venue select
        $session_outside_venue.val('');
    });

    // handle the change event for the session outside venue select
    $(document).on('change', 'select#session_outside_venue', function() {
        const $session_venue = $('input#session_venue');
        const $session_local_venue = $('select#session_local_venue');
        var selectedOutsideVenue = $(this).val();
        // set the selected outside venue value to the hidden input
        $session_venue.val(selectedOutsideVenue);
        // reset the local venue select
        $session_local_venue.val('');
    });

    // handle the change event for the event local venue select
    $(document).on('change', 'select#event_local_venue', function() {
        const $event_venue = $('input#event_venue');
        const $event_outside_venue = $('select#event_outside_venue');
        var selectedVenue = $(this).val();
        // set the selected venue value to the hidden input
        $event_venue.val(selectedVenue);
        // reset the outside venue select
        $event_outside_venue.val('');
    });

    // handle the change event for the event outside venue select
    $(document).on('change', 'select#event_outside_venue', function() {
        const $event_venue = $('input#event_venue');
        const $event_local_venue = $('select#event_local_venue');
        var selectedOutsideVenue = $(this).val();
        // set the selected outside venue value to the hidden input
        $event_venue.val(selectedOutsideVenue);
        // reset the local venue select
        $event_local_venue.val('');
    });
    
    // Handle image upload
    $(document).on('click', '.figure img', function() {
        const $image = $(this);
        const $input = $image.siblings('input[type="hidden"]');
        var image = wp.media({
            title: 'Select Background Image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        }).open().on('select', function(e) {
            var uploaded_image = image.state().get('selection').first().toJSON();
            $input.val(uploaded_image.url);
            $image.attr('src', uploaded_image.url);
        });
    });
    // Remove image button functionality
    $(document).on('click', '.remove_image', function(e) {
        e.preventDefault();
        const button = $(this);
        const imageInput = button.siblings('input[type="hidden"]');
        const imagePreview = button.siblings('img');
        imageInput.val('');
        imagePreview.attr('src', '');
    });

    // Handle the focus and blur events for the content editor
    function bindTinyMCEFocusHandlers() {
        $('iframe[id$="_ifr"]').each(function () {
        const $iframe = $(this);

        // Only bind once
        if ($iframe.data('focus-bound')) return;
        $iframe.data('focus-bound', true);

        const editorId = $iframe.attr('id').replace('_ifr', '');
        const $container = $('#wp-' + editorId + '-editor-container');

        // Access iframe DOM and bind focus/blur inside
        const iframe = $iframe[0];
        const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

        if (iframeDoc && iframeDoc.body) {
            $(iframeDoc.body).on('focus', function () {
            $container.addClass('editor-focused');
            }).on('blur', function () {
            $container.removeClass('editor-focused');
            });
        }
        });
    }

    // Run periodically until all iframes are bound
    const interval = setInterval(function () {
        if ($('iframe[id$="_ifr"]').length > 0) {
        bindTinyMCEFocusHandlers();
        }

        // Stop polling after a few seconds (or when all editors are ready)
        if (typeof tinymce !== 'undefined' && tinymce.editors.length) {
        const allReady = tinymce.editors.every(ed => ed.initialized);
        if (allReady) {
            clearInterval(interval);
        }
        }
    }, 500);

});