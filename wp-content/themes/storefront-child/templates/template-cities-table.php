<?php
/**
 * Template Name: Cities Table
 */
get_header();
do_action('before_cities_table');
?>

<form id="search-city-form">
    <input type="text" id="search-city-input" placeholder="Search cities...">
</form>

<table id="cities-table">
    <thead>
        <tr><th>Страна</th><th>Город</th><th>Температура</th></tr>
    </thead>
    <tbody>
        <?php
        global $wpdb;
        $results = $wpdb->get_results("
            SELECT p.ID, p.post_title AS city, t.name AS country
            FROM {$wpdb->prefix}posts p
            LEFT JOIN {$wpdb->prefix}term_relationships tr ON p.ID = tr.object_id
            LEFT JOIN {$wpdb->prefix}term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
            LEFT JOIN {$wpdb->prefix}terms t ON tt.term_id = t.term_id
            WHERE p.post_type = 'city' AND p.post_status = 'publish'
        ");

        $settings = get_weather_api_settings();
        $api_key = $settings['api_key'];
        $base_url = $settings['base_url'];

        foreach ($results as $row) {
            $lat = get_post_meta($row->ID, '_city_latitude', true);
            $lon = get_post_meta($row->ID, '_city_longitude', true);
            $temp = '—';

            if ($lat && $lon) {
                // Создаём уникальный ключ для кэша
                $cache_key = "weather_data_{$lat}_{$lon}";
                $cached_weather = get_transient($cache_key);

                if ($cached_weather !== false) {
                    // Используем данные из кэша
                    $temp = $cached_weather . '°C';
                } else {
                    // Если данных в кэше нет, делаем запрос к API
                    $weather = wp_remote_get("$base_url?lat=$lat&lon=$lon&units=metric&appid=$api_key");
                    if (!is_wp_error($weather)) {
                        $data = json_decode(wp_remote_retrieve_body($weather));
                        if (isset($data->main->temp)) {
                            $temp = $data->main->temp . '°C';
                            // Сохраняем данные в кэш на 10 минут
                            set_transient($cache_key, $data->main->temp, 10 * MINUTE_IN_SECONDS);
                        }
                    }
                }
            }

            echo "<tr><td>{$row->country}</td><td>{$row->city}</td><td>{$temp}</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php
do_action('after_cities_table');
get_footer();
?>
