<?php

require_once 'custom-options.php';
require_once 'options-page-render.php';

if (!defined('ABSPATH')) exit;

function awun_create_menu() {

	 add_options_page(
		'E-Mail Notifications for Updates',
		'E-Mail Notifications for Updates',
		'activate_plugins',
		'awun-admin-menu',
		'awun_settings'
	);

	add_action( 'admin_init', 'awun_register_setting' );
}

add_action('admin_menu', 'awun_create_menu');

function awun_update_mail_schedule() {

	wp_clear_scheduled_hook('awun-scheduled');

	$event = get_option('awun-schedule');

	if ($event == 'awun_each_3_days') {
		wp_schedule_event(time() + (3 * DAY_IN_SECONDS), $event, 'awun-scheduled');
	}

	else if ($event == 'awun_each_5_days') {
		wp_schedule_event(time() + (5 * DAY_IN_SECONDS), $event, 'awun-scheduled');
	}

	else if ($event == 'awun_each_7_days') {
		wp_schedule_event(time() + (7 * DAY_IN_SECONDS), $event, 'awun-scheduled');
	}

	else if ($event == 'awun_each_10_days') {
		wp_schedule_event(time() + (10 * DAY_IN_SECONDS), $event, 'awun-scheduled');
	}

	else {
		wp_schedule_event(time() + (14 * DAY_IN_SECONDS), $event, 'awun-scheduled');
	}
}

function awun_register_setting() {
	foreach (AWUN_DISPLAY as $slug => $option) {
		register_setting('awun-group', $slug);
	}
	register_setting('awun-group', 'awun-export-text');
	register_setting('awun-group', 'awun-inport-text');
}

function awun_show_import_settings() {
	require_once __DIR__ . '/import.php';
}

function awun_show_export_settings() {
	require_once __DIR__ . '/export.php';	
}

function awun_settings() {
?>
<style>
	.awun-action.page-title-action.active {
		/* background-color: #00A0D2;
		color: white; */
		border-color: #008ec2;
	}
</style>
<div class="wrap">
	<h1>
		<?php 
			esc_html_e('WP Update Notification per Mail', 'awun-domain'); 

			$awun_import_is_active = '';
			$awun_export_is_active = '';

			if (isset($_GET['action']) && $_GET['action'] === 'import') {
				$awun_import_is_active = 'active';
			} 
			
			else if (isset($_GET['action']) && $_GET['action'] === 'export') {
				$awun_export_is_active = 'active';
			}

			$awun_import_link = admin_url('options-general.php?page=awun-admin-menu&action=import');
			$awun_export_link = admin_url('options-general.php?page=awun-admin-menu&action=export');

			echo "<a class='awun-action page-title-action $awun_import_is_active' href='$awun_import_link'>Import Options </a>";
			echo "<a class='awun-action page-title-action $awun_export_is_active' href='$awun_export_link'>Export Options </a>";
		?>
	</h1>
	<p><?php
	echo sprintf(
		esc_html__(
			"Welcome to the admin area from 'WP Update Notification per Mail', you can configure this plugin with multiple recipients and a custom schedule. %s Dont forget to test the e-mail to see if you configured something wrong and the e-mail is not going out",
			'awun-domain'
		),
		'<br>'
	);
	?></p>
	<form method="post" action="options.php">

        <?php

	    settings_fields( 'awun-group' );
		do_settings_sections( 'awun-group' );

        ?>

        <div class="wrap">
            <table class="form-table">
                <?php

				if (isset($_GET['action'])) {
					$action = $_GET['action'];
					if ($action === 'import') {
						awun_show_import_settings();
					} else if ($action === 'export') {
						awun_show_export_settings();
					} else {
						echo '<h4>Your URL path is wrong, please go <a href="/wp-admin">back</a></h4>';
					}

					echo '</table>';

					return;
				}

				awun_auto_print_fields();
				awun_update_mail_schedule();

				?>
    	    </table>
        </div>
        <?php submit_button(); ?>
	</form>
</div>
<?php
}

function awun_auto_print_fields() {
	foreach (AWUN_DISPLAY as $slug => $option) {
		if (isset(AWUN_DISPLAY[$slug]['type'])) {
			$type = AWUN_DISPLAY[$slug]['type'];
		} else {
			$type = gettype($option['default']);
		}

		if ($type === 'string') awun_render_string($slug);
		if ($type === 'integer') awun_render_integer($slug);
		if ($type === 'textarea') awun_render_textarea($slug);
		if ($type === 'wysiwyg') awun_render_wysiwyg($slug);
		if ($type === 'dropdown') awun_render_dropdown($slug);
		if ($type === 'bool') awun_render_bool($slug);
		if ($type === 'custom') awun_render_custom($slug);
		if ($type === 'custom-full') awun_render_custom_full($slug);
	}
}

function awun_format_string($desc) {
	$output = $desc;
	$output = str_replace('[LINE-BREAK]', '<br>', $output);
	$output = str_replace("\r\n", '<br>', $output);

	$output = str_replace('[BOLD]', '<strong>', $output);
	$output = str_replace('[ENDBOLD]', '</strong>', $output);

	$update_url = admin_url('plugins.php');
	$output = str_replace('[UPDATE-LINK]', "<a href='$update_url'>$update_url</a>", $output);

	return $output;
}
