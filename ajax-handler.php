<?php

if (!defined('ABSPATH')) exit;

function awun_import_settings() {

    if (empty($_POST['options'])) {
        wp_send_json([
            'status' => 'Error - Empty options: please insert some data.'
        ]);
    }
    
    $data = json_decode(stripslashes($_POST['options']));

    if ($data === null) {
        wp_send_json([
            'status' => 'Error - Unvalid format: please check your imput.',
            'data' => $data,
            'options' => stripslashes($_POST['options'])
        ]);
    }

    foreach ($data as $option_slug => $value) {
        update_option($option_slug, $value);
    }

    wp_send_json([
        'status' => 'success'
    ]);
}

add_action('wp_ajax_awun_import_settings', 'awun_import_settings');