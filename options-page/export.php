<?php

if (!defined('ABSPATH')) exit;

function awun_export() {
    $all_options = [];
    foreach (AWUN_DISPLAY as $option_slug => $value) {
        $all_options[$option_slug] = get_option($option_slug, '');
    }
    return json_encode($all_options);
}

?>
<tr>
    <th colspan="2">
        <h1>Export your Options</h1>
        <p style="font-weight: 400">This is the area where your can Export all your options, please select the options you want to include in your export and follow the instructions.</p>
    </th>
</tr>
<tr>
    <th>
        <label>Data as text</label>
    </th>
    <td>
        <textarea name="awun-export-text" cols="120" rows="12"><?php 
            echo awun_export();
        ?></textarea>
    
        <p class="descripton">
            Please copy the options from this text field to an external file.
        </p>
    </td>
</tr>