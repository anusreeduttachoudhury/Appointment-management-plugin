<?php
/*
Plugin Name: Appointment plugin
Description: Displays an appointment form in public interface and the list of appointments for admin
Author: Anusree Dutta Chawdhury
Version: 1.0
*/


// Initialize the plugin database when its first activated.
register_activation_hook( __FILE__, 'init_plugin' );   // https://codex.wordpress.org/Function_Reference/register_activation_hook

// Add menus in the admin panel
add_action('admin_menu', 'setup_plugin_menu');        // https://developer.wordpress.org/reference/functions/add_action/


// Callback function used to add a menu entry for the plugin.
function setup_plugin_menu(){
    $page_title = "Appointment";
    $menu_title = "Manage Appointments";
    $capabilitiy = "manage_options";
    $menu_slug = "appointment-manager";
    $initializer = "main_page_html";
    
    // https://developer.wordpress.org/reference/functions/add_menu_page/
    add_menu_page( $page_title, $menu_title, $capabilitiy, $menu_slug, $initializer);

    add_hospital_submenu($menu_slug);
}

// Adds hostpital menu under the parent plugin menu. Called by setup_plugin_menu only.
function add_hospital_submenu($parent_slug){
    $hospital_sub_page_title = "Hospitals";
    $hospital_sub_menu_title = "Manage Hospitals";
    $hospital_sub_capability = "manage_options";
    $hospital_sub_menu_slug  = "hostpital-manager";
    $initializer = "hospital_submenu_html";

    // https://developer.wordpress.org/reference/functions/add_submenu_page/
    add_submenu_page( $parent_slug, $hospital_sub_page_title, 
        $hospital_sub_menu_title, $hospital_sub_capability, 
        $hospital_sub_menu_slug, $initializer );
}

// Callback function that defines the html structure of hospital submenu
function hospital_submenu_html(){
    echo "<h1> This is the hospital submenu </h1>";
}

// Callback function  defines the html structure of main plugin page
function main_page_html(){
    echo "<h1> Hello World! </h1>";
}

// Callback function called when the plugin is activated. (register_activision_hook)
function init_plugin(){
    create_table();
}

//https://codex.wordpress.org/Creating_Tables_with_Plugins
function create_table(){
    global $wpdb;

    $table_name = $wpdb->prefix . "appointment_manager_test";

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        time datetime DEFAULT NOW() NOT NULL,
        doctor varchar(100) NOT NULL,
        hospital varchar(100) NOT NULL,
        department varchar(100) NOT NULL,
        PRIMARY KEY  (id)
        ) $charset_collate";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta( $sql );
}
?>