mu-plugins
==========

Some useful translation ready WordPress mu plugins.

Installation:
-------------

Add `--recursive` to the `git clone` command.

    $ git clone --recursive git@github.com:mcguffin/wp-rainbow-hilite


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

    *	`SCRIPT_DEBUG`: Disable script minification by [autoptimize plugin](https://wordpress.org/plugins/autoptimize/)
    
    *	`SAVEQUERIES`: Display SQL queries at shutdown.

*   **Disable Comments**
    
    Completely removes comment trackback and pingback functionality. 
    
    Submodule added from [Disable Comments for WordPress](git@github.com:solarissmoke/disable-comments-mu.git)
  
*   **Email obfuscation**
   
    *The Problem:* Email address harvesting. The solution: will replace all email links on 
    your site with a placeholder link and load Email addresses with javascript half a second 
    later.
  
*   **Enable Document Upload**
   
    *The Problem:* Can't upload PDFs, and Office documents. The Solution: Enables upload 
    for PDF files, Text documents and presentations (OpenOffice and MS Office).
    
*   **Fix get_adjacent_post**
   
    *The Problem:* next_post_link / previous_posts_links don't work properly for posts 
    published at the same date and time. The plugin alters the sort condition in the 
    corresponding database queries by adding the post ID as a second sort column.
    
    http://core.trac.wordpress.org/ticket/8107, https://core.trac.wordpress.org/ticket/28026
  
*   **Fix oembed URLs**
   
    *The Problem:* oEmbed some content from `http://xxx.yy`, watch your page with 
    https://. Content is not displayed for security reasons. 

*	**PostType Term Archive**
    
    *The Problem:* Custom Post types do not have taxonomy archives. The solution: 

    *  Call `PostType_Term_Archive::get( $post_type , $taxonomy_slug );` on WP init. 
    *  Set your permalink settings to `http://my-domain.tld/%postname%/`.
    *  Generate a post type term link through `get_post_type_term_link( $post_type , $term , $taxonomy )`.

    Archive URLs will be in the form `http://my-domain.tld/%post_type%/%taxonomy%/%term_slug%`.
    The Polylang plugin is also supported.
    
*	**Fix WP Core issue #25449**
	
	*The Problem:* `wp_upload_dir()` doesn't support https. See: https://core.trac.wordpress.org/ticket/25449
