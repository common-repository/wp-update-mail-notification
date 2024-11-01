<?php

require_once ABSPATH . 'wp-admin/includes/update.php';
require_once ABSPATH . 'wp-admin/includes/admin.php';

if (!defined('ABSPATH')) exit;

function awun_send_email() {

    if (awun_get_plugin_content() === false) {
        return "No Updates";
    }

    if (get_option('awun-is-active') !== 'on') {
        return 'Mailing functions are not enabled/approved';
    }

    $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
    $twig = new \Twig\Environment($loader);

    $headers = "Content-Type: text/html; charset=UTF-8";

    $emails = explode("\r\n", get_option('awun-mail'));

    $message = $twig->render('mail-template.twig', [
        'maintitle' => get_option('awun-mail-headline'),
        'subtitle' => get_option('awun-mail-subtitle'),
        'small_notice' => get_option("awun-small-notice"),
        'logo' => get_option('awun-logo'),
        'color' => get_option('awun-mail-color'),
        'plugins' => awun_get_plugin_content(),
        'body' => apply_filters('awun-mail-content', get_option('awun-mail-content-header')),
        'footer' => apply_filters('awun-mail-content', get_option('awun-mail-content-footer')),
    ]);

    $subject = apply_filters('awun-email-subject', get_option('awun-mail-subject'));

    $errors = 0;
    foreach ($emails as $email) {
        if (is_email($email)) {
            wp_mail($email, $subject, $message, $headers);
        } else {
            $errors++;
        }
    }

    $times = count($emails) - $errors;

    if ($errors === 0) {
        return "Success, sended $times e-mail(s)";
    } else {
        return "$errors e-mail(s) couldn't be sended, $times successful";
    }
}

add_action('awun-scheduled', 'awun_send_email');

function awun_get_plugin_content() {
    $plugins = awun_get_outdated_plugins();
    $plugin_content = '';
    $output = [];


    for ($i = 0; $i < count($plugins); $i++) {
        $plugin_extension_with_version = end(explode('.', $plugins[$i]['icon']));

        // gmail dosnt support SVGs
        if ( strpos($plugin_extension_with_version, 'svg') !== false ) {
            $icon = plugin_dir_url(__FILE__) . 'assets/placeholder.png';
        }

        else if ($plugins[$i]['icon']) {
            $icon = $plugins[$i]['icon'];
        } 
        
        else {
            $icon = plugin_dir_url(__FILE__) . 'assets/placeholder.png';
        }

        $title = $plugins[$i]['title'];
        $fulltitle = $title;

        if (strlen($title) > 25) {
            $title = substr($title, 0, 25) . '...';
        }

        $output[] = [
            'fulltitle' => $fulltitle,
            'title' => $title,
            'old' => $plugins[$i]['current-version'],
            'new' => $plugins[$i]['new-version'],
            'icon' => $icon,
            'last' => $i === count($plugins) - 1,
        ];
    }

    if (count($plugins) === 0) {
        return false;
    }
    return $output;
}

/** returns array with 'title', 'uri', 'current-version', 'new-version', 'icon', 'banner' */
function awun_get_outdated_plugins() {

    $updates = get_site_transient('update_plugins')->response;

    $all_plugins = get_plugins();
    $active_plugins = [];


    foreach($all_plugins as $path => $info) {
        if (is_plugin_active($path)) {
            if (!isset($updates[$path])) continue;
            if (!isset($info['Version'])) continue;

            $current_version = $info['Version'];
            $new_version = $updates[$path]->new_version;

            if ($current_version >= $new_version) continue;

            $active_plugins[] = [
                'title' => $info['Title'],
                'uri' => $info['PluginURI'],
                'current-version' => $current_version,
                'new-version' => $new_version,
                'icon' => $updates[$path]->icons['1x'],
                'banner' => $updates[$path]->banners['2x'],
            ];
        }
    }

    return $active_plugins;
}

function awun_mail_text_filter($content) {
    $content = str_replace("\r\n", '<br>', $content);
    $update_url = admin_url('plugins.php');
    $admin_url = admin_url('options-general.php?page=awun-admin-menu');

    $content = preg_replace('/\[ADMIN-LINK.([a-zA-Z]*)\]/', "<a href='$admin_url'>$1</a>", $content);
    $content = preg_replace('/\[UPDATE-LINK.([a-zA-Z]*)\]/', "<a href='$update_url'>$1</a>", $content);

    return $content;
}

add_filter('awun-mail-subject', 'awun_mail_text_filter');
add_filter('awun-mail-content', 'awun_mail_text_filter');
