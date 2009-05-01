<?php
/*
Plugin Name: Recently Registered
Plugin URI: http://www.ipstenu.org/
Description: All this does is add in a submenu under the users menu on the admin side for recently registered users.
Version: 1.0
Author: Mika Epstein
Author URI: http://www.ipstenu.org/

        Copyright 2009 Mika Epstein (email: ipstenu@ipstenu.org)

        wp_since was stolen from bb_since from bbPress.  It worked so nicely,
        I didn't want to reinvent the wheel!

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
                add_submenu_page('users.php', 'Recently Registered', 'Recently Registered', '8', 'recently-registered.php', 'recentlyregistered_options');
        }
}

function recentlyregistered_options() {
        global $wpdb;
        $aUsersID = $wpdb->get_col( $wpdb->prepare("SELECT $wpdb->users.ID FROM $wpdb->users ORDER BY ID DESC LIMIT 25"));
        $size = 40;
        $default = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name='avatar_default'");

?>
<div class="wrap">
<h2>25 Most Recently Registered Users</h2>

<table class="widefat fixed" cellspacing="0">
<thead>
<tr class="thead">
        <th scope="col" id="username" class="manage-column column-username" style="">Username</th>
        <th scope="col" id="email" class="manage-column column-email" style="">E-mail</th>
        <th scope="col" id="registered" class="manage-column column-registered" style="">Registered</th>
</tr>
</thead>

<tbody id="users" class="list:user user-list">
<?php

        foreach ( $aUsersID as $iUserID ) :
                $user = get_userdata( $iUserID );
                $email = $user->user_email;
                $registered = strtotime($user->user_registered);
                $grav_url = "http://www.gravatar.com/avatar/".md5( strtolower($email) )."?d=".$default."&size=".$size;
                ?>

                <tr id="<?php echo $iUserID; ?>">
                  <td class="username column-username"><img alt="Avatar" src="<?php echo $grav_url; ?>" class="avatar avatar-<?php echo $size; ?> photo" height="<?php echo $size; ?>" width="<?php echo $size; ?>" /> <strong><a href="user-edit.php?user_id=<?php echo $user->ID ?>;wp_http_referer=%2Fblog%2Fwp-admin%2Fusers.php"><?php echo $user->user_login; ?></a></strong><br /><div class="row-actions"><span class='edit'><a href="user-edit.php?user_id=<?php echo $user->ID ?>&#038;wp_http_referer=%2Fblog%2Fwp-admin%2Fusers.php">Edit</a></span></div></td>
                  <td class="email column-email"><a href="mailto:<?php echo $email; ?>" title="e-mail: <?php echo $email; ?>"><?php echo $email; ?></a></td>
                  <td class="registered column-registered"><?php echo date('d M \- g:h:s a', $registered); ?></td>
                </tr>
                <?php
        endforeach;
?>
</table>

</div>
<?php
}

// Hooks
add_action('admin_menu', 'recentlyregistered_menu');

?>
