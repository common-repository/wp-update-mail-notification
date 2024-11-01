<?php

if (!defined('ABSPATH')) exit;

?>

<tr>
    <th>
        <label>Import</label>
    </th>
    <td>
        <textarea class="awun-import-text" name="awun-import-text" cols="120" rows="12"><?php 
            echo get_option('awun-import-text');
        ?></textarea>

        <p class="descripton">
            Please paste your previously copied data into this textarea.
        </p>
        
        <button class="submit button awun-import" style="margin-top: 15px">Import Now</button>
    </td>
</tr>

<script>
    jQuery(function ($) {
        $('.awun-import').click(function (e) {
            e.preventDefault();
            var self = this;
            var data = {
                'options' : $('.awun-import-text').val()
            };

            $(self).after('<p class="awun-loading">Connecting with database...</p>');

            <?php
            
            $awar_options_url = admin_url('options-general.php?page=awun-admin-menu') ;
            $awar_admin_ajax = admin_url('admin-ajax.php');
            
            ?>

            $.post('<?php echo $awar_admin_ajax ?>?action=awun_import_settings', data, function (response) {
                $('.awun-loading').remove();
                if (response.status === 'success') {
                    $(self).after(
                        '<p style="color: green">Your import was Successful! <a href="<?php echo $awar_options_url ?>">Go Back</a></p>'
                    );
                } else {
                    $(self).after('<p style="color: red">' + response.status + '</p>');
                }
            });
            
            return false;
        });
    });
</script>