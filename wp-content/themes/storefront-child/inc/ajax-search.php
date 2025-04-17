<?php
// Регистрируем обработчики AJAX-запросов для авторизованных и неавторизованных пользователей
add_action('wp_ajax_search_city', 'search_city_ajax_handler'); // Для авторизованных пользователей
add_action('wp_ajax_nopriv_search_city', 'search_city_ajax_handler'); // Для неавторизованных пользователей

/**
 * Обработчик AJAX-запроса для поиска городов.
 * 
 * Получает термин поиска из POST-запроса, ищет записи типа 'city',
 * название которых совпадает с термином, и возвращает результаты в формате JSON.
 */
function search_city_ajax_handler() {
    global $wpdb;

    // Получаем термин поиска из POST-запроса и очищаем его
    $term = sanitize_text_field($_POST['term']);

    // Выполняем запрос к базе данных для поиска записей типа 'city'
    $results = $wpdb->get_results($wpdb->prepare("
        SELECT p.ID, p.post_title
        FROM {$wpdb->prefix}posts p
        WHERE p.post_type = 'city' AND p.post_title LIKE %s
        LIMIT 10
    ", '%' . $wpdb->esc_like($term) . '%'));

    // Возвращаем результаты в формате JSON
    wp_send_json($results);
}
