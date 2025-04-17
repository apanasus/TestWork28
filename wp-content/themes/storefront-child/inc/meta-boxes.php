<?php
// Добавляет метабокс для ввода координат города
function city_location_meta_box() {
    add_meta_box(
        'city_location', // ID метабокса
        'City Location', // Заголовок метабокса
        'render_city_location_fields', // Функция для отображения полей
        'city', // Тип записи, к которому привязывается метабокс
        'normal', // Позиция метабокса
        'default' // Приоритет отображения
    );
}
add_action('add_meta_boxes', 'city_location_meta_box');

// Отображает поля для ввода широты и долготы
function render_city_location_fields($post) {
    $latitude = get_post_meta($post->ID, '_city_latitude', true); // Получение сохранённой широты
    $longitude = get_post_meta($post->ID, '_city_longitude', true); // Получение сохранённой долготы
    wp_nonce_field('save_city_location', 'city_location_nonce'); // Генерация nonce для защиты
    ?>
    <label for="city_latitude">Широта:</label>
    <input type="text" id="city_latitude" name="city_latitude" value="<?= esc_attr($latitude); ?>" /><br/><br/>
    <label for="city_longitude">Долгота:</label>
    <input type="text" id="city_longitude" name="city_longitude" value="<?= esc_attr($longitude); ?>" /><br/><br/>
    <button type="button" id="fetch_coordinates" class="button">Получить координаты</button>
    <script>
        //так как искать координаты в ручную неудобно то ставим другую апишку для автоподстановки данных
        document.getElementById('fetch_coordinates').addEventListener('click', function() {
            const cityName = document.getElementById('title').value; // Получаем название города из заголовка записи
            if (!cityName) {
                alert('Введите название города в заголовок записи.');
                return;
            }

            // Получаем настройки API из functions.php
            const apiSettings = <?php echo json_encode(get_geocoder_api_settings()); ?>;
            const apiKey = apiSettings.api_key;
            const baseUrl = apiSettings.base_url;

            // Формируем запрос
            const url = `${baseUrl}?q=${encodeURIComponent(cityName)}&key=${apiKey}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.results && data.results.length > 0) {
                        const location = data.results[0].geometry;
                        document.getElementById('city_latitude').value = location.lat;
                        document.getElementById('city_longitude').value = location.lng;
                    } else {
                        alert('Координаты не найдены.');
                    }
                })
                .catch(error => {
                    console.error('Ошибка при получении координат:', error);
                    alert('Не удалось получить координаты.');
                });
        });
    </script>
    <?php
}

// Сохраняет данные широты и долготы при сохранении записи
function save_city_location($post_id) {
    // Проверка nonce для защиты от CSRF
    if (!isset($_POST['city_location_nonce']) || !wp_verify_nonce($_POST['city_location_nonce'], 'save_city_location')) return;
    // Пропускаем автосохранение
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    // Сохраняем широту и долготу как мета-данные записи
    update_post_meta($post_id, '_city_latitude', sanitize_text_field($_POST['city_latitude']));
    update_post_meta($post_id, '_city_longitude', sanitize_text_field($_POST['city_longitude']));
}
add_action('save_post', 'save_city_location');

