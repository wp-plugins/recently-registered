<?php
/*
Plugin Name: Recently Registered
Plugin URI: http://www.ipstenu.org/
Description: All this does is add in a submenu under the users menu on the admin side for recently registered users.
Version: 1.1
Author: Mika Epstein
Author URI: http://www.ipstenu.org/

        Copyright 2009 Mika Epstein (email: ipstenu@ipstenu.org)

        This plugin is free software; you can redistribute it and/or modify
        it under the terms of the GNU General Public License as published by
        the Free Software Foundation; either version 2 of the License, or
        (at your option) any later version.

        This plugin is distributed in the hope that it will be useful,
        but WITHOUT ANY WARRANTY; without even the implied warranty of
        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
        GNU General Public License for more details.

*/

// Load the options page

function recentlyregistered_menu() {
                if (function_exists('add_submenu_page')) {
                add_submenu_page('users.php', 'Recently Registered', 'Recently Registered', '8', 'recently-registered/recently-registered_options.php');
        }
}

// Adding in an option for Stop Forum Spam
function recentlyregistered_activate() {
        update_option('recentlyregistered_stopforumspam', '0');
        updatee_option('recentlyregistered_number', '25');
}

// Delete the options if the plugin is being turned off (pet peeve)
function recentlyregistered_deactivate() {
        delete_option('recentlyregistered_stopforumspam');
        delete_option('recentlyregistered_number');
}

// Hooks
add_action('admin_menu', 'recentlyregistered_menu');

register_activation_hook( __FILE__, 'recentlyregistered_activate' );
register_deactivation_hook( __FILE__, 'recentlyregistered_deactivate' );

?>