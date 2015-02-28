<?php

	function wpatt_plugin_options()
    {
    
    if (!current_user_can('manage_options'))
        {
        
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
       
	    if (isset($_POST['wpatt_option_includeimages_n'])) {
            update_option('wpatt_option_includeimages', '1');
		} else {
			update_option('wpatt_option_includeimages', '0');
		}
		
		if (isset($_POST['wpatt_option_targetblank_n'])) {
            update_option('wpatt_option_targetblank', '1');
		} else {
			update_option('wpatt_option_targetblank', '0');
		}
	
	}
    
    
    
    echo '<div class="wrap">';
	
	echo '<div style="float:right;">
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="hidden" name="hosted_button_id" value="F2JK36SCXKTE2">
		<input type="image" src="https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png" border="0" name="submit" alt="PayPal - Il metodo rapido, affidabile e innovativo per pagare e farsi pagare.">
		</form>
		</div>';
    
    echo '<h2><strong>WP Attachments</strong><small> ' . get_option('wpa_version_number') . '</small> <a href="http://wordpress.org/support/view/plugin-reviews/wp-attachments" target="_blank" class="add-new-h2">Rate this plugin</a><a href="http://wordpress.org/plugins/wp-attachments/changelog/" target="_blank" class="add-new-h2">Changelog</a></h2>';
    
    echo '<form method="post" name="options" target="_self">
            <div id="welcome-panel" class="welcome-panel" style="padding: 5px 20px;">';
    
    settings_fields('wpatt_option_group');
    
    echo '

	<table class="form-table">
    
        <tr valign="top">

        <th scope="row">' . __('List Title','wp-attachments') . '</th>

        <td><input type="text" name="wpatt_option_localization_n" value="';
    
    echo get_option('wpatt_option_localization');
    
    echo '" />&nbsp;' . __('Insert here the title you want for the attachments list','wp-attachments') . '</td></tr>';
    
        echo '<tr><th scope="row">' . __('Include images','wp-attachments') . '</th>
        <td><input type="checkbox" name="wpatt_option_includeimages_n" ';
    $wpatt_option_includeimages_get = get_option('wpatt_option_includeimages');
    if ($wpatt_option_includeimages_get == '1') {
		echo 'checked=\'checked\'';
	}
    echo '/>&nbsp;' . __('Check this option if you want to include images (.jpg, .jpeg, .gif, .png) in the attachments list','wp-attachments') . '</td>';
    echo '</tr>';

    echo '<tr><th scope="row">' . __('Show date','wp-attachments') . '</th>
        <td><input type="checkbox" name="wpatt_option_showdate_n" ';
    $wpatt_option_showdate_get = get_option('wpatt_option_showdate');
    if ($wpatt_option_showdate_get == '1') {
		echo 'checked=\'checked\'';
	}
    echo '/>&nbsp;' . __('Check this if you want to show the date of file upload','wp-attachments') . '</td>';
    echo '</tr>';
	
	echo '<tr><th scope="row">' . __('Open in new tab','wp-attachments') . '</th>
        <td><input type="checkbox" name="wpatt_option_targetblank_n" ';
    $wpatt_option_targetblank_get = get_option('wpatt_option_targetblank');
    if ($wpatt_option_targetblank_get == '1') {
		echo 'checked=\'checked\'';
	}
    echo '/>&nbsp;' . __('Check this option if you want to add target="_blank" to every file listed in order to open it in a new tab','wp-attachments') . '</td>';
    echo '</tr></table>';
    
    
    
    echo '</table></div>
    <div style="float:right;">
    <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2FWPGov&amp;width&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false&amp;appId=262031607290004" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:258px;" allowTransparency="true"></iframe>
    </div>
    <p class="submit"><input type="submit" class="button-primary" name="Submit" value="' . __('Save Changes') . '" /></p></form>
    
    <div class="wrap about-wrap"><div class="about-text">
        <a href="http://wordpress.org/plugins/wp-attachments/" title "WP Attachments Wordpress Plugin>http://wordpress.org/plugins/wp-attachments/</a><br>
        Thank You for using this plugin!<br>
        If you like it, please leave a review or consider make a donation to keep it alive<br>
        <small><a href="http://marcomilesi.ml">Developed by Marco Milesi</a> &bull; <a href="http://facebook.com/WPGov">Follow us on Facebook</a></small>
    </div></div>';
    
    }
?>