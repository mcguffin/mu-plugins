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
   
    *The Problem:* Huge images. Takes advantage of the built in plupload capability to 
    downsize images before the get uploaded.

*   **Debug**
    
    Enhanced debugging mode controlled by constants set in the wp-config.php:

    *	`WP_DEBUG`: 
    	*	Disable [Cachify](https://wordpress.org/plugins/cachify/) in the frontend (Clear server cache first!)
    	*	Create and init a WP_Profiler instance
    	*	Profiler Usage: `WP_Profiler::log( 'Something happened!' );` and `WP_Profiler::dump();`

    *	`SCRIPT_DEBUG`: Disable script minification by [autoptimize plugin](https://wordpress.org/plugins/autoptimize/)
    
    *	`SAVEQUERIES`: Display SQL queries at shutdown.
    
    

*   **Email obfuscation**

    *The Problem:* Email address harvesting. The solution: will replace all email links on 
    your site with a placeholder link and load Email addresses with javascript half a second 
    later.

*   **Fix get_adjacent_post**
   
    *The Problem:* next_post_link / previous_posts_links don't work properly for posts 
    published at the same date and time. The plugin alters the sort condition in the 
    corresponding database queries by adding the post ID as a second sort column.
    
    http://core.trac.wordpress.org/ticket/8107, https://core.trac.wordpress.org/ticket/28026


*	**Fix WP Core issue #25449**
	
	*The Problem:* `wp_upload_dir()` doesn't support https. See: https://core.trac.wordpress.org/ticket/25449
