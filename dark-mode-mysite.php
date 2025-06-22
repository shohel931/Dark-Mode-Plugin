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
    // Font Awesome 
    wp_enqueue_style('dmms-font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css');


    // Enqueue the dark mode CSS
    wp_enqueue_style('dark-mode-mysite-style', plugin_dir_url(__FILE__) . 'css/dark-mode-mysite-style.css');

    // Enqueue the dark mode toggle script
    wp_enqueue_script('dark-mode-mysite-script', plugin_dir_url(__FILE__) . 'js/dark-mode-mysite-script.js', array('jquery'), null, true);

}
add_action('wp_enqueue_scripts', 'dmms_enqueue_scripts');



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




// body class for dark mode
function dmms_body_class($classes) {
    $style = get_option('dmms_switch_style', 'style1');
     $classes[] = 'dms-' . esc_attr($style);
    return $classes;

}
add_filter('body_class', 'dmms_body_class');

// toggle button 
function dmms_toggle_button() {
    $enabled = get_option('dmms_toggle_button');
    $position = get_option('dmms_button_position', 'bottom-right');
    if ($enabled) {
        echo '<button id="dmms-toggle-button" style="border: none;" class="dmms-toggle-button ' . esc_attr($position) . '">Dark</button>';
    }
}
add_action('wp_footer', 'dmms_toggle_button');


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
    


// Settings Register
function dmms_register_settings(){
    register_setting('dmms_settings_group', 'dmms_enable');
    register_setting('dmms_settings_group', 'dmms_toggle_button');
    register_setting('dmms_settings_group', 'dmms_dark_mode_style');
    register_setting('dmms_settings_group', 'dmms_switch_style');
    register_setting('dmms_settings_group', 'dmms_button_position');

    
    add_settings_section('dmms_main_section', 'Main Settings', null, 'dmms_settings');

    // Enable Dark Mode
    add_settings_field('dmms_enable',' Enable Dark Mode', function(){
       $checked = get_option('dmms_enable');
       echo '<input type="checkbox" name="dmms_enable" value="1"' . checked(1, $checked, false) . '> Enable';

    }, 'dmms_settings', 'dmms_main_section');

    // Button Hide Show
    add_settings_field('dmms_toggle_button', 'Show Toggle Button', function() {
        $checked = get_option('dmms_toggle_button');
        echo '<input type="checkbox" name="dmms_toggle_button" value="1"' . checked(1, $checked, false) . '> Show';

    }, 'dmms_settings', 'dmms_main_section');

    // Dark / Light Mode
    add_settings_field('dmms_dark_mode_style', 'Default Style', function(){
        $value = get_option('dmms_dark_mode_style', 'light');
        echo '<select name="dmms_dark_mode_style">
           <option value="light"' . selected($value, 'light', false) . '>Light</option>
           <option value="dark"' . selected($value, 'dark', false) . '>Dark</option>
        </select>';
    }, 'dmms_settings', 'dmms_main_section');

    // Button Style
    add_settings_field('dmms_switch_style', 'Button Style', function(){
       $style = get_option('dmms_switch_style', 'style1');
       ?>
       <select name="dmms_switch_style">
               <option value="style1" <?php selected($style, 'style1'); ?>>Style 1 (Default)</option>
               <option value="style2" <?php selected($style, 'style2'); ?>>Style 2 (icon)</option>
               <option value="style3" <?php selected($style, 'style3'); ?>>Style 3 (icon2)</option>
       </select>
       <?php
    }, 'dmms_settings', 'dmms_main_section');

    // Button Position
    add_settings_field('dmms_button_position', 'Button Position', function(){
       $position = get_option('dmms_button_position', 'bottom-right');
       ?>
       <select name="dmms_button_position">
               <option value="bottom-right" <?php selected($position, 'bottom-right'); ?>>Bottom Right</option>
               <option value="top-left" <?php selected($position, 'top-left'); ?>>Top Left</option>
               <option value="top-right" <?php selected($position, 'top-right'); ?>>Top Right</option>
       </select>
       <?php
    }, 'dmms_settings', 'dmms_main_section');


}
add_action('admin_init', 'dmms_register_settings');











?>