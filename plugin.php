<?php

/**
 *
 * Email Notifications for Updates
 *
 * @package     Email Notifications for Updates
 * @author      AWEOS GmbH
 * @copyright   2019 AWEOS GmbH
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Email Notifications for Updates
 * Description: Automatic E-mail notifications for outdated plugins. Select multiple recipients and use our beautiful E-mail layout with plugin thumbnails.
 * Version:     1.1.6
 * Author:      AWEOS GmbH
 * Author URI:  https://aweos.de
 * Text Domain: awun-domain
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 */

require_once 'options-page/options-page.php';
require_once 'options-page/custom-options.php';
require_once 'enqueue.php';
require_once 'mailing.php';
require_once 'ajax-handler.php';
require_once 'vendor/autoload.php';

if (!defined('ABSPATH')) exit;

function awun_on_activation() {
    // catch old wordpress version
	if ( version_compare(get_bloginfo('version'), '4.7', '<') ) {
		wp_die('Please update WordPress to use this plugin');
	}

	// remove default values (DEBUG)
	// awun_on_uninstall();

    // add default values
    foreach (AWUN_DISPLAY as $option => $config) {
        if (!isset($config['default'])) continue;
        $default = $config['default'];
        add_option($option, $default);
    }

    // more defualt values
    add_option('awun_last_sended', time());
	awun_update_mail_schedule();
}

register_activation_hook(__FILE__, 'awun_on_activation');

function awun_plugin_action_link($actions) {
    $settings_url = admin_url('options-general.php?page=awun-admin-menu');
    $settings_text = esc_html__('Settings', 'awun-domain');

    $actions['settings'] = "<a href='$settings_url'>$settings_text</a>";
    return $actions;
}

add_filter('plugin_action_links_' . plugin_basename( __FILE__ ), 'awun_plugin_action_link');

function awun_user_defined_schedule($schedules) {

    $schedules['awun_each_3_days'] = [
        'interval' => 3 * DAY_IN_SECONDS,
        'display'  => esc_html__( 'Once each 3 days' ),
    ];

    $schedules['awun_each_5_days'] = [
        'interval' => 5 * DAY_IN_SECONDS,
        'display'  => esc_html__( 'Once each 5 days' ),
    ];

    $schedules['awun_each_7_days'] = [
        'interval' => 7 * DAY_IN_SECONDS,
        'display'  => esc_html__( 'Once each 7 days' ),
    ];

    $schedules['awun_each_10_days'] = [
        'interval' => 10 * DAY_IN_SECONDS,
        'display'  => esc_html__( 'Once each 10 days' ),
    ];

    $schedules['awun_each_14_days'] = [
        'interval' => 14 * DAY_IN_SECONDS,
        'display'  => esc_html__( 'Once each 14 days' ),
    ];

    return $schedules;
}

add_filter('cron_schedules', 'awun_user_defined_schedule');

function awun_on_uninstall() {

    // remove default values
    foreach (AWUN_DISPLAY as $option => $config) {
        delete_option($option);
    }
}

register_uninstall_hook(__FILE__, 'awun_on_uninstall');

function awun_on_deactivation() {
    wp_clear_scheduled_hook('awun-scheduled');
}

register_deactivation_hook(__FILE__, 'awun_on_deactivation');

function awun_send_test_email() {
    echo awun_send_email();
    die;
}

add_action('wp_ajax_awun-send-test-email', 'awun_send_test_email');

function awun_load_textdomain() {
    load_plugin_textdomain('awun-domain', false, basename(dirname(__FILE__)) . '/languages');
}

add_action('plugins_loaded', 'awun_load_textdomain');
