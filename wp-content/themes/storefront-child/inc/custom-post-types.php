<?php
// Регистрируем CPT "Cities"
function register_cities_post_type() {
    $labels = [
        'name' => 'Cities',
        'singular_name' => 'City',
        'add_new' => 'Add New City',
        'add_new_item' => 'Add New City',
        'edit_item' => 'Edit City',
        'new_item' => 'New City',
        'view_item' => 'View City',
        'search_items' => 'Search Cities',
        'not_found' => 'No cities found',
        'menu_name' => 'Cities',
    ];

    $args = [
        'label' => 'Cities',
        'labels' => $labels,
        'public' => true,
        'has_archive' => false,
        'show_in_rest' => true,
        'supports' => ['title'],
        'menu_position' => 5,
        'menu_icon' => 'dashicons-location-alt',
    ];

    register_post_type('city', $args);
}
add_action('init', 'register_cities_post_type');
