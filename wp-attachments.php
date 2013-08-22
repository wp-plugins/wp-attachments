<?php
/*
Plugin Name: WP Attachments
Plugin URI: http://marcomilesi.ml
Description: Automatically shows you attachments under every post and pagec content. Simple. Automatic. Easy. As it has to be!
Author: Marco Milesi
Version: 3.0
Author URI: http://marcomilesi.ml
*/

function wpatt_format_bytes($a_bytes)
{
    if ($a_bytes < 1024) {
        return $a_bytes . ' B';
    } elseif ($a_bytes < 1048576) {
        return round($a_bytes / 1024, 2) . ' KB';
    } elseif ($a_bytes < 1073741824) {
        return round($a_bytes / 1048576, 2) . ' MB';
    } elseif ($a_bytes < 1099511627776) {
        return round($a_bytes / 1073741824, 2) . ' GB';
    } else {
        return round($a_bytes / 1208925819614629174706176, 2) . ' ERROR';
    }
}

add_action('template_redirect', 'wpatt_job_cpt_template');
function wpatt_job_cpt_template()
{
    global $wp, $wp_query;
    if (have_posts()) {
        add_filter('the_content', 'wpatt_job_cpt_template_filter');
    } else {
        $wp_query->is_404 = true;
    }
}

function wpatt_job_cpt_template_filter($content)
{
    global $wp_query;
    $jobID = $wp_query->post->ID;
    echo get_the_content();
    echo '<div style="width:100%;margin:10px 0 10px 0;"><h3>' . get_option('wpatt_option_localization') . '</h3></div>';
    $args        = array(
        'post_type' => 'attachment',
        'numberposts' => -1,
        'post_status' => null,
        'post_parent' => get_the_ID(),
        'orderby' => 'menu_order',
        'order' => 'desc'
    );
    $attachments = get_posts($args);
    if ($attachments) {
        foreach ($attachments as $attachment) {
            echo '<style>
	ul.post-attachments{list-style:none;margin:0;}
	li.post-attachment{background:url(' . plugin_dir_url(__FILE__) . 'icons/document.png) 0 4px no-repeat;padding-left:24px}	.post-attachment.mime-imagejpeg,.post-attachment.mime-imagepng{background-image:url(' . plugin_dir_url(__FILE__) . 'icons/document-image.png)}
	.post-attachment.mime-applicationzip{background-image:url(' . plugin_dir_url(__FILE__) . 'icons/document-zipper.png)}
	.post-attachment.mime-applicationpdf{background-image:url(' . plugin_dir_url(__FILE__) . 'icons/document-pdf.png)}
	.post-attachment.mime-applicationvnd-ms-excel{background-image:url(' . plugin_dir_url(__FILE__) . 'icons/document-excel.png)}
	.post-attachment.mime-applicationvnd-openxmlformats-officedocument-spreadsheetml-sheet{background-image:url(' . plugin_dir_url(__FILE__) . 'icons/document-excel.png)}
	.post-attachment.mime-applicationmsword{background-image:url(' . plugin_dir_url(__FILE__) . 'icons/document-word.png)}
	.post-attachment.mime-applicationvnd-openxmlformats-officedocument-wordprocessingml-document{background-image:url(' . plugin_dir_url(__FILE__) . 'icons/document-word.png)}
			</style>';
            echo '<ul class="post-attachments">';
            $class = "post-attachment mime-" . sanitize_title($attachment->post_mime_type);
            echo '<li class="' . $class . '"><a href="' . wp_get_attachment_url($attachment->ID) . '">';
            echo $attachment->post_title;
            echo '</a> (';
            echo wpatt_format_bytes(filesize(get_attached_file($attachment->ID)));
            $wpatt_option_showdate_get = get_option('wpatt_option_showdate');
            if ($wpatt_option_showdate_get == '1') {
                $wpatt_date = new DateTime($attachment->post_date);
                echo '<div style="float:right;">' . $wpatt_date->format('d.m.Y') . '</div>';
            }
            echo ')</li></ul>';
        }
    }
}

/* Register Settings */
add_action('admin_init', 'wpatt_reg_settings');
function wpatt_reg_settings()
{
    register_setting('wpatt_options_group', 'wpatt_option_showdate', 'intval');
    register_setting('wpatt_options_group', 'wpatt_option_localization');
    /* Preopulate 'Attachments' */
    $wpatt_option_showdate_get = get_option('wpatt_option_showdate');
    if (get_option('wpatt_option_localization') == '') {
        update_option('wpatt_option_localization', 'Attachments');
    }
}

/* Here starts the code for the option panel */

add_action('admin_menu', 'wpatt_plugin_menu');

function wpatt_plugin_menu()
{
    add_options_page('WP Attachments - Settings', 'WP Attachments', 'manage_options', 'wpatt-option-page', 'wpatt_plugin_options');
}

function wpatt_plugin_options()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    
    if (isset($_POST['Submit'])) {
        $wpatt_option_localization_get = $_POST["wpatt_option_localization_n"];
        update_option('wpatt_option_localization', $wpatt_option_localization_get);
        
        if (isset($_POST['wpatt_option_showdate_n'])) {
            update_option('wpatt_option_showdate', '1');
        } else {
            update_option('wpatt_option_showdate', '0');
        }
        
    }
    
    echo '<div class="wrap">';
    screen_icon();
    echo '<h2>Settings</h2>';
    echo '<div id="welcome-panel" class="welcome-panel">';
    echo '<form method="post" name="options" target="_self">';
    settings_fields('wpatt_option_group');
    echo '
	<table class="form-table">
	
        <tr valign="top">
        <th scope="row">Label for list header</th>
        <td><input type="text" name="wpatt_option_localization_n" value="';
    echo get_option('wpatt_option_localization');
    echo '" />&nbsp;Insert here the label you want to use for the title of the attachments list. Default "<b>Attachments</b>"</td></tr>';
    
    echo '<tr><th scope="row">Show date?</th>
        <td><input type="checkbox" name="wpatt_option_showdate_n" ';
    $wpatt_option_showdate_get = get_option('wpatt_option_showdate');
    if ($wpatt_option_showdate_get == '1') {
        echo 'checked=\'checked\'';
    }
    echo '/>&nbsp;Check this if you want to show when the file has been uploaded.</td>';
    echo '</tr></table>';
    
    echo '</table><p class="submit"><input type="submit" name="Submit" value="Update" /></p>';
    echo '</form></div></div>';
}

?>  