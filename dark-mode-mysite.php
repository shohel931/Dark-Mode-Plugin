<?php 
/*
* Plugin Name: Dark Mode Mysite
* Plugin URI: https://wordpress.org/plugins/dark-mode-mysite
* Description: A simple plugin to toggle dark mode on your WordPress site.
* Version: 1.0.0
* Requires at least: 5.2
* Requires PHP: 7.2
* Author: Shohel Rana
* Author URI: https://shohelrana.top
* License: GPLv2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: dark-mode-mysite
*/



// Css and Js Load
function dmms_enqueue_scripts(){
    // Enqueue the dark mode CSS
    wp_enqueue_style('dark-mode-mysite-style', plugin_dir_url(__FILE__) . 'css/dark-mode-mysite-style.css');

    // Enqueue the dark mode toggle script
    wp_enqueue_script('dark-mode-mysite-script', plugin_dir_url(__FILE__) . 'js/dark-mode-mysite-script.js', array('jquery'), null, true);

}
add_action('wp_enqueue_scripts', 'dmms_enqueue_scripts');




// body class for dark mode
function dmms_body_class($classes) {
    $style = get_option('dmms_dark_mode_style', 'default');
    if ($style === 'dark') {
        $classes[] = 'dark-mode';
    } elseif ($style === 'light') {
        $classes[] = 'light-mode';
    }
    return $classes;

}
add_filter('body_class', 'dmms_body_class');

// toggle button 
function dmms_toggle_button() {
    $enabled = get_option('dmms_toggle_button');
    if ($enabled) {
        echo '<button id="dmms-toggle-button" class="dmms-toggle-button">Toggle Dark Mode</button>';
    }
}
add_action('wp_footer', 'dmms_toggle_button');


// Admin Menu 
function dmms_add_admin_menu() {
    add_menu_page(
        'Dark Mode Mysite',       // Page Title
        'Dark Mode',              // Menu Title
        'manage_options',           // Capability
        'dmms_main_menu',            // Menu slug
        'dmms_settings_page',        // Callback function
        'dashicons-lightbulb',      // Icon
        60                          // Position
    );
    add_submenu_page(
        'dmms_main_menu',           // Parent slug
        'Settings',             // Page title
        'Settings',             // Menu title
        'manage_options',           // Capability
        'dmms_settings',        // Menu slug
        'dmms_settings_page'    // Callback function    
    );

}
add_action('admin_menu', 'dmms_add_admin_menu');



// Settings Page Callback
function dmms_settings_page() {
    ?>

     <div class="wrap">
        <h2>Dark Mode Settings</h2>
        <form action="options.php" method="post">
            <?php 
            settings_fields('dmms_settings_group'); 
            do_settings_sections('dmms_settings');
            submit_button('Save Changes');
             ?>
        </form>
     </div>

    <?php
}
    





// // Enqueue Admin Scripts and Styles
// function dmms_enqueue_admin_scripts($hook) {     
//     if ($hook != 'toplevel_page_dmms_main_menu' && $hook != 'dark-mode-mysite_page_dmms_social_share' && $hook != 'dark-mode-mysite_page_dmms_upgrade') {
//         return;
//     }
    
//     wp_enqueue_style('dmms-admin-style', plugin_dir_url(__FILE__) . 'css/admin-style.css');
//     wp_enqueue_script('dmms-admin-script', plugin_dir_url(__FILE__) . 'js/admin-script.js', array('jquery'), null, true);
// }   
// add_action('admin_enqueue_scripts', 'dmms_enqueue_admin_scripts');















?>