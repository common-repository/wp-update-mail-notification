<?php

if ( !defined( 'ABSPATH' ) ) exit;

function awun_admin_enqueue() {
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_script('awun-options-page', plugin_dir_url(__FILE__) . 'options-page/options-page.js', ['wp-color-picker'], '', true);
}

add_action('admin_enqueue_scripts', 'awun_admin_enqueue');
