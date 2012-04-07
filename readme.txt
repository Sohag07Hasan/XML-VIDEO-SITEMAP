=== Plugin Name ===
Contributors: labnol
Tags: youtube, xml sitemaps, google sitemaps, videos, seo, sitemaps, video sitemap
Requires at least: 2.9.2
Tested up to: 3.3.1
Stable tag: 2.5.1

This plugin will help you generate Google Video Sitemaps (XML) for your WordPress blog. 

== Description ==

Sitemaps are a way to tell Google, Bing and other search engines about web pages, images and video content on your site that they may otherwise not discover. 

The Video Sitemap plugin will generate an XML Sitemap for your WordPress blog using all YouTube videos that you may have embedded in your blog posts. 

Your Video Sitemap will includes web pages which embed videos from YouTube or which links to videos on YouTube. If a YouTube video that you have in your blog has been removed from YouTube, the record in the Sitemap file will be ignored by Googlebot.

**Related links:**

* [Google XML Sitemap for Mobile](http://wordpress.org/extend/plugins/google-mobile-sitemap/)
* [Google XML Sitemap for Images](http://wordpress.org/extend/plugins/google-image-sitemap/)
* [Must have WordPress Plug-ins](http://www.labnol.org/software/must-have-wordpress-plugins/14034/) on [Digital Inspiration](http://www.labnol.org/ "Technology Blog")

For updates, you can follow the [author](http://www.labnol.org/about/ "Amit Agarwal") on [Twitter](http://twitter.com/labnol) and [Facebook](http://www.facebook.com/digital.inspiration).

== Installation ==

Here's how you can install the plugin:

1. Upload the plugins folder to the /wp-content/plugins/ directory.
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Expand the Tools menu from WordPress dashboard sidebar and select "Video Sitemap."
1. Click the "Generate Sitemap" button to create your XML Sitemap for videos.
1. Once you have created your Sitemap, you can submit it to Google using Webmaster Tools. 

== Frequently Asked Questions ==

= How can I submit my video sitemap to Google? =

Once you have created your Sitemap, you can submit it to Google using Webmaster Tools. Google don't guarantee that all videos included in a Sitemap will appear in our search results.

= Should I check the "include video duration" option when generating the sitemap? =

If you have a *small number of videos* on your website, you may check this option. Please not that the plugin will make one call per video to the YouTube API  to determine the duration of the clip. It uses CURL to interact with the YouTube API.

= Where's the sitemap file stored? =

You can find the sitemap-video.xml file in your blog's root folder.

= I am getting Permission Denied like errors =

It implies that you don't have write permissions on your blog's root folder. Please use chmod or your FTP manager to set the necessary permissions to 0666.

= Can I block search engines from indexing pages that are in the XML Sitemap file? =

The Sitemaps protocol enables you to let search engines know what content you would like indexed. To tell search engines the content you don't want indexed, use a robots.txt file or add a robots meta tag to the web page that you would like to block.

== Screenshots ==

1. Click the button to generate your video sitemap.
2. This is how the XML sitemap should look like in your web browser.

== Changelog ==

= 2.5   =
* added - Your sitemaps now look gorgeous in the browser. Just open the sitemap-video.xml file directly in any modern browser.
* added - Sitemap now renders higher quality image thumbnails for YouTube videos

= 2.4 =
* fixed - Plugin now supports multiple videos embedded in the same page or post. This was earlier giving a "duplicate content" error in Google Webmaster Tools but, thanks to a suggestion by @blogsDNA, the problem is now fixed.
* added - Plugin compatible with WordPress 3.3.1

= 2.3.1 =
* added - Support for IFRAME based YouTube embeds 
* fixed - Improved discovery code for YouTube videos
* added - The plugin ensures that no video is included twice in the XML sitemap

= 2.2 =
* fixed - The sitemaps protocol allows only one category per video 
* fixed - location of sitemap in the error messages - thanks @ashishmohta
* fixed - limit the number of tags to 32

= 2.1 =
* If the plugin is unable to create a sitemap file, it gives an option to manually create the file.
* More error handling included.

= 2.0.1 =
* Better Error Handline
