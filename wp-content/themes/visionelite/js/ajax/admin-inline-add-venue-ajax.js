jQuery(document).ready(function($) {

    $('#add_venue_button').on('click', function (e) {
        e.preventDefault();
        const siteCity = $(this).data('site-city');
        const $form = $(this).closest('#add_venue_form');
        const venueName = $form.find('#new_venue_name').val();
        const venueAddress = $form.find('#new_venue_address').val();
        const venueCity = $form.find('#new_venue_city').val();
        const venueProvince = $form.find('#new_venue_province').val();
        const venuePostalCode = $form.find('#new_venue_postal_code').val();

        // AJAX request to add the new venue
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'add_new_venue',
                venue_name: venueName,
                venue_address: venueAddress,
                venue_city: venueCity,
                venue_province: venueProvince,
                venue_postal_code: venuePostalCode,
                nonce: admin_inline_add_venue_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    // Clear the form fields
                    $form.find('#new_venue_name').val('');
                    $form.find('#new_venue_address').val('');
                    $form.find('#new_venue_city').val('');
                    $form.find('#new_venue_province').val('');
                    $form.find('#new_venue_postal_code').val('');
                    $('select#session_local_venue').val('');
                    $('select#session_outside_venue').val('');

                    // Set the hidden input value to the new post ID
                    $('input#session_venue').val(response.data.post_id);
                    // if venueCity is equal to siteCity, append select#session_local_venue
                    if (venueCity.toLowerCase() === siteCity.toLowerCase()) {
                        $('select#session_local_venue').append(`<option value="${response.data.post_id}" selected="selected">${venueName}</option>`);
                    }
                    else {
                        $('select#session_outside_venue').append(`<option value="${response.data.post_id}" selected="selected">${venueName}</option>`);
                    }
                    // remove class "show-form" from #add_venue_wrapper
                    $('#add_venue_wrapper').removeClass('show-form');

                    // Optionally, you can update a list of venues or show a success message
                    alert('Venue added successfully!');
                } else {
                    alert('Error adding venue: ' + response.data);
                }
            },
            error: function(xhr, status, error) {
                alert('AJAX request failed: ' + error);
            }
        });
    });
    
});