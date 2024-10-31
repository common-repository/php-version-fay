<?php
/**
 * Plugin Name:       Php Version Fay
 * Plugin URI:        https://wordpress.org/plugins/fay-chat/
 * Description:       Php Version Fay is a simple yet powerful WordPress plugin that displays important information about your PHP, database and server on the WordPress Dashboard.
 * Version:           1.10.5
 * Requires at least: 4.6
 * Requires PHP:      5.0.0
 * Author:            ByteLabX
 * Author URI:        https://bytelabx.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       php-version-fay
 */

if (!defined('ABSPATH')) {
    die('You cannot jump here!!');
}


add_action('wp_dashboard_setup', 'php_vr_fay_custom_dashboard_widgets');

function php_vr_fay_custom_dashboard_widgets()
{
    wp_add_dashboard_widget('php-version-fay', 'PHP & Server Information',
        'php_vr_fay_custom_dashboard_help');
}

add_action('admin_head', 'php_vr_fay_custom_css');

function php_vr_fay_custom_css() {
    $screen = get_current_screen();
    if ($screen -> id == "dashboard") {
        echo '<style>
            #php-version-fay .postbox-header {
                background: #4C24CB;
            }
            #php-version-fay .postbox-header > .ui-sortable-handle{
                color: white; 
            }
            #php-version-fay .postbox-header .hide-if-no-js button{
   
                color: white; 
            }
            #php-version-fay .postbox-header .hide-if-no-js button > .toggle-indicator{
   
                color: white; 
            }
          </style>';
    }
}


function php_vr_fay_custom_dashboard_help()
{

    if (is_admin()) {

        $php_vr_fay = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $php_vr_fay_database = mysqli_get_server_info($php_vr_fay);
//       MariaDB or MySQL database check
        if (strpos($php_vr_fay_database, "mariadb") !== false || strpos($php_vr_fay_database, "MariaDB") !== false) {
            $db_version_fay = "MariaDB Version : " . $php_vr_fay_database;
        } else {
            $db_version_fay = "MySQL Version : " . $php_vr_fay_database;
        }

        $db_SERVER_SOFTWARE_fay = "SERVER_SOFTWARE: " . sanitize_text_field($_SERVER["SERVER_SOFTWARE"]);


        $db_DOCUMENT_ROOT_fay = "DOCUMENT_ROOT: " . sanitize_text_field($_SERVER["DOCUMENT_ROOT"]);

        ?>

        <div class="wordpress-news hide-if-no-js">
            <div class="rss-widget">
                <ul>
                    <li>
                        <?php echo "<p>" . esc_html("Current PHP version: " . sanitize_text_field(phpversion())) . "</p>";         ?>
                    </li>
                    <li>
                        <?php  echo "<p>" . esc_html("Current PHP version: " . sanitize_text_field(phpversion())) . "</p>";       ?>
                    </li>

                    <li>
                        <?php  echo "<p>" . esc_html($db_version_fay) . "</p>";   ?>
                    </li>
                    <li>
                        <?php echo "<p>" . esc_html("upload_max_filesize: " . sanitize_text_field(ini_get("upload_max_filesize"))) . "</p>";   ?>
                    </li>
                    <li>
                        <?php echo "<p>" . esc_html("post_max_size: " . sanitize_text_field(ini_get("post_max_size"))) . "</p>";    ?>
                    </li>
                    <li>
                        <?php   echo "<p>" . esc_html("max_execution_time: " . sanitize_text_field(ini_get("max_execution_time"))) . "</p>";  ?>
                    </li>
                    <li>
                        <?php   echo "<p>" . esc_html($db_SERVER_SOFTWARE_fay) . "</p>"; ?>
                    </li>
                    <li>
                        <?php echo "<p>" . esc_html($db_DOCUMENT_ROOT_fay) . "</p>"; ?>
                    </li>
                </ul>
            </div>

        </div>


        <?php

    } else {
        _e("<p>" . esc_html("Only admin can access the server info.") . "<p>", 'php-version-fay');
    }

    _e("<p>" . esc_html("Free support at => ") . esc_html("plugin@bytelabx.com") . "</p>", 'php-version-fay');




}