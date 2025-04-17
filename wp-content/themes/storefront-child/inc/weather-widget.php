<?php
class City_Weather_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct('city_weather_widget', 'City Weather Widget');
    }

    public function form($instance) {
        $selected_city = !empty($instance['city_id']) ? $instance['city_id'] : '';
        $cities = get_posts(['post_type' => 'city', 'numberposts' => -1]);
        ?>
        <p>
            <label for="<?= $this->get_field_id('city_id'); ?>">Select City:</label>
            <select name="<?= $this->get_field_name('city_id'); ?>" id="<?= $this->get_field_id('city_id'); ?>">
                <?php foreach ($cities as $city): ?>
                    <option value="<?= $city->ID; ?>" <?= selected($selected_city, $city->ID); ?>><?= $city->post_title; ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        return ['city_id' => strip_tags($new_instance['city_id'])];
    }

    public function widget( $args, $instance ) {
        echo $args['before_widget'];

        $city_id = intval( $instance['city_id'] );
        $title   = get_the_title( $city_id );
        $lat     = get_post_meta( $city_id, '_city_latitude', true );
        $lon     = get_post_meta( $city_id, '_city_longitude', true );

        if ( '' === $lat || '' === $lon ) {
            echo '<p>Coordinates not set for this city.</p>';
            echo $args['after_widget'];
            return;
        }

        // Получаем настройки API из функции
        $settings = get_weather_api_settings();
        $api_key  = $settings['api_key'];
        $base_url = $settings['base_url'];

        $endpoint = add_query_arg([
            'lat'   => $lat,
            'lon'   => $lon,
            'units' => 'metric',  // metric для Цельсия
            'appid' => $api_key,
            'lang'  => 'ru',      // ру локализация
        ], $base_url);

        $response = wp_remote_get( $endpoint, [ 'timeout' => 5 ] );

        // Отладка ошибок
        if ( is_wp_error( $response ) ) {
            echo '<p>Error: Unable to connect to weather service.</p>';
            echo $args['after_widget'];
            return;
        }

        $code = wp_remote_retrieve_response_code( $response );
        if ( 200 !== $code ) {
            echo "<p>Error: API returned status {$code}.</p>";
            echo $args['after_widget'];
            return;
        }

        $data = json_decode( wp_remote_retrieve_body( $response ) );
        if ( json_last_error() !== JSON_ERROR_NONE ) {
            echo '<p>Error: Invalid JSON response.</p>';
            echo $args['after_widget'];
            return;
        }

        // Берём только описание и температуру
        $desc = $data->weather[0]->description ?? 'No description';
        $temp = isset( $data->main->temp ) ? round( $data->main->temp ) : 'N/A';

        // Выводим виджет
        if ( $title ) {
            echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
        }
        echo "<p>{$desc}, {$temp}&deg;C</p>";

        echo $args['after_widget'];
    }
    
}
add_action('widgets_init', function() {
    register_widget('City_Weather_Widget');
});

 
