jQuery(function($) {
    $('#search-city-input').on('keyup', function() {
        var term = $(this).val();
        $.post(city_search_ajax.ajax_url, {
            action: 'search_city',
            term: term
        }, function(response) {
            $('#cities-table tbody').empty();
            response.forEach(function(row) {
                $('#cities-table tbody').append('<tr><td>—</td><td>' + row.post_title + '</td><td>—</td></tr>');
            });
        });
    });
});
