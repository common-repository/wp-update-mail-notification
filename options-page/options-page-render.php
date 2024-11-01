<?php

require_once 'custom-options.php';

if (!defined('ABSPATH')) exit;

function awun_render_string($slug) {
	$value = get_option($slug);

	$title = awun_format_string(
		AWUN_DISPLAY[$slug][0]
	);

	$description = awun_format_string(
		AWUN_DISPLAY[$slug][1]
	);

	$class = '';
	if (isset(AWUN_DISPLAY[$slug]['class'])) {
		$class .= ' ' . AWUN_DISPLAY[$slug]['class'];
	}

	echo "
		<tr>
			<th>
				<label for='$slug'>$title</label>
			</th>
			<td>
				<input type='text' class='$class' name='$slug' value='$value'>
				<p class='description'>$description</p>
			</td>
		</td>
	";
}

function awun_render_integer($slug) {
	$value = get_option($slug);

	$title = awun_format_string(
		AWUN_DISPLAY[$slug][0]
	);

	$description = awun_format_string(
		AWUN_DISPLAY[$slug][1]
	);

	echo "
		<tr>
			<th>
				<label for='$slug'>$title</label>
			</th>
			<td>
				<input type='number' name='$slug' value='$value'>
				<p class='description'>$description</p>
			</td>
		</td>
	";
}

function awun_render_dropdown($slug) {
	$value = get_option($slug);

	$title = awun_format_string(
		AWUN_DISPLAY[$slug][0]
	);

	$description = awun_format_string(
		AWUN_DISPLAY[$slug][1]
	);

	$options_html = '';
	$options = AWUN_DISPLAY[$slug]['options'];

	foreach($options as $option => $nice_name) {
		if ($value == $option) {
			$selected = 'selected="selected"';
		} else {
			$selected = '';
		}
		$options_html .= "<option value='$option' $selected>$nice_name</option>";
	}

	echo "
		<tr>
			<th>
				<label for='$slug'>$title</label>
			</th>
			<td>
				<select name='$slug'>$options_html</select>
				<p class='description'>$description</p>
			</td>
		</td>
	";
}

function awun_render_textarea($slug) {
	$value = get_option($slug);

	$title = awun_format_string(
		AWUN_DISPLAY[$slug][0]
	);

	$description = awun_format_string(
		AWUN_DISPLAY[$slug][1]
	);

	$class = '';
	if (isset(AWUN_DISPLAY[$slug]['class'])) {
		$class .= ' ' . AWUN_DISPLAY[$slug]['class'];
	}

	echo "
		<tr>
			<th>
				<label for='$slug'>$title</label>
			</th>
			<td>
				<textarea class='large-text $class' name='$slug' rows='8'>$value</textarea>
				<p class='description'>$description</p>
			</td>
		</td>
	";
}

function awun_render_bool($slug) {
	$value = get_option($slug);

	$title = awun_format_string(
		AWUN_DISPLAY[$slug][0]
	);

	$description = awun_format_string(
		AWUN_DISPLAY[$slug][1]
	);

	if ($value === 'on') {
		$checked = 'checked="checked"';
	} else {
		$checked = '';
	}

	$checkbox_text = AWUN_DISPLAY[$slug]['checkbox_text'];

	echo "
		<tr>
			<th>
				<label for='$slug'>$title</label>
			</th>
			<td>
				<label>
					<input type='checkbox' name='$slug' $checked> $checkbox_text
				</label>
				<p class='description'>$description</p>
			</td>
		</td>
	";
}


function awun_render_custom($slug) {
	$value = get_option($slug);

	$title = awun_format_string(
		AWUN_DISPLAY[$slug][0]
	);

	$description = awun_format_string(
		AWUN_DISPLAY[$slug][1]
	);

	$html = AWUN_DISPLAY[$slug]['html'];

	echo "
		<tr>
			<th>
				<label for='$slug'>$title</label>
			</th>
			<td>
				$html
			</td>
		</td>
	";
}

function awun_render_custom_full($slug) {
	$value = get_option($slug);
	$html = AWUN_DISPLAY[$slug]['html'];

	echo "
		<tr>
			<th>$html</th>
		</td>
	";
}

function awun_render_wysiwyg($slug) {
	$value = get_option($slug);

	$title = awun_format_string(
		AWUN_DISPLAY[$slug][0]
	);

	$description = awun_format_string(
		AWUN_DISPLAY[$slug][1]
	);

	$rows = 8;

	if (isset(AWUN_DISPLAY[$slug]['rows'])) {
		$rows = AWUN_DISPLAY[$slug]['rows'];
	}

	echo "<tr><th><label for='$slug'>$title</label></th><td>";

	wp_editor($value, $slug, [
		'textarea_rows'=> $rows
	]);

	echo "<p class='description'>$description</p></td></td>";
}
