mu-plugins
==========

Some useful WordPress mu plugins

Contains:

*   Disable Trackbacks
   
    *The Problem:* Trackbacks are a potential vulnerability which allows spammers to 
    publish arbitrary links on your blog, just by mentioning your post.
    
    In my point of view the risk of trackbacks clearly exceeds its benefits. This plugin 
    contains a few hooks that disable all trackbacks where possible.

*   Fix get_adjacent_post
   
    *The Problem:* next_post_link / previous_posts_links don't work properly for posts 
    published at the same date/time. The plugin alters the sort condition in the 
    corresponding database queries.
    
    http://core.trac.wordpress.org/ticket/8107, https://core.trac.wordpress.org/ticket/28026
  
*   Fix oembed URLs
   
    *The Problem:* oEmbed some content from `http://xxx.yy`, watch your page with 
    https://, content does not get displayed for security reasons.

*   Basic Comment Spam Trap
   
    *The Problem:* Comment spam. The plugin adds a honeypot input field. If this field is 
    filled (as a spam bot would do) the comment is marked as spam.

*   Client side image resize
   
    *The Problem:* Huge images. Takes advantage of the built in plupload capability to 
    downsize images before the get uploaded.

*   Add PDF to Media Library
   
    *The Problem:* Can't upload PDFs. The Solution: Now you can.

*   Show Queries (debugging)
   
    *The Problem:* Can't see any of these beautiful SQL queries. The solution: Set 
    the SAVEQUERIES constant in your wp-config to true and log in with an admin account.

