=== Recently Registered ===
Tags: users, recent, new
Contributors: Ipstenu
Requires at least: 2.7
Tested up to: 3.1
Stable Tag: 1.3

All this does is add in a submenu under the users menu on the admin side for recently registered users.

== Description ==

With this plugin, admins will have a new submenu under the Users menu to list the 25 most recently registered users (in reverse order), pulling down their avatar, based on what you set as default (so identicon, gravatar, etc). 

**Misc**

* [Donate](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5227973)
* [Plugin Site](http://code.ipstenu.org/recently-registered/)

== Changelog ==

= Version 1.3 - 12 July, 2010 =

* Cleanup of code, making it tighter etc.
* StopForum Spam check (which has been around for a while) is documented
* DO NOT use this on MultiSite

= Version 1.2 - 19 October, 2009 =

* Typo in function caused the plugin epic fail.

= Version 1.1 - 16 October, 2009 =

* Added in comment count to page.
* Added option to change recent number from 25 to whavever you want.

= Version 1.0 - 01 May, 2009 =

* Removed the since code (it wasn't working) and replaced with a short date.

= Version 0.2 - 30 March, 2009 =

* Moved to a sub-folder
* Formatting the list to be nicer.

= Version 0.1 - 27 March, 2009 =

Initial version.

== Installation ==

1. Unpack the *.zip file and extract the `/recently-registered/` folder and the files.
2. Using an FTP program, upload the full `/recently-registered/` folder to your WordPress plugins directory (Example: `/wp-content/plugins/`).
3. Go to Plugins > Installed and activate the plugin.
4. Go to **Users > Recently Registered** and see who's new.

== To Do ==

1. Add in a delete user link (have to sort out the nonce stuff for that).

== Frequently Asked Questions ==

= Will this work on older versions of WordPress? =

Probably, but I started writing this on v 2.7.1.  I won't be supporting anything less that the current version of WordPress and one major release back (so if we're on 3.0, then I support 3.0 and 2.9, but not 2.8, and so on).

= Will this work if I have a special avatar plugin? =

Yes, but it may not show the right avatars. I'd have to know more about those plugins and where they store data before I can answer that.

= Does this work on MultiSite? =

Yes, but don't bother to use it.  MultiSite's SuperAdmin user tab pretty much takes care of this (though not the StopForumSpam check). I have no plans on making a StopForumSpam checker for MultiSite at this time.

== Screenshots ==

1. Sidebar menu
2. Sample output
