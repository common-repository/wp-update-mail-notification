<?php

if (!defined('ABSPATH')) exit;

define('AWUN_DEFAULT_EMAIL_CONTENT_HEADER', __("
Dear WordPress user,

This is an automatic generated E-Mail. There are new Updates for your website available. You should check these updates and install them if necessary, in order to protect yourself against any security gaps and also hacker attacks.

If you are not a web developer, please consider hiring one for this task.

<strong>Please be aware, that updating can lead to visual and fatal problems!</strong>
", 'awun-domain'));

define('AWUN_DEFAULT_EMAIL_CONTENT_FOOTER', __("
You can update your WordPress-Plugins [UPDATE-LINK here]

If you want to configure your E-Mail settings, you can do this [ADMIN-LINK here]
", 'awun-domain'));

define('AWUN_DEFAULT_EMAIL_SUBJECT', __("New Updates Available | WordPress Update Notification per Mail", 'awun-domain'));

define('AWUN_DISPLAY', [
    'awun-is-active' => [
        __('Plugin is active', 'awun-domain'),
        __('We recommend you to to check and approve your options before you activate this plugin, the initial e-mail should be sended after the schedule is over.', 'awun-domain'),
        'type' => 'bool',
        'checkbox_text' => __('Activate the automatic e-mail notifications', 'awun-domain'),
    ],
    'awun-send-all-button' => [
        '',
        '',
        'type' => 'custom',
        'html' => '
            <button class="button awun-send-test-email">
                Send a test E-Mail to all recipients
            </button>
        ',
    ],
    'awun-mail' => [
        __('E-Mail Recipients', 'awun-domain'),
        __('Put each E-Mail in a seperate line if you want the E-Mail to be sended to multiple people.', 'awun-domain'),
        'type' => 'textarea',
        'class' => 'awun-email-recipients',
        'default' => get_bloginfo('admin_email'),
    ],
    'awun-save-settings-1' => [
        '',
        '',
        'type' => 'custom-full',
        'html' => '<input type="submit" name="submit" class="button button-primary" value="Save Changes"><br><br><br><br>',
    ],
    'awun-schedule' => [
        __('Schedule', 'awun-domain'),
        __('Insert the schedule you want to get notified.'),
        'type' => 'dropdown',
        'options' => [
            // IMPORTANT: if you want to add more schedules, also edit plugin.php
            'awun_each_3_days' => 'Every 3 Days',
            'awun_each_5_days' => 'Every 5 Days',
            'awun_each_7_days' => 'Every 7 Days',
            'awun_each_10_days' => 'Every 10 Days',
            'awun_each_14_days' => 'Every 14 Days',
        ],
        'default' => 'awun_each_10_days',
    ],
    'awun-logo' => [
        __('Logo', 'awun-domain'),
        __('Insert an URL for your logo, the logo will be placed at the top of your e-mail template.', 'awun-domain'),
        'class' => 'large-text',
        'default' => '',
    ],
    'awun-mail-color' => [
        __('Mail Color', 'awun-domain'),
        __('Color for the banner on top of the e-mail template, the banner comes together with the logo. That means if you dont have a logo there will be no banner.', 'awun-domain'),
        'default' => '#0077c8',
        'class' => 'awun-color-picker',
    ],
    'awun-save-settings-2' => [
        '',
        '',
        'type' => 'custom-full',
        'html' => '<input type="submit" name="submit" class="button button-primary" value="Save Changes"><br><br><br><br>',
    ],
    'awun-mail-subject' => [
        __('E-Mail Subject', 'awun-domain'),
        __('Type in your E-Mail Subject, we recommend to insert about 7 words.', 'awun-domain'),
        'class' => 'large-text',
        'default' => AWUN_DEFAULT_EMAIL_SUBJECT,
    ],
    'awun-mail-headline' => [
        __('E-Mail Headline', 'awun-domain'),
        __('Headline inside the E-Mails body.', 'awun-domain'),
        'class' => 'large-text',
        'default' => 'WordPress Updates'
    ],
    'awun-mail-subtitle' => [
        __('E-Mail Subtitle', 'awun-domain'),
        __('Subtitle placed after the headline.', 'awun-domain'),
        'class' => 'large-text',
        'default' => 'Please check your admin dashboard'
    ],
    'awun-small-notice' => [
        __('E-Mail Upper Subtitle (Small notice)', 'awun-domain'),
        __('Subtitle placed over the plugin list.', 'awun-domain'),
        'class' => 'large-text',
        'default' => 'Plugin Updates'
    ],
    'awun-mail-content-header' => [
        __('E-Mail Content Header', 'awun-domain'),
        __('Write the content that will be sended via E-Mail, this text will appear above the plugin list and should probable tell the reciepents: that this is an automated e-mail,  recommend to install the new versions, warn about incompatibility problems.', 'awun-domain'),
        'type' => 'wysiwyg',
        'rows' => '15',
        'default' => AWUN_DEFAULT_EMAIL_CONTENT_HEADER,
    ],
    'awun-mail-content-footer' => [
        __('E-Mail Content Footer', 'awun-domain'),
        __('Write the content that will be sended via E-Mail, this text will appear under the plugin list and will be colored lite gray, this can be the right place for legal disclosures but also a few links like the plugin and admin pages. Use [UPDATE-LINK click-here] to get a link to the /plugins.php page and [ADMIN-LINK click-here] for the /wp-admin area, where the second part is an individual anchor-text.', 'awun-domain'),
        'type' => 'wysiwyg',
        'rows' => '6',
        'default' => AWUN_DEFAULT_EMAIL_CONTENT_FOOTER,
    ],
]);
