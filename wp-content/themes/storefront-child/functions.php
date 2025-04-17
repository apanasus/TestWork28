<?php
/**
 * Функции дочерней темы Storefront
 */

defined('ABSPATH') || exit;
// Подключаем стили с родительской темы
add_action('wp_enqueue_scripts', 'storefront_child_enqueue_styles');
function storefront_child_enqueue_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}

// Подключаем все файлы с логикой погоды
require_once get_stylesheet_directory() . '/inc/custom-post-types.php';
require_once get_stylesheet_directory() . '/inc/custom-taxonomies.php';
require_once get_stylesheet_directory() . '/inc/meta-boxes.php';
require_once get_stylesheet_directory() . '/inc/weather-widget.php';
require_once get_stylesheet_directory() . '/inc/ajax-search.php';

/**
 * Подключение AJAX-поиска по городам
 */
function enqueue_city_search_script() {
    if (is_page_template('templates/template-cities-table.php')) {
        wp_enqueue_script(
            'city-search',
            get_stylesheet_directory_uri() . '/js/city-search.js',
            ['jquery'],
            null,
            true // В подвале
        );

        // Передаём ajaxurl в JS
        wp_localize_script('city-search', 'city_search_ajax', [
            'ajax_url' => admin_url('admin-ajax.php')
        ]);
    }
}
add_action('wp_enqueue_scripts', 'enqueue_city_search_script');

/**
 * Настройки API погоды
 */
function get_weather_api_settings() {
    return [
        'api_key' => '5ca044e928d0d9524b37830c8cc681dd',
        'base_url' => 'https://api.openweathermap.org/data/2.5/weather',
    ];
}

/**
 * Настройки API геокодера
 */
function get_geocoder_api_settings() {
    return [
        'api_key' => 'dad4f3e64a4f42b490dbec806d9eef38', // Ваш API-ключ
        'base_url' => 'https://api.opencagedata.com/geocode/v1/json', // URL API
    ];
}
