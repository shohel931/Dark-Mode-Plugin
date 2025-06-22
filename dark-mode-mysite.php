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


















// Add Admin Menu
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

}
add_action('admin_menu', 'dmms_add_admin_menu');





// Settings Page Callback
function dmms_settings_page() {
    ?>
    <div class="wrap settings-page">
        <form method="post" action="options.php">
            <?php
            settings_fields('dmms_settings_group');
            do_settings_sections('dmms_main_menu');
            submit_button();
            ?>
        </form>
        
    </div>
    <?php
}


// Admin Settings Initialization
function dmms_settings_init() {
    // Register a new setting for the plugin
    register_setting('dmms_settings_group', 'dmms_settings');

    // Add a new section to the settings page
    add_settings_section(
        'dmms_settings_section',
        'Dark Mode Settings',
        'dmms_settings_section_callback',
        'dmms_main_menu'
    );

    // Add a new field to the section
    add_settings_field(
        'dmms_enable_dark_mode',
        'Enable Dark Mode',
        'dmms_enable_dark_mode_render',
        'dmms_main_menu',
        'dmms_settings_section'
    );
}
add_action('admin_init', 'dmms_settings_init');
// Section Callback
function dmms_settings_section_callback() {
    echo '<p>Configure the settings for Dark Mode Mysite.</p>';
}

// Render the field for enabling dark mode
function dmms_enable_dark_mode_render() {   
    $options = get_option('dmms_settings');
    ?>
    <input type="checkbox" name="dmms_settings[enable_dark_mode]" value="1" <?php checked(isset($options['enable_dark_mode']) ? $options['enable_dark_mode'] : 0, 1); ?> />
    <label for="dmms_settings[enable_dark_mode]">Enable Dark Mode</label>
    <?php
}





// Upgrade Page Callback
function dmms_upgrade_page() {
    ?>
    <div class="wrap">
        <h1>Upgrade to Dark Mode Mysite Pro</h1>
        <p>Upgrade to the Pro version for more features and support.</p>
        <a href="https://shohelrana.top/dark-mode-mysite-pro" class="button button-primary">Upgrade Now</a>
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