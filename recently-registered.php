<?php
/*
Plugin Name: Recently Registered
Plugin URI: http://www.ipstenu.org/
Description: All this does is add in a submenu under the users menu on the admin side for recently registered users.
Version: 0.2
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
                $grav_url = "http://www.gravatar.com/avatar/".md5( strtolower($email) )."?d=".$default."&size=".$size;
                ?>

                <tr id="<?php echo $iUserID; ?>">
                  <td class="username column-username"><img alt="Avatar" src="<?php echo $grav_url; ?>" class="avatar avatar-<?php echo $size; ?> photo" height="<?php echo $size; ?>" width="<?php echo $size; ?>" /> <strong><a href="user-edit.php?user_id=<?php echo $user->ID ?>;wp_http_referer=%2Fblog%2Fwp-admin%2Fusers.php"><?php echo $user->user_login; ?></a></strong><br /><div class="row-actions"><span class='edit'><a href="user-edit.php?user_id=<?php echo $user->ID ?>&#038;wp_http_referer=%2Fblog%2Fwp-admin%2Fusers.php">Edit</a></div></td>
                  <td class="email column-email"><a href="mailto:<?php echo $email; ?>" title="e-mail: <?php echo $email; ?>"><?php echo $email; ?></a></td>
                  <td class="registered column-registered"><?php printf(__('%s ago'), wp_since( $user->user_registered )) ?></td>
                                </tr>
                <?php
        endforeach;
?>
</table>


</div>
<?php
}

function wp_since( $original, $do_more = 0 ) {
       $today = time();

   if ( !is_numeric($original) ) {
          if ( $today < $_original = strtotime( str_replace(',', ' ', $original) ) ) // Looks like bb_since was called twice
             return $original;
         else
             $original = $_original;
     }

     // array of time period chunks
     $chunks = array(
         array(60 * 60 * 24 * 365 , __('year') , __('years')),
         array(60 * 60 * 24 * 30 , __('month') , __('months')),
         array(60 * 60 * 24 * 7, __('week') , __('weeks')),
         array(60 * 60 * 24 , __('day') , __('days')),
         array(60 * 60 , __('hour') , __('hours')),
         array(60 , __('minute') , __('minutes')),
         array(1 , __('second') , __('seconds')),
     );

     $since = $today - $original;

     for ($i = 0, $j = count($chunks); $i < $j; $i++) {
         $seconds = $chunks[$i][0];
         $name = $chunks[$i][1];
         $names = $chunks[$i][2];

         if ( 0 != $count = floor($since / $seconds) )
             break;
     }

     $print = sprintf(__('%1$d %2$s'), $count, $count == 1 ? $name : $names);

     if ( $do_more && $i + 1 < $j) {
         $seconds2 = $chunks[$i + 1][0];
         $name2 = $chunks[$i + 1][1];
         $names2 = $chunks[$i + 1][2];
         if ( 0 != $count2 = floor( ($since - $seconds * $count) / $seconds2) )
             $print .= sprintf(__(', %1$d %2$s'), $count2, ($count2 == 1) ? $name2 : $names2);
     }
     return $print;
 }

// Hooks
add_action('admin_menu', 'recentlyregistered_menu');

?>
