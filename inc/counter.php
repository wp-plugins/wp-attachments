<?php

    function wpa_download_attachment_columns($columns) {
	$columns['wpa-download'] = __("Downloads");
	return $columns;
    }
    add_filter("manage_media_columns", "wpa_download_attachment_columns", null, 2);

    function wpa_download_show_column($name) {
        global $post;
        switch ($name) {
            case 'wpa-download':
                $value = '<center><span style="display: initial;" class="dashicons dashicons-download"></span> '.wpa_get_downloads($post->ID).'</center>';
                echo $value;
                break;
        }
    }
    add_action('manage_media_custom_column', 'wpa_download_show_column', null, 2);


?>