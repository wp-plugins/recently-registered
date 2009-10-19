<div class="wrap">
<h2>Recently Registered</h2>

<?php
        global $wpdb;
        $number = get_option('recentlyregistered_number');
        $aUsersID = $wpdb->get_col( $wpdb->prepare("SELECT $wpdb->users.ID FROM $wpdb->users ORDER BY ID DESC LIMIT $number"));
        $size = 40;
        $default = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name='avatar_default'");

        if (isset($_POST['update']))
        {
        // Update Stop Forum Spam
                if ($recentlyregistered_newsfs = $_POST['recentlyregistered_newsfs'])
                { update_option('recentlyregistered_stopforumspam', $recentlyregistered_newsfs); }
                else
                { update_option('recentlyregistered_stopforumspam', '0'); }

        // Update Number of Recent Users
                if ($recentlyregistered_newnum = $_POST['recentlyregistered_newnum'])
                { update_option('recentlyregistered_number', $recentlyregistered_newnum); }
?>
        <div id="message" class="updated fade"><p><strong>Options Updated!</strong></p></div>
<?php
        }

        if (get_option('recentlyregistered_stopforumspam') != '0' )
        {
                $recentlyregistered_sfs = ' checked="checked"';
        } else {
                $recentlyregistered_sfs = '';
        }
?>

<h3><?php echo $number; ?> Most Recently Registered Users</h3>

<table class="widefat" cellspacing="0">
<thead>
<tr class="thead">
        <th scope="col" id="username" class="manage-column column-username" style="">Username</th>
        <th scope="col" id="fullname" class="manage-column column-fullname" style="">Name</th>
        <th scope="col" id="email" class="manage-column column-email" style="">E-mail</th>
        <th scope="col" id="registered" class="manage-column column-registered" style="">Registered</th>
        <th scope="col" id="comments" class="manage-column column-comments" style="">Comments</th>
</tr>
</thead>

<tbody id="users" class="list:user user-list">
<?php

        foreach ( $aUsersID as $iUserID ) :
                $user = get_userdata( $iUserID );
                $email = $user->user_email;
                $username = $user->display_name;
                $registered = strtotime($user->user_registered);
                $grav_url = "http://www.gravatar.com/avatar/".md5( strtolower($email) )."?d=".$default."&size=".$size;
?>
                <tr id="<?php echo $iUserID; ?>">
                  <td class="username column-username"><img alt="Avatar" src="<?php echo $grav_url; ?>" class="avatar avatar-<?php echo $size; ?> photo" height="<?php echo $size; ?>" width="<?php echo $size; ?>" /> <strong><a href="user-edit.php?user_id=<?php echo $user->ID ?>;wp_http_referer=%2Fblog%2Fwp-admin%2Fusers.php"><?php echo $user->user_login; ?></a></strong><br /><div class="row-actions"><span class='edit'><a href="user-edit.php?user_id=<?php echo $user->ID ?>&#038;wp_http_referer=%2Fblog%2Fwp-admin%2Fusers.php">Edit</a></span></div></td>
                  <td class="fullname column-fullname"><?php echo $username; ?></td>
                  <td class="email column-email">
                  <?php if (get_option('recentlyregistered_stopforumspam') != '0' ) {
                   // Check the users against StopForumSpam
                $ch = curl_init();
                $StopForumSpam = "http://www.stopforumspam.com/api?email=$email";
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_URL, $StopForumSpam);
                $check = curl_exec($ch);
                curl_close($ch);

                $test = "yes";
                if ( strpos( $check, $test) > 0 )
                {
                 $recently_isspam = "".$email." is listed on StopForumSpam.com.";
                }
                else { $recently_isspam = '<a href="mailto:'.$email.'" title="email:'.$email.'">'.$email.'</a>';}
                    }
                 else { $recently_isspam = '<a href="mailto:'.$email.'" title="email:'.$email.'">'.$email.'</a>';}
                    echo $recently_isspam;
                  ?>
                  </td>
                  <td class="registered column-registered"><?php echo date('d M Y \- g:h:s a', $registered); ?></td>
                  <td class="comments column-comments">
                  <!-- List number of comments -->

                  <?php
                                        $where = 'WHERE comment_approved = 1 AND user_id = '.$user->ID.' ';
                                        $comment_counts = (array) $wpdb->get_results("SELECT user_id, COUNT( * ) AS total FROM {$wpdb->comments} {$where} GROUP BY user_id", object);
                                        foreach ( $comment_counts as $count ) {
                                                $user = get_userdata($count->user_id);
                                                echo $count->total;
                                                }
                                  ?>
                  </td>
                </tr>
                <?php
        endforeach;
?>
</table>

<h3>Customization Options</h3>
<form method="post" width='1'>

<fieldset class="options">
<legend><h3>Number of New Users to list</h3></legend>
<p>Update this field to indicate how many new users you want to list. Default is 25.</p>

<script type="text/javascript">
    // verifies only a number was typed into the form element
    function numbersonly(e){
        var unicode=e.charCode? e.charCode : e.keyCode
        // if (unicode!=8||unicode!=9)
        if (unicode<8||unicode>9)
        {

            if (unicode<48||unicode>57) //if not a number
            return false //disable key press
        }
    }
</script>
<input name="recentlyregistered_newnum" type="text" onkeypress="return numbersonly(event);" value="<?php echo $number; ?>" />
</fieldset>

<fieldset class="options">
<legend><h4>Check emails against StopForumSpam.com?</h4></legend>

<p> <input type="checkbox" id="recentlyregistered_newsfs" name="recentlyregistered_newsfs" value="1" <?php echo $recentlyregistered_sfs ?> /> <a href="http://www.stopforumspam.com/">StopForumSpam.com</a> is a repository for forum spambots.  Since a disturbingly high number of them also sign up on blogs, some people may want to block them here as well.  If you do, check the box and any email address flagged by StopForumSpam will be flagged here. If not, leave it alone (which is the default).</p>
</fieldset>
</fieldset>
        <p class="submit"><input type="submit" name="update" value="Update Options" /></p>

</form>

</div>