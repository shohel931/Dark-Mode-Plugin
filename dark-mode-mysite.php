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

    wp_localize_script('dark-mode-mysite-script', 'dmms_data', array(
    'default_style' => get_option('dmms_dark_mode_style', 'light')
));

}
add_action('wp_enqueue_scripts', 'dmms_enqueue_scripts');



// Admin Menu 
function dmms_add_admin_menu() {
    add_menu_page(
        'Dark Mode Mysite',      
        'Dark Mode',              
        'manage_options',         
        'dmms_main_menu',         
        'dmms_settings_page',     
        'dashicons-lightbulb',    
        60                        
    );

    // Settings page 
    add_submenu_page(
        'dmms_main_menu',         
        'Dark Mode Settings',     
        'Settings',               
        'manage_options',         
        'dmms_settings',          
        'dmms_settings_page'      
    );
}
add_action('admin_menu', 'dmms_add_admin_menu');




// toggle button 
function dmms_toggle_button() {
    $enabled = get_option('dmms_toggle_button');
    $position = get_option('dmms_button_position', 'bottom-right');
    if ($enabled) {
        echo '<button id="dmms-toggle-button" style="border: none; " class="dmms-toggle-button ' . esc_attr($position) . '"><i class="fas fa-moon"></i></button>';
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
    register_setting('dmms_settings_group', 'dmms_toggle_button');
    register_setting('dmms_settings_group', 'dmms_dark_mode_style');
    register_setting('dmms_settings_group', 'dmms_button_position');

    
    add_settings_section('dmms_main_section', 'Main Settings', null, 'dmms_settings');


    // Button Hide Show
    add_settings_field('dmms_toggle_button', 'Show Toggle Button', function() {
        $checked = get_option('dmms_toggle_button');
        echo '<input type="checkbox" name="dmms_toggle_button" value="1"' . checked(1, $checked, false) . '> Show';

    }, 'dmms_settings', 'dmms_main_section');



    // Dark / Light Mode
  add_settings_field('dmms_dark_mode_style', 'Default Style', function() {
    $value = get_option('dmms_dark_mode_style', 'light');
    echo '<select name="dmms_dark_mode_style">
        <option value="light" '.selected($value, 'light', false).'>Light</option>
        <option value="dark" '.selected($value, 'dark', false).'>Dark</option>
    </select>';
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


// Plugin Redirect

register_activation_hook(__FILE__, 'dmms_plugin_activate');
function dmms_plugin_activate() {
    add_option('dmms_do_redirect', true);
}

add_action('admin_init', 'dmms_plugin_redirect_after_activation');
function dmms_plugin_redirect_after_activation() {
    if (get_option('dmms_do_redirect')) {
        delete_option('dmms_do_redirect');

        if (!isset($_GET['activate-multi'])){
            wp_redirect(admin_url('admin.php?page=dmms_main_menu'));
            exit;
        }
    }
}



?>