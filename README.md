mu-plugins
==========

Some useful translation ready WordPress mu plugins.

Installation:
-------------

Add `--recursive` to the `git clone` command.

    $ git clone --recursive git@github.com:mcguffin/mu-plugins

Customizing:
------------

Add a file `project.php` and a directory named `project/` in case you want to add your
own code. These files are .gitignore‘d, so you can safely `git pull`.


Contains:
---------

*   **Client side image resize**

    *The Problem:* Huge images. Takes advantage of the built in plupload capability to downsize images before they are uploaded.

*   **Debug**

    Enhanced debugging mode controlled by constants set in the wp-config.php:

    *	`WP_DEBUG`:
    	*	Disable [Cachify](https://wordpress.org/plugins/cachify/) in the frontend (Clear server cache first!)
    	*	Create and init a WP_Profiler instance
    	*	Profiler Usage: `WP_Profiler::log( 'Something happened!' );` and `WP_Profiler::dump();`

    *	`SCRIPT_DEBUG`: Disable script minification by [autoptimize plugin](https://wordpress.org/plugins/autoptimize/)

    *	`SAVEQUERIES`: Display SQL queries at shutdown.



*   **Email obfuscation**

    *The Problem:* Email address harvesting. By defining the constant `EMAIl_OBFUSCATION_METHOD` you can choose between two methods:
	`ajax` will load the email fragments from the server, on user interaction or half a second after the page is loaded. The Server is performing a referrer check before the fragments are delivered. As this method is considered more secure, it is the default.  
	`js-crypt` will 'encrypt' the addresses and links with some random bytes, and decrypt again it on page load. Use this if you run into issues with a varnish or other caching techniques, choose this method.


*   **Fix get_adjacent_post**

    *The Problem:* next_post_link / previous_posts_links don't work properly for posts published at the same date and time. The plugin alters the sort condition in the corresponding database queries by adding the post ID as a second sort column.

    http://core.trac.wordpress.org/ticket/8107, https://core.trac.wordpress.org/ticket/28026

*	**Matomo OptOut**

	Shortcode for WP-Matomo outout-iframe with the possibility to pass some styling attributes:
	`[matomo_optout backgroundcolor="#000000" fontcolor="#ffffff" fontsize="16em" fontfamily="fantasy"]`

	Requires [WP-Matomo](https://wordpress.org/plugins/wp-piwik/).


*	**WP-SEO / Polylang fix**

	*The Problem:* WP-SEO columns are gone when a Post is saved in QuickEdit.
	See: https://github.com/Yoast/wordpress-seo/issues/6593
