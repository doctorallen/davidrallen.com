=== Yet Another Photoblog ===

Contributors: jaroat
Donate link: http://johannes.jarolim.com/yapb/donate
Tags: photoblog, photo blog, photo blogging, images, yapb, yet another photoblog
Requires at least: 2.5
Tested up to: 3.3.2
Stable tag: 1.10.7

Convert your WordPress Blog into a full featured photoblog in virtually no time.

== Description ==

Convert your WordPress Blog into a full featured photoblog in virtually no time. Use the full range of WordPress functions and plugins: Benefit from the big community WordPress has to offer.

= What is YAPB / What can you expect? =

* A non invasive WordPress-plugin that converts wp into a easy useable photoblog system 
* Easy image upload - All wordpress post-features can be used 
* On the fly thumbnail generation - Use multiple thumbnail sizes where and when you need them: Thumbnail generation gets controlled by the theme.
* EXIF data processing and output 
* Self-learning EXIF filter - Your own cameras tags can be selected to be viewed. 
* Full i18n-Support through gnutext mo/po files
* YAPB Plugin Infrastructure for extended functionality
* Ping additional update-service-sites when posting a photoblog entry. 
* Nearly every WP-theme can become a photoblog in virtually no time.
* Out of the box configurable "latest images" sidebar widget
* You'll get a photoblog system based on wordpress - Decide if you want to post a normal Wordpress article or a photoblog entry. Be free to use all available extensions / plugins of the WordPress platform ;-)
* Be the owner of your own photos on your own webhost

= YAPB is a photoblog plugin =

One post, one image, one description. Your image should be worth that. If you need to display multiple images in one post - Just download and use one of the several available gallery plugins for WordPress.

= More Information =

* For more information see the [YAPB Homepage](http://johannes.jarolim.com/yapb "YAPB homepage").
* Find YAPB plugins via the [YAPB Plugins overview page](http://johannes.jarolim.com/yapb/plugins "YAPB Plugin Overview")

= Plugins i currently know of =

* [YAPB Bulk Uploader](http://wordpress.org/extend/plugins/yapb-bulk-uploader "YAPB Bulk Uploader")
* [XP Uploader](http://wordpress.org/extend/plugins/xp-uploader "YAPB XP Uploader Homepage")
* [YAPB Importer Exporter](http://johannes.jarolim.com/yapb-forum/showthread.php?tid=853 "YAPP Importer Exporter post in YAPB Forum")
* [YAPB Sidebar Widget](http://wordpress.org/extend/plugins/yapb-sidebar-widget "YAPB Sidebar Widget Homepage")
* [YAPB XMLRPC Server](http://wordpress.org/extend/plugins/yapb-xmlrpc-server "YAPB XMLRPC Server Homepage")
* [YAPB XMLRPC Sidebar Widget](http://johannes.jarolim.com/yapb/sidebar-widget "YAPB XMLRPC Sidebar Widget Homepage")

= Translations i currently know of =

* German: Included.
* [Italian](http://gidibao.net/index.php/2009/12/27/yet-another-photoblog-in-italiano/ "Homepage of the italian translation")
* [French](http://www.aurelienpaulus.net/yet-another-photoblog-traduit-en-francais/ "Homepage of the french translation")
* [Russian](http://kosivart.if.ua/2008/10/09/515/ "Homepage of the russian translation")
* [Ukrainian](http://kosivart.if.ua/2008/10/07/502/ "Homepage of the ukrainian translation")





== Installation ==

1. Go to Plugins/Add New
2. Enter the term "YAPB" and start the search
3. Click on "Yet Another Photoblog"
4. Click on "install"
5. Go to "admin panel/plugins" and activate YAPB



= Spread the word =

If you like YAPB, please don't forget to backlink to the plugins homepage:

[http://johannes.jarolim.com/yapb](http://johannes.jarolim.com/yapb "The plugins homepage")

Additionally, it would be nice if you could rate YAPB on the according WordPress page:

[Rate YAPB on wordpress.org!](http://www.wordpress.org/extend/plugins/yet-another-photoblog "Please rate YAPB here")

= Finally: Enjoy and share your photography = 

Really: do and share some serious photography so everybody may discover your view and interpretation of the world.





== Frequently Asked Questions ==

Have a look at the [YAPB FAQ Page](http://johannes.jarolim.com/yapb "The plugins homepage").





== Screenshots ==

1. YAPB integrates thightly into wordpress
2. You get extra functionality on your new post and edit post mask
3. Seamless integration in other areas of your admin panel
4. The quick info on your dashboard gives you a rough overview
5. The detailed info/options page gives you *alot* possibilities
6. Use the automattic image insertion feature or adapt your theme manually to show your images
7. Easely display EXIF data of your images; list alternative image formats
8. Just click an option to integrate your images into RSS2 and atom feeds





== Changelog ==

= 2012-06-11, Release 1.10.7 =

* Security Fix: Deleted phpThumb demo directory (Thanks to Scott Reilly for the report)
* Actualized german translation
* Bugfix: Warning from YabpExifTagnamesOption.class.php catched (Thanks to Anne for the feedback)

= 2012-01-10, Release 1.10.6 =

* Bug Workaround for users of plugin User-Access-Manager: plugin calls various functions from wp-includes/pluggable.php without checking if those functions are in scope at calling time causing major problems in connection with YAPB.

= 2012-01-10, Release 1.10.5 =

* Enhanced automatic image insertion feature: Much more finegrained options for every section of the theme (Thanks to Jorge for the feedback)

= 2012-01-08, Release 1.10.4 =

* Additional feature: Facebook post thumbnail metadata feature

= 2011-11-21, Release 1.10.3 =

* Code Brushup: PHP 5.3 compatibility

= 2011-11-07, Release 1.10.2 =

* Code Brushup: Several refactorings to remove deprecated function calls (Thanks to YellowShark for analysis and detailed feedback)

= 2011-11-07, Release 1.10.1 =

* BugFix: Fixed broken file upload in Internet Explorer 8+ (Thanks to Lev for the technical hint and Philippe for the IE bug report)

= 2011-11-05, Release 1.10 =

* Major brushup of the YAPB-Options page
* Update to phpThumb 1.7.11
* Update of .po file 
* Actualized german base translation
* Additional feature: If files are missing: You now may view posts belonging to the missing file and clean up according database entries if needed

= 2011-09-06, Release 1.9.32 =

* Compatibility Patch: Enable YAPB-ImageUpload on "User" - VHosts (eg. URLs starting with /~username)

= 2011-09-06, Release 1.9.31 =

* Additional feature: If files are missing, YAPB doesn't throw warnings anymore: You get a listing of all missing files on the YAPB Options Page.

= 2011-09-06, Release 1.9.30 =

* Compatibility Patch: Enable phpThumb thumbnail generation even on strange configured servers (many thanks to Artisan Guitars for a sample server) 

= 2011-07-18, Release 1.9.29 =

* WPMU-Compat Patch (thanks to Dario Ernst for the tip and the working solution)

= 2011-06-14, Release 1.9.28 =

* Security Update: Improved general prevention of parameter injection to phpThumb 1.7.9 (many thanks to Joost@yoast and jon@lionsgoroar)

= 2011-06-14, Release 1.9.27 =

* Security Update: General prevention of parameter injection to phpThumb 1.7.9 which has problems with parameter validation.

= 2011-04-14, Release 1.9.26 =

* Bugfix: If "Settings / Media / Store uploads in this folder" wasn't set by the blog owner, YAPB throws an error after uploading the image. It now assumes the default value "wp-content/uploads".
* Closure of the yapb-support-forum: I give up. Since i don't seem able to secure MyBB against spammers (and i tried) i have to close it.

= 2010-03-02, Release 1.9.25 =

* Bugfix: Added missing parameter $liclass in YAPB template function yapb_get_alternative_image_formats($limits, $liclass)
* Bugfix: Corrected yapb_is_photoblog_post so it doesn't throw notices anymore

= 2009-12-28, Release 1.9.24 =

* New feature: Set default jpeg quality for all thumbnails at "YAPB / Thumbnailer Options / Default JPEG output quality" (Thanks to Alex Sorokoletov)
* Went through all used strings to allow proper translation (Thanks to Gianni from gidibao.net)
* Happy new year!

= 2009-12-23, Release 1.9.23 =

* Included passthrough of quality parameter in YapbThumbnailer.php
* Tested up to WP 2.9
* Happy christmas to all photographers out there!

= 2009-08-21, Release 1.9.22 =

* Security Fix: Removed XSS Cross Site Scripting possibility via YapbThumbnailer.php (Special thanks to Andrew Nairn @ Gotham Digital Science - London, UK for recherching and reporting the issue)

= 2009-08-13, Release 1.9.21 =

* Bugfix: Wrong by-reference argument in callback for WP Filter "the_posts" causing PHP 5.3 to throw an error (Thanks to Lear for reporting and debugging)

= 2009-06-29, Release 1.9.20 =

* Bugfix: Activation does not work in WP 2.6 because of WP 2.7 function call in lib/Yapb.class.php (Thanks to M.G.F. M�gling for the feedback)

= 2009-06-14, Release 1.9.19 =

* Tested with WP 2.8 (it's working on my own, updated blog)
* phpThumb library updated to version 1.7.9

= 2009-01-15, Release 1.9.18 =

Bugfix:

* Problems with detection of absolute paths on windows hosts in method YapbImage::systemFilePath
* Incorrect checking for empty wordpress options in Yapb.class.php (Thanks to buonaluce)

= 2009-01-14, Release 1.9.17 =

Additional features:

* New filter hook: yapb_upload_image
* Enhanced YapbDiagnostics
* Thumbnails in RSS feeds: title attribute in href and alt attribute in image tag - happy validating
* Yahoo media RSS 1.1.12 integration

Workaround: 

* Next try of a stable workaround for unreliable DOCUMENT_ROOT settings on some hosts

= 2008-12-22, Release 1.9.16 =

Bugfix: Problems with absolute upload_dir settings in WP (Thanks to jocose and 93dots)

= 2008-12-20, Release 1.9.15 =

Bugfix: Wrong hook used to insert style tag for the automatic image insertion (Thanks to lars for giving feedback).

= 2008-12-17, Release 1.9.14 =

* New feature: optional rss and atom feed media enclosure
* New feature: optional xhtml-style imagetag at rss content integration (Thanks to max)
* Admin Backend Eye Candy for nicer WordPress 2.7 integration
* Change of the YAPB Automatic Image Insertion feature: No border="0" attribute in the imagetag anymore (Thanks to seriocomic)
* Change of the YAPB thumbnail cache location: Better support for WP auto update and WP 2.7 auto plugin installation - AND it's the right way to be done ;-)
* New internal admin notice infrastructure
* Minor CSS changes for better WP 2.7 integration
* General plugin and directory refactoring for more readable code
* Happy christmas!

= 2008-10-15 =

* Update of the readme.txt to communicate two new translation released by Stas: Ukrainian and Russian!

= 2008-09-26, Release 1.9.12 =

* Workaround/BugFix: YAPB Options Page problem with PHP running as CGI and SCRIPT_NAME reporting /cgi-bin/php4.cgi - Form now sends to REQUEST_URI

= 2008-09-22, Release 1.9.11 =

* Adapted YAPB Plugin Infrastructure: Old version does only work with PHP5 thus rendering YAPB plugins useless on servers with PHP4. Thanks to Alarane for providing a testing environment.

= 2008-08-26, Release 1.9.10 =

Bugfix Try (Options of the YAPB Sidebar Widget not shown on the YAPB Plugin Page)

* Moved execution of the yapb_register_plugin hook to the end of the WordPress plugin loading cycle

= 2008-08-20, Release 1.9.9 =

Compatibility issue:

Thumbnails file permission issue on some unix/php configurations: YAPB now tries to set Thumbnail file permission to 644 right after creation so webserver can access and serve it

Thanks to Bazyli for reporting and investigating

= 2008-08-20, Release 1.9.8 =

Small Bugfix in I18N code and adaption of the translation - Thanks to Aurelien Paulus for reporting

= 2008-08-08, Release 1.9.7 =

Small Bugfix in YAPB Options Classes - Thanks to mozkart for reporting

= 2008-07-28, Release 1.9.6 =

I18N release:

* Adapted YAPB Options Page so that all strings may be translated
* Actualized po-file
* Updated german translation

= 2008-07-23, Release 1.9.5 =

WordPress 2.6 release:

* Additional handling code to reflect the new WP post revisions feature
* Silently removed beta status


= 2008-06-25, Release 1.9.4 =

Bugfix:

* Wrong parameter handover in yapb_thumbnail(...) template function (Thanks to Jeff Sayre for analyzing and solving this issue)


= 2008-06-25, Release 1.9.3 =

Additional feature: 

* Optional link around thumbnails in "Automatic Image Insertion" mode.
* According configuration option on YAPB Options Page (On/Off and linktarget)

= 2008-06-24, Release 1.9.2 =

Several minor backend changes

* Options Page: Moved Return-thumbnail-URL-as-valid-XHTML-option up into thumbnailer section
* YapbImageClass: XHTML Override Parameter now really overrides the setting - Was previously only able to disable it
* Several infrastructural changes to reflect changes in YAPB Sidebar Widget Plugin
* Typo on Options Page

= 2008-06-18, Release 1.9.1 =

* Bugfix: Call-time pass-by-reference at line 156 of Yapb.class.php (Thanks to Erik for reporting that issue)

= 2008-06-16, Release 1.9 =

* Complete Brushup of the YAPB Options (Code candy) and YAPB Options Page (Eye candy).
* New YAPB Plugin concept: YAPB centered plugins can register to hook which gets called right after YAPB initialization and may place their options on the YAPB options page
* Migration of the YAPB Sidebar Widget to it's own plugin: [YAPB Sidebar Widget Plugin Page](http://www.wordpress.org/extend/plugins/yapb-sidebar-widget "YAPB Sidebar Widget Plugin Page")

= 2008-04-29, Release 1.8.2 =

* Temporary phpExifRW Bug Workaround (Divizion by zero in line 857 in exifReader.inc)
* Deprecated prototype.js calls replaced with according jQuery code

= 2008-04-17, Release 1.8.1 =

Enhanced configurability

* More thumbnail flexibility in feeds: Define width and/or height, decide if you want the thumbnails to be cropped if you defined both.
* Small brushups at the configuration page

= 2008-03-31, Release 1.8 =

WordPress 2.5 Backend Integration Release

* Updated dashboard integration
* Updated upload form integration
* Updated options page

TODO's

* Migration prototype.js to jquery
* More tightly integration into wordpress

= 2008-03-21, Release 1.7.4 =

Bugfix:

* Thumbnails didn't get deleted on image replacement or deletion since release 1.7 (SEO thumbnail naming scheme change). Thanks to yeungda for providing a patch code snippet.

Due to major changes in WordPress 2.5, YAPB 1.7.4 is the last working release for WordPress 2.3.x

= 2008-02-07 =

Bugfix:

* Template functions yapb_thumbnail and yapb_get_thumbnail didn't use the class parameter (Thanks from Salzburg to Jorge Otero)

WordPress 2.3.3 release

* YAPB now tested up to WordPress 2.3.3

= 2008-01-09 =

Small Bugfix:

* Call to YapbImage->transform in unused code branch causes warnings (thanks to Sean): Codebranch commented out
* New global: YAPB_PLUGINDIR

= 2008-01-01 =

Multiple brushups and additions

* Heavy weight logging library (log4php) replaced by lightweight internal logging infrastructure thus hopefully minimizing memory footprint and disk usage of the plugin
* "YAPB Latest Images" sidebar widget (activated on presentation/widgets and administered via the general YAPB options page)
* SEO image names: thumbnails get prepended with the original image filename
* YAPB now tested up to WordPress 2.3.2

= 2007-11-21 = 

General infrastructural brushup

* Calculate plugins base path automatically so it may be installed to any direct subdirectory below wp-content/plugins
* Plugin information centralized in the readme.txt file so i have only to change 1 instead of 4 files for a release. 
* YAPB now reads needed information directly out of the readme.txt
* YapbDiagnostics output enhanced
* Update to [phpThumb 1.7.8](http://phpthumb.sourceforge.net).
* Disabled [phpExifRW](http://open.vinayras.com/phpexifrw_exif_reader_writer) thumbnail caching
* Reviewed and hardened the plugin activation call & hook

= 2007-11-16 = 

Some minor infrastructural changes

* Yapb Class and Instancing separated into two files

= 2007-10-02 = 

First WordPress 2.3 Release:

* THANKS DAVE: Adaption of the _options_categories_array method

= 2007-09-16 = 

Template functions:

* Change of yapb_thumbnail and yapb_get_thumbnail call
* Additional yapb_image and yapb_get_image functions

= 2007-08-06 = 

Multiple changes

* New LoggerAppenderCache for log4php so the YapbThumbnailer Script may return available errors again if called directly
* Bugfix in YapbDiagnostics: Check for is_executable not required on windows systems
* Additional global YAPB_EXECUTING_OS
* YapbDiagnostics: Additional Output of YAPB version

= 2007-06-27 = 

Thumbnails in feeds are now surrounded by a link to the post - Thanks to fsimo for the idea

= 2007-06-25 = 

Bugfix

* "Thumbnail generation on every request"

= 2007-06-22 = 

Added Log4PHP library for enhanced logging

= 2007-05-25 = 

Quick Info Display on Dashboard

= 2007-05-25 = 

Brushed up admin panel options page

= 2007-05-25 = 

First Bunch of Template Functions:

* yapb_is_photoblog_post
* yapb_get_thumbnail
* yapb_thumbnail
* yapb_get_exif
* yapb_exif
* yapb_get_alternative_image_formats
* yapb_alternative_image_formats

= 2007-05-23 = 

Update of YapbDiagnostics to perform some automatic testing

* Plugin Version and WordPress compatibility Testing

= 2007-04-11 = 

Update from phpThumb 1.7.6 to 1.7.7

* Wild hack in YapbThumbnailer.php for hosts not having a correct DOCUMENT_ROOT setting. Greets to oxoxo.

= 2007-04-11 = 

Extended YapbThumbnailer Debug Code:

* Output of phpThumb debug messages if thumbnail generation failed

= 2007-02-22 = 

Exact adjustment of all automatic insertion features in conjunction with the xhtml feature (theme and rss)

* width and height in rss and atom feed inclusions

= 2007-02-22 = 

Additional readme file in cache dir so WinZip will extract this directory too - Thanks to GREGK for that tip.

= 2007-02-20 = 

General code refactorings

* Semantical upgrade of comments
* Minor code refactorings
* Reinclusion and update of XHTML-Option (img tag now closed)
* little interface brushup (background-gif for upload form)

= 2007-02-08 = 

WP 2.1 Infrastructure adaption: 

* Inclusion of general js libraries on YAPB options page over WordPress wp-includes/script-loader.php

= 2007-02-08 = 

Additional feature

* Allow YAPB Image Upload for WordPress pages
* Additional code and options for the automatic image insertion on pages
* Change of plugin description
* Change of version number (forgot that last time)

= 2007-01-25 = 

First set of adaptions to make YAPB WP 2.1 compatible

* No use of $table_prefix anymore
* No double integration of prototype.js anymore 

Goals for the next time: 

* No use of deprecated WordPress infrastructure
* Better integration through use of new WP infrastructure

= 2007-01-25 = 

Bugfix

* GMT offset and delay before seeing post solved

= 2007-01-22 = 

Possible Bugfix

* YapbImage::getInstanceFromDb now returns null instead of error if no $post->ID was provided.

= 2007-01-18 = 

Additional feature

* Original image dimensions now available over YapbImage class (width and height attributes)

= 2007-01-18 = 

Additional feature 

* thumbnail dimensions now available over YapbImage class (Even if thumb wasn't generated yet)

= 2007-01-06 = 

I'm to stupid to fix a bug sheme at the first time:

* Bugfix: "Division by zero" Error on YAPB-Options-Page Section Statistics if no images where uploaded yet, but a file exists in thumbnails dir 

Thanks to torontobroad

= 2007-01-05 = 

Bugfix: 

* "Division by zero" Error on YAPB-Options-Page Section Statistics if no images where uploaded yet.

Thanks to Martin Ciastko and torontobroad

= 2006-10-31 = 

Bugfix

* "Division by zero" Error on YAPB-Options-Page Section Statistics if no images where uploaded yet.

= 2006-10-28 = 

Bugfix

* If defining a phpThumb single-usage parameter multiple times in method getThumbnailHref YAPB couldn't locate the according cachefile - Though generating it on every access.

= 2006-10-27 = 

Back to BETA: 1.2: Major infrastructure adaption for better performance

* Thighter phpThumb integration 
* Direct thumbnail creation and URL rendering
* Manual cache management
* Maintainance and Information part on Yapb-Options-Page
* Upgrade to phpThumb 1.7.4

= 2006-10-17 = 

Release Candidate 1

* Completed GnuText usage in sourcecode
* Activated GnuText usage
* Added a german language file
* Added image tag inline css input fields on options page
* Included some YAPB buttons

= 2006-10-09 = 

Added feature

* Control over rss2 and atom feed thumbnail embedding.

= 2006-10-02 =

Turned off EXIF thumbnail caching behaviour in ExifUtils usage of PHPExifRW so there's no need for the .cache_thumbs directory anymore

= 2006-10-02 =

Enhancement of XHTML BugFix

* No ampersand replacement in rss2 feed (Wordpress places a CDATA Block around content blocks so that's not needed)

= 2006-09-20 = 

XHTML BugFix in YapbImage.class.php

* Changed the Thumbnail URL generation to be XHTML compliant

Thanks for the tip to yovko at yovko dot net

= 2006-09-13 = 

Workaround in YapbImageFile and Yapb Class files 

* Method delivering correct system path of image file depended on CGI var "DOCUMENT_ROOT" - This may report wrong values in multi-hosting-enviroments. The wp-installation root get's calculated now on YAPB-Startup and is defined as three directories above .../wp-content/plugins/yet-another-photoblog/Yapb.class.php

= 2006-09-12 = 

Changed creation of YAPB_PLUGIN_PATH to use wp_option "siteurl" instead of "home"

= 2006-09-07 = 

JavaScript workaround in edit_form_advanced_javascript_injection.tpl.php, File upload didn't work in Safari

= 2006-09-06 = 

Inserted "Automatic Template Insertion" for newbies and Added a bunch of related options to make it a little bit more flexible

= 2006-08-29 =

Extended feeds (rss, rss2, atom): Every yapb-xml-item now contains an image-tag refering to a thumbnail of the image.

= 2006-08-29 =

Extended options page offers a set of phpThumb options now, JS-DBX-Folders included for better structure and usability

= 2006-08-29 =

Added flexible options engine - Options are stored in Yapb.class.php now

= 2006-08-27 =

JavaScript workaround in edit_form_advanced_javascript_injection.tpl.php

File upload didn't work in IE:

* Node.enctype = 'multipart/form-data' just works in standard compatible browsers
* Node.encoding = 'multipart/form-data' works in IE too

= 2006-08-26 =

Little rearrangements on the options panel; Added option yapb_default_post_category_activate

= 2006-08-26 =

Added update services pinging if posting photoblog-entry

= 2006-08-26 =

Corrected bug in edit_publish_save_post():

* Extracting the needed URI of an uploaded image failed if the wp siteurl option didn't end with a slash.

= 2006-08-24 = 

Beta release

= 2006-05-27 = 

Alpha release

