<?php
function register_countries_taxonomy() {
    register_taxonomy('country', 'city', [
        'labels' => [
            'name' => 'Countries',
            'singular_name' => 'Country',
            'search_items' => 'Search Countries',
            'add_new_item' => 'Add New Country',
        ],
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
    ]);
}
add_action('init', 'register_countries_taxonomy');
